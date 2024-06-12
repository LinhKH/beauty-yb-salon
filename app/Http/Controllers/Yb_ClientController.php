<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\str;
use Illuminate\Support\Carbon;
use Mail;
use App\Models\PasswordReset;
use App\Models\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Yb_ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Client::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('type', function ($row) {
                    if ($row->type == '1') {
                        return 'Online';
                    } else {
                        return 'Direct';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if ($row->status == '1') {
                        $btn .= '<a href="javascript:void(0)" class="text-danger client-status" data-id="' . $row->id . '" data-status="0">Block</a>';
                    } else {
                        $btn .= '<a href="javascript:void(0)" class="text-success client-status" data-id="' . $row->id . '" data-status="1">Unblock</a>';
                    }
                    $btn .= ' <a href="client/' . $row->id . '/edit" class="btn btn-sm btn-success">Edit</a> <button type="button" value="delete" class="btn btn-danger btn-sm delete-client" data-id="' . $row->id . '">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.client.index');
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
    public function store(Request $request)
    {
        //
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
        $client = Client::find($id);
        return view('admin.client.edit', ['client' => $client]);
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
        $client = Client::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request["password"]),
        ]);
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Client::where('id', $id)->delete();
        return $destroy;
    }

    public function changeStatus(Request $request)
    {
        $client = Client::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        return $client;
    }

    public function yb_change_password(Request $request)
    {
        if (Session::has('id')) {
            if ($request->input()) {
                $request->validate([
                    'password' => 'required',
                    'new_pass' => 'required',
                    'new_confirm' => 'required'
                ]);
                $id = session()->get('id');
                $select = DB::table('clients')->where('id', $id)->pluck('password');

                if (Hash::check($request->password, $select[0])) {
                    $update = DB::table('clients')->where('id', $id)->update([
                        'password' => Hash::make($request->new_pass)
                    ]);
                    return 1;
                } else {
                    return 'Please Enter Correct Old Password';
                }
            } else {
                return view('public.change-password');
            }
        } else {
            return redirect('login');
        }
    }

    public function yb_login(Request $req)
    {
        if (!session()->has('id')) {
            if ($req->input()) {
                $req->validate([
                    'email' => 'required|email',
                    'password' => 'required',
                ]);

                $user = $req->input('email');
                // print_r($user);
                $pass = $req->input('password');

                $login = Client::select(['id', 'name', 'phone', 'email', 'password', 'status'])
                    ->where('email', $user)->first();
                if ($login) {
                    if ($login['status'] == '1') {
                        if (Hash::check($pass, $login['password'])) {
                            $req->session()->put('id', $login['id']);
                            $req->session()->put('name', $login['name']);
                            return '1';
                        } else {
                            return 'Email Address and Password Not Matched.';
                        }
                    } else {
                        return 'Your Account is blocked by Site Administrator.';
                    }
                } else {
                    return 'Email Does Not Exists';
                }
            } else {
                return view('public.login');
            }
        } else {
            return redirect('my_appointment');
        }
    }

    public function yb_forgot_password(Request $request)
    {
        if (!session()->has('id')) {
            if ($request->input()) {
                try {
                    $client = Client::where('email', $request->email)->first();
                    if ($client) {
                        if ($client->type == '0') {
                            return 'Your account is blocked by Site Administrator';
                        }
                        $token = Str::random(40);
                        $domain = URL::to('/');
                        $url = $domain . '/reset-password?token=' . $token;

                        $data['url'] = $url;
                        $data['email'] = $request->email;
                        $data['title'] = 'Password Reset';
                        $data['body'] = 'Please click on below link to reset you password.';

                        Mail::send('public.mail.forgotPasswordMail', ['data' => $data], function ($message) use ($data) {
                            $message->to($data['email'])->subject($data['title']);
                        });
                        $dataTime = Carbon::now()->format('Y-m-d H:i:s');
                        PasswordReset::updateOrCreate(
                            ['email' => $request->email],
                            [
                                'email' => $request->email,
                                'token' => $token,
                                'created_at' => $dataTime
                            ]
                        );
                        return 'Please check your mail to reset your password';
                    } else {
                        return 'Email Does Not Exists!';
                    }
                } catch (\Exception $e) {
                    return response()->json(['error', $e->getMessage()]);
                }
            } else {
                return view('public.forgot-password');
            }
        } else {
            return abort('404');
        }
    }

    public function yb_reset_password(Request $request)
    {
        $resetData = PasswordReset::where('token', $request->token)->get();
        //  return $resetData;
        if (isset($request->token) && count($resetData) > 0) {
            $client = Client::where('email', $resetData[0]['email'])->get();
            //  return $client;
            return view('public.reset-password', compact('client'));
        } else {
            return view('public.404');
        }
    }

    public function yb_reset_passwordUpdate(Request $request)
    {
        //  return $request->input();
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        $data = Client::where(['id' => $request->id])->update([
            "password" => Hash::make($request->input("password")),
        ]);
        $client = Client::where('id', $request->id)->first();
        PasswordReset::where('email', $client->email)->delete();
        return '1';
        //return 'Your Password has been reset successfully.';
    }

    public function yb_logout(Request $request)
    {
        $request->session()->forget('id');
        $request->session()->forget('name');
        return redirect('/');
    }
}
