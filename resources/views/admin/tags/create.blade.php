@extends('admin.layout.main')
@section('title', 'Create Tags')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Tag</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Tag</li>
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
                            <form action="{{ route('store.tag') }}" method="POST" id="create-tag-form">
                                @csrf
                                <!-- general form elements disabled -->
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control " id="name" name="name"
                                                placeholder="Enter name" />
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="0">Off</option>
                                                        <option value="1">On</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control" name="type" id="type">
                                                        <option value="1">Product</option>
                                                        <option value="2">Blog</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary submit-create-tag">
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
        $('.submit-create-tag').on('click', function(e){
            var nameValue = $('#name').val();
            var statusValue = $('#status').val();
            var typeValue = $('#type').val();

            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('name', nameValue);
            formData.append('status', statusValue);
            formData.append('type', typeValue);

            $.ajax({
                url: '{{ route('store.tag') }}',
                method: 'POST',
                contentType: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    toastr.success('Create successfully!')
                    $('#create-tag-form').get(0).reset();
                },
                error: function(response) {
                    // $.each(response.responseJSON.errors, function(index, error) {
                    //     $('input[name='+index+']').addClass('is-invalid')
                    //     toastr.error(error)
                    // });

                }
            })
        });
    </script>
@endpush
