@extends('backend.layouts.app')

@section('content')

    @php
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
    @endphp

    <div class="row">
        <style>
            .error {
                color: red;
                margin-top: 5px;
                font-size: 0.75rem;
            }
        </style>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('User Information') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="dealer_update" action="{{ route('dealers.update', $user->id) }}"
                        method="POST" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        @if ($user->user_type == 'super_dealer' || $user->user_type == 'dealer')
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Dealer Code') }}</label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('Dealer Code') }}" id="dealer_code" name="dealer_code"
                                    class="form-control" value="{{ $user->dealer_code }}" disabled>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Email') }}</label>
                            <div class="col-md-9">
                                <input type="email" placeholder="{{ translate('Email') }}" id="email" name="email"
                                    class="form-control" value="{{ $user->email }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="aadhaar_card_photo">{{ translate('Profile Photo') }}</label>
                            <div class="col-md-9">
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
                            <label class="col-md-3 col-form-label">{{ translate('Name') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                    class="form-control" value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Business Name') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('Business Name') }}" id="business_name"
                                    name="business_name" class="form-control" value="{{ $user->business_name }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Phone') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('Phone') }}" id="phone" name="phone"
                                    class="form-control" value="{{ $user->phone }}" required>
                            </div>
                        </div>

                        @if ($user->user_type == 'super_dealer' || $user->user_type == 'dealer')
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Address') }}</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="address" id="address" placeholder="{{ translate('Address') }}">{{ $user->address }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="phone">{{ translate('Aadhaar Card Number') }}</label>
                                <div class="col-md-9">
                                    <input type="text" name="aadhaar_card_number" value="{{ $user->aadhaar_card_number == 0 ? '' : $user->aadhaar_card_number }}" id="aadhaar_card_number" class="form-control" placeholder="{{ translate('Aadhaar Card Number')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="aadhaar_card_photo">{{ translate('Aadhaar Card Photo') }}</label>
                                <div class="col-md-9">
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
                                <label class="col-md-3 col-form-label" for="phone">{{ translate('PAN Number') }}</label>
                                <div class="col-md-9">
                                    <input type="text" name="pan_number" value="{{ $user->pan_number == 0 ? '' : $user->pan_number }}" id="aadhaar_card_number" class="form-control" placeholder="{{ translate('PAN Card Number')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="aadhaar_card_photo">{{ translate('PAN Card Photo') }}</label>
                                <div class="col-md-9">
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


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Status') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="select2 form-control aiz-selectpicker" name="dealer_status"
                                    data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                                    <option value="0" {{ $user->dealer_status == '0' ? 'selected' : '' }}>
                                        {{ translate('Pending') }}</option>
                                    <option value="1" {{ $user->dealer_status == '1' ? 'selected' : '' }}>
                                        {{ translate('Approve') }}</option>
                                    <option value="2" {{ $user->dealer_status == '2' ? 'selected' : '' }}>
                                        {{ translate('Reject') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update Profile') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Change Password') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="reset-password" action="{{ route('dealers.update', $user->id) }}"
                        method="POST" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Password') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="password" placeholder="{{ translate('Password') }}" id="password"
                                    name="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Confirm Password') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
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

            @if ($user->user_type == 'super_dealer')
                @if (!empty($user->DealerList))
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Dealer List') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Contact</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->DealerList as $key => $value)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->phone }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif

            @if ($user->user_type == 'dealer')
                @if (!empty($user->DealerList))
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Seller List') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Contact</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->DealerList as $key => $value)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ !empty($value->name) ? $value->name : '-NA-' }}</td>
                                            <td>{{ !empty($value->email) ? $value->email : '-NA-' }}</td>
                                            <td>{{ !empty($value->phone) ? $value->phone : '-NA-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dealer_update').validate({
                rules: {
                    name: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    business_name: {
                        required: true
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            $.validator.addMethod("strong_password", function (value, element) {
                let password = value;
                if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%&])(.{8,20}$)/.test(password))) {
                    return false;
                }
                return true;
            }, function (value, element) {
                let password = $(element).val();
                if (!(/^(.{8,15}$)/.test(password))) {
                    return 'Password must be between 8 to 15 characters long.';
                }
                else if (!(/^(?=.*[A-Z])/.test(password))) {
                    return 'Password must contain at least one uppercase.';
                }
                else if (!(/^(?=.*[a-z])/.test(password))) {
                    return 'Password must contain at least one lowercase.';
                }
                else if (!(/^(?=.*[0-9])/.test(password))) {
                    return 'Password must contain at least one digit.';
                }
                else if (!(/^(?=.*[!@#$%^&*])/.test(password))) {
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
