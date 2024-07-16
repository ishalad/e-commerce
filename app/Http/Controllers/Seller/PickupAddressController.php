<?php

namespace App\Http\Controllers\Seller;

use App\Models\PickupAddress;
use Illuminate\Http\Request;
use Auth;
use App\Models\City;
use App\Models\State;

class PickupAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pickupAddress = new PickupAddress;
        $pickupAddress->user_id       = Auth::user()->id;
        $pickupAddress->shop_id       = Auth::user()->shop->id;
        $pickupAddress->address       = $request->address;
        $pickupAddress->country_id    = $request->country_id;
        $pickupAddress->state_id      = $request->state_id;
        $pickupAddress->city_id       = $request->city_id;
        $pickupAddress->longitude     = $request->longitude;
        $pickupAddress->latitude      = $request->latitude;
        $pickupAddress->postal_code   = $request->postal_code;
        $pickupAddress->phone         = $request->phone;
        $pickupAddress->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PickupAddress  $pickupAddress
     * @return \Illuminate\Http\Response
     */
    public function show(PickupAddress $pickupAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PickupAddress  $pickupAddress
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['address_data'] = PickupAddress::findOrFail($id);
        $data['states'] = State::where('status', 1)->where('country_id', $data['address_data']->country_id)->get();
        $data['cities'] = City::where('status', 1)->where('state_id', $data['address_data']->state_id)->get();
        
        $returnHTML = view('seller.profile.pickupaddress_edit_modal', $data)->render();
        return response()->json(array('data' => $data, 'html'=>$returnHTML));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PickupAddress  $pickupAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $address = PickupAddress::findOrFail($id);
        
        $address->address       = $request->address;
        $address->country_id    = $request->country_id;
        $address->state_id      = $request->state_id;
        $address->city_id       = $request->city_id;
        $address->longitude     = $request->longitude;
        $address->latitude      = $request->latitude;
        $address->postal_code   = $request->postal_code;
        $address->phone         = $request->phone;

        $address->save();

        flash(translate('Pickup address info updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PickupAddress  $pickupAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = PickupAddress::findOrFail($id);
        if(!$address->set_default){
            $address->delete();
            return back();
        }
        flash(translate('Default pickup address cannot be deleted'))->warning();
        return back();
    }

    public function set_default($id){
        foreach (Auth::user()->pickupaddresses as $key => $address) {
            $address->set_default = 0;
            $address->save();
        }
        $address = PickupAddress::findOrFail($id);
        $address->set_default = 1;
        $address->save();

        return back();
    }
}
