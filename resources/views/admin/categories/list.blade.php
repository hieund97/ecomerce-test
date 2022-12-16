@extends('admin.layout.main')
@section('title', 'Category')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
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
                                    <th width='25%'>Status</th>
                                    <th width='25%'>Type</th>
                                    <th width='10%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aryCategories as $categories)
                                <tr>
                                    <td>{{ $categories->id }}</td>
                                    <td> {{ $categories->name }} </td>
                                    <td> {{ $categories->status == 0 ? 'Off' : 'On' }}  </td>
                                    <td> {{ $categories->type == 0 ? 'Product' : 'Blog' }} </td>
                                    <td>
                                        <a href="{{ route('edit.categories', $categories->id) }}" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                            <form style="display: inline" action="{{ route('delete.categories', $categories->id) }}"
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
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            @if ($page > 1 )
                            <li class="page-item"><a class="page-link" href="{{ route('list.categories') }}?page={{$page - 1}}">&laquo;</a></li>
                            @endif
                            @for ($i = 1; $i <= $totalPages; $i++)
                                <li class="page-item"><a class="page-link" href="{{ route('list.categories') }}?page={{$i}}">{{ $i }}</a></li>
                            @endfor
                            @if ($page < $totalPages)
                            <li class="page-item"><a class="page-link" href="{{ route('list.categories') }}?page={{$page + 1}}">&raquo;</a></li>
                            @endif
                        </ul>
                      </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
