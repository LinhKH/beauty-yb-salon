<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Models\Agent;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class Yb_ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $data = Service::select(['services.*',DB::raw('GROUP_CONCAT(agents.name) as agents')])
        // ->leftJoin('agents','agents.service','=','services.id')
        // ->groupBy('services.id')
        // ->latest('id')->get();
        if ($request->ajax()) {
           $data = Service::select(['services.*',DB::raw('GROUP_CONCAT(agents.name) as agents')])
                ->leftJoin('agents','agents.service','=','services.id')
                ->groupBy('services.id')
                ->latest('id')->get();
                $cur_format = DB::table('general_settings')->pluck('cur_format')->first();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('service_image',function($row){
                    if($row->service_image != ''){
                        $img = '<div class="d-flex flex-row">
                                    <img src="'.asset("public/services/".$row->service_image).'" class="mr-2" width="70px">
                                    <span class="align-self-center">'.$row->title.'</span>
                                </div>';
                    }else{
                        $img = '<div class="d-flex flex-row">
                                    <img src="'.asset("public/services/default.jpg").'" class="mr-2" width="70px">
                                    <span class="align-self-center">'.$row->title.'</span>
                                </div>';
                    }
                    return $img;
                })
                ->editColumn('status',function($row){
                    if($row->status == '1'){
                        $status = '<span class="btn btn-xs btn-success">Active</span>';
                    }else{
                        $status = '<span class="btn btn-xs btn-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->editColumn('price',function($row) use ($cur_format){
                    return $cur_format.$row->price;
                })
                // ->addColumn('name', function($row){
                //     return $row->agent->name;
                // })
                ->addColumn('action', function($row){
                    $btn = '<a href="services/'.$row->id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-service btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['service_image','status','action'])
                ->make(true);
        }
        return view('admin.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        if($request->img){
            $image = str_replace(' ','-',strtolower($request->title)).rand().$request->img->getClientOriginalName();
            $request->img->move(public_path('services'),$image);
        }else {
            $image = "";
        }

        $gallery = [];
        if($request->hasfile('gallery')){
            foreach($request->file('gallery') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('services'), $name);
                $gallery[] = $name;
            }
        }

        $service = new Service();
        $service->title = $request->title;
        $service->slug = Str::slug($request->title);
        $service->service_image = $image;
        $service->description = htmlspecialchars($request->description);
        $service->price = $request->price;
        $service->duration = $request->duration;
        $service->avail_space = $request->space;
        $service->images = implode(',',$gallery);
        $result = $service->save();
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
        $service = Service::where('id',$id)->first();
        return view('admin.services.edit',['service'=>$service]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        // return $request->input();
        // Update Service Image
        if($request->img != ''){        
            $path = public_path().'/services/';
            //code for remove old file
            if($request->old_img != ''  && $request->old_img != null){
                $file_old = $path.$request->old_img;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->img;
            $image = str_replace(' ','-',strtolower($request->title)).rand().$request->img->getClientOriginalName();
            $file->move($path, $image);
        }else{
            $image = $request->old_img;
        }

        $gallery = array_filter(explode(',',$request->old_gallery));
        if(!empty($request->old)){
            for($j=0;$j<count($gallery);$j++){
                if(!in_array($j+1,$request->old)){
                    $img = $gallery[$j];
                    if(file_exists(public_path('services/'.$img))){
                        unlink(public_path('services/').$img);
                    }
                    unset($gallery[$j]);
                }
            }
        }
        if($request->hasfile('gallery')){
            foreach($request->file('gallery') as $file){
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('services'), $name);
                $gallery[] = $name;
            }
        }

        $service = Service::where(['id'=>$id])->update([
            "title" => $request->title,
            "slug" => str_replace(' ','-',strtolower($request->title)),
            "service_image" => $image,
            "description" => $request->description,
            "price" => $request->price,
            "duration" => $request->duration,
            "avail_space" => $request->space,
            "images" => implode(',',$gallery),
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
        $check = Agent::where('service',$id)->first();
        if(!$check){
            $imagePath = Service::select('service_image','images')->where('id',$id)->first();
            $filePath = public_path().'/services/'.$imagePath->service_image;

            // If there are multiple gallery images, you can use a loop to delete them like this:
            $galleryImages = explode(',', $imagePath->images); // Get the array of gallery image names
            $galleryPath = public_path().'/services/'; // Set the path of the gallery folder
    
            foreach($galleryImages as $image){
                $imagePath = $galleryPath . $image; // Set the path of the gallery image to delete
                File::delete($imagePath); // Delete the gallery image
            }
            File::delete($filePath);

            $destroy = Service::where('id',$id)->delete();
            return  $destroy;
        }else{
            return "you won't delete this service name (This service name used in Agents).";
        }
    }

    // select services for show on homepage
    public function homepage_services(Request $request){
        if($request->input()){
            $show = $request->show;
            foreach($show as $row){
                Service::where('id',$row[0])->update([
                    'show_on_homepage' => $row[1]
                ]);
            }
            return '1';
        }else{
            $services = Service::where('status','1')->latest()->get();
            return view('admin.services.show-on-homepage',['services'=>$services]);
        }
    }
}
