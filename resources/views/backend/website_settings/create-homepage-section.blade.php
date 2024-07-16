@extends('backend.layouts.app')
@section('content')

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Create New Homepage Section')}}</h5>
            </div>
            <div class="card-body">
                <!-- Error Meassages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('save_homepage_section') }}" method="POST" >
                  	@csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="title">
                            {{translate('Title')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Title')}}" id="name" name="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">
                            {{translate('Device Type')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control aiz-selectpicker" name="device_type"  id="device_type" required>
                                <option value="all">{{ translate('All') }}</option>
                                <option value="web">{{ translate('Web') }}</option>
                                <option value="mobile">{{ translate('Mobile') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">
                            {{translate('section_type')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control aiz-selectpicker" name="section_type"  id="section_type" required>
                                <option value="category">{{ translate('Category') }}</option>
                                <option value="product">{{ translate('Product') }}</option>
                                <option value="brand">{{ translate('Brand') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="" id="select_section">
                        <div class="form-group row category_select_block">
                            <label class="col-sm-3 col-from-label" for="category_ids">
                                {{translate('Categories')}}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9 category_select" id="category_select">
                                <select name="category_ids[]" class="form-control aiz-selectpicker" data-multiple="true" multiple id="category_ids" data-live-search="true">
                                    @foreach ($categories = \App\Models\Category::where('parent_id', 0)->get() as $category)
                                        <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Active')}}</label>
                        <div class="col-md-9">
                            <label class="aiz-switch aiz-switch-success mb-0 d-block">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span></span>
                            </label>
                            {{-- <small class="text-muted">{{ translate('If you enable this, this product will be granted as a featured product.') }}</small> --}}
                        </div>
                    </div>
                    
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#section_type').on('change', function() {
                if ($(this).val() == 'category') {
                    $('#select_section').empty();
                    var html = `<div class="form-group row category_select_block">
                                    <label class="col-sm-3 col-from-label" for="name">
                                        {{translate('Categories')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9 category_select" id="category_select">
                                        </div>
                                </div>`;
                    $('#select_section').append(html);
                    var $select = $('<select>', {
                        id: 'category_ids',
                        name: 'category_ids[]',
                        class: 'form-control aiz-selectpicker',
                        required: true
                    });
                    $select.attr('multiple', 'multiple');
                    var categories = {!! json_encode(\App\Models\Category::all()) !!};
                    $.each(categories, function(key, value) {
                        $select.append($('<option>', {
                            value: value.id,
                            text: value.name
                        }));
                    });

                    $('#category_select').append($select);
                }

                if ($(this).val() == 'brand') {
                    // Remove any existing category select element
                    $('#select_section').empty();
                    var html = `<div class="form-group row brand_select_block">
                                    <label class="col-sm-3 col-from-label" for="name">
                                        {{translate('Brands')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9 brand_select" id="brand_select">
                                        </div>
                                </div>`;
                    $('#select_section').append(html);
                    // Create a new select element
                    var $select = $('<select>', {
                        id: 'brand_ids',
                        name: 'brand_ids[]',
                        class: 'form-control aiz-selectpicker',
                        required: true
                    });
                    $select.attr('multiple', 'multiple');
                    // Add options to the select element
                    var brands = {!! json_encode(\App\Models\Brand::all()) !!};
                    $.each(categories, function(key, value) {
                        $select.append($('<option>', {
                            value: value.id,
                            text: value.name
                        }));
                    });

                    // Append the select element to the form
                    $('#brand_select').append($select);
                }
                if ($(this).val() == 'product') {
                    // Remove any existing category select element
                    $('#select_section').empty();
                    var html = `<div class="form-group row product_select_block">
                                    <label class="col-sm-3 col-from-label" for="name">
                                        {{translate('Products')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9 product_select" id="product_select">
                                        </div>
                                </div>`;
                    $('#select_section').append(html);
                    // Create a new select element
                    var $select = $('<select>', {
                        id: 'product_ids',
                        name: 'product_ids[]',
                        class: 'form-control aiz-selectpicker',
                        required: true
                    });
                    $select.attr('multiple', 'multiple');
                    // Add options to the select element
                    var categories = {!! json_encode(\App\Models\Product::all()) !!};
                    $.each(categories, function(key, value) {
                        $select.append($('<option>', {
                            value: value.id,
                            text: value.name
                        }));
                    });

                    // Append the select element to the form
                    $('#product_select').append($select);
                    if ($('#product_select').length > 0) {
                        console.log('here');
                        $('.aiz-selectpicker').selectpicker('refresh');
                    }
                    // $('.aiz-selectpicker').selectpicker('refresh');
                }
            });
        });
            

    </script>