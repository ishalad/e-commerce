@extends('auth.layouts.authentication')

@section('content')
    <!-- aiz-main-wrapper -->
    <div class="aiz-main-wrapper d-flex flex-column justify-content-md-center bg-white">
        <section class="bg-white overflow-hidden">
            <div class="row">
                <div class="col-xxl-6 col-xl-9 col-lg-10 col-md-7 mx-auto py-lg-4">
                    <div class="card shadow-none rounded-0 border-0">
                        <div class="row ">
                            <!-- Left Side Image-->
                            <div class="col-lg-6">
                                   <div class=" d-flex align-items-center commonInner">
                                    <img src="{{ uploaded_asset(get_setting('seller_register_page_image')) }}" alt="">
                                   </div>
                                </div>
                                    
                                <!-- Right Side -->
                                <div class="col-lg-6  d-flex flex-column justify-content-center  right-content paddingBox" >
                                    <!-- Site Icon -->
                                    <div class="mb-3 mx-auto mx-lg-0">
                                        <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="img-fit h-100">
                                    </div>

                                    <ul class="tabForm nav nav-tabs mt-5 mb-3" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="supert-dealer-tab" data-bs-toggle="tab"
                                                data-bs-target="#super-dealer-tab-pane" type="button" role="tab" aria-controls="super-dealer-tab-pane"
                                                aria-selected="true">{{ translate('Super Dealer')}}</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="dealer-tab" data-bs-toggle="tab"
                                                data-bs-target="#dealer-tab-pane" type="button" role="tab" aria-controls="dealer-tab-pane"
                                                aria-selected="false">{{ translate('Dealer')}}</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="influencer-tab" data-bs-toggle="tab"
                                                data-bs-target="#influencer-tab-pane" type="button" role="tab" aria-controls="influencer-tab-pane"
                                                aria-selected="false">{{ translate('Influencer')}}</button>
                                        </li>
                    
                                    </ul>
                                    <div class="tab-content tabContent__wpr" id="myTabContent">
                                        <div class="tab-pane fade show active" id="super-dealer-tab-pane" role="tabpanel" aria-labelledby="supert-dealer-tab"
                                            tabindex="0">
                                            <form id="reg-super" class="form-default" action="{{ route('dealers.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_type" value="super_dealer">
                                                <div class="form-group">
                                                    <label for="name" class="fs-12 fw-700 text-soft-dark">{{  translate('Your Name') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name">
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Your Phone') }}</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-5 col-lg-5">
                                                            <select class="form-control aiz-selectpicker" data-live-search="true" name="phone_code">
                                                                <option value="+91">{{ translate('India') }}({{ translate('+91') }})</option>
                                                                @foreach (\App\Models\CountryCodes::where('phonecode', '!=', '+91')->get() as $key => $countrycode)
                                                                    <option value="{{ $countrycode->phonecode }}">{{ $countrycode->name }} ({{ $countrycode->phonecode }}) </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-7 col-lg-7">
                                                            <input type="number" class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="{{  translate('Phone') }}" name="phone">
                                                            @if ($errors->has('phone'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="form-group">
                                                    <label for="email" class="fs-12 fw-700 text-soft-dark">{{ translate('Your Email')}}</label>
                                                    <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password" id="password">
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('Confirm Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation">
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                    @if ($errors->has('password_confirmation'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="business_name" class="fs-12 fw-700 text-soft-dark">{{  translate('Business Name') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('business_name') ? ' is-invalid' : '' }}" value="{{ old('business_name') }}" placeholder="{{  translate('Business Name') }}" name="business_name">
                                                    @if ($errors->has('business_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('business_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <button type="submit" class="btn-primary btn-block fw-700 fs-14 rounded-0 submitBTN">{{  translate('Next') }}</button>
                                            </form>
                    
                                        </div>
                                        <div class="tab-pane fade" id="dealer-tab-pane" role="tabpanel" aria-labelledby="dealer-tab"
                                            tabindex="0">
                                            <form id="reg-dealer" class="form-default" role="form" action="{{ route('dealers.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_type" value="dealer">

                                                <div class="form-group">
                                                    <label class="col-form-label fs-12 fw-700 text-soft-dark">{{ translate('Is Super Dealer ?') }}</label>
                                                        <label class="aiz-switch aiz-switch-success">
                                                            <input value="0" name="is_superdealer" id="is_superdealer" type="checkbox" >
                                                            <span class="slider round"></span>
                                                        </label>
                                                </div>

                                                <div class="form-group super_dealer_options">
                                                </div>

                                                <div class="form-group">
                                                    <label for="name" class="fs-12 fw-700 text-soft-dark">{{  translate('Your Name') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name">
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Your Phone') }}</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-5 col-lg-5">
                                                            <select class="form-control aiz-selectpicker" data-live-search="true" name="phone_code">
                                                                <option value="+91">{{ translate('India') }}({{ translate('+91') }})</option>
                                                                @foreach (\App\Models\CountryCodes::where('phonecode', '!=', '+91')->get() as $key => $countrycode)
                                                                    <option value="{{ $countrycode->phonecode }}">{{ $countrycode->name }} ({{ $countrycode->phonecode }}) </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-7 col-lg-7">
                                                            <input type="number" class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="{{  translate('Phone') }}" name="phone">
                                                            @if ($errors->has('phone'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="form-group">
                                                    <label for="email" class="fs-12 fw-700 text-soft-dark">{{ translate('Your Email')}}</label>
                                                    <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password" id="dealerpassword">
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('Confirm Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation">
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                    @if ($errors->has('password_confirmation'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="business_name" class="fs-12 fw-700 text-soft-dark">{{  translate('Business Name') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('business_name') ? ' is-invalid' : '' }}" value="{{ old('business_name') }}" placeholder="{{  translate('Business Name') }}" name="business_name">
                                                    @if ($errors->has('business_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('business_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <button type="submit" class="btn-primary btn-block fw-700 fs-14 rounded-0 submitBTN">{{  translate('Create Account') }}</button>
                                            </form>
                    
                                        </div>
                                        <div class="tab-pane fade" id="influencer-tab-pane" role="tabpanel" aria-labelledby="influencer-tab"
                                            tabindex="0">
                                            <form id="reg-influencer" class="form-default" role="form" action="{{ route('dealers.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_type" value="influencer">
                                                <div class="form-group">
                                                    <label for="name" class="fs-12 fw-700 text-soft-dark">{{  translate('Your Name') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name">
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Your Phone') }}</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-5 col-lg-5">
                                                            <select class="form-control aiz-selectpicker" data-live-search="true" name="phone_code">
                                                                <option value="+91">{{ translate('India') }}({{ translate('+91') }})</option>
                                                                @foreach (\App\Models\CountryCodes::where('phonecode', '!=', '+91')->get() as $key => $countrycode)
                                                                    <option value="{{ $countrycode->phonecode }}">{{ $countrycode->name }} ({{ $countrycode->phonecode }}) </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-7 col-lg-7">
                                                            <input type="number" class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="{{  translate('Phone') }}" name="phone">
                                                            @if ($errors->has('phone'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="form-group">
                                                    <label for="email" class="fs-12 fw-700 text-soft-dark">{{ translate('Your Email')}}</label>
                                                    <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password" id="influencerpassword">
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('Confirm Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation">
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                    @if ($errors->has('password_confirmation'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="business_name" class="fs-12 fw-700 text-soft-dark">{{  translate('Business Name') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('business_name') ? ' is-invalid' : '' }}" value="{{ old('business_name') }}" placeholder="{{  translate('Business Name') }}" name="business_name">
                                                    @if ($errors->has('business_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('business_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <button type="submit" class="btn-primary btn-block fw-700 fs-14 rounded-0 submitBTN">{{  translate('Create Account') }}</button>
                                            </form>
                                        </div>
                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Go Back -->
                        <div class="mt-3 mr-4 mr-md-0">
                            <a href="{{ url()->previous() }}" class="ml-auto fs-14 fw-700 d-flex align-items-center text-primary" style="max-width: fit-content;">
                                <i class="las la-arrow-left fs-20 mr-1"></i>
                                {{ translate('Back to Previous Page')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/boosted/5.3.3/js/boosted.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    @if(get_setting('google_recaptcha') == 1)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script type="text/javascript">
        $(document).on('click', '[name=is_superdealer]', function() {
            var is_superdealer = $(this).val();
            $('.super_dealer_options').html(null);
            if(is_superdealer == 1) {
                $(this).val(0);
            } else {
                $(this).val(1);
                $('.super_dealer_options').append('\
                    <label for="sd_name" class="fs-12 fw-700 text-soft-dark">{{  translate("Super Dealer Name") }}</label>\
                    <input type="text" class="form-control rounded-0" placeholder="{{  translate("Super Dealer Name") }}" name="super_dealer_name">\
                    @if ($errors->has("super_dealer_name"))\
                        <span class="invalid-feedback" role="alert">\
                            <strong>{{ $errors->first("super_dealer_name") }}</strong>\
                        </span>\
                    @endif\
                    </div>\
                    <div class="form-group">\
                    <label for="super_dealer_code" class="fs-12 fw-700 text-soft-dark">{{  translate("Super Dealer Code") }}</label>\
                    <input type="text" class="form-control rounded-0" placeholder="{{  translate("Super Dealer Code") }}" name="super_dealer_code">\
                    @if ($errors->has("super_dealer_code"))\
                        <span class="invalid-feedback" role="alert">\
                            <strong>{{ $errors->first("super_dealer_code") }}</strong>\
                        </span>\
                    @endif\
                ');
            }
        });

        $(document).ready(function(){
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
            $('#reg-super').validate({
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
                    password: {
                        required: true,
                        strong_password: true
                    },
                    password_confirmation: {
                        required: true,
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
            $('#reg-dealer').validate({
                rules: {
                    super_dealer_name: {
                        required: '#is_superdealer:checked'
                    },
                    super_dealer_code: {
                        required:  '#is_superdealer:checked'
                    },
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
                    password: {
                        required: true,
                        strong_password: true
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#dealerpassword"
                    },
                    business_name: {
                        required: true
                    },
                    
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            $('#reg-influencer').validate({
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
                    password: {
                        required: true,
                        strong_password: true
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#influencerpassword"
                    },
                    business_name: {
                        required: true
                    },
                    
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        @if(get_setting('google_recaptcha') == 1)
        // making the CAPTCHA  a field for form submission
        $(document).ready(function(){
            $("#reg-form").on("submit", function(evt)
            {
                var response = grecaptcha.getResponse();
                if(response.length == 0)
                {
                //reCaptcha not verified
                    alert("please verify you are human!");
                    evt.preventDefault();
                    return false;
                }
                //captcha verified
                //do the rest of your validations here
                $("#reg-form").submit();
            });
        });
        @endif
    </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boosted/5.3.3/css/boosted.min.css" />
<link rel="stylesheet" href="{{ static_asset('assets/css/custom-style.css') }}">
@endsection