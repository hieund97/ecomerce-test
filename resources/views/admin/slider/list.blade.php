@extends('admin.layout.main')
@section('title', 'Slider')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Slider</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Slider</li>
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
                                    <th width='20%'>Name</th>
                                    <th width='20%'>Image</th>
                                    <th width='20%'>Title</th>
                                    <th width='10%'>Status</th>
                                    <th width='20%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arySlider as $slider)
                                    <tr>
                                        <td>{{ $slider->id }}</td>
                                        <td>{{ $slider->name }}</td>
                                        <td>
                                            @foreach ($slider->image as $image)
                                            @if ($image->is_primary == 1)
                                                <img class="image-slider"
                                                src="{{ asset('storage/images/'.$image->name ) }}"></td>
                                            @endif
                                            @endforeach
                                        <td>{{ $slider->title }}</td>
                                        <td>
                                            {{ $slider->status == 0 ? 'Off' : 'On' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('edit.slider', $slider->id) }}" class="btn btn-primary"><i
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
                    
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
