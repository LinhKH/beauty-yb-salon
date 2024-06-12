<?php

namespace App\Http\Controllers;
use App\Http\Requests\GalleryCategoryRequest;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class Yb_GalleryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->ajax()){
            $data = GalleryCategory::withCount('images')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href= "javascript:void(0)" data-id="'.$row->id.'" class="editGalleryCat btn btn-success btn-sm">Edit</a>  <button type="button" value="delete" class="btn btn-danger btn-sm delete-galleryCat" data-id="'.$row->id.'">Delete</button>';
                        return $btn;
                    })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.gallery_cat.index');
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
    public function store(GalleryCategoryRequest $request)
    {
        //
        $GalleryCategory = new GalleryCategory();
        $GalleryCategory->title = $request->input("title");
        $result = $GalleryCategory->save();
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
        $GalleryCategory = GalleryCategory::where(['id'=>$id])->get();
        return $GalleryCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryCategoryRequest $request, $id)
    {
        //
        $GalleryCategory = GalleryCategory::where(['id'=>$id])->update([
            "title"=>$request->input('title'),
        ]);
        return $GalleryCategory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = GalleryImage::where('category',$id)->first();
        if(!$check){
            $destroy = GalleryCategory::where('id',$id)->delete();
            return $destroy;
        }else{
            return "you won't delete this category (This category used in Gallery Images).";
        }
    }
}
