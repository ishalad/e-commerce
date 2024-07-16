@extends('superdealer.layouts.app')

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Dealers') }}</h1>
        </div>
      </div>
    </div>

    <div class="card">
        <form class="" id="sort_dealers" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('All Dealers') }}</h5>
                </div>

                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="search" name="search" @isset($search) value="{{ $search }}" @endisset placeholder="{{ translate('Search dealer') }}">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th width="20%">{{ translate('Name')}}</th>
                            <th width="20%">{{ translate('Phone')}}</th>
                            <th width="30%">{{ translate('Email')}}</th>
                            <th width="40%">{{ translate('Business Name')}}</th>
                            <th width="30%">{{ translate('Status')}}</th>
                            <th data-breakpoints="md" class="text-right">{{ translate('Options')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($dealears as $key => $dealear)
                            <tr>
                                <td>{{ $dealear->name }}</td>
                                <td>{{ $dealear->phone }}</td>
                                <td>{{ $dealear->email }}</td>
                                <td>{{ $dealear->business_name }}</td>
                                <td>Temp</td>
                                <td class="text-right">
                                <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{route('superdealer.dealers.edit', ['id'=>$dealear->id])}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $dealears->links() }}
                </div>
            </div>
        </form>
    </div>

@endsection

@section('modal')
    <!-- Delete modal -->
    @include('modals.delete_modal')
    <!-- Bulk Delete modal -->
    @include('modals.bulk_delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;                       
                });
            }
          
        });

        function bulk_delete() {
            var data = new FormData($('#sort_dealers')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('seller.products.bulk-delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }

    </script>
@endsection
