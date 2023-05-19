@extends('admin.layout.main')
@section('title', 'Products')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width='10%'>ID</th>
                                    <th width='20%'>Name</th>
                                    <th width='20%'>Image</th>
                                    <th width='10%'>Price</th>
                                    <th width='20%'>Category</th>
                                    <th width='10%'>Status</th>
                                    <th width='10%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aryProduct as $product)
                                    <tr id="product_{{ $product->id }}">
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td><img class="image-product"
                                                @foreach ($product->image as $image)
                                                    @if ($image->is_primary == 1)
                                                        src="{{ asset('storage/images/' . $image->name) }}">
                                                    @endif
                                                @endforeach
                                        </td>
                                        <td>{{ $product->price }}$</td>
                                        <td>
                                            @foreach ($product->categories as $cate)
                                                {{ $cate->name }} |
                                            @endforeach
                                        </td>
                                        <td>
                                            <label data-id="{{ $product->id }}" onclick="changeStatus({{ $product->id }})"
                                                class="btn btn-{{ $product->status == 1 ? 'success' : 'danger' }} status-label"
                                                id="status-{{ $product->id }}"
                                                for="status">{{ $product->status == 1 ? 'On' : 'Off' }}</label>
                                        </td>
                                        <td>
                                            <a href="{{ route('edit.products', $product->id) }}" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger btn-del"
                                                data-id="{{ $product->id }}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="change-status-modal-{{ $product->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Status</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status-{{ $product->id }}" value="1" checked/>
                                                            <label class="form-check-label">On</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status-{{ $product->id }}" value="2"/>
                                                            <label class="form-check-label">Off</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" id="btn-change-status-{{ $product->id }}">Save changes</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    {{ $aryProduct->links('admin.partials.pagination') }}
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('.btn-del').on('click', function() {
                var productID = $(this).attr('data-id');
                Swal.fire({
                    title: 'Do you want to delete the product?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: `No`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('delete.products') }}',
                            method: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}',
                                id: productID
                            },
                            success: function(response) {
                                Swal.fire('Product is deleted!', '', 'success')
                                $('#product_' + productID).remove()
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire('Product is not deleted', '', 'info')
                    }
                })
            });

            $('.status-label').on('click', function() {
                var productId = $(this).attr('data-id');
                
            });
        });

        function changeStatus(productId) {
            $('#change-status-modal-'+productId).modal('show');
                $('#btn-change-status-'+productId).on('click', function() {
                    var statusValue = $('input[name=status-'+productId+']:checked').val();
                    // console.log(statusValue);return;
                    $.ajax({
                        url: '/admin/products/update/status/' + productId,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: productId,
                            status: statusValue,
                        },
                        success: function(response) {
                            $('#change-status-modal-'+productId).modal('hide');
                            if (statusValue == 1) {
                                var text = 'ON';
                                var color = 'success';
                            } else {
                                var text = 'OFF';
                                var color = 'danger';
                            }
                            $('#status-' + productId).text(text).attr('class', 'btn btn-' + color);
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    })
                });
        }
    </script>
@endpush
