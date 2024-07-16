@extends('superdealer.layouts.app')

@section('panel_content')

<div class="row">
    <div class="col-md-6">
        <div class="card p-3">
            <h4 class="BasicInfo">{{ translate('Basic Info') }}</h4> 
            @if (!empty($user->dealer_code))
            <div class="details__info">
                <h5>{{ translate('Dealer Code') }} : </h5>
                <h4>{{ translate($user->dealer_code) }}</h4>
            </div>
            @endif
            <div class="details__info">
                <h5>{{ translate('Name') }} : </h5>
                <h4>{{ translate($user->name) }}</h4>
            </div>   
        </div>
    </div>
    @if(!empty($user->shop))
    <div class="col-md-6">
        <div class="card p-3">
            <h4 class="BasicInfo">{{ translate('Business Setting') }}</h4> 
            <div class="details__info">
                <h5>{{ translate('Shop Name') }} : </h5>
                <h4>{{ translate($user->shop->name) }}</h4>
            </div>
            <div class="details__info">
                <h5>{{ translate('Shop Address') }} : </h5>
                <h4>{{ translate($user->shop->address) }}</h4>
            </div>
            <div class="details__info">
                <h5>{{ translate('Business Name') }} : </h5>
                <h4>{{ translate($user->shop->business_name) }}</h4>
            </div>
            <div class="details__info">
                <h5>{{ translate('Business Type') }} : </h5>
                <h4>{{ translate($user->shop->business_type) }}</h4>
            </div>
            <div class="details__info">
                <h5>{{ translate('Alternate person') }} : </h5>
                <h4>{{ translate($user->shop->alternate_person) }}</h4>
            </div>
            <div class="details__info">
                <h5>{{ translate('Responsible person') }} : </h5>
                <h4>{{ translate($user->shop->responsible_person) }}</h4>
            </div>   
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h4 class="BasicInfo">{{ translate('Bank Details') }}</h4> 
            <div class="details__info">
                <h5>{{ translate('Bank Branch Name') }} : </h5>
                <h4>{{ translate($user->shop->bank_branch_name) }}</h4>
            </div>
            <div class="details__info">
                <h5>{{ translate('Bank Name') }} : </h5>
                <h4>{{ translate($user->shop->bank_name) }}</h4>
            </div>
            <div class="details__info">
                <h5>{{ translate('Bank Account Number') }} : </h5>
                <h4>{{ translate($user->shop->bank_acc_no) }}</h4>
            </div>
            <div class="details__info">
                <h5>{{ translate('Bank IFSC Code') }} : </h5>
                <h4>{{ translate($user->shop->bank_ifsc_code) }}</h4>
            </div>  
        </div>
    </div>
    @endif
</div>


@endsection

