@extends('admin.layout.main')
@section('title', 'Create Discount')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Discount</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Discount</li>
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
                            <form>
                                @csrf
                                <!-- general form elements disabled -->
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter name" />
                                            <div><p id="error-name" style="color: red"></p></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Code</label>
                                            <input type="text" class="form-control" id="code"
                                                placeholder="Enter code" />
                                            <div><p id="error-code" style="color: red"></p></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Product Discount</label>
                                                    <select id="prod-discount" multiple="multiple"
                                                        data-placeholder="Select a Product" style="width: 100%;"
                                                        name="product[]">
                                                        @foreach ($aryProduct as $prod)
                                                            <option class="related-prod" value="{{ $prod->id }}">
                                                                {{ $prod->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div ><p id="error-related_id" style="color: red"></p></div>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Time Usage</label>
                                                    <input class="form-control date-range" type="text"
                                                        name="daterange" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Reduce Type</label>
                                                    <select class="form-control reduce-type">
                                                        <option value="{{ config('handle.type.discount.cash') }}">Cash
                                                        </option>
                                                        <option value="{{ config('handle.type.discount.percent') }}">Percent
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Reduce Value</label>
                                                    <input class="form-control reduce-value" type="text" />
                                                    <div><p id="error-value" style="color: red"></p></div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary submit-btn">
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
        $('#prod-discount').select2();

        $(document).ready(function() {
            $('.submit-btn').on('click', function() {
                var name = $('#name').val();
                var code = $('#code').val();
                var relatedProd = $('#prod-discount').val();
                var reduceType = $('.reduce-type').val()
                var reduceValue = $('.reduce-value').val()
                var date = $('.date-range').val().split('-');
                var start = date[0];
                var end = date[1];

                var formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}')
                formData.append('name', name)
                formData.append('code', code)
                formData.append('related_id', relatedProd)
                formData.append('type', reduceType)
                formData.append('value', reduceValue)
                formData.append('start', start)
                formData.append('end', end)

                $.ajax({
                    type: "POST",
                    url: '{{ route('store.discount') }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success('Create successfully!')
                        setTimeout(() => {
                            window.location.href = '{{ route('list.discount') }}'
                        }, 1500);
                    },
                    error: function(xhr) {
                        $.each(xhr.responseJSON.errors, function(prop, val) {
                            $('#error-' + prop).html(val)
                        });
                    }
                });
            });
        })
    </script>
@endpush
