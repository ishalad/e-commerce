@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('All Sellers')}}</h1>
        </div>
    </div>
</div>

<div class="card">
    <form class="" id="sort_sellers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('Sellers') }}</h5>
            </div>

            @can('delete_seller')
                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{translate('Bulk Action')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item confirm-alert" href="javascript:void(0)"  data-target="#bulk-delete-modal">{{translate('Delete selection')}}</a>
                    </div>
                </div>
            @endcan

            <div class="col-md-3 ml-auto">
                <select class="form-control aiz-selectpicker" name="approved_status" id="approved_status" onchange="sort_sellers()">
                    <option value="">{{translate('Filter by Approval')}}</option>
                    <option value="0"  @isset($approved) @if($approved == '0') selected @endif @endisset>{{translate('Pending')}}</option>
                    <option value="1"  @isset($approved) @if($approved == '1') selected @endif @endisset>{{translate('Approved')}}</option>
                    <option value="2"  @isset($approved) @if($approved == '2') selected @endif @endisset>{{translate('Reject')}}</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                  <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name or email & Enter') }}">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                <tr>

                    <th>
                        @if(auth()->user()->can('delete_seller'))
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        @else
                            #
                        @endif
                    </th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{translate('Phone')}}</th>
                    <th data-breakpoints="lg">{{translate('Email Address')}}</th>
                    <th data-breakpoints="lg">{{translate('Verification Info')}}</th>
                    <th data-breakpoints="lg">{{translate('Approval')}}</th>
                    <th data-breakpoints="lg">{{ translate('Num. of Products') }}</th>
                    <th data-breakpoints="lg">{{ translate('Due to seller') }}</th>
                    <th data-breakpoints="lg">{{ translate('Status') }}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shops as $key => $shop)
                    <tr>
                        <td>
                            @if(auth()->user()->can('delete_seller'))
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]" value="{{$shop->id}}">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            @else
                                {{ ($key+1) + ($shops->currentPage() - 1)*$shops->perPage() }}
                            @endif
                        </td>
                        <td>@if($shop->user->banned == 1) <i class="fa fa-ban text-danger" aria-hidden="true"></i> @endif {{$shop->name}}</td>
                        <td>{{$shop->user->phone}}</td>
                        <td>{{$shop->user->email}}</td>
                        <td>
                            @if ($shop->verification_status != 1 && $shop->verification_info != null)
                                <a href="{{ route('sellers.show_verification_request', $shop->id) }}">
                                    <span class="badge badge-inline badge-info">{{translate('Show')}}</span>
                                </a>
                            @endif
                        </td>
                        <td>
                            <select class="form-control" name="approval_status" id="approval_status" onchange="update_approved(this)">
                                <option value="0" data-id="{{ $shop->id }}"  @isset($shop->verification_status) @if($shop->verification_status == '0') selected @endif @endisset>{{translate('Pending')}}</option>
                                <option value="1" data-id="{{ $shop->id }}"  @isset($shop->verification_status) @if($shop->verification_status == '1') selected @endif @endisset>{{translate('Approved')}}</option>
                                <option value="2" data-id="{{ $shop->id }}"  @isset($shop->verification_status) @if($shop->verification_status == '2') selected @endif @endisset>{{translate('Reject')}}</option>
                            </select>
                        </td>
                        <td>{{ $shop->user->products->count() }}</td>
                        <td>
                            @if ($shop->admin_to_pay >= 0)
                                {{ single_price($shop->admin_to_pay) }}
                            @else
                                {{ single_price(abs($shop->admin_to_pay)) }} ({{ translate('Due to Admin') }})
                            @endif
                        </td>
                        <td>
                            @if($shop->user->banned)
                                <span class="badge badge-inline badge-danger">{{ translate('Ban') }}</span>
                            @else
                                <span class="badge badge-inline badge-success">{{ translate('Regular') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="las la-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                    @can('view_seller_profile')
                                        <a href="javascript:void();" onclick="show_seller_profile('{{$shop->id}}');"  class="dropdown-item">
                                            {{translate('Profile')}}
                                        </a>
                                    @endcan
                                    @can('login_as_seller')
                                        <a href="{{route('sellers.login', encrypt($shop->id))}}" class="dropdown-item">
                                            {{translate('Log in as this Seller')}}
                                        </a>
                                    @endcan
                                    @can('pay_to_seller')
                                        <a href="javascript:void();" onclick="show_seller_payment_modal('{{$shop->id}}');" class="dropdown-item">
                                            {{translate('Go to Payment')}}
                                        </a>
                                    @endcan
                                    @can('seller_payment_history')
                                        <a href="{{route('sellers.payment_history', encrypt($shop->user_id))}}" class="dropdown-item">
                                            {{translate('Payment History')}}
                                        </a>
                                    @endcan
                                    @can('edit_seller')
                                        <a href="{{route('sellers.edit', encrypt($shop->id))}}" class="dropdown-item">
                                            {{translate('Edit')}}
                                        </a>
                                    @endcan
                                    <a href="javascript:void(0)" onclick="SendMessage('{{$shop->id}}')" class="dropdown-item">
                                        {{translate('Send Message')}}
                                    </a>
                                    @can('ban_seller')
                                        @if($shop->user->banned != 1)
                                            <a href="javascript:void();" onclick="confirm_ban('{{route('sellers.ban', $shop->id)}}');" class="dropdown-item">
                                                {{translate('Ban this seller')}}
                                                <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a href="javascript:void();" onclick="confirm_unban('{{route('sellers.ban', $shop->id)}}');" class="dropdown-item">
                                                {{translate('Unban this seller')}}
                                                <i class="fa fa-check text-success" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    @endcan
                                    @can('delete_seller')
                                        <a href="javascript:void();" class="dropdown-item confirm-delete" data-href="{{route('sellers.destroy', $shop->id)}}" class="">
                                            {{translate('Delete')}}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
              {{ $shops->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>

@endsection

@section('modal')
	<!-- Delete Modal -->
	@include('modals.delete_modal')
    <!-- Bulk Delete modal -->
    @include('modals.bulk_delete_modal')

	<!-- Seller Profile Modal -->
	<div class="modal fade" id="profile_modal">
		<div class="modal-dialog">
			<div class="modal-content" id="profile-modal-content">

			</div>
		</div>
	</div>

	<!-- Seller Payment Modal -->
	<div class="modal fade" id="payment_modal">
	    <div class="modal-dialog">
	        <div class="modal-content" id="payment-modal-content">

	        </div>
	    </div>
	</div>

     <!-- Seller Message Modal -->
	<div class="modal fade" id="message_modal">
	    <div class="modal-dialog">
	        <div class="modal-content" id="message-modal-content">

	        </div>
	    </div>
	</div>

	<!-- Ban Seller Modal -->
	<div class="modal fade" id="confirm-ban">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
					<button type="button" class="close" data-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
                    <p>{{translate('Do you really want to ban this seller?')}}</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
					<a class="btn btn-primary" id="confirmation">{{translate('Proceed!')}}</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Unban Seller Modal -->
	<div class="modal fade" id="confirm-unban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                        <p>{{translate('Do you really want to unban this seller?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <a class="btn btn-primary" id="confirmationunban">{{translate('Proceed!')}}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Remark --}}
    <div class="modal fade" id="remark">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-default" id="sellers-status" action="{{ route('sellers.approved') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="status" id="status">
                    <div class="modal-header">
                        <h5 class="modal-title h6 remark_header"></h5>
                        <button type="button" class="close" data-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{ translate('Remark') }}</label>
                            <div class="col-md-10">
                                <textarea class="form-control" placeholder="Remark here..." name="remark_details"></textarea>
                                @error('remark_details')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row d-flex justify-content-end mr-2">
                            <button type="button" class="btn btn-light mr-2" data-dismiss="modal">{{translate('Cancel')}}</button>
                            <button type="submit" class="btn btn-primary">{{ translate('Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

    <script type="text/javascript">
     @if (count($errors) > 0)
            $('#remark').modal({backdrop: 'static', keyboard: false}, 'show');
        @endif

        $(document).ready(function() {
            $('#sellers-status').validate({
                rules: {
                    remark_details: {
                        required: true
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
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

        function show_seller_payment_modal(id){
            $.post('{{ route('sellers.payment_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#payment_modal #payment-modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});
                $('.demo-select2-placeholder').select2();
            });
        }

        function show_seller_profile(id){
            $.post('{{ route('sellers.profile_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#profile_modal #profile-modal-content').html(data);
                $('#profile_modal').modal('show', {backdrop: 'static'});
            });
        }

        function update_approved(el){
            var approval_status = el.value;
            $('.remark_header').text('');
            $('input[name=id]').val($('#approval_status option:selected').data('id'));
            if(approval_status == 0) {
                $('.remark_header').append('Pending Remark');
                $('#status').val(approval_status);
            } else if(approval_status == 1) {
                $('.remark_header').append('Approve Remark');
                $('#status').val(approval_status);
            } else if(approval_status == 2) {
                $('.remark_header').append('Reject Remark');
                $('#status').val(approval_status);
            }
            $('#remark').modal({backdrop: 'static', keyboard: false}, 'show');
        }

        function sort_sellers(el){
            $('#sort_sellers').submit();
        }

        function confirm_ban(url)
        {
            if('{{env('DEMO_MODE')}}' == 'On'){
                AIZ.plugins.notify('info', '{{ translate('Data can not change in demo mode.') }}');
                return;
            }

            $('#confirm-ban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmation').setAttribute('href' , url);
        }

        function confirm_unban(url)
        {
            if('{{env('DEMO_MODE')}}' == 'On'){
                AIZ.plugins.notify('info', '{{ translate('Data can not change in demo mode.') }}');
                return;
            }

            $('#confirm-unban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmationunban').setAttribute('href' , url);
        }

        function bulk_delete() {
            var data = new FormData($('#sort_sellers')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('bulk-seller-delete')}}",
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
        function SendMessage(id){
            $.post('{{ route('sellers.send_message') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#message_modal #message-modal-content').html(data);
                $('#message_modal').modal('show', {backdrop: 'static'});
            });
        }
    </script>
@endsection
