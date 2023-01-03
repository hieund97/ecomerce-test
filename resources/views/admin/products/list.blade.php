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
                                    <th width='5%'>ID</th>
                                    <th width='20%'>Name</th>
                                    <th width='10%'>Price</th>
                                    <th width='10%'>Category</th>
                                    <th width='5%'>Status</th>
                                    <th width='20%'>Image</th>
                                    <th width='20%'>Description</th>
                                    <th width='10%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aryProduct as $product)
                                    {{-- @dd($product) --}}
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td></td>
                                        <td>{{ $product->status }}</td>
                                        <td><img width="150" height="150" src="{{ asset('storage/images/products/'.$product->image) }}"></td>
                                        <td>{{ $product->description }}</td>
                                        <td>
                                            <a href="" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                            <form style="display: inline" action=""
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    {{$aryProduct->links('admin.partials.pagination')}}
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
