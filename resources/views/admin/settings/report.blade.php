@extends('admin.layout')
@section('title','Income Report')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Income Report @endslot
        @slot('add_btn') @endslot
        @slot('active') Income Report  @endslot
    @endcomponent
    <!-- /.content-header -->

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="">From Date</label>
                    <input type="date" id="from-date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">To Date</label>
                    <input type="date" id="to-date" class="form-control">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary mt-4" type="button" id="filter">Search</button>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table id="income-list" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Appointment No.</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Online</th>
                        <th>Direct</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Grand Total</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->

</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#income-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "report",
            data: function (d) {
                d.from_date = $('#from-date').val();
                d.to_date = $('#to-date').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'id', name: 'id'},
            {data: 'client_name', name: 'client_name'},
            {data: 'date', name: 'date'},
            {data: 'advance', name: 'advance'},
            {data: 'direct', name: 'direct'},
            {data: 'total', name: 'total'},
        ],
        footerCallback: function( tfoot, data, start, end, display ) {
            var api = this.api();
            $(api.column(6).footer()).html(
                api.column(6).data().reduce(function ( a, b ) {
                    return a + b;
                }, 0)
            );
        }
    });
    $('#filter').click(function(){
            table.draw();
        });
</script>
@stop