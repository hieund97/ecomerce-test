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
                                    <tr id="slider_{{ $slider->id }}">
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
                                            <button type="button" class="btn btn-danger btn-del"
                                            data-id="{{ $slider->id }}"><i class="fas fa-trash"></i></button>
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
@push('js')
    <script>
        $('.btn-del').click(function(e) {
            e.preventDefault();
            var sliderID = $(this).attr('data-id');
            Swal.fire({
                title: 'Do you want to delete this slider?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'slider/delete/'+sliderID ,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}',
                            id: sliderID
                        },
                        success: function(response) {
                            Swal.fire('Slider is deleted!', '', 'success')
                            $('#slider_' + sliderID).remove()
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    })
                } else if (result.isDenied) {
                    Swal.fire('Slider is not deleted', '', 'info')
                }
            })
        });
    </script>
@endpush
