<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DealerRegistrationRequest;
use App\Models\User;
use Hash;
use Mail;
use Auth;
use URL;
use App\Mail\EmailManager;
use App\Mail\SecondEmailVerifyMailManager;
use App\Mail\InvoiceEmailManager;
use Carbon\Carbon;

class DealerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = "",Request $request)
    {
        $sort_search = $users = null;
        if(!empty($type)){
            $sort_search =null;
            $user = User::orderBy('id', 'desc');
            $user->where('user_type', $type);
            if ($request->has('search')){
                if(!empty($request->search)){
                    $sort_search = $request->search;
                    $user = $user->where('name', 'like', '%'.$sort_search.'%');
                    $user = $user->orwhere('email', 'like', '%'.$sort_search.'%');
                }
            }
            $users = $user->paginate(15);
        }
        return view('backend.dealer.index', compact('users', 'sort_search', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.'.get_setting('authentication_layout_select').'.dealer.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'super_dealer_name' => 'required_if:is_superdealer,3|string',
            'super_dealer_code' => 'required_if:is_superdealer,3|string',
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
            'business_name' => 'required|max:255'
        ]);

        $user = new User;
        $user->name = !empty($request->name) ? $request->name : $user->name;
        $user->phone = !empty($request->phone) ? $request->phone_code.' '.$request->phone : $user->phone;
        $user->phone_verification_otp = rand(100000,999999);
        $user->email = !empty($request->email) ? $request->email : $user->email;
        $user->verification_code = rand(100000,999999);
        $user->user_type = !empty($request->user_type) ? $request->user_type : $user->user_type;
        if($request->password != null && ($request->password == $request->password_confirmation)){
            $user->password = Hash::make($request->password);
        }
        $user->business_name = !empty($request->business_name) ? $request->business_name : $user->business_name;
        $user->address = !empty($request->address) ? $request->address : $user->address;
        if(!empty($request->aadhaar_card_number) && !empty($request->aadhaar_card_photo)){
            $user->aadhaar_card_number = $request->aadhaar_card_number? $request->aadhaar_card_number : $user->aadhaar_card_number;
            $user->aadhaar_card_photo = $request->aadhaar_card_photo? $request->aadhaar_card_photo : $user->aadhaar_card_photo;
            $user->verification_aadhaar_card_number = 0;
        }

        if(!empty($request->pan_number) && !empty($request->pan_card_photo)){
            $user->pan_number = $request->pan_number? $request->pan_number : '';
            $user->pan_card_photo = $request->pan_card_photo? $request->pan_card_photo : '';
        }
        
        if ($user->save()) {
            if($user->user_type == "super_dealer") {
                $user->dealer_code = 'IZSD'.$user->id;
            } else if($user->user_type == "dealer") {
                if($request->is_superdealer == 1) {
                    $superDealerID = User::where('dealer_code', $request->super_dealer_code)->pluck('id')->toArray();
                    $user->dealer_code = 'IZSD'.$superDealerID[0].'-D'.$user->id;
                    $user->parent_dealer_id = $superDealerID[0];
                } else {
                    $user->dealer_code = 'IZD'.$user->id;
                }
            }
            $user->save();

            $array['view'] = 'emails.verification';
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['subject'] = translate('Email Verification');
            $array['content'] = translate('Verification Code is').': '. $user->verification_code;

            try {
                Mail::to($user->email)->queue(new SecondEmailVerifyMailManager($array));
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            
            return redirect()->route('phone',[encrypt($user->id)]);
            // return redirect()->route('seller.shop.index');
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
        $user = User::findOrFail($id);
        if($user) {
            return view('dealer.sellers.show', compact('user'));
        } else {
            flash(translate('Seller not found.'))->warning();
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(!empty($id)){
            $user = User::with(['DealerList','shop'])->find($id);
            if(!empty($user)){
                if(Auth::user()->user_type == "admin"){
                    return view('backend.dealer.edit', compact('user'));
                } else {
                    if ($user->user_type == "super_dealer") {
                        return view('superdealer.dealear.edit', compact('user'));
                    } else if ($user->user_type == "dealer" || $user->user_type == "seller") {
                        return view('dealer.sellers.edit', compact('user'));
                    } else if ($user->user_type == "influencer") {
                        return view('influencer.edit', compact('user'));
                    } else {
                        flash(translate('This dealer is not yours.'))->warning();
                        return back();
                    }            
                }
        
            } else {
                flash(translate('User Not Found.'))->error();
                return back();        
            }
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $user->name = !empty($request->name) ? $request->name : $user->name;
        $user->phone = !empty($request->phone) ? $request->phone : $user->phone;
        $user->email = !empty($request->email) ? $request->email : $user->email;
        $user->business_name = !empty($request->business_name) ? $request->business_name : $user->business_name;
        $user->address = !empty($request->address) ? $request->address : $user->address;
        $user->avatar_original = !empty($request->avatar_original) ? $request->avatar_original : $user->avatar_original;

        if (!empty($request->password) && strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }

        if($user->user_type == "dealer" || $user->user_type == "super_dealer") {
            $user->aadhaar_card_number = !empty($request->aadhaar_card_number) ? $request->aadhaar_card_number : $user->aadhaar_card_number;
            $user->aadhaar_card_photo = !empty($request->aadhaar_card_photo) ? $request->aadhaar_card_photo : $user->aadhaar_card_photo;
            //$user->verification_aadhaar_card_number = 0;
            $user->pan_number = !empty($request->pan_number) ? $request->pan_number : $user->pan_number;
            $user->pan_card_photo = !empty($request->pan_card_photo) ? $request->pan_card_photo : $user->pan_card_photo;
            $user->bank_branch_name = !empty($request->bank_branch_name) ? $request->bank_branch_name : $user->bank_branch_name;
            $user->bank_name = !empty($request->bank_name) ? $request->bank_name : $user->bank_name;
            $user->bank_acc_no = !empty($request->bank_acc_no) ? $request->bank_acc_no : $user->bank_acc_no;
            $user->bank_ifsc_code = !empty($request->bank_ifsc_code) ? $request->bank_ifsc_code : $user->bank_ifsc_code;
        }

        if(!empty($request->dealer_status)){
            if((int)$request->dealer_status != $user->dealer_status){
                if($request->dealer_status == "1"){
                    if($user->is_profile == "0"){
                        $array['subject'] = translate('Your Account Approved');
                        $array['from'] = env('MAIL_FROM_ADDRESS');
                        $array['view'] = 'backend.dealer.approve';
                        Mail::to('dpaddonwebtech@outlook.com')->queue(new EmailManager($array));
                    }
                    $user->is_profile = 1;
                    $user->dealer_status = !empty($request->dealer_status) ? $request->dealer_status : $user->dealer_status;
                }
                if($request->dealer_status == "2"){
                    if($user->is_profile == "0"){
                        $array['subject'] = translate('Your Account Reject');
                        $array['from'] = env('MAIL_FROM_ADDRESS');
                        $array['view'] = 'backend.dealer.reject';
                        Mail::to('dpaddonwebtech@outlook.com')->queue(new EmailManager($array));
                    }
                    $user->is_profile = 1;
                    $user->dealer_status = !empty($request->dealer_status) ? $request->dealer_status : $user->dealer_status;
                }
            }
        }

        if ($user->save()) {
            if($user->user_type == "super_dealer"){
                flash(translate('Super dealer has been updated successfully'))->success();    
            } else if($user->user_type == "dealer"){
                flash(translate('Dealer has been updated successfully'))->success();
            } else if($user->user_type == "influencer"){
                flash(translate('Influencer has been updated successfully'))->success();
            } else {
                flash(translate('Seller has been updated successfully'))->success();
            }
            
            if(Auth::user()->user_type == "admin"){
                return back();
            }
            return redirect()->route('superdealer.dashboard');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function dealersDashboard()
    {
        return view('dealers.dashboard');
    }

    public function superdealerProfile()
    {
        $user = Auth::user();
        return view('dealers.profile', compact('user'));
    }

    public function sellerupdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $request->photo;
        $shop = $user->shop;

        if($shop){
            $shop->name = !empty($request->shop_name) ? $request->shop_name : '';
            $shop->address = !empty($request->address) ? $request->address : '';
            $shop->bank_branch_name = $request->bank_branch_name;
            $shop->bank_name = $request->bank_name;
            $shop->bank_acc_no = $request->bank_acc_no;
            $shop->bank_ifsc_code = $request->bank_ifsc_code;

            $shop->business_name = !empty($request->business_name) ? $request->business_name : '';
            $shop->business_type = !empty($request->business_type) ? $request->business_type : '';
            // $shop->gst = !empty($request->gst) ? $request->gst : '';
            $shop->gst_status = !empty($request->gst_status) ? (int)$request->gst_status : $shop->gst_status;
            $shop->gst_number = !empty($request->gst_number) ? $request->gst_number : $shop->gst_number;
            $shop->gst_document = !empty($request->gst_document) ? $request->gst_document : $shop->gst_document;
            $shop->alternate_person = !empty($request->alternate_person) ? $request->alternate_person : $shop->alternate_person;
            $shop->responsible_person = !empty($request->responsible_person) ? $request->responsible_person : $shop->responsible_person;
            $shop->save();
        }

        $user->save();
        
        flash(translate('Seller profile has been updated successfully!'))->success();
        return back();
    }

    public function dealerList(Request $request)
    {
        $search = null;
        $user = Auth::user();

        if($user->user_type == 'super_dealer') {
            $dealears = User::where('parent_dealer_id', Auth::user()->id)->where('user_type', 'dealer')->orderBy('created_at', 'desc');
    
            if ($request->has('search')) {
                $search = $request->search;
                $dealears = $dealears->where('name', 'like', '%' . $search . '%');
            }
            $dealears = $dealears->paginate(10);
            return view('superdealer.dealear.index', compact('dealears', 'search'));
        } else if ($user->user_type == 'dealer') {
            $sellers = User::where('parent_dealer_id', Auth::user()->id)->where('user_type', 'seller')->orderBy('created_at', 'desc');
    
            if ($request->has('search')) {
                $search = $request->search;
                $sellers = $sellers->where('name', 'like', '%' . $search . '%');
            }
            $sellers = $sellers->paginate(10);
            return view('dealer.sellers.index', compact('sellers', 'search'));
        } else if ($user->user_type == 'influencer') {
            $influencers = User::where('parent_dealer_id', Auth::user()->id)->where('user_type', 'influencer')->orderBy('created_at', 'desc');
    
            if ($request->has('search')) {
                $search = $request->search;
                $influencers = $influencers->where('name', 'like', '%' . $search . '%');
            }
            $influencers = $influencers->paginate(10);
            return view('influencer.index', compact('influencers', 'search'));
        }
    }

    public function dealersPhoneVerify(Request $request) {
        $request->validate([
            'verify_code' => 'required|digits:6',
            'email_code' => 'required|digits:6',
        ]);

        $user = User::findOrFail($request->user_id);

        if($user->phone_verification_otp == $request->verify_code) {
            $user->phone_verified_at = Carbon::now();
            $user->save();
        } else {
            flash(translate('Phone code is not match.'))->warning();
            return redirect()->route('phone',[encrypt($user->id)]);
        }

        if($user->verification_code == $request->email_code) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            $user->dealer_type = $user->user_type != 'super_dealer' ? $user->user_type != 'dealer' ? 'Influencer' : 'Dealer' : 'Super Dealer';

            $array['subject'] = translate('New '.$user->dealer_type.' Registration');
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['view'] = 'backend.dealers.verificationmail';
            $array['order'] = $user;

            try {
                Mail::to('dpaddonwebtech@outlook.com')->queue(new InvoiceEmailManager($array));
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            flash(translate('Email code is not match.'))->warning();
            return redirect()->route('phone',[encrypt($user->id)]);
        }

        return back();
    }

    public function resendCode(Request $request) {
        $user = User::findOrFail($request->id);
        if($request->type == "phone") {
            $user->phone_verification_otp = rand(100000,999999);
            $user->save();
        } 
        
        if($request->type == "email") {
            $user->verification_code = rand(100000,999999);
            $user->save();

            $array['view'] = 'emails.verification';
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['subject'] = translate('Email Verification');
            $array['content'] = translate('Verification Code is').': '. $user->verification_code;

            try {
                Mail::to($user->email)->queue(new SecondEmailVerifyMailManager($array));
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        return response()->json(array('data' => $request->type));
    }
}
