@extends('admin/layout/main')
@section('title', 'Edit Blog')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Blog</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Blog</li>
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
                            <form action="{{ route('update.blogs', $blog->id) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            id="name" name="name" value="{{ $blog->name }}"
                                            placeholder="Enter name" />
                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Descrition</label>
                                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description" name="description"
                                            placeholder="Enter description">{{ $blog->description }} </textarea>
                                            @if ($errors->has('description'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('description') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category_id">
                                            @foreach ($aryCategories as $categories)
                                                <option value='{{ $categories->id }}'>{{ $categories->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text"
                                            class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                                            id="slug" name="slug" value="{{ $blog->slug }}"
                                            placeholder="Enter slug" />
                                            @if ($errors->has('slug'))
                                            <div id="slugFeedback" class="invalid-feedback">
                                                {{ $errors->first('slug') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="detail">Detail</label>
                                        <textarea id="blog_detail" class="form-control {{ $errors->has('detail') ? 'is-invalid' : '' }}" style="height: 300px"
                                            name="detail" placeholder="Enter detail">{{ $blog->detail }}</textarea>
                                        @if ($errors->has('detail'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('detail') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="1" {{ $blog->status == 1 ? 'selected' : '' }}>Approving
                                            </option>
                                            <option value="2" {{ $blog->status == 2 ? 'selected' : '' }}>Approved
                                            </option>
                                            <option value="0" {{ $blog->status == 0 ? 'selected' : '' }}>Unapproved
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->
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
@push('js')
    <script>
        CKEDITOR.replace('blog_detail');
    </script>
@endpush
