@extends('frontend.layouts.user_panel')

@section('panel_content')
    @if ($user->gst_status == 1)
        <style>
            .GSTDetails {display: block;}
        </style>
    @elseif($user->gst_status == 2)
        <style>
            .EnrollmentNumberDetails {display: block;}
        </style>
    @else
        <style>
            .GSTDetails {display: none}
            .EnrollmentNumberDetails {display: none}
        </style>
    @endif

    <div class="aiz-titlebar mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="fs-20 fw-700 text-dark">{{ translate('GST Details') }}</h1>
        </div>
      </div>
    </div>

    <form action="{{ route('user.gst_verify') }}" id="gstVerificationForm" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('GST Number') }}</h5>
            </div>
            <div class="card-body">
                @if($user->gst_status == 0)
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
                                <label class="col-md-3 col-form-label" for="gst_business_name">{{ translate("Business Name (As Per GST Document)") }}</label>
                                <div class="col-md-9">
                                    <input type="text" name="gst_business_name" id="gst_business_name" class="form-control" placeholder="{{ translate("Business Name") }}">
                                    @error("gst_business_name")
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="gst_number">{{ translate("GST Number") }}</label>
                                <div class="col-md-9">
                                    <input type="text" name="gst_number" value="" id="gst_number" class="form-control" placeholder="{{ translate("GST Number") }}">
                                    @error("gst_number")
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate("GST Documents") }}</label>
                                <div class="col-md-9">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate("Browse") }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate("Choose File") }}</div>
                                        <input type="hidden" name="gst_document" id="gst_document" class="selected-files" required>
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 text-right">
                                <button type="submit" class="btn btn-primary">{{ translate("Update GST Number") }}</button>
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
                            @if ($user->gst_status == 1)
                                <label class="col-md-3 col-form-label"
                                    for="gst_number">{{ translate('GST Number') }}</label>
                            @elseif($user->gst_status == 2)
                                <label class="col-md-3 col-form-label"
                                    for="gst_number">{{ translate('Enroll Number') }}</label>
                            @endif
                            <div class="col-md-9">
                                <label class="col-form-label" for="gst_number">{{ $user->gst_number }}</label>
                            </div>
                        </div>
                        @if ($user->gst_status == 1)
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

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
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
        })
    </script>
    
    <script type="text/javascript">
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
    </script>

    @if (get_setting('google_map') == 1)
        @include('frontend.'.get_setting('homepage_select').'.partials.google_map')
    @endif

@endsection
