@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{translate('All Doodle')}}</h1>
        </div>
        @can('add_blog')
            <div class="col text-right">
                <a href="{{ route('doodle.create') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Add New Doodle')}}</span>
                </a>
            </div>
        @endcan
    </div>
</div>
<br>

<div class="card">
    <form class="" id="sort_doodles" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('All Doodles') }}</h5>
            </div>
            
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control form-control-sm" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & Enter') }}">
                </div>
            </div>
        </div>
        </form>
        <div class="card-body">
            <table class="table mb-0 aiz-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{translate('Title')}}</th>
                        <th>{{translate('Header Image')}}</th>
                        <th>{{translate('Banner')}}</th>
                        <th>{{translate('Publish Date')}}</th>
                        <th class="text-right">{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doodles as $key => $doodle)
                    <tr>
                        <td>{{ ($key+1)}}</td>
                        <td>{{ $doodle->title }}</td>
                        <td>
                            <img class="lazyload mw-100 size-60px mx-auto"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($doodle->header_image) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        </td>
                        <td>
                            <img class="lazyload mw-100 size-60px mx-auto" style="width: 110px;"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($doodle->banner) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        </td>
                        <td>{{ date('d-m-Y', strtotime($doodle->publish_date)) }}</td>
                        <td class="text-right">
                            @can('edit_blog')
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('doodle.edit',$doodle->id)}}" title="{{ translate('Edit') }}">
                                    <i class="las la-pen"></i>
                                </a>
                            @endcan
                            @can('delete_blog')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('doodle.destroy', $doodle->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $doodles->appends(request()->input())->links() }}
            </div>
        </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
