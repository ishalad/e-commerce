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
                            <div class="col-lg-6  d-flex flex-column justify-content-center  right-content paddingBox">
                                <!-- Site Icon -->
                                <div class="mb-3 mx-auto mx-lg-0">
                                    <img src="{{ uploaded_asset(get_setting('site_icon')) }}"
                                        alt="{{ translate('Site Icon') }}" class="img-fit h-100">
                                </div>

                                <ul class="tabForm nav nav-tabs mt-5" id="myTab" role="tablist">
                                    @if ($user->user_type == 'super_dealer')
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active">{{ translate('Super Dealer') }}</button>
                                        </li>
                                    @elseif ($user->user_type == 'dealer')
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active">{{ translate('Dealer') }}</button>
                                        </li>
                                    @elseif ($user->user_type == 'influencer')
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active">{{ translate('Influencer') }}</button>
                                        </li>
                                    @endif
                                </ul>

                                <!-- Required Data List -->
                                @if (empty($user->email_verified_at) || empty($user->phone_verified_at))
                                    <div class="card p-0 mt-2">
                                        <div class="card-body">
                                            <ul style="padding: 0px 15px;">
                                                @if (empty($user->phone_verified_at))
                                                    <li style="list-style: circle;color:#28306d;padding-bottom: 5px;">Your
                                                        phone code is required.</li>
                                                @endif
                                                @if (empty($user->email_verified_at))
                                                    <li style="list-style: circle;color:#28306d;padding-bottom: 5px;">Your
                                                        email code is required.</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="card-body p-0 mt-2">
                                        <div class="alert alert-success mt-2" role="alert" style="font-size: 15px;">
                                            {{ translate('Thank you for your registration. Once the admin approves your account then you can log in!') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="tab-content tabContent__wpr" id="myTabContent">
                                    <div class="tab-pane fade show active" id="super-dealer-tab-pane" role="tabpanel"
                                        aria-labelledby="supert-dealer-tab" tabindex="0">
                                        <form id="verificationForm" class="form-default"
                                            action="{{ route('dealers.verification') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

                                            <div class="form-group">
                                                <label for="verify_code"
                                                    class="fs-12 fw-700 text-soft-dark">{{ translate('Your Phone Code') }}</label>
                                                <input type="number"
                                                    class="form-control rounded-0{{ $errors->has('verify_code') ? ' is-invalid' : '' }}"
                                                    placeholder="{{ translate('Phone Code') }}" name="verify_code"
                                                    @if (!empty($user->phone_verified_at)) value="{{ $user->phone_verification_otp }}" readonly @endif>
                                                @if ($errors->has('verify_code'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('verify_code') }}</strong>
                                                    </span>
                                                @endif
                                                @if (empty($user->phone_verified_at))
                                                    <small class="d-flex justify-content-end mt-2"><a href="#"
                                                            style="color:#28306d;"
                                                            class="resendPhone">{{ translate('Resend Phone Code') }}</a></small>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="email_code"
                                                    class="fs-12 fw-700 text-soft-dark">{{ translate('Your Email Code') }}</label>
                                                <input type="number"
                                                    class="form-control rounded-0{{ $errors->has('email_code') ? ' is-invalid' : '' }}"
                                                    placeholder="{{ translate('Email Code') }}" name="email_code"
                                                    @if (!empty($user->email_verified_at)) value="{{ $user->verification_code }}" readonly @endif>
                                                @if ($errors->has('email_code'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email_code') }}</strong>
                                                    </span>
                                                @endif
                                                @if (empty($user->email_verified_at))
                                                    <small class="d-flex justify-content-end mt-2"><a href="#"
                                                            style="color:#28306d;"
                                                            class="resendEmail">{{ translate('Resend Email Code') }}</a></small>
                                                @endif
                                            </div>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="btn-primary btn-block fw-700 fs-14 rounded-0 submitBTN">{{ translate('Create Account') }}</button>
                                </form>
                            </div>
                        </div>
                        <!-- Go Back -->
                        <div class="mt-3 mr-4 mr-md-0">
                            <a href="{{ url()->previous() }}" class="ml-auto fs-14 fw-700 d-flex align-items-center text-primary"
                                style="max-width: fit-content;">
                                <i class="las la-arrow-left fs-20 mr-1"></i>
                                {{ translate('Back to Previous Page') }}
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
    @if (get_setting('google_recaptcha') == 1)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script type="text/javascript">
        $(document).ready(function() {
            $('#verificationForm').validate({
                rules: {
                    verify_code: {
                        required: true,
                        minlength: 6,
                        maxlength: 6
                    },
                    email_code: {
                        required: true,
                        minlength: 6,
                        maxlength: 6
                    },
                },
                messages: {
                    verify_code: {
                        minlength: "Please enter at least 6 digits.",
                        maxlength: "Please enter no more than 6 digits.",
                    },
                    email_code: {
                        minlength: "Please enter at least 6 digits.",
                        maxlength: "Please enter no more than 6 digits.",
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $(".resendPhone").click({
                param: "phone"
            }, resendCode);
            $(".resendEmail").click({
                param: "email"
            }, resendCode);

        });

        function resendCode(event) {
            var user_id = $("#user_id").val();
            var type = event.data.param;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('resendCode') }}",
                type: 'POST',
                data: {
                    id: user_id,
                    type: type,
                },
                success: function(response) {
                    if (response.data == 'phone') {
                        AIZ.plugins.notify('success',
                            '{{ translate('Check you phone code on your phone sms. ') }}');
                    } else if (response.data == 'email') {
                        AIZ.plugins.notify('success',
                            '{{ translate('Check you email code on your mail. ') }}');
                    } else {
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                }
            });
        }

        @if (get_setting('google_recaptcha') == 1)
            // making the CAPTCHA  a field for form submission
            $(document).ready(function() {
                $("#reg-form").on("submit", function(evt) {
                    var response = grecaptcha.getResponse();
                    if (response.length == 0) {
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
