@extends('admin.layout')
@section('title','Gallery Category')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Gallery Category @endslot
        @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary d-inline-block">Add New</button> @endslot
        @slot('active') Gallery Category  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Gallery Category Name','Images','Action']
    ])
        @slot('table_id') galleryCat-list @endslot
    @endcomponent

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Gallery Category Add</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- form start -->
                <form id="addGalleryCat" method="POST" >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Gallery Category Name</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Gallery Category Name">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary ">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal --> 
    <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Gallery Category Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- form start -->
                <form id="editGalleryCat" method="POST">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label>Gallery Category Name</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Gallery Category Name">
                            <input type="hidden" name="id" >
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary ">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#galleryCat-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "gallery_cat",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'title', name: 'category_name'},
            {data: 'images_count', name: 'images'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true,
                sWidth: '100px'
            }
        ]
    });
</script>
@stop