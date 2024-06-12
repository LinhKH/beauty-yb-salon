<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Requests\AgentRequest;
use App\Models\Agent;
use App\Models\Service;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class Yb_AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            //$data = Agent::latest('id')->get();
            $data = Agent::select(['agents.*','services.title as service',DB::raw('COUNT(appointment_service.id) as booking')])
                    ->leftJoin('services','agents.service','=','services.id')
                    ->leftJoin('appointment_service','appointment_service.agent','=','agents.id')
                    ->groupBy('agents.id')
                    ->orderBy('agents.id','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('agent_image',function($row){
                    if($row->agent_image != ''){
                        $img = '<div class="d-flex flex-row">
                                    <img src="'.asset("public/agents/".$row->agent_image).'" class="mr-2" width="70px">
                                    <span class="align-self-center">'.$row->name.'</span>
                                </div>';
                    }else{
                        $img = '<div class="d-flex flex-row">
                                    <img src="'.asset("public/agents/default.png").'" class="mr-2" width="70px">
                                    <span class="align-self-center">'.$row->name.'</span>
                                </div>';
                    }
                    return $img;
                })
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status = '<span class="btn btn-xs btn-success">Active</span>';
                    }else{
                        $status = '<span class="btn btn-xs btn-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="agents/'.$row->id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-agent btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['agent_image','status','action'])
                ->make(true);
        }
        return view('admin.agents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $service = Service::All(); 
        return view('admin.agents.create',['service'=>$service]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentRequest $request)
    {
        //return $request->input();
        if($request->img){
            $image = str_replace(' ','-',strtolower($request->name)).rand().$request->img->getClientOriginalName();
            $request->img->move(public_path('agents'),$image);
        }else {
            $image = "";
        }

        $agent = new Agent();
        $agent->name = $request->input('name');
        $agent->agent_image = $image;
        $agent->service = $request->input('service');
        $agent->description = htmlspecialchars($request->input('description'));
        $agent->experience = $request->input('experience');
        $result = $agent->save();
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
        $agent = Agent::where('id',$id)->first();
        return view('admin.agents.edit',['agent'=> $agent]);
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
        // Update Agent Image
        if($request->img != ''){        
        $path = public_path().'/agents/';
        //code for remove old file
        if($request->old_img != ''  && $request->old_img != null){
            $file_old = $path.$request->old_img;
            if(file_exists($file_old)){
                unlink($file_old);
            }
        }
        //upload new file
        $file = $request->img;
        $image = str_replace(' ','-',strtolower($request->name)).rand().$request->img->getClientOriginalName();
        $file->move($path, $image);
        }else{
            $image = $request->old_img;
        }
        
        $agent = Agent::where(['id'=>$id])->update([
            "name" => $request->name,
            "agent_image" => $image,
            "description" => $request->description,
            "experience" => $request->experience,
            "status" => $request->status,
        ]);
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
        //
        $image = Agent::where('id',$id)->pluck('agent_image')->first();
        if($image != ''){
            $filePath = public_path().'/agents/'.$image;
            File::delete($filePath);
        }
        $destroy = Agent::where('id',$id)->delete();
        return  $destroy;
    }
}
