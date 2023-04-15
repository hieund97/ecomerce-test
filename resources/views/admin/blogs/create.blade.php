@extends('admin/layout/main')
@section('title', 'Create Blogs')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Blog</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Blog</li>
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
                            <form action="{{ route('store.blogs') }}" method="POST" enctype="multipart/form-data" style="display:inline">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            id="name" name="name" value="{{ old('name') ?? '' }}"
                                            placeholder="Enter name" />
                                        @if ($errors->has('name'))
                                            <div id="nameFeedback" class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description" name="description"
                                            placeholder="Enter description"> </textarea>
                                        @if ($errors->has('description'))
                                            <div id="descriptionFeedback" class="invalid-feedback">
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
                                        <label for="detail">Detail</label>
                                        <textarea id="blog_detail" class="form-control {{ $errors->has('detail') ? 'is-invalid' : '' }}" style="height: 300px"
                                            name="detail" placeholder="Enter detail"></textarea>
                                        @if ($errors->has('detail'))
                                            <div id="detailFeedback" class="invalid-feedback">
                                                {{ $errors->first('detail') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="1">Approving</option>
                                            <option value="2">Approved</option>
                                            <option value="0">Unapproved</option>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-6 col-md-6 col-lg-6">
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
                                                            <input type="file" id="image_slider" name="image" />
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                            data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-6">
                                            <div class="input-field">
                                                <label class="active">Related Image<span style="color: red">*</span></label>
                                                <div class="input-images-1" style="padding-top: .5rem;"></div>
                                            </div>
                                        </div>
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

        $('.input-images-1').imageUploader({
            imagesInputName: 'blog-image',
        });
    </script>
@endpush
