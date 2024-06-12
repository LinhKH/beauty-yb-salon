@extends('admin.layout')
@section('title','Services')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Services @endslot
        @slot('add_btn') <a href="{{url('admin/services/create')}}" class="align-top btn btn-sm btn-primary">Add New</a> <a href="{{url('admin/services/homepage_services')}}" class="align-top btn btn-sm btn-dark">Service Show on Homepage</a> @endslot
        @slot('active') Services  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Service Image','Duration (in Minutes)','Price','Agents','Status','Action']
    ])
        @slot('table_id') service-list @endslot
    @endcomponent
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#service-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "services",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'service_image', name: 'image'},
            {data: 'duration', name: 'duration'},
            {data: 'price', name: 'price'},
            {data: 'agents', name: 'agents'},
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
