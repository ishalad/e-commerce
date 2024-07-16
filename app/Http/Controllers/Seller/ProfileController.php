<?php

namespace App\Http\Controllers\Seller;

use App\Http\Requests\SellerProfileRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminMessage;
use Auth;
use Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses ? $user->addresses : []; 
        $pickupaddresses = $user->pickupaddresses ? $user->pickupaddresses : [];
        
        return view('seller.profile.index', compact('user','addresses','pickupaddresses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SellerProfileRequest $request , $id)
    {
        if(env('DEMO_MODE') == 'On'){
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->aadhaar_card_number = $request->aadhaar_card_number;
        $user->aadhaar_card_photo = $request->aadhaar_card_photo;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }
        
        $user->avatar_original = $request->photo;

        $shop = $user->shop;

        if($shop){
            $shop->cash_on_delivery_status = !empty($request->cash_on_delivery_status) ? $request->cash_on_delivery_status : '';
            $shop->bank_payment_status = !empty($request->bank_payment_status) ? $request->bank_payment_status : '';
            $shop->bank_name = !empty($request->bank_name) ? $request->bank_name : '';
            $shop->bank_acc_name = !empty($request->bank_acc_name) ? $request->bank_acc_name : '';
            $shop->bank_acc_no = !empty($request->bank_acc_no) ? $request->bank_acc_no : '';
            $shop->bank_routing_no = !empty($request->bank_routing_no) ? $request->bank_routing_no : '';

            $shop->bank_branch_name = $request->bank_branch_name;
            $shop->bank_name = $request->bank_name;
            $shop->bank_acc_no = $request->bank_acc_no;
            $shop->bank_ifsc_code = $request->bank_ifsc_code;

            $shop->business_name = !empty($request->business_name) ? $request->business_name : '';
            $shop->business_type = !empty($request->business_type) ? $request->business_type : '';
            $shop->address = !empty($request->business_address) ? $request->business_address : '';
            $shop->address_document = !empty($request->business_address_document) ? $request->business_address_document : '';
            
            $shop->alternate_person = !empty($request->alternate_person) ? $request->alternate_person : '';
            $shop->responsible_person = !empty($request->responsible_person) ? $request->responsible_person : '';
            $shop->responsible_person_document = !empty($request->responsible_person_document) ? $request->responsible_person_document : '';    
            $shop->save();
        }
        if(empty($user->phone_verified_at)) {
            flash(translate('Please verify your phone!'))->warning();
        } elseif (count($user->pickupaddresses) == 0) {
            flash(translate('Please add pickup address!'))->warning();
        } elseif($user->shop->verification_gst == 0) {
            flash(translate('Please verify your gst!'))->warning();
        } else {
            flash(translate('Your Profile has been updated successfully!'))->success();
        }
        $user->is_profile = 1;
        $user->save();


        return back();
    }
    function admin_message(Request $request) {
        $search = null;
        $messages = AdminMessage::where('receiver_id', Auth::user()->id);
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $messages = $messages->where('message', 'like', '%' . $search . '%');
        }
        $messages = $messages->paginate(15);
        return view('seller.profile.message', compact('search','messages'));
    }

    function show_message($id = "") {
        if(!empty($id)){
            $message = AdminMessage::find(decrypt($id));
            $message->is_view = 1;
            $message->save();
            if(!empty($message)){
                return view('seller.profile.ShowMessage', compact('message'));
            }
        }
    }

    public function submit_message(Request $request) {
        $request->validate([
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'parent_id' => 'required',
            'message' => 'required',
        ]);

        $message = new AdminMessage;
        $message->sender_id = !empty($request->sender_id) ? $request->sender_id : 0;
        $message->receiver_id = !empty($request->receiver_id) ? $request->receiver_id : 0;
        $message->parent_id = !empty($request->parent_id) ? $request->parent_id : 0;
        $message->message = !empty($request->message) ? $request->message : 0;
        $message->save();

        if($message->parent_id != 0){
            $msg = AdminMessage::findOrFail($message->parent_id);
            $msg->is_replay = 1;
            $msg->save();
        }

        flash(translate('Message hass been send successfully.'))->success();
        return back();
    }
}
