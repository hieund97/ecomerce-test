@extends('admin.layout.main')
@section('title', 'Edit Tag')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Tag</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Tag</li>
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
                            <form action="{{ route('update.tag', $tag->id) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <!-- general form elements disabled -->
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter name" value="{{ $tag->name }}" />
                                            <input type="hidden" value="{{ $tag->id }}" id="id">

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="{{ config('handle.status.off') }}"
                                                            {{ $tag->status == config('handle.status.off') ? 'selected' : '' }}>
                                                            Off</option>
                                                        <option value="{{ config('handle.status.on') }}"
                                                            {{ $tag->status == config('handle.status.on') ? 'selected' : '' }}>
                                                            On</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control" name="type" id="type">
                                                        <option value="{{ config('handle.type_of_tag.product') }}"
                                                            {{ $tag->type == config('handle.type_of_tag.product') ? 'selected' : '' }}>
                                                            Product</option>
                                                        <option value="{{ config('handle.type_of_tag.blog') }}"
                                                            {{ $tag->type == config('handle.type_of_tag.blog') ? 'selected' : '' }}>
                                                            Blog</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary edit-submit">
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
        $('.edit-submit').click(function(e) {
            e.preventDefault();
            var idValue = $('#id').val();
            var nameValue = $('#name').val();
            var statusValue = $('#status').val();
            var typeValue = $('#type').val();

            var formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id', idValue);
            formData.append('name', nameValue);
            formData.append('status', statusValue);
            formData.append('type', typeValue);

            $.ajax({
                url: '{{ route('update.tag') }}',
                method: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    toastr.success('Edit successfully!')
                },
                error: function(response) {
                    $.each(response.responseJSON.errors, function(index, error) {
                        $('input[id=' + index + ']').addClass('is-invalid')
                        toastr.error(error)
                    });
                },
            });
        });
    </script>
@endpush
