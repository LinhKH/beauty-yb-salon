<?php

namespace App\Http\Controllers;
use App\Http\Requests\PageRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Page;


class Yb_PageController extends Controller
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
            $data = Page::orderBy('id','desc')->get();
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="pages/'.$row->id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-page btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                    return $btn;
                })
                ->editColumn('show_in_header', function($row){
                    $checked = ($row->show_in_header == '1') ? 'checked' : '';
                    return '<div class="page-checkbox">
                        <input type="checkbox" class="show-in-header" id="head'.$row->id.'" '.$checked.'>
                        <label for="head'.$row->id.'"></label>
                    </div>';
                })
                ->editColumn('show_in_footer', function($row){
                    $checked = ($row->show_in_footer == '1') ? 'checked' : '';
                    return '<div class="page-checkbox">
                        <input type="checkbox" class="show-in-footer" id="foot'.$row->id.'" '.$checked.'>
                        <label for="foot'.$row->id.'"></label>
                    </div>';
                })
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status = '<span class="badge badge-success">Active</span>';
                    }else{
                        $status = '<span class="badge badge-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->rawColumns(['show_in_header','show_in_footer','action','status'])
                ->make(true);
        }
        return view('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
       //return $request->input();
        $page = new Page();
        $page->page_title = $request->input('title');
        $page->page_slug = str_replace(array(' ','_'),'-',strtolower($request->input('title')));
        $page->description = htmlspecialchars($request->input('description'));
        $result = $page->save();
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
        $page = Page::where('id',$id)->first();
        return view('admin.pages.edit',['page'=>$page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $id)
    {
        //
        $page = Page::where(['id'=>$id])->update([
            "page_title" => $request->title,
            "page_slug" => str_replace(' ','-',strtolower($request->slug)),
            "description" => htmlspecialchars($request->description),
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
        $destroy = Page::where('id',$id)->delete();
        return  $destroy;
    }

    public function show_in_header(Request $request){
        $id = $request->id;
        $status = $request->status;

        $response = Page::where('id',$id)->update([
            'show_in_header'=> $status
        ]);
        return $response;
    }

    public function show_in_footer(Request $request){
        $id = $request->id;
        $status = $request->status;

        $response = Page::where('id',$id)->update([
            'show_in_footer'=> $status
        ]);
        return $response;
    }
}
