@extends('admin.layout.main')
@section('title', 'Edit Discount')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Discount</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Discount</li>
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
                            <form action="{{ route('update.discount'), $discount->id }}" method='POST'>
                                @method('PUT')
                                @csrf
                                <!-- general form elements disabled -->
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Enter name" value="{{ $discount->name }}" />
                                            <input type="hidden" value="{{ $discount->id }}" id="id">
                                        </div>
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input type="text" class="form-control" id="code"
                                                placeholder="Enter code" value="{{ $discount->code }}" />
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
                                                            <option
                                                                @foreach (explode(',', $discount->related_id) as $item)
                                                                    {{ $item == $prod->id ? 'selected' : '' }} @endforeach
                                                                value="{{ $prod->id }}">
                                                                {{ $prod->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Time Usage</label>
                                                    <input class="form-control date-range" type="text" name="daterange"
                                                        value="{{ $discount->start . ' - ' . $discount->end }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Reduce Type</label>
                                                    <select class="form-control reduce-type">
                                                        <option {{ $discount->type_discount == config('handle.type.discount.cash') ? 'selected' : '' }}
                                                            value="0">Cash</option>
                                                        <option {{ $discount->type_discount == config('handle.type.discount.percent') ? 'selected' : '' }}
                                                            value="1">Percent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Reduce Value</label>
                                                    <input class="form-control reduce-value" type="text"
                                                        value="{{ $discount->value }}" />
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary submit-btn">
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
            $('.submit-btn').on('click', function(e) {
                e.preventDefault();
                var id = $('#id').val();
                var name = $('#name').val();
                var code = $('#code').val();
                var relatedProd = $('#prod-discount').val();
                var reduceType = $('.reduce-type').val()
                var reduceValue = $('.reduce-value').val()
                var date = $('.date-range').val().split('-');
                var start = date[0];
                var end = date[1];

                var formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PUT');
                formData.append('id', id);
                formData.append('name', name);
                formData.append('code', code);
                formData.append('related_id', relatedProd);
                formData.append('type', reduceType);
                formData.append('value', reduceValue);
                formData.append('start', start);
                formData.append('end', end);

                $.ajax({
                    url: '{{ route('update.discount') }}',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success('Edit successfully!')
                        setTimeout(() => {
                            window.location.href = '{{ route('list.discount') }}'
                        }, 1500);
                    }
                });
            });
        });
    </script>
@endpush
