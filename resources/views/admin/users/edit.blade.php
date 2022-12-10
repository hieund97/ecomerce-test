@extends('admin/layout/main')
@section('title', 'Edit Users')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <form action="{{ route('update.users', $user->id) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            name="name" id="name" value="{{ $user->name }}"
                                            placeholder="Enter name">
                                        @if ($errors->has('name'))
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            name="email" id="email" value="{{ $user->email }}"
                                            placeholder="Enter email">
                                        @if ($errors->has('email'))
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="status" name="status">Status</label>
                                        <select class="form-control">
                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive
                                            </option>
                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password"
                                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            name="password" id="password" placeholder="Password">
                                        @if ($errors->has('password'))
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Re-password</label>
                                        <input type="password"
                                            class="form-control {{ $errors->has('re_password') ? 'is-invalid' : '' }}"
                                            name="re_password" id="re_password" placeholder="Re-password">
                                        @if ($errors->has('re_password'))
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $errors->first('re_password') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->


                    </div>
                    <!--/.col (left) -->


                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
