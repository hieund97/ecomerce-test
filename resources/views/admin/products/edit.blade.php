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
                            <label for="detail">Detail</label>
                            <textarea id="product_detail" class="form-control" cols="50" rows="10" name="details"
                                placeholder="Enter detail">{{ $product->details }}</textarea>
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
                                                            data-type="{{ $type->id }}"
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
                            <label for="customFile">Image product</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image_product" name="image" />
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary submit-edit-product" data-id="{{ $product->id }}">
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
        CKEDITOR.replace('product_detail');

        $(document).ready(function() {
            $('.related_product').select2();

            //Edit products
            $('.submit-edit-product').on('click', function() {
                // debugger;
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
                var detailsValue = $('#product_detail').val();
                var relatedValue = $('#related_product').val();
                var aryCategoryValue = $('.category-id:checked').map(function() {
                    return this.value
                }).get();
                var imageValue = $('#image_product').prop('files')[0];
                // check value neu ko co value thi ban thng bao va return
                var aryAttributeValue = [];

                @foreach ($aryAttributeType as $key => $type)
                    aryAttributeValue['{{$type->id}}'] = $('.attribute-value-id-{{$type->id}}:checked').map(function() {
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
                formData.append('details', detailsValue);
                formData.append('related_product_id', relatedValue);
                formData.append('category', JSON.stringify(aryCategoryValue));
                formData.append('attribute_value', JSON.stringify(aryAttributeValue));
                if($('#image_product').get(0).files.length !== 0){
                    var imageValue = $('#image_product').prop('files')[0];
                    formData.append('image', imageValue);
                }
                $.ajax({
                    url: '{{ route('update.products') }}',
                    method: 'POST',
                    contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData:false,
                    data: formData,
                    success: function(response) {
                        Swal.fire('Edit successfully!', '', 'success');
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                        });
                    }
                })
            });
        })
    </script>
@endpush
