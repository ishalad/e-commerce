@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Home Page Section') }}</h1>
		</div>
	</div>
</div>

<div class="card">
	@can('add_website_page')
		<div class="card-header">
			<h6 class="mb-0 fw-600">{{ translate('All Sections') }}</h6>
			<a href="{{ route('create_homepage_section') }}" class="btn btn-circle btn-info">{{ translate('Add New Section') }}</a>
		</div>
	@endcan
	<div class="card-body">
		<table class="table aiz-table mb-0">
        <thead>
            <tr>
                {{-- <th data-breakpoints="lg">#</th> --}}
                <th>{{translate('Title')}}</th>
                <th data-breakpoints="md">{{translate('Device Type')}}</th>
                <th data-breakpoints="md">{{translate('Section Type')}}</th>
                {{-- <th data-breakpoints="md">{{translate('is_active')}}</th> --}}
                <th data-breakpoints="md">{{translate('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
        	@foreach ($sections as $key => $section)
        	<tr>
        		{{-- <td>{{ $key+1 }}</td> --}}
				<td>{{ $section->title }}</td>
				<td>{{ $section->device_type }}</td>
				<td>{{ $section->section_type }}</td>
				{{-- <td>{{ $section->is_active }}</td> --}}
        		<td class="text-right">
					@can('edit_homepage_section')
							<a href="{{route('edit_homepage_section', ['id'=>$section->id] )}}" class="btn btn-icon btn-circle btn-sm btn-soft-primary" title="Edit">
								<i class="las la-pen"></i>
							</a>
					@endcan
					{{-- @if($page->type == 'custom_page' && auth()->user()->can('delete_website_page'))
          				<a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('custom-pages.destroy', $page->id)}} " title="{{ translate('Delete') }}">
          					<i class="las la-trash"></i>
          				</a>
					@endif --}}
        		</td>
        	</tr>
        	@endforeach
        </tbody>
    </table>
	</div>
</div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
