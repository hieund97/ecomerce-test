@extends('admin.layout.main')
@section('title', 'Blogs')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
                @if (session()->has('create_complete'))
                    <div class="alert alert-success" role="alert">
                        Create blog successfully!
                    </div>
                @endif
                @if (session()->has('edit_complete'))
                    <div class="alert alert-success" role="alert">
                        Edit blog successfully!
                    </div>
                @endif
                @if (session()->has('delete_complete'))
                    <div class="alert alert-success" role="alert">
                        Delete blog successfully!
                    </div>
                @endif
                @if (session()->has('blog_not_exist'))
                    <div class="alert alert-danger" role="alert">
                        Can not find the blog!
                    </div>
                @endif
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
                                    <th width='20%'>Category</th>
                                    <th width='20%'>Description</th>
                                    <th width='20%'>Status</th>
                                    <th width='10%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aryBlog as $blog)
                                    <tr>
                                        <td>{{ $blog->id }}</td>
                                        <td> {{ $blog->name }}</td>
                                        <td>{{ $blog->categories['name'] }}</td>
                                        <td>{{ $blog->description }}</td>
                                        <td>
                                            @switch($blog->status)
                                                @case(0)
                                                    {{ 'Unapproved' }}
                                                @break
                                                @case(1)
                                                    {{ 'Approving' }}
                                                @break
                                                @case(2)
                                                    {{ 'Approved' }}
                                                @break
                                                @default
                                            @endswitch

                                        </td>
                                        <td>
                                            <a href="{{ route('edit.blogs', $blog->id) }}" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                            <form style="display: inline" action="{{ route('delete.blogs', $blog->id) }}"
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
                    {{$aryBlog->links('admin.partials.pagination')}}
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
