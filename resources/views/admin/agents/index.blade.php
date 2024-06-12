@extends('admin.layout')
@section('title','Agents')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Agents @endslot
        @slot('add_btn') <a href="{{url('admin/agents/create')}}" class="align-top btn btn-sm btn-primary">Add New</a> @endslot
        @slot('active') Agents  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Agent Image','Service','Experience (in Years)','Bookings Completed','Status','Action']
    ])
        @slot('table_id') agent-list @endslot
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
    var table = $("#agent-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "agents",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'agent_image', name: 'image'},
            {data: 'service', name: 'service'},
            {data: 'experience', name: 'experience'},
            {data: 'booking', name: 'booking'},
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