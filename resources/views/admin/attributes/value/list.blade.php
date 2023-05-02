@extends('admin.layout.main')
@section('title', 'Attribute Value')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Attribute Value</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Attribute Value</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                {{-- Table --}}
                <div class="row">
                    <div class="col-9 col-md-9 col-lg-9">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th width='20%'>ID</th>
                                            <th width='20%'>Name</th>
                                            <th width='20%'>Attribute Type</th>
                                            <th width='30%'>Color</th>
                                            <th width='10%'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aryAttributeValues as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->attributesType['name'] }}</td>
                                                <td class="row">
                                                    <div style="width: 30px; height: 30px; background-color: {{$value->color_id}}; border-radius:50%;" class="mr-3"></div>
                                                    <p>{{$value->color_id}}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('edit.attributeValues', $value->id) }}"
                                                        class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                    <form style="display: inline"
                                                        action="{{ route('delete.attributeValues', $value->id) }}"
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
                        {{ $aryAttributeValues->links('admin.partials.pagination') }}
                    </div>
                    {{-- Create --}}
                    <!-- left column -->
                    <div class="col-3 col-md-3 col-lg-3">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('store.attributeValues') }}" method="POST">
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
                                    <div class="form-group">
                                        <label>Attribute Type</label>
                                        <select class="form-control attr-type" name="attribute_id">
                                            @foreach ($aryAttributeTypes as $type)
                                                <option value='{{ $type->id }}' id="attr-type"> {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group color-picker" style="display: none">
                                        <label class="mr-3">Color Picker</label>
                                        <input type="color" id="color-picker" name="color_id">
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
@push('js')
    <script>
        $(document).ready(function () {
            $('.color-picker').hide();
            $('.attr-type').on('change', function () {
                if ($('.attr-type').val() == "{{ config('handle.attribute_type.color') }}") {
                    $('.color-picker').show();
                }
                else{
                    $('.color-picker').hide();
                }
            });
        });

    </script>
@endpush
