@extends('seller.layouts.app')

@section('panel_content')
@if ($user->shop->gst_status == 1)
        <style>
            .GSTDetails {display: block;}
        </style>
    @elseif($user->shop->gst_status == 2)
        <style>
            .EnrollmentNumberDetails {display: block;}
        </style>
    @else
        <style>
            .GSTDetails {display: none}
            .EnrollmentNumberDetails {display: none}
        </style>
    @endif
    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Manage Profile') }}</h1>
        </div>
      </div>
    </div>

    <!-- Required Data List -->
    @if (empty($user->name) ||
            empty($user->shop->business_name) ||
            empty($user->shop->business_type) ||
            empty($user->shop->alternate_person) ||
            empty($user->shop->responsible_person) ||
            empty($user->shop->bank_branch_name) ||
            empty($user->shop->bank_name) ||
            empty($user->shop->bank_acc_no) ||
            empty($user->shop->bank_ifsc_code) ||
            count($pickupaddresses) == 0 ||
            empty($user->phone_verified_at) ||
            $user->shop->verification_gst == 0)
        <div class="card p-0">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Required Data List') }}</h5>
            </div>
            <div class="card-body p-o">
                <ul style="padding: 0px 15px;">
                    @if (empty($user->name) ||
                            empty($user->shop->business_name) ||
                            empty($user->shop->business_type) ||
                            empty($user->shop->alternate_person) ||
                            empty($user->shop->responsible_person) ||
                            empty($user->shop->bank_branch_name) ||
                            empty($user->shop->bank_name) ||
                            empty($user->shop->bank_acc_no) ||
                            empty($user->shop->bank_ifsc_code))
                        <li style="list-style: circle;color: red;padding-bottom: 5px;">Basic Info, Business Setting and Bank
                            Details are required.</li>
                    @endif
                    @if (count($pickupaddresses) == 0)
                        <li style="list-style: circle;color: red;padding-bottom: 5px;">Pickup Address is required.</li>
                    @endif
                    {{-- @if (empty($user->phone_verified_at))
                        <li style="list-style: circle;color: red;padding-bottom: 5px;">Verify your phone is required.</li>
                    @endif --}}
                    @if ($user->shop->verification_gst == 0)
                        <li style="list-style: circle;color: red;padding-bottom: 5px;">GST Number is required.</li>
                    @endif
                </ul>
            </div>
        </div>
    @elseif ($user->shop->verification_status == 0)
        <div class="alert alert-success" role="alert" style="font-size: 15px;">
            {{ translate('Once admin approved your account, then you would be able to log in.') }}
        </div>
    @endif

    <form action="{{ route('seller.profile.update', $user->id) }}" id="sellerProfileForm" method="POST" 
        enctype="multipart/form-data">
        <input name="_method" type="hidden" value="POST">
        @csrf
        <!-- Basic Info-->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Basic Info') }}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="name">{{ translate('Your Name') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="name" value="{{ $user->name }}" id="name" class="form-control" 
                            placeholder="{{ translate('Your Name') }}" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="phone">{{ translate('Your Phone') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="phone" value="{{ $user->phone }}" id="phone" class="form-control" placeholder="{{ translate('Your Phone')}}">
                        @error('phone')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{ translate('Photo') }}</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                    {{ translate('Browse') }}
                                </div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="photo" value="{{ $user->avatar_original }}" 
                            class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="password">{{ translate('Your Password') }}</label>
                    <div class="col-md-9">
                        <input type="password" name="new_password" id="password" class="form-control" 
                            placeholder="{{ translate('New Password') }}">
                        @error('new_password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" 
                        for="confirm_password">{{ translate('Confirm Password') }}</label>
                    <div class="col-md-9">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" 
                            placeholder="{{ translate('Confirm Password') }}">
                        @error('confirm_password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="aadhaar_card_number">{{ translate('Aadhaar Card Number') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="aadhaar_card_number" value="{{ $user->aadhaar_card_number }}"
                            id="aadhaar_card_number" class="form-control"
                            placeholder="{{ translate('Aadhaar Card Number') }}">
                        @error('aadhaar_card_number')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{ translate('Aadhaar Card Photo') }}</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                    {{ translate('Browse') }}
                                </div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="aadhaar_card_photo" value="{{ $user->aadhaar_card_photo }}"
                                class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Business System -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Business Setting') }}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="business_name">{{ translate('Business Name') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="business_name" value="{{ $user->shop->business_name }}"
                            id="business_name" class="form-control" placeholder="{{ translate('Business Name') }}">
                        @error('business_name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="business_type">{{ translate('Business Type') }}</label>
                    <div class="col-md-9">
                        <select class="form-control aiz-selectpicker" name="business_type">
                            <option value="">{{ translate('Select business type') }}</option>
                            <option value="Private Limited / Limited"
                                {{ $user->shop->business_type == 'Private Limited / Limited' ? 'selected' : '' }}>
                                {{ translate('Private Limited / Limited') }}</option>
                            <option value="Sole Proprietorship / One Person Company"
                                {{ $user->shop->business_type == 'Sole Proprietorship / One Person Company' ? 'selected' : '' }}>
                                {{ translate('Sole Proprietorship / One Person Company') }}</option>
                            <option value="Partnership"
                                {{ $user->shop->business_type == 'Partnership' ? 'selected' : '' }}>
                                {{ translate('Partnership') }}</option>
                            <option value="Limited Liability Partnership"
                                {{ $user->shop->business_type == 'Limited Liability Partnership' ? 'selected' : '' }}>
                                {{ translate('Limited Liability Partnership') }}</option>
                            <option value="Self Employed Businesses (Enrolment number incase there is no GSTIN)"
                                {{ $user->shop->business_type == 'Self Employed Businesses (Enrolment number incase there is no GSTIN)' ? 'selected' : '' }}>
                                {{ translate('Self Employed Businesses (Enrolment number incase there is no GSTIN)') }}
                            </option>
                            <option value="NGO" {{ $user->shop->business_type == 'NGO' ? 'selected' : '' }}>
                                {{ translate('NGO') }}</option>
                            <option value="Trust" {{ $user->shop->business_type == 'Trust' ? 'selected' : '' }}>
                                {{ translate('Trust') }}</option>
                            <option value="Cooperative Society"
                                {{ $user->shop->business_type == 'Cooperative Society' ? 'selected' : '' }}>
                                {{ translate('Cooperative Society') }}</option>
                        </select>
                        @error('business_type')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="alternate_person">{{ translate('Alternate person') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="alternate_person" value="{{ $user->shop->alternate_person }}"
                            id="alternate_person" lang="en" class="form-control"
                            placeholder="{{ translate('Alternate person') }}">
                        @error('alternate_person')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="responsible_person">{{ translate('Responsible person') }}</label>
                    <div class="col-md-9">
                        <select class="form-control aiz-selectpicker" name="responsible_person">
                            <option value="">{{ translate('Select responsible person') }}</option>
                            <option value="Owner" {{ $user->shop->responsible_person == 'Owner' ? 'selected' : '' }}>
                                {{ translate('Owner') }}</option>
                            <option value="Director"
                                {{ $user->shop->responsible_person == 'Director' ? 'selected' : '' }}>
                                {{ translate('Director') }}</option>
                            <option value="Manager" {{ $user->shop->responsible_person == 'Manager' ? 'selected' : '' }}>
                                {{ translate('Manager') }}</option>
                        </select>
                        @error('responsible_person')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label
                        class="col-md-3 col-form-label">{{ translate('Responsible Person Authorization Proof') }}</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                    {{ translate('Browse') }}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="responsible_person_document"
                                value="{{ $user->shop->responsible_person_document }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment System -->
        <!--<div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Payment Setting')}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <label class="col-md-3 col-form-label">{{ translate('Cash Payment') }}</label>
                    <div class="col-md-9">
                        <label class="aiz-switch aiz-switch-success mb-3">
                            <input value="1" name="cash_on_delivery_status" type="checkbox" @if ($user->shop->cash_on_delivery_status == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label">{{ translate('Bank Payment') }}</label>
                    <div class="col-md-9">
                        <label class="aiz-switch aiz-switch-success mb-3">
                            <input value="1" name="bank_payment_status" type="checkbox" @if ($user->shop->bank_payment_status == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label" for="bank_name">{{ translate('Bank Name') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_name" value="{{ $user->shop->bank_name }}" id="bank_name" class="form-control mb-3" placeholder="{{ translate('Bank Name')}}">
                        @error('phone')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label" for="bank_acc_name">{{ translate('Bank Account Name') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_acc_name" value="{{ $user->shop->bank_acc_name }}" id="bank_acc_name" class="form-control mb-3" placeholder="{{ translate('Bank Account Name')}}">
                        @error('bank_acc_name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label" for="bank_acc_no">{{ translate('Bank Account Number') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_acc_no" value="{{ $user->shop->bank_acc_no }}" id="bank_acc_no" class="form-control mb-3" placeholder="{{ translate('Bank Account Number')}}">
                        @error('bank_acc_no')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label" for="bank_routing_no">{{ translate('Bank Routing Number') }}</label>
                    <div class="col-md-9">
                        <input type="number" name="bank_routing_no" value="{{ $user->shop->bank_routing_no }}" id="bank_routing_no" lang="en" class="form-control mb-3" placeholder="{{ translate('Bank Routing Number')}}">
                        @error('bank_routing_no')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="aiz-checkbox">
                            <input type="checkbox" name="tc" id="tc">
                            <span class="">{{ translate('I Agree to all ') }} <a href="{{ route('terms') }}"
                                    class="fw-500">{{ translate('T & C') }}</a></span>
                            <span class="aiz-square-check"></span>
                            @error('tc')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{ translate('Update Profile') }}</button>
                </div>
            </div>
        </div>-->
        
        <!-- Payment System -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Bank Details') }}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="bank_branch_name">{{ translate('Bank Branch Name') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_branch_name" value="{{ $user->shop->bank_branch_name }}"
                            id="bank_branch_name" class="form-control"
                            placeholder="{{ translate('Bank Branch Name') }}">
                        @error('bank_branch_name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="bank_name">{{ translate('Bank Name') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_name" value="{{ $user->shop->bank_name }}" id="bank_name"
                            class="form-control" placeholder="{{ translate('Bank Name') }}">
                        @error('bank_name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="bank_acc_no">{{ translate('Bank Account Number') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_acc_no" value="{{ $user->shop->bank_acc_no }}"
                            id="bank_acc_no" class="form-control" placeholder="{{ translate('Bank Account Number') }}">
                        @error('bank_acc_no')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="re_bank_acc_no">{{ translate('Re-enter Bank Account Number') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="re_bank_acc_no" value="{{ $user->shop->re_bank_acc_no }}"
                            id="re_bank_acc_no" class="form-control"
                            placeholder="{{ translate('Re-enter Bank Account Number') }}">
                        @error('re_bank_acc_no')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="bank_ifsc_code">{{ translate('Bank IFSC Code') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_ifsc_code" value="{{ $user->shop->bank_ifsc_code }}"
                            id="bank_ifsc_code" lang="en" class="form-control"
                            placeholder="{{ translate('Bank IFSC Code') }}">
                        @error('bank_ifsc_code')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="aiz-checkbox">
                            <input type="checkbox" name="tc" id="tc">
                            <span class="">{{ translate('I Agree to all ') }} <a href="{{ route('terms') }}"
                                    class="fw-500">{{ translate('T & C') }}</a></span>
                            <span class="aiz-square-check"></span>
                            @error('tc')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{ translate('Update Profile') }}</button>
                </div>
            </div>
        </div>

    </form>

    <br>

    <!-- Pickup Address -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Pickup Address') }}</h5>
        </div>
        <div class="card-body">
            <div class="row gutters-10">
                @foreach ($pickupaddresses as $key => $address)
                    <div class="col-lg-4">
                        <div class="border p-3 pr-5 rounded mb-3 position-relative">
                            <div>
                                <span class="w-50 fw-600">{{ translate('Address') }}:</span>
                                <span class="ml-2">{{ $address->address }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('Postal Code') }}:</span>
                                <span class="ml-2">{{ $address->postal_code }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('City') }}:</span>
                                <span class="ml-2">{{ optional($address->city)->name }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('State') }}:</span>
                                <span class="ml-2">{{ optional($address->state)->name }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('Country') }}:</span>
                                <span class="ml-2">{{ optional($address->country)->name }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('Phone') }}:</span>
                                <span class="ml-2">{{ $address->phone }}</span>
                            </div>
                            @if ($address->set_default)
                                <div class="position-absolute right-0 bottom-0 pr-2 pb-3">
                                    <span class="badge badge-inline badge-primary">{{ translate('Default') }}</span>
                                </div>
                            @endif
                            <div class="dropdown position-absolute right-0 top-0">
                                <button class="btn bg-gray px-2" type="button" data-toggle="dropdown">
                                    <i class="la la-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" onclick="edit_pickupaddress('{{ $address->id }}')">
                                        {{ translate('Edit') }}
                                    </a>
                                    @if (!$address->set_default)
                                        <a class="dropdown-item"
                                            href="{{ route('seller.pickupaddresses.set_default', $address->id) }}">{{ translate('Make This Default') }}</a>
                                    @endif
                                    <a class="dropdown-item"
                                        href="{{ route('seller.pickupaddresses.destroy', $address->id) }}">{{ translate('Delete') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-4 mx-auto" onclick="add_pickup_address()">
                    <div class="border p-3 rounded mb-3 c-pointer text-center bg-light">
                        <i class="la la-plus la-2x"></i>
                        <div class="alpha-7">{{ translate('Add New Pickup Address') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Address -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Address')}}</h5>
        </div>
        <div class="card-body">
            <div class="row gutters-10">
                @foreach ($addresses as $key => $address)
                    <div class="col-lg-4">
                        <div class="border p-3 pr-5 rounded mb-3 position-relative">
                            <div>
                                <span class="w-50 fw-600">{{ translate('Address') }}:</span>
                                <span class="ml-2">{{ $address->address }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('Postal Code') }}:</span>
                                <span class="ml-2">{{ $address->postal_code }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('City') }}:</span>
                                <span class="ml-2">{{ optional($address->city)->name }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('State') }}:</span>
                                <span class="ml-2">{{ optional($address->state)->name }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('Country') }}:</span>
                                <span class="ml-2">{{ optional($address->country)->name }}</span>
                            </div>
                            <div>
                                <span class="w-50 fw-600">{{ translate('Phone') }}:</span>
                                <span class="ml-2">{{ $address->phone }}</span>
                            </div>
                            @if ($address->set_default)
                                <div class="position-absolute right-0 bottom-0 pr-2 pb-3">
                                    <span class="badge badge-inline badge-primary">{{ translate('Default') }}</span>
                                </div>
                            @endif
                            <div class="dropdown position-absolute right-0 top-0">
                                <button class="btn bg-gray px-2" type="button" data-toggle="dropdown">
                                    <i class="la la-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" onclick="edit_address('{{ $address->id }}')">
                                        {{ translate('Edit') }}
                                    </a>
                                    @if (!$address->set_default)
                                        <a class="dropdown-item" 
                                        href="{{ route('seller.addresses.set_default', $address->id) }}">{{ translate('Make This Default') }}</a>
                                    @endif
                                    <a class="dropdown-item" 
                                    href="{{ route('seller.addresses.destroy', $address->id) }}">{{ translate('Delete') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-4 mx-auto" onclick="add_new_address()">
                    <div class="border p-3 rounded mb-3 c-pointer text-center bg-light">
                        <i class="la la-plus la-2x"></i>
                        <div class="alpha-7">{{ translate('Add New Address') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Email -->
    <form action="{{ route('user.change.email') }}" id="emailVerificationForm" method="POST">
        @csrf
        <div class="card">
          <div class="card-header">
              <h5 class="mb-0 h6">{{ translate('Change your email') }}</h5>
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-md-3">
                      <label>{{ translate('Your Email') }}</label>
                  </div>
                  <div class="col-md-9">
                      <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="{{ translate('Your Email') }}"
                        id="email" name="email" value="{{ $user->email }}" />
                        @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        <div class="input-group-append">
                           <button type="button" class="btn btn-outline-secondary new-email-verification">
                               <span class="d-none loading">
                                   <span class="spinner-border spinner-border-sm" role="status" 
                                   aria-hidden="true"></span>{{ translate('Sending Email...') }}
                               </span>
                               <span class="default">{{ translate('Verify') }}</span>
                           </button>
                        </div>
                      </div>
                      <div class="form-group mb-0 text-right">
                          <button type="submit" class="btn btn-primary">{{ translate('Update Email') }}</button>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </form>

    <form action="{{ route('user.gst_verify') }}" id="gstVerificationForm" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('GST Number') }}</h5>
            </div>
            <div class="card-body">
                @if ($user->shop->gst_status == 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ translate('GST') }}</label>
                                <div class="col-md-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input gst_status" type="radio" name="gst_status" id="inlineRadio1" value="1">
                                        <label class="form-check-label" for="inlineRadio1">GST Number</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input gst_status" type="radio" name="gst_status" id="inlineRadio2" value="2">
                                        <label class="form-check-label" for="inlineRadio2">Enrollment Number</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input gst_status" type="radio" name="gst_status" id="inlineRadio3" value="0">
                                        <label class="form-check-label" for="inlineRadio3">-NA-</label>
                                      </div>
                                </div>
                            </div>
                            <div class="GSTDetails">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label"
                                        for="gst_number">{{ translate('Business Name (As Per GST Document)') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" name="gst_business_name" id="gst_business_name"
                                            class="form-control" placeholder="{{ translate('Business Name') }}">
                                        @error('gst_business_name')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label"
                                        for="gst_number">{{ translate('GST Number') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" name="gst_number" class="form-control" placeholder="{{ translate('GST Number') }}">
                                        @error('gst_number')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">{{ translate('GST Documents') }}</label>
                                    <div class="col-md-9">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    {{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="gst_document"
                                                class="selected-files" required>
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-right">
                                    <button type="submit"
                                        class="btn btn-primary">{{ translate('Update GST Number') }}</button>
                                </div>
                            </div>
                            <div class="EnrollmentNumberDetails">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label"
                                        for="enrollment_number">{{ translate('Enrollment Number') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" name="enrollment_number" class="form-control" placeholder="{{ translate('Enrollment Number') }}">
                                        @error('enrollment_number')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">{{ translate('Enrollment Number Documents') }}</label>
                                    <div class="col-md-9">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    {{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="enrollment_document"
                                                class="selected-files" required>
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-right">
                                    <button type="submit"
                                        class="btn btn-primary">{{ translate('Update Enrollment Number') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">

                                @if ($user->shop->gst_status == 1)
                                    <label class="col-md-3 col-form-label"
                                        for="gst_number">{{ translate('GST Number') }}</label>
                                @elseif($user->shop->gst_status == 2)
                                    <label class="col-md-3 col-form-label"
                                        for="gst_number">{{ translate('Enroll Number') }}</label>
                                @endif
                                <div class="col-md-9">
                                    <label class="col-form-label" for="gst_number">{{ $user->shop->gst_number }}</label>
                                </div>
                            </div>
                            @if ($user->shop->gst_status == 1)
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label"
                                        for="gst_number">{{ translate('Status') }}</label>
                                    <div class="col-md-9">
                                        <label class="col-form-label" for="gst_number">Verified</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>

@endsection

@section('modal')
    {{-- New Address Modal --}}
    <div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-default" role="form" action="{{ route('seller.addresses.store') }}" 
                method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="p-3">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Address') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control mb-3" placeholder="{{ translate('Your Address') }}" rows="2" name="address" 
                                    required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Country') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <select class="form-control aiz-selectpicker" data-live-search="true" 
                                        data-placeholder="{{ translate('Select your country') }}" name="country_id"
                                            required>
                                            <option value="">{{ translate('Select your country') }}</option>
                                            @foreach (\App\Models\Country::where('status', 1)->get() as $key => $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('State') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" 
                                    name="state_id" required>

                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('City') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" 
                                    name="city_id" required>

                                    </select>
                                </div>
                            </div>

                            @if (get_setting('google_map') == 1)
                                <div class="row">
                                    <input id="searchInput" class="controls" type="text" 
                                    placeholder="{{ translate('Enter a location') }}">
                                    <div id="map"></div>
                                    <ul id="geoData">
                                        <li style="display: none;">{{ translate('Full Address') }}: <span 
                                            id="location"></span></li>
                                        <li style="display: none;">{{ translate('Postal Code') }}: <span 
                                            id="postal_code"></span></li>
                                        <li style="display: none;">{{ translate('Country') }}: <span 
                                            id="country"></span></li>
                                        <li style="display: none;">{{ translate('Latitude') }}: <span 
                                            id="lat"></span></li>
                                        <li style="display: none;">{{ translate('Longitude') }}: <span 
                                            id="lon"></span></li>
                                    </ul>
                                </div>

                                <div class="row">
                                    <div class="col-md-2" id="">
                                        <label for="exampleInputuname">{{ translate('Longitude') }}</label>
                                    </div>
                                    <div class="col-md-10" id="">
                                        <input type="text" class="form-control mb-3" id="longitude" name="longitude" 
                                        readonly="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" id="">
                                        <label for="exampleInputuname">{{ translate('Latitude') }}</label>
                                    </div>
                                    <div class="col-md-10" id="">
                                        <input type="text" class="form-control mb-3" id="latitude" name="latitude" 
                                        readonly="">
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Postal code') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" 
                                        placeholder="{{ translate('Your Postal Code') }}" name="postal_code" 
                                        value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Phone') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" 
                                        placeholder="{{ translate('+880') }}" name="phone" value="" required>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Address Modal --}}
    <div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="edit_modal_body">

                </div>
            </div>
        </div>
    </div>

    {{-- Pickup Address Modal --}}
    <div class="modal fade" id="pickup-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Pickup Address') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-default" role="form" action="{{ route('seller.pickupaddresses.store') }}"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="p-3">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Address') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control mb-3" placeholder="{{ translate('Your Address') }}" rows="2" name="address"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Country') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <select class="form-control aiz-selectpicker" data-live-search="true"
                                            data-placeholder="{{ translate('Select your country') }}" name="country_id"
                                            required>
                                            <option value="">{{ translate('Select your country') }}</option>
                                            @foreach (\App\Models\Country::where('status', 1)->get() as $key => $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('State') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control mb-3 aiz-selectpicker" data-live-search="true"
                                        name="state_id" required>

                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('City') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control mb-3 aiz-selectpicker" data-live-search="true"
                                        name="city_id" required>

                                    </select>
                                </div>
                            </div>

                            @if (get_setting('google_map') == 1)
                                <div class="row">
                                    <input id="searchInput" class="controls" type="text"
                                        placeholder="{{ translate('Enter a location') }}">
                                    <div id="map"></div>
                                    <ul id="geoData">
                                        <li style="display: none;">{{ translate('Full Address') }}: <span
                                                id="location"></span></li>
                                        <li style="display: none;">{{ translate('Postal Code') }}: <span
                                                id="postal_code"></span></li>
                                        <li style="display: none;">{{ translate('Country') }}: <span
                                                id="country"></span></li>
                                        <li style="display: none;">{{ translate('Latitude') }}: <span
                                                id="lat"></span></li>
                                        <li style="display: none;">{{ translate('Longitude') }}: <span
                                                id="lon"></span></li>
                                    </ul>
                                </div>

                                <div class="row">
                                    <div class="col-md-2" id="">
                                        <label for="exampleInputuname">{{ translate('Longitude') }}</label>
                                    </div>
                                    <div class="col-md-10" id="">
                                        <input type="text" class="form-control mb-3" id="longitude" name="longitude"
                                            readonly="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" id="">
                                        <label for="exampleInputuname">{{ translate('Latitude') }}</label>
                                    </div>
                                    <div class="col-md-10" id="">
                                        <input type="text" class="form-control mb-3" id="latitude" name="latitude"
                                            readonly="">
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Postal code') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3"
                                        placeholder="{{ translate('Your Postal Code') }}" name="postal_code"
                                        value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Phone') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3"
                                        placeholder="{{ translate('+880') }}" name="phone" value="" required>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Pickup Address Modal --}}
    <div class="modal fade" id="edit-pickupaddress-modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Edit Pickup Address') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="edit_pickup_modal_body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
            $('#sellerProfileForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    bank_branch_name: {
                        required: true
                    },
                    bank_name: {
                        required: true
                    },
                    bank_acc_name: {
                        required: true
                    },
                    bank_acc_no: {
                        required: true
                    },
                    re_bank_acc_no: {
                        equalTo: "#bank_acc_no"
                    },
                    bank_ifsc_code: {
                        required: true
                    },
                    business_name: {
                        required: true
                    },
                    business_type: {
                        required: true
                    },
                    business_address: {
                        required: true
                    },
                    business_address_document: {
                        required: true
                    },
                    /*gst_number : {
                        required : $("#gst").val() == 1
                    },*/
                    alternate_person: {
                        required: true
                    },
                    responsible_person: {
                        required: true
                    },
                    responsible_person_authorization_proof: {
                        required: true
                    },
                    tc: {
                        required: true
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $('#gstVerificationForm').validate({
                rules: {
                    gst_number: {
                        required: true,
                        maxlength: 15,
                        minlength: 15
                    },
                    gst_business_name: {
                        required: $(".gst_status").val() == 1
                    },
                    gst_document: {
                        required: true
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        $(document).on('change', '[name=gst_status]', function() {
            var gst_status = $(this).val();

            if(gst_status == 0){
                $(".GSTDetails").hide();
                $(".EnrollmentNumberDetails").hide();
            } else if(gst_status == 1) {
                $(".GSTDetails").show();
                $(".EnrollmentNumberDetails").hide();
            } else if(gst_status == 2) {
                $(".GSTDetails").hide();
                $(".EnrollmentNumberDetails").show();
            }
        });

        $('.new-phone-verification').on('click', function() {
            $(this).find('.loading').removeClass('d-none');
            $(this).find('.default').addClass('d-none');
            var phone = $("input[name=phone]").val();

            $.post('{{ route('user.phone.verify') }}', {
                _token: '{{ csrf_token() }}',
                phone: phone
            }, function(data) {
                data = JSON.parse(data);
                $('.default').removeClass('d-none');
                $('.loading').addClass('d-none');
                if (data.status == 2)
                    AIZ.plugins.notify('warning', data.message);
                else if (data.status == 1)
                    AIZ.plugins.notify('success', data.message);
                else
                    AIZ.plugins.notify('danger', data.message);
            });
        });

        $('.new-email-verification').on('click', function() {
            $(this).find('.loading').removeClass('d-none');
            $(this).find('.default').addClass('d-none');
            var email = $("input[name=email]").val();

            $.post('{{ route('user.new.verify') }}', {_token:'{{ csrf_token() }}', email: email}, function(data){
                data = JSON.parse(data);
                $('.default').removeClass('d-none');
                $('.loading').addClass('d-none');
                if(data.status == 2)
                    AIZ.plugins.notify('warning', data.message);
                else if(data.status == 1)
                    AIZ.plugins.notify('success', data.message);
                else
                    AIZ.plugins.notify('danger', data.message);
            });
        });

        function add_new_address(){
            $('#new-address-modal').modal('show');
        }

        function add_pickup_address() {
            $('#pickup-address-modal').modal('show');
        }

        function edit_address(address) {
            var url = '{{ route("seller.addresses.edit", ":id") }}';
            url = url.replace(':id', address);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#edit_modal_body').html(response.html);
                    $('#edit-address-modal').modal('show');
                    AIZ.plugins.bootstrapSelect('refresh');

                    @if (get_setting('google_map') == 1)
                        var lat = -33.8688;
                        var long = 151.2195;

                        if(response.data.address_data.latitude && response.data.address_data.longitude) {
                            lat = parseFloat(response.data.address_data.latitude);
                            long = parseFloat(response.data.address_data.longitude);
                        }

                        initialize(lat, long, 'edit_');
                    @endif
                }
            });
        }

        function edit_pickupaddress(address) {
            var url = '{{ route('seller.pickupaddresses.edit', ':id') }}';
            url = url.replace(':id', address);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#edit_pickup_modal_body').html(response.html);
                    $('#edit-pickupaddress-modal').modal('show');
                    AIZ.plugins.bootstrapSelect('refresh');

                    @if (get_setting('google_map') == 1)
                        var lat = -33.8688;
                        var long = 151.2195;

                        if (response.data.address_data.latitude && response.data.address_data.longitude) {
                            lat = parseFloat(response.data.address_data.latitude);
                            long = parseFloat(response.data.address_data.longitude);
                        }

                        initialize(lat, long, 'edit_');
                    @endif
                }
            });
        }

        $(document).on('change', '[name=country_id]', function() {
            var country_id = $(this).val();
            get_states(country_id);
        });

        $(document).on('change', '[name=state_id]', function() {
            var state_id = $(this).val();
            get_city(state_id);
        });

        function get_states(country_id) {
            $('[name="state"]').html("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('seller.get-state')}}",
                type: 'POST',
                data: {
                    country_id  : country_id
                },
                success: function (response) {
                    var obj = JSON.parse(response);
                    if(obj != '') {
                        $('[name="state_id"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

        function get_city(state_id) {
            $('[name="city"]').html("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('seller.get-city')}}",
                type: 'POST',
                data: {
                    state_id: state_id
                },
                success: function (response) {
                    var obj = JSON.parse(response);
                    if(obj != '') {
                        $('[name="city_id"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

    </script>

    @if (get_setting('google_map') == 1)

        @include('frontend.partials.google_map')

    @endif

@endsection
