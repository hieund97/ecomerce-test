@extends('admin/layout/main')
@section('title', 'Edit Slider')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Slider</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Slider</li>
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
                            <form action="{{ route('update.slider'), $slider->id }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $slider->name }}" placeholder="Enter name" />
                                        <input type="hidden" value="{{ $slider->id }}" id="id">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ $slider->title }}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control " id="description" name="description" placeholder="Enter description">{{ $slider->description }}</textarea>
                                    </div>
                                    <div class="form-group row mx-0">
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <label>Related product</label>
                                            <div class="row mx-0">
                                                <div class="form-check mr-3">
                                                    <input class="form-check-input type_slider" {{ $slider->type_slider == 0 ? 'checked' : '' }} type="radio"
                                                        name="type_slider" value="0">
                                                    <label class="form-check-label">Category</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input type_slider" {{ $slider->type_slider == 1 ? 'checked' : '' }} type="radio"
                                                        name="type_slider" value="1">
                                                    <label class="form-check-label">Product</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" id="related_url_id" name="related_id">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control mt-4" id="status" name="status">
                                                    <option value="0" {{ $slider->status == config('handle.status.off') ? 'selected' : '' }}>Off</option>
                                                    <option value="1" {{ $slider->status == config('handle.status.on') ? 'selected' : '' }}>On</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="customFile">Image product<span style="color: red">*</span></label>
                                        <div class="card card-profile">
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail mt-4">
                                                    @foreach ($slider->image as $item)
                                                    <img style="max-height: 400px" src="{{ asset('storage/images/' . $item->name) }}">
                                                    @endforeach
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail img-fluid mt-4">
                                                </div>
                                                <div>
                                                    <span class="btn btn-primary btn-round btn-file">
                                                        <span class="fileinput-new select-image">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="image_slider" name="image" value="{{$slider->image}}"/>
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                        data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary submit-edit-slider" data-id="{{ $slider->id }}">
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
        $(document).ready(function() {
            getRelatedID('{{ $slider->related_id }}');
        });

        $('.type_slider').on('change', function() {
            getRelatedID();
        });

        $('.submit-edit-slider').on('click', function(e) {
            e.preventDefault();
            var idValue = $('#id').val();
            var nameValue = $('#name').val();
            var titleValue = $('#title').val();
            var descriptionValue = $('#description').val();
            // var imageValue = $('#image_slider').attr('value');
            var statusValue = $('#status').val();
            var typeSliderValue = $('input[name=type_slider]:checked').val();
            var relatedIDValue = $('#related_url_id').val();

            // console.log(imageValue);return;
            var formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id', idValue);
            formData.append('name', nameValue);
            formData.append('title', titleValue);
            formData.append('description', descriptionValue);
            // formData.append('image', imageValue);
            formData.append('related_id', relatedIDValue);
            formData.append('status', statusValue);
            formData.append('type_slider', typeSliderValue);
            if($('#image_slider').get(0).files.length !== 0){
                imageValue = $('#image_slider').prop('files')[0];
                formData.append('image', imageValue);
            }
            // console.log(imageValue);return;
            $.ajax({
                url: '{{ route('update.slider') }}',
                method: 'POST',
                contentType: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    toastr.success('Edit successfully!')
                },
                error: function(response) {
                    $.each(response.responseJSON.errors, function(index, error) {
                        $('input[name='+index+']').addClass('is-invalid')
                        toastr.error(error)
                    });
                }
            })

        });

        function getRelatedID(related_id = null) {
            var type = $('input[name=type_slider]:checked').val();
            $.ajax({
                url: `{{ route('get.related.id') }}`,
                method: 'GET',
                data: {
                    type_slider: type,
                },
                success: function(response) {
                    var option = '';
                    $.each(response, function(index, item) {
                        option += `<option ${item.id == related_id ? `selected` : ``} value="${item.id}">${item.name}</option>`;
                    });
                    $('#related_url_id').html(option);
                },
                error: function(response) {
                    console.log(response);
                }
            })
        }
    </script>
@endpush