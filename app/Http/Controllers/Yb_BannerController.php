<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use App\Models\Banner;

class Yb_BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('banner_image',function($row){
                    if($row->banner_image != ''){
                        $img = '<img src="'.asset("/banner/".$row->banner_image).'" width="70px">';
                    }else{
                        $img = '<img src="'.asset("/banner/default.jpg").'"  width="70px">';
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
                    $btn = '<a href="banner-slider/'.$row->id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-banner btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['banner_image','status','action'])
                ->make(true);
        }
        return view('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'=> 'image|mimes:jpg,jpeg,png,svg',
            'title'=> 'required',
        ]);

        if($request->image){
            $image = rand().$request->image->getClientOriginalName();
            $request->image->move(public_path('banner'),$image);
        }else {
            $image = "";
        }

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->banner_image = $image;
        $banner->sub_title = $request->sub_title;
        $result = $banner->save();
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
        $banner = Banner::where('id',$id)->first();
        return view('admin.banner.edit',['banner'=>$banner]);
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
        $request->validate([
            'image'=> 'image|mimes:jpg,jpeg,png,svg',
            'title'=> 'required',
            'status'=> 'required',
        ]);

        if($request->image != ''){        
            $path = public_path().'/banner/';

            //code for remove old file
            if($request->old_image != ''  && $request->old_image != null){
                $file_old = $path.$request->old_image;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->image;
            $filename = rand().$file->getClientOriginalName();
            $file->move($path, $filename);
        }else{
            $filename = $request->old_image;
        }
        $update = Banner::where('id',$id)->update([
            'banner_image'=>$filename,
            'title'=>$request->title,
            'sub_title'=>$request->sub_title,
            'status'=>$request->status,
        ]);
        return $update;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Banner::where('id',$id)->pluck('banner_image')->first();
        if($image != ''){
            $filePath = public_path().'/agents/'.$image;
            File::delete($filePath);
        }
        $destroy = Banner::where('id',$id)->delete();
        return  $destroy;
    }
}
