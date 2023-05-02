@extends('admin.layout.main')
@section('title', 'Edit Attribute Value')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Attribute Value</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Attribute Value</li>
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
                            <form action="{{ route('update.attributeValues', $value->id) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            id="name" name="name" value="{{ $value->name }}"
                                            placeholder="Enter name" />
                                        @if ($errors->has('name'))
                                            <div id="nameFeedback" class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Attribute Type</label>
                                        <select class="form-control" name="attribute_id">
                                            <option
                                                {{ $value->attribute_id == config('handle.attribute_type.size') ? 'selected' : '' }}
                                                value='{{ config('handle.attribute_type.size') }}'> Size
                                            </option>
                                            <option
                                                {{ $value->attribute_id == config('handle.attribute_type.color') ? 'selected' : '' }}
                                                value='{{ config('handle.attribute_type.color') }}'> Color
                                            </option>
                                        </select>
                                    </div>
                                    @if ($value->attribute_id == config('handle.attribute_type.color'))
                                        <div class="form-group color-picker">
                                            <label class="mr-3">Color Picker</label>
                                            <input type="color" id="color-picker" name="color_id"
                                                value="{{ $value->color_id }}">
                                        </div>
                                    @endif
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
