@extends('admin.layout.main')
@section('title', 'Discount List')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Discount</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Discount</li>
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
                                    <th width='30%'>Name</th>
                                    <th width='10%'>Start</th>
                                    <th width='10%'>End</th>
                                    <th width='20%'>Value</th>
                                    <th width='20%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aryDiscount as $discount)
                                    <tr id="discount_{{ $discount->id }}">
                                        <td>{{ $discount->id }}</td>
                                        <td>{{ $discount->name }}</td>
                                        <td>{{ $discount->start }}</td>
                                        <td>{{ $discount->end }}</td>
                                        <td>{{ $discount->value }}{{ $discount->type_discount == config('handle.type.discount.percent') ? '%' : '$' }}</td>
                                        <td>
                                            <a href="{{ route('edit.discount', $discount->id) }}" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger btn-del"
                                                data-id="{{ $discount->id }}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    {{ $aryDiscount->links('admin.partials.pagination') }}
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
                var dicountID = $(this).attr('data-id');
                Swal.fire({
                    title: 'Do you want to delete this discount code?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: `No`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'discount/delete/' + dicountID,
                            method: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}',
                                id: dicountID
                            },
                            success: function(response) {
                                Swal.fire('Discount code is deleted!', '', 'success')
                                $('#discount_' + dicountID).remove()
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire('Dicount code is not deleted', '', 'info')
                    }
                })
            });
        });
    </script>
@endpush
