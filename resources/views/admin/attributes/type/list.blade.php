@extends('admin.layout.main')
@section('title', 'Attribute Type')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Attribute Type</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Attribute Type</li>
                        </ol>
                    </div>
                </div>
                @if (session()->has('add_success'))
                    <div class="alert alert-success" role="alert">
                        Create attribute successfully!
                    </div>
                @endif
                @if (session()->has('update_success'))
                    <div class="alert alert-success" role="alert">
                        Edit attribute successfully!
                    </div>
                @endif
                @if (session()->has('delete_complete'))
                    <div class="alert alert-success" role="alert">
                        Delete attribute successfully!
                    </div>
                @endif
            </div>
            <!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                {{-- Table --}}
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th width='20%'>ID</th>
                                            <th width='60%'>Name</th>
                                            <th width='20%'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aryAttributes as $type)
                                            <tr>
                                                <td>{{ $type->id }}</td>
                                                <td>{{ $type->name }}</td>
                                                <td>
                                                    <a href="{{ route('edit.attributeTypes', $type->id) }}"
                                                        class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                    <form style="display: inline"
                                                        action="{{ route('delete.attributeTypes', $type->id) }}"
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
                        </div>
                        <!-- /.card -->
                        {{ $aryAttributes->links('admin.partials.pagination') }}
                    </div>
                    {{-- Create --}}
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('store.attributeTypes') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            id="name" name="name" placeholder="Enter name" />
                                        @if ($errors->has('name'))
                                            <div id="nameFeedback" class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
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
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
