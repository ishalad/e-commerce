@extends('superdealer.layouts.app')

@section('panel_content')

<!-- Error Meassages -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('dealer.seller.profile.update', $user->id) }}" id="sellerEditForm" method="POST"
    enctype="multipart/form-data">
    <input name="_method" type="hidden" value="POST">
    @csrf
    <!-- Basic Info-->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Basic Info') }}</h5>
        </div>
        <div class="card-body">
            @if (!empty($user->dealer_code))
            <div class="form-group row">
                <label class="col-md-2 col-form-label" for="name">{{ translate('Dealer Code') }}</label>
                <div class="col-md-10">
                    <input type="text" name="name" value="{{ $user->dealer_code }}" id="name" class="form-control"
                        placeholder="{{ translate('Dealer Code') }}" disabled>
                    @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            @endif
            <div class="form-group row">
                <label class="col-md-2 col-form-label" for="name">{{ translate('Your Name') }}</label>
                <div class="col-md-10">
                    <input type="text" name="name" value="{{ $user->name }}" id="name" class="form-control"
                        placeholder="{{ translate('Your Name') }}">
                    @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- <div class="form-group row">
                <label class="col-md-2 col-form-label" for="phone">{{ translate('Your Phone') }}</label>
                <div class="col-md-10">
                    <input type="text" name="phone" value="{{ $user->phone }}" id="phone" class="form-control" placeholder="{{ translate('Your Phone')}}">
                    @error('phone')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div> --}}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ translate('Photo') }}</label>
                <div class="col-md-10">
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}
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
                <label class="col-md-2 col-form-label" for="aadhaar_card_number">{{ translate('Aadhaar Card Number') }}</label>
                <div class="col-md-10">
                    <input type="text" name="aadhaar_card_number" value="{{ $user->Z }}" id="aadhaar_card_number" class="form-control"
                        placeholder="{{ translate('Aadhaar Card Number') }}" readonly>
                    @error('aadhaar_card_number')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ translate('Aadhaar Card Photo') }}</label>
                <div class="col-md-10">
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <input type="hidden" name="aadhaar_card_photo" value="{{ $user->aadhaar_card_photo }}"
                            class="selected-files">
                    </div>
                    <div class="file-preview box sm documentRemove">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password-->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Password') }}</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-2 col-form-label" for="password">{{ translate('Reset Password') }}</label>
                <div class="col-md-10">
                    <input type="password" name="new_password" id="password" class="form-control"
                        placeholder="{{ translate('Reset Password') }}">
                    @error('new_password')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label"
                    for="confirm_password">{{ translate('Confirm Password') }}</label>
                <div class="col-md-10">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                        placeholder="{{ translate('Confirm Password') }}">
                    @error('confirm_password')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>


    @if(!empty($user->shop))
    <!-- Business System -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Business Setting') }}</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="shop_name">{{ translate('Shop Name') }}</label>
                <div class="col-md-9">
                    <input type="text" name="shop_name" value="{{ $user->shop->name }}"
                        id="shop_name" class="form-control" placeholder="{{ translate('Shop Name') }}">
                    @error('shop_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="address">{{ translate('Shop Address') }}</label>
                <div class="col-md-9">
                    <input type="text" name="address" value="{{ $user->shop->address }}"
                        id="address" class="form-control" placeholder="{{ translate('Shop Address') }}">
                    @error('address')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
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
                    <input type="text" name="business_type" value="{{ $user->shop->business_type }}" id="business_type"
                        class="form-control" placeholder="{{ translate('Business Type') }}">
                    @error('business_type')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            @if ($user->shop->gst_status == 1)
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="gst">{{ translate('GST Number') }}</label>
                <div class="col-md-9">
                    <input type="text" name="gst" value="{{ $user->shop->gst_number }}" id="gst"
                        class="form-control mb-3" placeholder="{{ translate('GST Number') }}" readonly>
                    @error('gst')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('GST Documents') }}</label>
                <div class="col-md-9">
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <input type="hidden" name="gst_document" value="{{ $user->shop->gst_document }}"
                            class="selected-files">
                    </div>
                    <div class="file-preview box sm documentRemove">
                    </div>
                </div>
            </div>
            @endif
            {{-- <div class="form-group row">
                <label class="col-md-3 col-form-label"
                    for="business_address">{{ translate('Registered Business Address') }}</label>
                <div class="col-md-9">
                    <input type="text" name="business_address" value="{{ $user->shop->business_address }}"
                        id="business_address" lang="en" class="form-control mb-3"
                        placeholder="{{ translate('Registered Business Address') }}">
                    @error('business_address')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div> --}}
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
                    <input type="text" name="responsible_person" value="{{ $user->shop->responsible_person }}"
                        id="responsible_person" lang="en" class="form-control"
                        placeholder="{{ translate('Responsible person') }}">
                    @error('responsible_person')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Payment System -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Bank Details') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <label class="col-md-3 col-form-label" for="bank_branch_name">{{ translate('Bank Branch Name') }}</label>
                <div class="col-md-9">
                    <input type="text" name="bank_branch_name" value="{{ $user->shop->bank_branch_name }}" id="bank_branch_name"
                        class="form-control mb-3" placeholder="{{ translate('Bank Branch Name') }}">
                    @error('bank_branch_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label" for="bank_name">{{ translate('Bank Name') }}</label>
                <div class="col-md-9">
                    <input type="text" name="bank_name" value="{{ $user->shop->bank_name }}" id="bank_name"
                        class="form-control mb-3" placeholder="{{ translate('Bank Name') }}">
                    @error('bank_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label"
                    for="bank_acc_no">{{ translate('Bank Account Number') }}</label>
                <div class="col-md-9">
                    <input type="text" name="bank_acc_no" value="{{ $user->shop->bank_acc_no }}"
                        id="bank_acc_no" class="form-control mb-3"
                        placeholder="{{ translate('Bank Account Number') }}">
                    @error('bank_acc_no')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label"
                    for="re_bank_acc_no">{{ translate('Re-enter Bank Account Number') }}</label>
                <div class="col-md-9">
                    <input type="text" name="re_bank_acc_no" value="{{ $user->shop->re_bank_acc_no }}"
                        id="re_bank_acc_no" class="form-control mb-3"
                        placeholder="{{ translate('Re-enter Bank Account Number') }}">
                    @error('re_bank_acc_no')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label"
                    for="bank_ifsc_code">{{ translate('Bank IFSC Code') }}</label>
                <div class="col-md-9">
                    <input type="text" name="bank_ifsc_code" value="{{ $user->shop->bank_ifsc_code }}"
                        id="bank_ifsc_code" lang="en" class="form-control mb-3"
                        placeholder="{{ translate('Bank IFSC Code') }}">
                    @error('bank_ifsc_code')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="form-group row">
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
    <div class="form-group mb-3 text-right">
        <button type="submit" class="btn btn-primary">{{ translate('Update Profile') }}</button>
    </div>
</form>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sellerEditForm').validate({
            rules: {
                name: {
                    required: true
                },
                password_confirmation: {
                    equalTo: "#password"
                },
                tc: {
                    required: true
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
@endsection
