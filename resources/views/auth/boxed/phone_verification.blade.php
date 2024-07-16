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
                                        <h1 class="fs-20 fs-md-24 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('Verify your phone')}}</h1>
                                    </div>
                                    <!-- Register form -->
                                    <div class="pt-3 pt-lg-4">
                                        <div class="">
                                            @if ($user->user_type == "customer")
                                                <form id="verify-phone" class="form-default" action="{{ route('customer.verify.phone') }}" method="POST">
                                            @else
                                                <form id="verify-phone" class="form-default" action="{{ route('verify.phone') }}" method="POST">
                                            @endif
                                                @csrf
                                                <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                                                <div class="form-group">
                                                    <label for="phone" class="fs-12 fw-700 text-soft-dark">{{ translate('Your Phone')}}</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-5 col-lg-5">
                                                            <select class="form-control aiz-selectpicker" data-live-search="true" name="phone_code" id="phone_code">
                                                                <option value="+91">{{ translate('India') }}({{ translate('+91') }})</option>
                                                                @foreach (\App\Models\CountryCodes::where('phonecode', '!=', '+91')->get() as $key => $countrycode)
                                                                    <option value="{{ $countrycode->phonecode }}">{{ $countrycode->name }} ({{ $countrycode->phonecode }}) </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-7 col-lg-7">
                                                            <input type="number" class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="{{  translate('Phone') }}" name="phone" id="phone">
                                                            @if ($errors->has('phone'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group verify_code">
                                                    <label for="verify_code" class="fs-12 fw-700 text-soft-dark">{{ translate('Your Phone Code')}}</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-5 col-lg-5">
                                                            <input type="number" class="form-control rounded-0{{ $errors->has('verify_code') ? ' is-invalid' : '' }}" placeholder="{{  translate('Phone Code') }}" name="verify_code">
                                                            @if ($errors->has('verify_code'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('verify_code') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-5 col-lg-5">
                                                            <a href="#" style="color:#28306d;" class="resend">{{ translate('Resend Code')}}</a>
                                                        </div>
                                                        <div class="col-md-7 col-lg-7">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                                <!-- Submit Button -->
                                                <div class="mb-4 mt-4">
                                                    <button type="submit" class="btn btn-primary btn-block fw-600 rounded-0">{{  translate('Register Your Shop') }}</button>
                                                </div>
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
        </section>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/boosted/5.3.3/js/boosted.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('.verify_code').hide();
        $('#verify-phone').validate({
            rules: {
                phone: {
                    required: true,
                    minlength:10,
                    maxlength:10
                },
                verify_code: {
                    required: true,
                    minlength:6,
                    maxlength:6
                },
            },
            messages: {
                phone: {
                    minlength: "Please enter at least 10 digits.",
                    maxlength: "Please enter no more than 10 digits.",
                },
                verify_code: {
                    minlength: "Please enter at least 6 digits.",
                    maxlength: "Please enter no more than 6 digits.",
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $("#phone").keyup(function() {
            var check = $('#phone').val().length;
            if(check == 10) {
                storePhoneOTP();   
            } else {
                $('.verify_code').hide();
            }
        });

        $('.resend').on("click",function(){
            storePhoneOTP();
        });

        function storePhoneOTP() {
            var user_id = $("#user_id").val();
                var phone = $("#phone_code").val() + ' ' +$("#phone").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('phone.store')}}",
                    type: 'POST',
                    data: {
                        id : user_id,
                        phone : phone
                    },
                    success: function (response) {
                        if(response == 1) {
                            $('.verify_code').show();
                            AIZ.plugins.notify('success', '{{ translate('Check you phon code on your phone sms. ') }}');
                        } else {
                            $('.verify_code').hide();
                        }
                    }
                }); 
        }
    });
    </script>
@endsection