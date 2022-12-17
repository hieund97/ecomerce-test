@extends('admin.layout.main')
@section('title', 'Edit Category')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Category</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('update.categories', $category->id) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <!-- general form elements disabled -->
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                id="name" name="name" placeholder="Enter name"
                                                value="{{ $category->name }}" />
                                            @if ($errors->has('name'))
                                                <div id="nameFeedback" class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Parent Category</label>
                                                    <select class="form-control" name="parent_id">
                                                        <option value="0"
                                                            {{ $category->parent_id == 0 ? 'selected' : '' }}>Default
                                                            Category</option>
                                                        @foreach ($aryCategories as $categories)
                                                            <option
                                                                {{ $category->parent_id == $categories->id ? 'selected' : '' }}
                                                                value='{{ $categories->id }}'>{{ $categories->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control" name="type">
                                                        <option {{ $category->type == 0 ? 'selected' : '' }} value='0'>
                                                            Product</option>
                                                        <option {{ $category->type == 1 ? 'selected' : '' }} value='1'>
                                                            Blog</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status">
                                                        <option {{ $category->status == 0 ? 'selected' : '' }}
                                                            value="0">Off</option>
                                                        <option {{ $category->status == 1 ? 'selected' : '' }}
                                                            value="1">On</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
