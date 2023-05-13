@extends('admin.layout.main')
@section('title', 'Create Products')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Products</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Products</li>
                        </ol>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div><!-- /.container-fluid -->
        </section>

        <form action="{{ route('store.products') }}" method='POST' enctype="multipart/form-data" style="display:inline">
            @csrf
            <div class="card col-12 col-md-12 col-lg-12 ">
                {{-- Left --}}
                <div class="card-body row">
                    @csrf
                    <div class="col-9">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" name="name" id="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="detail">Description</label>
                            <textarea id="description" class="form-control" cols="50" rows="3" name="description"
                                placeholder="Enter describtion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="additional_information">Additional Information</label>
                            <textarea id="additional_information" class="form-control" cols="50" rows="10" name="additional_information"
                                placeholder="Enter detail"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attribute</label>
                            <a class="float-right" href="{{ route('list.attributeTypes') }}">Add new attribute</a>
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                    @foreach ($aryAttributeType as $key => $type)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $key == 0 ? 'active' : '' }}" data-toggle="pill"
                                                href="#{{ $type->name . '_' . $type->id }}" role="tab"
                                                aria-controls="custom-tabs-three-home"
                                                aria-selected="true">{{ $type->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    @foreach ($aryAttributeType as $key => $type)
                                        <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}"
                                            id="{{ $type->name . '_' . $type->id }}" role="tabpanel"
                                            aria-labelledby="custom-tabs-three-home-tab">
                                            <div class="row">
                                                @foreach ($type->attributesValue as $value)
                                                    <div class="col-2 custom-control custom-checkbox">
                                                        <input class="custom-control-input "
                                                            name="attribute_value[{{ $type->id }}][]" type="checkbox"
                                                            value="{{ $value->id }}"
                                                            id="{{ $value->name . '_' . $value->id }}" />
                                                        <label for="{{ $value->name . '_' . $value->id }}"
                                                            class="custom-control-label">{{ $value->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- /.card -->
                            <div class="input-field">
                                <label class="active">Related Image</label>
                                <div class="input-images-1" style="padding-top: .5rem;"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Right --}}
                    <div class="col-3">
                        <div class="form-group">
                            <label>SKU</label>
                            <input class="form-control" name="sku" id="sku" placeholder="SKU">
                        </div>
                        <div class="form-group">
                            <label>Price($)</label>
                            <input class="form-control" name="price" id="price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity"
                                placeholder="quantity">
                        </div>
                        <div class="form-group">
                            <label>Tag</label>
                            <select class="tag" multiple="multiple" data-placeholder="Select a Tag"
                                name="tag[]" style="width: 100%;">
                                @foreach ($aryTag as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <div class='scroll-category'>
                                @foreach ($aryCategory as $category)
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input " name="category[]" type="checkbox"
                                            id="{{ $category->name }}_{{ $category->id }}"
                                            value="{{ $category->id }}" />
                                        <label for="{{ $category->name }}_{{ $category->id }}"
                                            class="custom-control-label">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Related product</label>
                            <select class="related_product" multiple="multiple" data-placeholder="Select a Product"
                                name="related_product_id[]" style="width: 100%;">
                                @foreach ($aryProduct as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status">
                                <option value="1">On</option>
                                <option value="2">Off</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" value='1' id="new_product"
                                    name='is_new' />
                                <label class="custom-control-label" for="new_product">New product</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" value='1' id="sale_product"
                                    name='is_sale' />
                                <label class="custom-control-label" for="sale_product">Sale product</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" value='1'
                                    id="highlight_product" name='highlight' />
                                <label class="custom-control-label" for="highlight_product">Highlight product</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customFile">Primary Image<span style="color: red">*</span></label>
                            <div class="card card-profile">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail mt-4">
                                        <img src="{{ asset('/img/noimage.png') }}">
                                    </div>
                                    <div
                                        class="fileinput-preview fileinput-exists thumbnail img-fluid mt-4">
                                    </div>
                                    <div>
                                        <span class="btn btn-primary btn-round btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" id="image_product" name="image" />
                                        </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                            data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>


    </div>
    <!-- /.content-wrapper -->
@endsection
@push('js')
    <script>
        CKEDITOR.replace('additional_information');

        CKEDITOR.replace('description');

        $(document).ready(function() {
            $('.related_product').select2();
            $('.tag').select2();

        })

        $('.input-images-1').imageUploader({
            imagesInputName: 'image-prod',
        });
    </script>
@endpush
