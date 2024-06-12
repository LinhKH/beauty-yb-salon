@extends('admin.layout')
@section('title','Appointment')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Appointment @endslot
        @slot('add_btn') 
            <a href="{{url('admin/appointment/create')}}" class="align-top btn btn-sm btn-primary">Add New</a> 
            {{-- <a href="{{url('admin/appointment/clientbill')}}" class="align-top btn btn-sm btn-primary">Client Bill</a>  --}}
        @endslot
        @slot('active') Appointment  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['Appointment No.','Client Details','Date/Time','Services','Amount','Status','Action']
    ])
        @slot('table_id') appointment-list @endslot
    @endcomponent
</div>
{{-- status change modal --}}
<div class="modal fade" id="changeAppointment-status" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Change Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary updateAppointment-status">Update</button>
        </div>
      </div>
    </div>
  </div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#appointment-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "appointment",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'name', name: 'name'},
            {data: 'date', name: 'date'},
            {data: 'services', name: 'services'},
            {data: 'amount', name: 'amount'},
            {data: 'service_status', name: 'service_status'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true,
                sWidth: '70px'
            }
        ]
    });
</script>
@stop