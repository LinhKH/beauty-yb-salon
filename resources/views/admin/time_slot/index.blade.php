@extends('admin.layout')
@section('title','Time Slot')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Time Slot @endslot
        @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary d-inline-block">Add New</button> @endslot
        @slot('active') Time Slot  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Start Time','End Time','Status','Action']
    ])
        @slot('table_id') time-list @endslot
    @endcomponent

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Time Slot Add</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- form start -->
                <form id="addTimeSlot" method="POST" >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" class="form-control" name="from_time" placeholder="Enter Start Time">
                            
                        </div>
                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" class="form-control" name="to_time" placeholder="Enter End Time">
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
                    <h4 class="modal-title">Time Slot Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- form start -->
                <form id="editTimeSlot" method="POST">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" class="form-control" name="from_time" placeholder="Enter Start Time">
                            <input type="hidden" name="id" >
                        </div>
                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" class="form-control" name="to_time" placeholder="Enter End Time">
                        </div>
                        <div class="form-group ">
                            <label> Status </label>
                            <select name="status" class="form-control">
                                <option value="" disabled>Select Status</option>    
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
    var table = $("#time-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "time_slot",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'from_time', name: 'from_time'},
            {data: 'to_time', name: 'to_time'},
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