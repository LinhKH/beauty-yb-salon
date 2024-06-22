@extends('admin.layout')
@section('title','Gallery Image')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Gallery Image @endslot
        @slot('add_btn') <a href="{{url('admin/gallery_img/create')}}" class="align-top btn btn-sm btn-primary">Add New</a> @endslot
        @slot('active') Gallery Image @endslot
    @endcomponent
    <!-- /.content-header -->
    
    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Gallery Image','Category','Status','Action']
    ])
        @slot('table_id') gallery-list @endslot
    @endcomponent
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#gallery-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "gallery_img",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'image', name: 'image'},
            {data: 'category', name: 'category'},
            {data: 'status', name: 'status'},
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