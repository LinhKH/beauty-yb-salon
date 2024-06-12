<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\ContactUs;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class Yb_SettingController extends Controller
{
    //
    public function yb_general_settings(Request $request){
        if($request->input()){
            $request->validate([
                'logo'=> 'image|mimes:jpg,jpeg,png,svg',
                'com_name'=> 'required',
                'com_email'=> 'required',
                'address'=> 'required',
                'phone'=> 'required',
                'description'=> 'required',
                'currency'=> 'required',
                'f_address'=> 'required',
                'map'=> 'required',
            ]);

            if($request->logo != ''){        
                $path = public_path().'/site-img/';

                //code for remove old file
                if($request->old_logo != ''  && $request->old_logo != null){
                    $file_old = $path.$request->old_logo;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                //upload new file
                $file = $request->logo;
                $filename = rand().$file->getClientOriginalName();
                $file->move($path, $filename);
            }else{
                $filename = $request->old_logo;
            }

            $update = DB::table('general_settings')->update([
                'com_logo'=>$filename,
                'com_name'=>$request->com_name,
                'com_email'=>$request->com_email,
                'com_phone'=>$request->phone,
                'address'=>$request->address,
                'description'=>$request->description,
                'address_footer'=>$request->f_address,
                'cur_format'=>$request->currency,
                'map'=>$request->map,
                'booking_amount'=>$request->discount,
             
            ]);
            return $update;
        }else{
            $settings = DB::table('general_settings')->get();
            return view('admin.settings.general',['data'=>$settings]);
        }
    }
    
    public function yb_profile_settings(Request $request){
        if($request->input()){
            $request->validate([
                'admin_name'=> 'required',
                'admin_email'=> 'required|email:rfc',
                'username'=> 'required',
            ]);

            $update = DB::table('admin')->update([
                'admin_name'=>$request->admin_name,
                'admin_email'=>$request->admin_email,
                'username'=>$request->username,
            ]);
            return $update;

        }else{
            $settings = DB::table('admin')->get();
            return view('admin.settings.profile',['data'=>$settings]);
        }
    }

    public function yb_change_password(Request $request){
        if($request->input()){
            $request->validate([
                'password'=> 'required',
                'new'=> 'required',
                'new_confirm'=> 'required',
            ]);

            $get_admin = DB::table('admin')->first();

            if(Hash::check($request->password,$get_admin->password)){
                DB::table('admin')->update([
                    'password'=>Hash::make($request->new)
                ]);
                return '1';
            }else{
                return 'Please Enter Correct Current Password';
            }
        }
    } 
  
    public function yb_social_settings(Request $request){
        if($request->input()){
            $update = DB::table('social-setting')->update([
                'facebook'=>$request->facebook,
                'twitter'=>$request->twitter,
                'instagram'=>$request->instagram,
                'you_tube'=>$request->you_tube,
            ]);
            return $update;
        }else{
            $settings = DB::table('social-setting')->get();
            return view('admin.settings.social',['data'=>$settings]);
        }
    }

    public function yb_contact(Request $request){
        //
        if ($request->ajax()) {
            $data = ContactUs::orderBy('id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
            $btn = '<a href= "javascript:void(0)" data-id="'.$row->id.'" class="viewContact btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        } 
        return view('admin.contact'); 
    }

    public function yb_Contactview($id){
        //
        $contactUs = ContactUs::where(['id'=> $id])->get();
        $output = '';
            foreach($contactUs as $value){
            $output .= '<tr>
                            <th>Client Name:</th>
                            <td scope="row" class="client">'.$value["client"].'</td>
                        </tr>
                        <tr>
                            <th>Email :</th>
                            <td>'.$value["email"].'</td>
                        </tr>
                        <tr>
                            <th>Phone :</th>
                            <td>'.$value["phone"].'</td>
                        </tr>
                        <tr>
                            <th>Description :</th>
                            <td>'.htmlspecialchars_decode($value["description"]).'</td>
                        </tr>';
            } 
        return $output;      
    }

    public function yb_incomeReport(Request $request){
        if($request->ajax()){
            if($request->from_date != '' && $request->to_date != ''){
                $from = $request->from_date;
                $to = $request->to_date;
                $data = Appointment::with('client_detail')
                ->where('service_status','2')
                ->whereBetween('date', [$from, $to])->get();
            }else{
                $data = Appointment::with('client_detail')->where('service_status','2')->get();
            }

            
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('date',function($row){
                    return date('d M, Y',strtotime($row->date));
                })
                ->addColumn('client_name',function($row){
                    return $row->client_detail->name;
                })
                ->addColumn('direct',function($row){
                    return ($row->amount-$row->advance);
                })
                ->addColumn('total', function($row){
                        return $row->amount;
                    })
                ->rawColumns(['total','client_name','direct'])
                ->make(true);
        }
        return view('admin.settings.report');
    }
}
