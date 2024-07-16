@extends('seller.layouts.app')

@section('panel_content')
    <div class="card">
        <form class="" action="" id="sort_commission_history" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Admin Message') }}</h5>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="search" name="search" @isset($search) value="{{ $search }}" @endisset placeholder="{{ translate('Search message') }}">
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Message From') }}</th>
                        <th>{{ translate('Message') }}</th>
                        <th>{{ translate('Message Date') }}</th>
                        <th>{{ translate('Is Read') }}</th>
                        <th>{{ translate('Is Repaly') }}</th>
                        <th>{{ translate('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $key => $msg)
                    <tr>
                        <td>{{ ($key+1) }}</td>
                        <td>{{ 'Admin' }}</td>
                        <td>{{ truncateText($msg->message) }}</td>
                        <td>{{ date('h:i:m d-m-Y', strtotime($msg->created_at)) }}</td>
                        <td>{{ $msg->is_view == 0 ? 'No' : 'Yes' }}</td>
                        <td>{{ $msg->is_replay == 0 ? 'No' : 'Yes' }}</td>
                        <td>
                            <a href="{{route('seller.profile.show_message', encrypt($msg->id))}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Log in as this Customer') }}">
                                <i class="las la-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination mt-4">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
@endsection
