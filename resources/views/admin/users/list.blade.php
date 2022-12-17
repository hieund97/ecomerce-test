@extends('admin.layout.main')
@section('title', 'Users')
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
                @if (session()->has('create_user'))
                    <div class="alert alert-success" role="alert">
                        Create user successfully!
                    </div>
                @endif
                @if (session()->has('user_not_exist'))
                    <div class="alert alert-danger" role="alert">
                        Can not find user!
                    </div>
                @endif
                @if (session()->has('edit_user'))
                    <div class="alert alert-success" role="alert">
                        Edit user successfully!
                    </div>
                @endif
                @if (session()->has('delete_user'))
                    <div class="alert alert-success" role="alert">
                        Delete user successfully!
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
                                    <th width='30%'>Name</th>
                                    <th width='30%'>Email</th>
                                    <th width='20%'>Status</th>
                                    <th width='10%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aryUser as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td> {{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('edit.users', $user->id) }}" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                            <form style="display: inline" action="{{ route('delete.users', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    {{$aryUser->links('admin.partials.pagination')}}
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection

