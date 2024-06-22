@extends('admin.layout')
@section('title','Banner Slider')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Banner Slider @endslot
        @slot('add_btn') <a href="{{url('admin/banner-slider/create')}}" class="align-top btn btn-sm btn-primary">Add New</a> @endslot
        @slot('active') Banner Slider  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Image','Yitle','Sub Title','Status','Action']
    ])
        @slot('table_id') banner-list @endslot
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
    var table = $("#banner-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "banner-slider",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'banner_image', name: 'image'},
            {data: 'title', name: 'service'},
            {data: 'sub_title', name: 'experience'},
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