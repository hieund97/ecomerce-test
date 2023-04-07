@extends('admin.layout.main')
@section('title', 'Tag')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tag</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tag</li>
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
                                    <th width='30%'>Name</th>
                                    <th width='10%'>Status</th>
                                    <th width='10%'>Type</th>
                                    <th width='20%'>Created at</th>
                                    <th width='20%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aryTag as $tag)
                                    <tr id="tag_{{ $tag->id }}">
                                        <td>{{ $tag->id }}</td>
                                        <td>{{ $tag->name }}</td>
                                        <td>{{ $tag->status == 0 ? 'Off' : 'On' }}</td>
                                        <td>{{ $tag->type == 1 ? 'Product' : 'Blog' }}</td>
                                        <td>{{ $tag->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('edit.tag', $tag->id) }}" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger btn-del"
                                                data-id="{{ $tag->id }}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    {{ $aryTag->links('admin.partials.pagination') }}
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
            var tagID = $(this).attr('data-id');
            Swal.fire({
                title: 'Do you want to delete this tag?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'tag/delete/'+tagID ,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}',
                            id: tagID
                        },
                        success: function(response) {
                            Swal.fire('Tag is deleted!', '', 'success')
                            $('#tag_' + tagID).remove()
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    })
                } else if (result.isDenied) {
                    Swal.fire('Tag is not deleted', '', 'info')
                }
            })
        });
    </script>
@endpush
