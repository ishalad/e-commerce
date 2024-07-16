@extends('backend.layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Create New Homepage Section') }}</h5>
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
                    <form action="{{ route('update_homepage_section', $section->id) }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="title">
                                {{ translate('Title') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Title') }}" id="name" name="title"
                                    class="form-control" required value="{{ $section->title }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">
                                {{ translate('Device Type') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control aiz-selectpicker" name="device_type" id="device_type" required>
                                    <option value="all" @if ($section->device_type == 'all') selected @endif>
                                        {{ translate('All') }}</option>
                                    <option value="web" @if ($section->device_type == 'web') selected @endif>
                                        {{ translate('Web') }}</option>
                                    <option value="mobile" @if ($section->device_type == 'mobile') selected @endif>
                                        {{ translate('Mobile') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">
                                {{ translate('section_type') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control aiz-selectpicker" name="section_type" id="section_type"
                                    required>
                                    <option value="category" @if ($section->section_type == 'category') selected @endif>
                                        {{ translate('Category') }}</option>
                                    <option value="product" @if ($section->section_type == 'product') selected @endif>
                                        {{ translate('Product') }}</option>
                                    <option value="brand" @if ($section->section_type == 'brand') selected @endif>
                                        {{ translate('Brand') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="" id="select_section">
                            <div class="form-group row category_select_block">
                                @if ($section->section_type == 'category')
                                <label class="col-sm-3 col-from-label" for="category_ids">
                                    {{ translate('Categories') }}
                                </label>
                                    <div class="col-sm-9 category_select" id="category_select">
                                        <select name="category_ids[]" class="form-control aiz-selectpicker"
                                            data-multiple="true" multiple id="category_ids" data-live-search="true">
                                            @foreach ($categories = \App\Models\Category::where('parent_id', 0)->get() as $category)
                                                <option value="{{ $category->id }}"  @if(in_array($category->id, $section->category_ids)) selected @endif>
                                                    {{ $category->getTranslation('name') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if ($section->section_type == 'product')
                                    <label class="col-sm-3 col-from-label" for="product_ids">
                                        {{ translate('Products') }}
                                    </label>
                                    <div class="col-sm-9 product_select" id="product_select">
                                        <select name="product_ids[]" class="form-control aiz-selectpicker"
                                            data-multiple="true" multiple id="product_ids" data-live-search="true">
                                            @foreach ($products = \App\Models\Product::all() as $product)
                                                <option value="{{ $product->id }}"  @if(in_array($product->id, $section->product_ids)) selected @endif>
                                                    {{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if ($section->section_type == 'brand')
                                <label class="col-sm-3 col-from-label" for="brand_ids">
                                    {{ translate('Products') }}
                                </label>
                                <div class="col-sm-9 product_select" id="product_select">
                                    <select name="brand_ids[]" class="form-control aiz-selectpicker"
                                        data-multiple="true" multiple id="brand_ids" data-live-search="true">
                                        @foreach ($brands = \App\Models\Brand::all() as $brand)
                                            <option value="{{ $brand->id }}"  @if(in_array($brand->id, $section->brand_ids)) selected @endif>
                                                {{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Active') }}</label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0 d-block">
                                    <input type="checkbox" name="is_active" value="{{ $section->is_active }}"
                                        @if ($section->is_active == 1) checked @endif>
                                    <span></span>
                                </label>
                                {{-- <small class="text-muted">{{ translate('If you enable this, this product will be granted as a featured product.') }}</small> --}}
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script> --}}
<script type="text/javascript">
    $(document).ready(function() {
        $('#section_type').on('change', function() {
            var brands = {!! json_encode(\App\Models\Brand::all()) !!};
            if ($(this).val() == 'category') {
                $('#select_section').empty();
                var html = `<div class="form-group row category_select_block">
                                    <label class="col-sm-3 col-from-label" for="name">
                                        {{ translate('Categories') }}
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
                if ($('#category_select').length > 0) {
                    console.log('here');
                    $('.aiz-selectpicker').selectpicker('refresh');
                }
            }

            if ($(this).val() == 'brand') {
                console.debug('here');
                $('#select_section').empty();
                var html = `<div class="form-group row brand_select_block">
                                    <label class="col-sm-3 col-from-label" for="name">
                                        {{ translate('Brands') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9 brand_select" id="brand_select">
                                        </div>
                                </div>`;
                $('#select_section').append(html);
                var $select = $('<select>', {
                    id: 'brand_ids',
                    name: 'brand_ids[]',
                    class: 'form-control aiz-selectpicker',
                    required: true
                });
                $select.attr('multiple', 'multiple');

                console.debug(brands);
                $.each(brands, function(key, value) {
                    console.debug(value, key);
                    $select.append($('<option>', {
                        value: value.id,
                        text: value.name
                    }));
                });

                $('#brand_select').append($select);
                if ($('#brand_select').length > 0) {
                    console.log('here');
                    $('.aiz-selectpicker').selectpicker('refresh');
                }
            }
            if ($(this).val() == 'product') {
                $('#select_section').empty();
                var html = `<div class="form-group row product_select_block">
                                    <label class="col-sm-3 col-from-label" for="name">
                                        {{ translate('Products') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9 product_select" id="product_select">
                                        </div>
                                </div>`;
                $('#select_section').append(html);
                var $select = $('<select>', {
                    id: 'product_ids',
                    name: 'product_ids[]',
                    class: 'form-control aiz-selectpicker',
                    required: true
                });
                $select.attr('multiple', 'multiple');
                var products = {!! json_encode(\App\Models\Product::all()) !!};
                $.each(products, function(key, value) {
                    $select.append($('<option>', {
                        value: value.id,
                        text: value.name
                    }));
                });

                $('#product_select').append($select);
                if ($('#product_select').length > 0) {
                    console.log('here');
                    $('.aiz-selectpicker').selectpicker('refresh');
                }
            }
        });
    });
    let section_type = '{{ $section->section_type }}';
    $(document).on('load', function() {
        let device_type = '{{ $section->device_type }}';
        $('#device_type option[value="' + device_type + '"]').prop('selected', true);
        $('#section_type option[value="' + section_type + '"]').prop('selected', true);
        var section = '{{ $section->section_type }}';
        if (section == 'category') {
            let categories = {!! json_encode($section->category_ids ?? []) !!};
            categories.each(category => {
                $('#category_ids option[value="' + category + '"]').prop('selected', true);
            })
        }
        if (section == 'brand') {
            let brands = {!! json_encode($section->brand_ids ?? []) !!};
            brands.each(brand => {
                $('#brand_ids option[value="' + brand + '"]').prop('selected', true);
            })
        }
        if (section == 'product') {
            let products = {!! json_encode($section->product_ids ?? []) !!};
            products.each(product => {
                $('#product_ids option[value="' + product + '"]').prop('selected', true);
            })
        }
    });
</script>
