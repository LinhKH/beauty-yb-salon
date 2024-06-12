<?php

namespace App\Http\Controllers;
use App\Http\Requests\TimeSlotRequest;
use App\Models\TimeSlot;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class Yb_TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = TimeSlot::latest('id')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status = '<span class="btn btn-xs btn-success">Active</span>';
                    }else{
                        $status = '<span class="btn btn-xs btn-danger">InActive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href= "javascript:void(0)" data-id="'.$row->id.'" class="editTimeSlot btn btn-success btn-sm">Edit</a>  <button type="button" value="delete" class="btn btn-danger btn-sm deleteTime" data-id="'.$row->id.'">Delete</button>';
                        return $btn;
                    })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin.time_slot.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimeSlotRequest $request)
    {
        //
        $timeSlot = new TimeSlot();
        $timeSlot->from_time = $request->input("from_time");
        $timeSlot->to_time = $request->input("to_time");
        $result = $timeSlot->save();
        return $result;
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
        //
        $timeSlot = TimeSlot::where(['id'=>$id])->get();
        return $timeSlot;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TimeSlotRequest $request, $id)
    {
        //
        $timeSlot = TimeSlot::where(['id'=>$id])->update([
            "from_time"=>$request->input('from_time'),
            "to_time"=>$request->input('to_time'),
            "status" => $request->status,
        ]);
        return $timeSlot;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $destroy = TimeSlot::where('id',$id)->delete();
        return $destroy;
    }
}
