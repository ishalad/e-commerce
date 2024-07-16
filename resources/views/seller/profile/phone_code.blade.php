@extends('seller.layouts.app')

@section('panel_content')
    <form action="{{ route('phone.code.verify') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Phone Verification') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Your Phone Code') }}</label>
                    </div>
                    <div class="col-md-10">
                        <div class="input-group mb-3">
                            <input type="number" name="phone_code" id="phone_code" class="form-control"
                            placeholder="{{ translate('Your Phone Code') }}" min="000000" max="999999" value="{{$phoneotp}}" required readonly>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Verify Phone') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
