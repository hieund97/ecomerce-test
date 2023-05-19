@extends('admin.layout.main')
@section('title', 'Edit Products')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Products</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Products</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <form action="{{ route('update.products', $product->id) }}" method='POST' enctype="multipart/form-data"
            style="display:inline">
            @method('PUT')
            @csrf
            <div class="card col-12 col-md-12 col-lg-12 ">
                {{-- Left --}}
                <div class="card-body row">
                    @csrf
                    <div class="col-9">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" name="name" id="name" placeholder="Name"
                                value="{{ $product->name }}">
                        </div>
                        <div class="form-group">
                            <label for="detail">Description</label>
                            <textarea id="description" class="form-control" cols="50" rows="3" name="description"
                                placeholder="Enter describtion">{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="additional_information">Additional Information</label>
                            <textarea id="additional_information" class="form-control" cols="50" rows="10" name="additional_information"
                                placeholder="Enter detail">{{ $product->additional_information }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Attribute</label>
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
                                                        <input
                                                            @foreach ($product->attribute_value as $valueProd)  {{ $valueProd->id == $value->id ? 'checked' : '' }} @endforeach
                                                            class="custom-control-input attribute-value-id-{{ $type->id }}"
                                                            name="attribute_value[{{ $type->id }}][]" type="checkbox"
                                                            data-type="{{ $type->id }}" value="{{ $value->id }}"
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
                                <div class="input-images-1" style="padding-top: .5rem;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right --}}
                    <div class="col-3">
                        <div class="form-group">
                            <label for="password">SKU</label>
                            <input class="form-control" name="sku" id="sku" placeholder="SKU"
                                value="{{ $product->sku }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Price($)</label>
                            <input class="form-control" name="price" id="price" placeholder="Price"
                                value="{{ $product->price }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity"
                                value="{{ $product->quantity }}" placeholder="quantity">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <div class='scroll-category'>
                                @foreach ($aryCategory as $category)
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input category-id" name="category[]" type="checkbox"
                                            id="{{ $category->name }}_{{ $category->id }}" value="{{ $category->id }}"
                                            @foreach ($product->categories as $cate)
                                                {{ $cate->id == $category->id ? 'checked' : '' }} @endforeach />
                                        <label for="{{ $category->name }}_{{ $category->id }}"
                                            class="custom-control-label">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Related product</label>
                            <select class="related_product" multiple="multiple" id="related_product"
                                data-placeholder="Select a State" style="width: 100%;">
                                @foreach ($aryProduct as $prd)
                                    @foreach (explode(',', $product->related_product_id) as $item)
                                        <option {{ $item == $prd->id ? 'selected' : '' }} value="{{ $prd->id }}">
                                            {{ $prd->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option {{ $product->status == 1 ? 'selected' : '' }} value="1">On</option>
                                <option {{ $product->status == 2 ? 'selected' : '' }} value="2">Off</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" value='1' id="new_product"
                                    name='is_new' {{ $product->is_new == 1 ? 'checked' : '' }} />
                                <label class="custom-control-label" for="new_product">New product</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" value='1' id="sale_product"
                                    name='is_sale' {{ $product->is_sale == 1 ? 'checked' : '' }} />
                                <label class="custom-control-label" for="sale_product">Sale product</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" value='1'
                                    id="highlight_product" name='highlight'
                                    {{ $product->highlight == 1 ? 'checked' : '' }} />
                                <label class="custom-control-label" for="highlight_product">Highlight product</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customFile">Primary Image<span style="color: red">*</span></label>
                            <div class="card card-profile">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail mt-4">
                                        @foreach ($primaryImage as $image)
                                            <img src="{{ asset('storage/images/' . $image->name) }}">
                                        @endforeach
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail img-fluid mt-4">
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
                    <button type="button" class="btn btn-primary submit-edit-product" data-id="{{ $product->id }}">
                        Submit
                    </button>
                </div>
            </div>
            <div class="card col-12 col-md-12 col-lg-12 p-3">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Variant Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><b>Size</b></td>
                            <td class="text-center"><b>Color</b></td>
                            <td class="text-center"><b>Price</b></td>
                            <td class="text-center"><b>Action</b></td>
                        </tr>
                        @foreach ($aryVariant as $variant)
                            <tr>
                                <td class="text-center">{{ $variant->values[0]->name }}</td>
                                <td class="text-center">{{ $variant->values[1]->name }}</td>
                                <td class="text-center variant-price-{{ $variant->id }}">{{ $variant->price }}</td>
                                <td width="10%" class="text-center">
                                    <button type="button"
                                        onclick="editVariant({{ $variant->id }}, {{ $variant->price }})"
                                        class="btn btn-edit btn-primary btn-edit-variant-{{ $variant->id }}"
                                        data-id="{{ $variant->id }}"><i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button"
                                        onclick="submitVariant({{ $variant->id }}, {{ $variant->price }})"
                                        class="btn btn-submit btn-success btn-submit-variant-{{ $variant->id }}"
                                        data-id="{{ $variant->id }}"><i class="fas fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>


    </div>
    <!-- /.content-wrapper -->
@endsection
@push('js')
    <script>
        CKEDITOR.replace('additional_information');

        CKEDITOR.replace('description');

        $('.input-images-1').imageUploader({
            imagesInputName: 'image-prod',
        });

        $(document).ready(function() {
            $('.btn-submit').hide();

            $('.related_product').select2();

            //Edit products
            $('.submit-edit-product').on('click', function() {
                var productId = $(this).attr('data-id');
                var nameValue = $('#name').val();
                var skuValue = $('#sku').val();
                var priceValue = $('#price').val();
                var isNewValue = $('#new_product').val();
                var isSaleValue = $('#sale_product').val();
                var highlightValue = $('#highlight_product').val();
                var statusValue = $('#status').val();
                var quantityValue = $('#quantity').val();
                var descriptionValue = $('#description').val();
                var additionalInfosValue = $('#additional_information').val();
                var relatedValue = $('#related_product').val();
                var aryCategoryValue = $('.category-id:checked').map(function() {
                    return this.value
                }).get();
                var imageValue = $('#image_product').prop('files')[0];
                var relatedImage = $("#image-prod").prop('files');

                // var aryImage = document.getElementByName('image-prod');
                var aryAttributeValue = [];
                @foreach ($aryAttributeType as $key => $type)
                    aryAttributeValue['{{ $type->id }}'] = $(
                        '.attribute-value-id-{{ $type->id }}:checked').map(function() {
                        return this.value
                    }).get()
                @endforeach

                var formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('id', productId);
                formData.append('name', nameValue);
                formData.append('sku', skuValue);
                formData.append('price', priceValue);
                formData.append('is_new', isNewValue);
                formData.append('is_sale', isSaleValue);
                formData.append('highlight', highlightValue);
                formData.append('status', statusValue);
                formData.append('quantity', quantityValue);
                formData.append('description', descriptionValue);
                formData.append('additional_information', additionalInfosValue);
                formData.append('related_product_id', relatedValue);
                formData.append('category', JSON.stringify(aryCategoryValue));
                formData.append('attribute_value', JSON.stringify(aryAttributeValue));
                $.each(relatedImage, function(index, value) {
                    formData.append('related_image[' + index + ']', value);
                });
                formData.append(`related_image[primary]`, imageValue);
                $.ajax({
                    url: '{{ route('update.products') }}',
                    method: 'POST',
                    contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        Swal.fire('Edit successfully!', '', 'success');
                    },
                    error: function(response) {
                        $.each(response.responseJSON.errors, function(index, error) {
                            $('input[name=' + index + ']').addClass('is-invalid')
                            toastr.error(error)
                        });
                    }
                })
            });
        })

        function editVariant(id, price) {
            var inputPrice = `<input type="text" id="variant-price-${id}" value="${price}">`
            $(".variant-price-" + id).html(inputPrice);
            $('.btn-edit-variant-' + id).hide();
            $('.btn-submit-variant-' + id).show();
        }

        function submitVariant(id, price) {
            var price = $('#variant-price-' + id).val();

            var formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id', id);
            formData.append('price', price);

            $.ajax({
                type: "POST",
                url: "{{ route('update.variant.price') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success('Edit price successfully!');
                    $(".variant-price-" + id).html(`${price}`);
                    $('.btn-submit-variant-' + id).hide();
                    $('.btn-edit-variant-' + id).show();
                }
            });

        }
    </script>
@endpush
