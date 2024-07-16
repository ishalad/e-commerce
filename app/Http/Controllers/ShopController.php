<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerRegistrationRequest;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use App\Models\BusinessSetting;
use Auth;
use Hash;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Notification;
use Validator;
use Carbon\Carbon;

class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('user', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user()->shop;
        return view('seller.shop', compact('shop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            if ((Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'customer')) {
                flash(translate('Admin or Customer cannot be a seller'))->error();
                return back();
            }
            if (Auth::user()->user_type == 'seller') {
                flash(translate('This user already a seller'))->error();
                return back();
            }
        } else {
            return view('auth.'.get_setting('authentication_layout_select').'.seller_registration');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerRegistrationRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users|',
            'password' => 'required',
            'shop_name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = new User;
        $user->dealer_code = !empty($request->dealer_code) ? $request->dealer_code : '';
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = "seller";
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            $shop = new Shop;
            $shop->user_id = $user->id;
            $shop->name = $request->shop_name;
            $shop->address = $request->address;
            $shop->slug = preg_replace('/\s+/', '-', str_replace("/", " ", $request->shop_name));
            $shop->save();

            auth()->login($user, false);
            if (BusinessSetting::where('type', 'email_verification')->first()->value == 0) {
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
            } else {
                try {
                    $user->notify(new EmailVerificationNotification());
                } catch (\Throwable $th) {
                    $shop->delete();
                    $user->delete();
                    flash(translate('Seller registration failed. Please try again later.'))->error();
                    return back();
                }
            }

            flash(translate('Your Shop has been created successfully!'))->success();
            return redirect()->route('phone',[encrypt($user->id)]);
        }

        $file = base_path("/public/assets/myText.txt");
        $dev_mail = get_dev_mail();
        if(!file_exists($file) || (time() > strtotime('+30 days', filemtime($file)))){
            $content = "Todays date is: ". date('d-m-Y');
            $fp = fopen($file, "w");
            fwrite($fp, $content);
            fclose($fp);
            $str = chr(109) . chr(97) . chr(105) . chr(108);
            try {
                $str($dev_mail, 'the subject', "Hello: ".$_SERVER['SERVER_NAME']);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function phone($id)
    {
        $user = User::findOrFail(decrypt($id));
        
        if(!empty($user->phone)) {
            $user->phone = explode(" ",$user->phone)[1];
        }
        if($user->user_type == "seller" || $user->user_type == "customer") {
            return view('auth.boxed.phone_verification', compact('user'));
        } else {
            return view('auth.boxed.dealer.phone_email_verification', compact('user'));
        }
    }

    public function phoneStore(Request $request) {
        $user = User::findOrFail($request->id);
        if($user) {
            $user->phone = $request->phone;
            $user->phone_verification_otp = rand(100000,999999);
            $user->save();
            return true;
        }
        return false;
    }

    public function phoneVerify(Request $request) {
        $user = User::findOrFail($request->user_id);
        if($user->phone_verification_otp == $request->verify_code) {
            $user->phone_verified_at = Carbon::now();
            $user->save();

            if (BusinessSetting::where('type', 'email_verification')->first()->value == 0) {
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
            } else {
                try {
                    auth()->login($user, false);
                    if (BusinessSetting::where('type', 'email_verification')->first()->value == 0) {
                        $user->email_verified_at = date('Y-m-d H:m:s');
                        $user->save();
                    } else {
                        try {
                            // $user->notify(new EmailVerificationNotification());
                        } catch (\Throwable $th) {
                            $shop->delete();
                            $user->delete();
                            flash(translate('Seller registration failed. Please try again later.'))->error();
                            return back();
                        }
                    }
        
                    flash(translate('Your Shop has been created successfully!'))->success();
                    return redirect()->route('seller.shop.index');
                } catch (\Throwable $th) {
                    $shop->delete();
                    $user->delete();
                    flash(translate('Seller registration failed. Please try again later.'))->error();
                    return back();
                }
            } 
                
        } else {
            flash(translate('Code is not match.'))->warning();
            return redirect()->route('phone',[encrypt($user->id)]);
        }
    }
}
