@extends('auth.layouts.authentication')

@section('content')
    <!-- aiz-main-wrapper -->
    <div class="aiz-main-wrapper d-flex flex-column justify-content-md-center bg-white">
        <section class="bg-white overflow-hidden">
            <div class="row">
                <div class="col-xxl-6 col-xl-9 col-lg-10 col-md-7 mx-auto py-lg-4">
                    <div class="card shadow-none rounded-0 border-0">
                        <div class="row no-gutters">
                            <!-- Left Side Image-->
                            <div class="col-lg-6">
                                    <img src="{{ uploaded_asset(get_setting('seller_register_page_image')) }}" alt="" class="img-fit h-100">
                                </div>
                                    
                                <!-- Right Side -->
                                <div class="col-lg-6 p-4 p-lg-5 d-flex flex-column justify-content-center border right-content" style="height: auto;">
                                    <!-- Site Icon -->
                                    <div class="size-48px mb-3 mx-auto mx-lg-0">
                                        <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="img-fit h-100">
                                    </div>

                                    <!-- Titles -->
                                    <div class="text-center text-lg-left">
                                        <h1 class="fs-20 fs-md-24 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('Register your shop')}}</h1>
                                    </div>
                                    <!-- Register form -->
                                    <div class="pt-3 pt-lg-4">
                                        <div class="">
                                            <form id="reg-form" class="form-default" role="form" action="{{ route('shops.store') }}" method="POST">
                                                @csrf
                                                <div class="fs-15 fw-600 pb-2">{{ translate('Dealer')}}</div>
                                                <div class="form-group">
                                                    <label for="name" class="fs-12 fw-700 text-soft-dark">{{  translate('Dealer Code') }}</label>
                                                    <input type="text" class="form-control rounded-0" value="{{ old('dealer_code') }}" placeholder="{{  translate('Dealer Code') }}" name="dealer_code">
                                                </div>

                                                <div class="fs-15 fw-600 pb-2">{{ translate('Personal Info')}}</div>
                                                <!-- Name -->
                                                <div class="form-group">
                                                    <label for="name" class="fs-12 fw-700 text-soft-dark">{{  translate('Your Name') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name" required>
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ translate('Your Email')}}</label>
                                                    <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email" required>
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- password -->
                                                <div class="form-group mb-0">
                                                    <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password" required>
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                    <div class="text-right mt-1">
                                                        <span class="fs-12 fw-400 text-gray-dark">{{ translate('Password must contain at least 6 digits') }}</span>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- password Confirm -->
                                                <div class="form-group">
                                                    <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('Confirm Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation" required>
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                </div>


                                                <div class="fs-15 fw-600 py-2">{{ translate('Basic Info')}}</div>
                                                
                                                <div class="form-group">
                                                    <label for="shop_name" class="fs-12 fw-700 text-soft-dark">{{  translate('Shop Name') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('shop_name') ? ' is-invalid' : '' }}" value="{{ old('shop_name') }}" placeholder="{{  translate('Shop Name') }}" name="shop_name" required>
                                                    @if ($errors->has('shop_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('shop_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="address" class="fs-12 fw-700 text-soft-dark">{{  translate('Address') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}" placeholder="{{  translate('Address') }}" name="address" required>
                                                    @if ($errors->has('address'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('address') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Recaptcha -->
                                                @if(get_setting('google_recaptcha') == 1)
                                                    <div class="form-group">
                                                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                                    </div>
                                                    @if ($errors->has('g-recaptcha-response'))
                                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                        </span>
                                                    @endif
                                                @endif
                                            
                                                <!-- Submit Button -->
                                                <div class="mb-4 mt-4">
                                                    <!--<button type="submit" class="btn btn-primary btn-block fw-600 rounded-0">{{  translate('Register Your Shop') }}</button>-->
                                                    <button type="submit" class="btn btn-primary btn-block fw-600 rounded-0">{{  translate('Next') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Log In -->
                                        <p class="fs-12 text-gray mb-0">
                                            {{ translate('Already have an account?')}}
                                            <a href="{{ route('seller.login') }}" class="ml-2 fs-14 fw-700 animate-underline-primary">{{ translate('Log In')}}</a>
                                        </p>
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
            $('#reg-form').validate({
                rules: {
                    name: {
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
                    shop_name: {
                        required: true
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $("#phone").keyup(function() {
                var check = $('#phone').val().length;
                if(check == 10) {
                    $('.phone_code').show();
                } else {
                    $('.phone_code').hide();
                }
            });
        });
        @if(get_setting('google_recaptcha') == 1)
        // making the CAPTCHA  a required field for form submission
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