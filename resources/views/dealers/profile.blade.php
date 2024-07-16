@extends('superdealer.layouts.app')

@section('panel_content')
<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('superdealer.profile.update', $user->id) }}" id="superdealerProfileForm" method="POST">
            @csrf
            <input type="hidden" name="dealer_page" value="dealer_profile">   
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Manage Profile') }}</h5>
                </div>
                <div class="card-body">
                    @if ($user->user_type == 'super_dealer' || $user->user_type == 'dealer')
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{ translate('Dealer Code') }}</label>
                            <div class="col-md-10">
                                <input type="text" placeholder="{{ translate('Dealer Code') }}" id="dealer_code" name="dealer_code"
                                    class="form-control" value="{{ $user->dealer_code }}" disabled>
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="name">{{ translate('Dealer Name') }}  <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" name="name" value="{{ $user->name }}" id="name" class="form-control"
                                placeholder="{{ translate('Dealer Name') }}">
                            @error('name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="phone">{{ translate('Dealer Phone') }}  <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" name="phone" value="{{ $user->phone }}" id="phone" class="form-control" placeholder="{{ translate('Dealer Phone')}}">
                            @error('phone')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="email">{{ translate('Dealer Email') }}  <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="email" name="email" value="{{ $user->email }}" id="email" class="form-control" placeholder="{{ translate('Dealer Email')}}">
                            @error('email')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="aadhaar_card_photo">{{ translate('Profile Photo') }}</label>
                        <div class="col-md-10">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="avatar_original" value="{{ $user->avatar_original }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="business_name">{{ translate('Dealer Business Name') }}  <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" name="business_name" value="{{ $user->business_name }}" id="business_name" class="form-control" placeholder="{{ translate('Dealer Business Name')}}">
                            @error('business_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    @if ($user->user_type == 'super_dealer' || $user->user_type == 'dealer')
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{ translate('Address') }}</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="address" id="address" placeholder="{{ translate('Address') }}">{{ $user->address }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="phone">{{ translate('Aadhaar Card Number') }}</label>
                            <div class="col-md-10">
                                <input type="text" name="aadhaar_card_number" value="{{ $user->aadhaar_card_number == 0 ? '' : $user->aadhaar_card_number }}" id="aadhaar_card_number" class="form-control" placeholder="{{ translate('Aadhaar Card Number')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="aadhaar_card_photo">{{ translate('Aadhaar Card Photo') }}</label>
                            <div class="col-md-10">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="aadhaar_card_photo" value="{{ $user->aadhaar_card_photo }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="phone">{{ translate('PAN Number') }}</label>
                            <div class="col-md-10">
                                <input type="text" name="pan_number" value="{{ $user->pan_number == 0 ? '' : $user->pan_number }}" id="aadhaar_card_number" class="form-control" placeholder="{{ translate('PAN Card Number')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="aadhaar_card_photo">{{ translate('PAN Card Photo') }}</label>
                            <div class="col-md-10">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="pan_card_photo" value="{{ $user->pan_card_photo }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Update Profile') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Bank Details') }}</h5>
            </div>
            <div class="card-body">
            <form action="{{ route('superdealer.profile.update', $user->id) }}" id="BankProfileForm" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="bank_branch_name">{{ translate('Bank Branch Name') }} <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="bank_branch_name" value="{{ $user->bank_branch_name }}"
                            id="bank_branch_name" class="form-control"
                            placeholder="{{ translate('Bank Branch Name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="bank_name">{{ translate('Bank Name') }} <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="bank_name" value="{{ $user->bank_name }}"
                            id="bank_name" class="form-control" placeholder="{{ translate('Bank Name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="bank_acc_no">{{ translate('Bank Account Number') }} <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="bank_acc_no" value="{{ $user->bank_acc_no }}"
                            id="bank_acc_no" class="form-control"
                            placeholder="{{ translate('Bank Account Number') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="bank_ifsc_code">{{ translate('Bank IFSC Code') }} <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="bank_ifsc_code" value="{{ $user->bank_ifsc_code }}"
                            id="bank_ifsc_code" lang="en" class="form-control"
                            placeholder="{{ translate('Bank IFSC Code') }}">
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{ translate('Update Bank Details') }}</button>
                </div>
            </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Change Password') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" id="reset-password"
                    action="{{ route('dealers.update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">{{ translate('Password') }} <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="password" placeholder="{{ translate('Password') }}" id="password"
                                name="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">{{ translate('Confirm Password') }} <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="password" placeholder="{{ translate('Confirm Password') }}"
                                id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Change Password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#superdealerProfileForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password_confirmation: {
                        equalTo: "#password"
                    },
                    business_name: {
                        required: true
                    },
                    
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $('#BankProfileForm').validate({
                rules: {
                    bank_branch_name: {
                        required: true
                    },
                    bank_name: {
                        required: true
                    },
                    bank_acc_no: {
                        required: true
                    },
                    bank_ifsc_code: {
                        required: true
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $('#reset-password').validate({
                rules: {
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    password: {
                        required: true,
                        strong_password: true
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

        });

        
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.validator.addMethod("strong_password", function(value, element) {
                let password = value;
                if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%&])(.{8,20}$)/.test(password))) {
                    return false;
                }
                return true;
            }, function(value, element) {
                let password = $(element).val();
                if (!(/^(.{8,15}$)/.test(password))) {
                    return 'Password must be between 8 to 15 characters long.';
                } else if (!(/^(?=.*[A-Z])/.test(password))) {
                    return 'Password must contain at least one uppercase.';
                } else if (!(/^(?=.*[a-z])/.test(password))) {
                    return 'Password must contain at least one lowercase.';
                } else if (!(/^(?=.*[0-9])/.test(password))) {
                    return 'Password must contain at least one digit.';
                } else if (!(/^(?=.*[!@#$%^&*])/.test(password))) {
                    return "Password must contain special characters from !@#$%^&*.";
                }
                return false;
            });
            $('#reset-password').validate({
                rules: {
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    password: {
                        required: true,
                        strong_password: true
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection