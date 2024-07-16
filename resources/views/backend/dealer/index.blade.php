@extends('backend.layouts.app')

@section('content')

@php
    CoreComponentRepository::instantiateShopRepository();
    CoreComponentRepository::initializeCache();
@endphp

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('All')." ". Str::ucfirst(str_replace('_', ' ', $type))}}</h1>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-block d-md-flex">
        <h5 class="mb-0 h6">{{ Str::ucfirst(str_replace('_', ' ', $type)) }}</h5>
        <form class="" id="sort_categories" action="" method="GET">
            <div class="box-inline pad-rgt pull-left">
                <div class="" style="min-width: 200px;">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{ translate('Email Address') }}</th>
                    <th data-breakpoints="lg">{{ translate('Contact Number') }}</th>
                    <th data-breakpoints="lg">{{ translate('Business Name') }}</th>
                    <th data-breakpoints="lg">{{ translate('Status') }}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                    <tr>
                        <td>{{ ($key+1) + ($users->currentPage() - 1)*$users->perPage() }}</td>
                        <td class="d-flex align-items-center">{{ $user->name }}</td>
                        <td>{{ !empty($user->email) ? $user->email : '-NA-' }}</td>
                        <td>{{ !empty($user->phone) ? $user->phone : '-NA-' }}</td>
                        <td>{{ !empty($user->business_name) ? $user->phone : '-NA-' }}</td>
                        <td>{!! $user->dealer_status == "0" ?  "<span class='badge badge-inline badge-primary'>Pending</span>" : ($user->dealer_status == "1" ? "<span class='badge badge-inline badge-success'>Approved</span>" :  "<span class='badge badge-inline badge-danger'>Rejected</span>") !!}</td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('edit-dealer', ['id'=>$user->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <!--<a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('categories.destroy', $user->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>-->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection


@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('categories.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Featured categories updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
