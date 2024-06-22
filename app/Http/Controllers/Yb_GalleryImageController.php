<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use App\Http\Requests\GalleryImageRequest;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class Yb_GalleryImageController extends Controller
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
            $data = GalleryImage::latest('id')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image',function($row){
                    if($row->image != ''){
                        $img = '<div class="d-flex flex-row">
                                    <img src="'.asset("/gallery/".$row->image).'" class="mr-2" width="70px">
                                    <span class="align-self-center">'.$row->title.'</span>
                                </div>';
                    }else{
                        $img = '<div class="d-flex flex-row">
                                    <img src="'.asset("/gallery/default.jpg").'" class="mr-2" width="70px">
                                    <span class="align-self-center">'.$row->title.'</span>
                                </div>';
                    }
                    return $img;
                })
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status = '<span class="btn btn-xs btn-success">Publish</span>';
                    }else{
                        $status = '<span class="btn btn-xs btn-danger">Draft</span>';
                    }
                    return $status;
                })
                ->addColumn('category', function($row){
                    return $row->gallery_category->title;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="gallery_img/'.$row->id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-galleryImg btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['image','status','action'])
                ->make(true);
        }
        return view('admin.gallery_img.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $galleryCategory = GalleryCategory::all();
        return view('admin.gallery_img.create',['category'=>$galleryCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryImageRequest $request)
    {
        //
        if($request->img){
            $image = str_replace(' ','-',strtolower($request->title)).rand().$request->img->getClientOriginalName();
            $request->img->move(public_path('gallery'),$image);
        }else {
            $image = "";
        }

        $galleryImage = new GalleryImage();
        $galleryImage->title = $request->input('title');
        $galleryImage->image = $image;
        $galleryImage->description = htmlspecialchars($request->input('description'));
        $galleryImage->category = $request->input('category');
        $result = $galleryImage->save();
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
        $galleryCategory = GalleryCategory::all();
        $galleryImage = GalleryImage::where('id',$id)->first();
        return view('admin.gallery_img.edit',['gallery'=> $galleryImage,'category'=>$galleryCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryImageRequest $request, $id)
    {
        // Update Gallery Image
        if($request->img != ''){        
            $path = public_path().'/gallery/';
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

        $galleryImage = GalleryImage::where(['id'=>$id])->update([
            "title" => $request->title,
            "image" => $image,
            "description" => $request->description,
            "category" => $request->category,
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
        $imagePath = GalleryImage::select('image')->where('id',$id)->first();
        $filePath = public_path().'/gallery/'.$imagePath->image;
        File::delete($filePath);
        $destroy = GalleryImage::where('id',$id)->delete();
        return $destroy;
    }
}
