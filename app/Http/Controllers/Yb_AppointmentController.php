<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\Client;
use App\Models\AppointmentService;
use Illuminate\Support\Facades\DB;

class Yb_AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $data = Appointment::withCount('services')->select(['appointments.*', 'clients.name', 'clients.phone', DB::raw("CONCAT(time_slot.from_time,' - ',time_slot.to_time) as timings")])
                ->leftJoin('clients', 'clients.id', '=', 'appointments.client')
                ->leftJoin('time_slot', 'time_slot.id', '=', 'appointments.time')
                ->orderBy('appointments.id', 'desc')
                ->get();
            $cur_format = DB::table('general_settings')->pluck('cur_format')->first();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    $name = $row->name . '<br><small>Phone : ' . $row->phone . '</small>';
                    if ($row->appointment_type == '1') {
                        $name .= '<br><span class="badge bg-info">Online</span>';
                    }
                    return $name;
                })
                ->editColumn('date', function ($row) {
                    return date('d M, Y', strtotime($row->date)) . '<br><small>@' . $row->timings . '</small>';
                })
                ->editColumn('amount', function ($row) use ($cur_format) {
                    return $cur_format . $row->amount;
                })
                ->editColumn('services', function ($row) {
                    $service1 = '';
                    foreach($row?->services as $service) {
                        $service1 .= $service->service_name->title .' - ';

                    }
                    return $service1;
                    // return $row->services->count();
                })
                ->editColumn('service_status', function ($row) {
                    if ($row->service_status == '0') {
                        $status = '<span class="badge bg-warning">Pending</span>';
                    } else if ($row->service_status == '1') {
                        $status = '<span class="badge bg-info">In Progress</span>';
                    } else {
                        $status = '<span class="badge bg-success">Completed</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                      Action
                    </button>
                    <div class="dropdown-menu">
                        <ul class="list-group">
                            <li class="list-group-item py-1"><a href= "appointment/' . $row->id . '/print">Invoice</a></li>';
                    if ($row->service_status < 2) {
                        $btn .= '<li class="list-group-item py-1"><a href= "appointment/' . $row->id . '/edit">Edit</a></li>
                            <li class="list-group-item py-1"><a href="javascript:void(0)" value="delete" class="delete-appointment" data-id="' . $row->id . '">Delete</a></li>
                            <li class="list-group-item py-1"><a href="javascript:void(0)" class="change-appointment-status" data-id="' . $row->id . '">Change Status</a></li>';
                    }
                    $btn .= '</ul>
                    </div>
                  </div>   ';
                    return $btn;
                })
                ->rawColumns(['name', 'date', 'service_status', 'action'])
                ->make(true);
        }
        return view('admin.appointment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        $time_slot = TimeSlot::where('status', '1')->get();
        return view('admin.appointment.create', ['services' => $services, 'time_slot' => $time_slot]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->input();
        $request->validate([
            'c_name' => 'required',
            'c_phone' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        $client = new Client();
        $client->name = $request->c_name;
        $client->phone = $request->c_phone;
        $client->type = '0';
        $saveClient = $client->save();
        $count_service = count($request->service);
        $amount = 0;
        for ($i = 0; $i < $count_service; $i++) {
            $price = Service::where('id', $request->service[$i])->pluck('price')->first();
            $amount += $price * $request->qty[$i];
        }

        $appointment = new Appointment();
        $appointment->client = $client->id;
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->amount = $amount;
        $appointment->appointment_type = '0';
        $saveAppointment = $appointment->save();

        for ($i = 0; $i < $count_service; $i++) {
            $price = Service::where('id', $request->service[$i])->pluck('price')->first();
            $appointmentService = new AppointmentService();
            $appointmentService->appointment = $appointment->id;
            $appointmentService->service = $request->service[$i];
            $appointmentService->agent = 0;
            $appointmentService->qty = $request->qty[$i];
            $appointmentService->service_price = $price;
            $saveAppService = $appointmentService->save();
        }
        return '1';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $services = Service::all();
        $time_slot = TimeSlot::where('status', '1')->get();
        $appointment = Appointment::select(['appointments.*', 'clients.name', 'clients.phone'])
            ->leftJoin('clients', 'clients.id', '=', 'appointments.client')
            ->where('appointments.id', $id)->first();
        $appointment_services = AppointmentService::where('appointment', $id)->get();
        return view('admin.appointment.edit', ['services' => $services, 'time_slot' => $time_slot, 'appointment' => $appointment, 'appointmentServices' => $appointment_services]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return $request->input();
        $count_service = count($request->service);
        $amount = 0;
        for ($i = 0; $i < $count_service; $i++) {
            $price = Service::where('id', $request->service[$i])->pluck('price')->first();
            $amount += $price * $request->qty[$i];
        }

        $appointment = Appointment::find($id);
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->amount = $amount;
        $saveAppointment = $appointment->save();

        AppointmentService::where('appointment', $id)->delete();

        for ($i = 0; $i < $count_service; $i++) {
            $price = Service::where('id', $request->service[$i])->pluck('price')->first();
            $appointmentService = new AppointmentService();
            $appointmentService->appointment = $id;
            $appointmentService->service = $request->service[$i];
            $appointmentService->agent = 0;
            $appointmentService->qty = $request->qty[$i];
            $appointmentService->service_price = $price;
            $saveAppService = $appointmentService->save();
        }
        return '1';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Appointment::where('id', $id)->delete();
        return $destroy;
    }

    public function yb_ClientBill()
    {
        return view('admin.appointment.clientbill');
    }

    public function get_service_row(Request $request)
    {
        $services = Service::all();
        return view('admin.appointment.service-row', ['services' => $services, 'id' => $request->id]);
    }

    public function get_service_price(Request $request)
    {
        return $price = Service::where('id', $request->sid)->pluck('price')->first();
    }

    public function print_appointment($id)
    {
        $appointment = Appointment::select(['appointments.*', 'clients.name', 'clients.phone', 'time_slot.from_time', 'time_slot.to_time'])
            ->leftJoin('clients', 'clients.id', '=', 'appointments.client')
            ->leftJoin('time_slot', 'time_slot.id', '=', 'appointments.time')
            ->where('appointments.id', $id)->first();
        $appointment_services = AppointmentService::select(['appointment_service.*', 'services.title'])
            ->leftJoin('services', 'services.id', '=', 'appointment_service.service')
            ->where('appointment', $id)->get();
        return view('admin.appointment.print', ['appointment' => $appointment, 'appointmentServices' => $appointment_services]);
    }

    public function changeStatus(Request $request)
    {
        $appointment = Appointment::select(['appointments.id', 'appointments.service_status', 'clients.name'])
            ->leftJoin('clients', 'clients.id', '=', 'appointments.client')
            ->where('appointments.id', $request->id)->first();
        return view('admin.appointment.status-modal-content', ['appointment' => $appointment]);
    }

    public function updateStatus(Request $request)
    {
        $pay_status = '0';
        if ($request->status == '2') {
            $pay_status = '1';
        }
        $appointment = Appointment::find($request->id);
        $appointment->service_status = $request->status;
        $appointment->payment_status = $pay_status;
        $save = $appointment->save();
        DB::table('direct_payments')->insert([
            'appointment_id' => $request->id,
            'amount' => $appointment->amount - $appointment->advance,
        ]);
        return $save;
    }
}
