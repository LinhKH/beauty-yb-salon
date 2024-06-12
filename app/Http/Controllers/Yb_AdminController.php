<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Client;
use App\Models\GeneralSetting;

use Illuminate\Http\Request;

class Yb_AdminController extends Controller
{
    //
    public function yb_index(Request $request){
        if($request->input()){

			$request->validate([
				'username'=>'required',
				'password'=>'required',
			]); 
		// return Hash::make($request->input('password'));
			$login = Admin::where(['username'=>$request->username])->pluck('password')->first();

			if(empty($login)){
				return response()->json(['username'=>'Username Does not Exists']);
			}else{
				if(Hash::check($request->password,$login)){
					$admin = Admin::first();
					$request->session()->put('admin','1');
					$request->session()->put('admin_name',$admin->admin_name);
					return '1';
				}else{
					return response()->json(['password'=>'Username and Password does not matched']);
				}
			}
	    }else{
			return view('admin.admin');
		}
    }

    public function yb_dashboard(){
		$agents = Agent::count();

		$services = Service::count();
		$clients = Client::count();
		$appointments = Appointment::count();
		$today_appointments = Appointment::with(['client_detail', 'services'])->select(['appointments.*','time_slot.from_time','time_slot.to_time',DB::raw('COUNT(appointment_service.appointment) as services_total')])
		->leftJoin('appointment_service','appointment_service.appointment','=','appointments.id')
		->leftJoin('time_slot','time_slot.id','=','appointments.time')
		->where('appointments.date',date('Y-m-d'))
		->groupBy('appointments.id')
		->latest()
		->get();
        // dd($today_appointments);
        return view('admin.dashboard',compact('agents','services','clients','appointments','today_appointments'));
    }

	public function yb_logout(Request $req){
		// Auth::logout();
		session()->forget('admin');
		session()->forget('admin_name');
		return '1';
	}
}
