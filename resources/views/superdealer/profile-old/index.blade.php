@extends('superdealer.layouts.app')

@section('panel_content')
    <form action="{{ route('superdealer.profile.update', $user->id) }}" id="superdealerProfileForm" method="POST">
        @csrf
        <input type="hidden" name="dealer_page" value="dealer_profile">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Manage Profile') }}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="name">{{ translate('Dealer Name') }}</label>
                    <div class="col-md-10">
                        <input type="text" name="name" value="{{ $user->name }}" id="name" class="form-control"
                            placeholder="{{ translate('Dealer Name') }}">
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="phone">{{ translate('Dealer Phone') }}</label>
                    <div class="col-md-10">
                        <input type="text" name="phone" value="{{ $user->phone }}" id="phone" class="form-control" placeholder="{{ translate('Dealer Phone')}}">
                        @error('phone')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="email">{{ translate('Dealer Email') }}</label>
                    <div class="col-md-10">
                        <input type="email" name="email" value="{{ $user->email }}" id="email" class="form-control" placeholder="{{ translate('Dealer Email')}}">
                        @error('email')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="password">{{ translate('Dealer Password') }}</label>
                    <div class="col-md-10">
                        <input type="password" name="new_password" id="password" class="form-control" placeholder="{{ translate('New Password') }}">
                        @error('new_password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"
                        for="confirm_password">{{ translate('Dealer Confirm Password') }}</label>
                    <div class="col-md-10">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                            placeholder="{{ translate('Dealer Confirm Password') }}">
                        @error('confirm_password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="business_name">{{ translate('Dealer Business Name') }}</label>
                    <div class="col-md-10">
                        <input type="text" name="business_name" value="{{ $user->business_name }}" id="business_name" class="form-control" placeholder="{{ translate('Dealer Business Name')}}">
                        @error('business_name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{ translate('Update Profile') }}</button>
                </div>
            </div>
        </div>
    </form>
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
        });
    </script>
@endsection