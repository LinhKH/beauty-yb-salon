<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\Agent;
use App\Models\Client;
use App\Models\GalleryImage;
use App\Models\ContactUs;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\GalleryCategory;
use App\Models\Banner;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
// use App\PaymentGateway\Paypal;
use App\PaymentGateway\PaypalTest;
use App\PaymentGateway\Stripe;


use App\PaymentGateway\Razorpay;
use App\PaymentGateway\AuthorizeNet;
use Illuminate\Pagination\Paginator;
use Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;;

class Yb_HomeController extends Controller
{
    // home page
    public function index()
    {
        $banner = Banner::where('status', '1')->get();
        $service = Service::where(['status' => '1', 'show_on_homepage' => '1'])->latest()->get();
        $agent = Agent::select(['agents.*', 'services.title'])
            ->leftJoin('services', 'services.id', '=', 'agents.service')
            ->where('agents.status', '1')->limit('8')->get();
        $timeSlot = TimeSlot::where('status', '1')->get();
        return view('public.index', ['service' => $service, 'agent' => $agent, 'time' => $timeSlot, 'banner' => $banner]);
    }
    // our Services page
    public function yb_all_services()
    {
        Paginator::useBootstrapFive();
        $service = Service::where('status', '1')->latest()->paginate(9);
        return view('public.services', ['service' => $service]);
    }

    // Our team Page
    public function yb_all_agents()
    {
        Paginator::useBootstrapFive();
        $agent = Agent::select(['agents.*', 'services.title'])
            ->leftJoin('services', 'services.id', '=', 'agents.service')
            ->where('agents.status', '1')->paginate('6');
        return view('public.agents', ['agent' => $agent]);
    }

    // Gallery Page
    public function yb_all_gallery()
    {
        Paginator::useBootstrapFive();
        $category = GalleryCategory::withCount('images')->get();
        $gallery = GalleryImage::where('status', '1')->inRandomOrder()->paginate(12);
        return view('public.gallery', ['category' => $category, 'gallery' => $gallery]);
    }

    // Category Gallery Page
    public function yb_category_gallery($slug)
    {
        Paginator::useBootstrapFive();
        $category = GalleryCategory::withCount('images')->get();
        $single_category = GalleryCategory::where('title', $slug)->first();
        if ($single_category) {
            $gallery = GalleryImage::where(['category' => $single_category->id, 'status' => '1'])->paginate(12);
            return view('public.category-gallery', ['category' => $category, 'gallery_category' => $single_category, 'gallery' => $gallery]);
        } else {
            return redirect('404');
        }
    }
    // Contact Us Page
    public function yb_contact()
    {
        return view('public.contact');
    }

    // Single Service  Page
    public function yb_single_service($slug)
    {
        $service = Service::where('slug', $slug)->first();
        if ($service) {
            return view('public.single-service', ['service' => $service]);
        } else {
            return redirect('404');
        }
    }

    // insert contact message 
    public function yb_contactStore(Request $request)
    {
        $request->validate([
            'client' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'description' => 'required',
        ]);

        $contactUs = new ContactUs();
        $contactUs->client = $request->input("client");
        $contactUs->email = $request->input("email");
        $contactUs->phone = $request->input("phone");
        $contactUs->description = htmlspecialchars($request->input("description"));
        $result = $contactUs->save();
        return $result;
    }

    // shoe appointment checkout page    
    public function yb_appointment_booking(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
        ]);
        $date = $request->input("date");
        $time = $request->input("time");
        $qty = $request->input("qty");
        $service = $request->input("service");
        $agent_id = $request->input("agent");
        $timeSlot = TimeSlot::select('id', 'to_time', 'from_time')->where('id', $time)->first();


        $services = Service::select('id', 'title', 'price')->whereIn('id', $service)->get()->keyBy('id');
        $agents = Agent::select('id', 'name')->whereIn('id', $agent_id)->get()->keyBy('id');




        $client = '';
        if (session()->has('id')) {
            $client = Client::select(['name', 'phone', 'email'])->where('id', session()->get('id'))->first();
        }
        return view('public.appointment_booking', ['date' => $date, 'time' => $timeSlot, 'qty' => $qty, 'services' => $services, 'service' => $service, 'agent_id' => $agent_id, 'agents' => $agents, 'client' => $client]);
    }

    // create appointment
    public function yb_create_appointment(Request $request)
    {
        if (!session()->has('id')) {
            $request->validate([
                'client' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'pass' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);
        }

        $pay_method = $request->pay_method;
        Session::put('appointment', $request->input());

        if ($pay_method == 'paypal') {
            $paypal = new PaypalTest();
            return $paypal->checkout();
        }
        if ($pay_method == 'stripe') {
            $stripe = new Stripe();
            return $stripe->create();
        }
        if ($pay_method == 'authorizenet') {
            $authorize = new AuthorizeNet();
            return $authorize->create($request);
        }
    }
    // store appointment data in DB
    public function yb_store_appointment($response)
    {
        $request = Session::get('appointment');
        // $date = $request["date"];
        // $time = $request["time"];
        // $qty = $request["qty"];
        // $agent = $request["agent"];
        // $service_id = $request["service"];

        if (!session()->has('id')) {
            // insert client details
            $client = new Client();
            $client->name = $request["client"];
            $client->email = $request["email"];
            $client->phone = $request["phone"];
            $client->password = Hash::make($request["pass"]);
            $saveClient = $client->save();
            $client_id = $client->id;
        } else {
            $client_id = session()->get('id');
        }
        // calculate total amount
        $count_service = count($request["service"]);
        $amount = 0;
        for ($i = 0; $i < $count_service; $i++) {
            $price = Service::where('id', $request["service"][$i])->pluck('price')->first();
            $amount += $price * $request["qty"][$i];
        }
        // insert appointment
        $appointment = new Appointment();
        $appointment->client = $client_id;
        $appointment->date = $request['date'];
        $appointment->time = $request['time'];
        $appointment->amount = $amount;
        $appointment->advance = $request['advance_payment'];
        $appointment->payment_status = '1'; //1 = Active, 0 = Inactive
        $appointment->appointment_type = '1'; //1 = Online
        $saveAppointment = $appointment->save();
        // insert appointment services
        for ($i = 0; $i < $count_service; $i++) {
            $price = Service::where('id', $request["service"][$i])->pluck('price')->first();
            $appointmentService = new AppointmentService();
            $appointmentService->appointment = $appointment->id;
            $appointmentService->service = $request["service"][$i];
            $appointmentService->agent = $request["agent"][$i];
            $appointmentService->qty = $request["qty"][$i];
            $appointmentService->service_price = $price;
            $saveAppService = $appointmentService->save();
        }
        // insert payment details
        DB::table('payments')->insert([
            'appointment_id' => $appointment->id,
            'amount' => $request['advance_payment'],
            'pay_method' => $request['pay_method'],
            'transaction_id' => $response['id'],
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);
        if (!session()->has('id')) {
            $data['email'] = $request['email'];
        } else {
            $data['email'] = Client::where('id', session()->get('id'))->pluck('email')->first();
        }
        $data['title'] = 'Appointment Booked Successfully.';
        $data['body'] = 'Your Appointment Booked Successfully.';
        // send mail to client for appointment successfully booked
        Mail::send('mail.contact-mail', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });

        Session::forget('appointment');
        return $saveAppService;
    }

    // check payment status
    public function yb_paymentStatus(Request $request)
    {
        $request_sess = Session::get('appointment');
        if ($request_sess['pay_method'] == 'paypal') {
            $paypal = new Paypal();
            $response = $paypal->getPaymentStatus($request);
            if (isset($response['success'])) {
                $store = $this->yb_store_appointment($response);
                if ($store == '1') {
                    return redirect('appointment/payment/success')->with('payment_success', $response['success']);
                }
            } else {
                return redirect('appointment/payment/failed')->with('payment_error', $response['error']);;
            }
        } elseif ($request_sess['pay_method'] == 'razorpay') {
            $razorpay = new Razorpay();
            $response = $razorpay->checkout($request->razor_payid);
            if (isset($response['success'])) {
                $store = $this->yb_store_appointment($response);
                if ($store == '1') {
                    return redirect('appointment/payment/success')->with('payment_success', $response['success']);
                }
            } else {
                return redirect('appointment/payment/failed')->with('payment_error', $response['error']);;
            }
        } elseif ($request_sess['pay_method'] == 'stripe') {
            $request->validate(
                [
                    'fullName' => 'required',
                    'cardNumber' => 'required|max:19',
                    'month' => 'required',
                    'year' => 'required',
                    'cvv' => 'required|numeric|max_digits:4'
                ],
                [
                    'fullName.required' => 'Enter Full Name',
                    'cardNumber.required' => 'Card Number is Required',
                    'cardNumber.size' => 'Card Number is Incorrect',
                    'cardNumber.max' => 'Card Number is Incorrect',
                    'month.required' => 'Month is Required',
                    'year.required' => 'Year is Required',
                    'cvv.required' => 'CVV is Required',
                    'cvv.size' => 'CVV is Invalid',
                    'cvv.numeric' => 'CVV is Invalid',
                    'cvv.max_digits' => 'CVV is Invalid',
                ]
            );

            $amount = $request_sess['advance_payment'];
            $stripe = new Stripe();
            $response = $stripe->createToken($request, $amount);
            dd($response);
            if (isset($response['success'])) {
                $store = $this->yb_store_appointment($response);
                if ($store == '1') {
                    return redirect('appointment/payment/success')->with('payment_success', $response['success']);
                }
            } else {
                return redirect('appointment/payment/failed')->with('payment_error', $response['error']);;
            }
        } elseif ($request_sess['pay_method'] == 'authorizenet') {
            $request->validate(
                [
                    'fullName' => 'required',
                    'cardNumber' => 'required|max:19',
                    'month' => 'required',
                    'year' => 'required',
                    'cvv' => 'required|numeric|max_digits:4'
                ],
                [
                    'fullName.required' => 'Enter Full Name',
                    'cardNumber.required' => 'Card Number is Required',
                    'cardNumber.size' => 'Card Number is Incorrect',
                    'cardNumber.max' => 'Card Number is Incorrect',
                    'month.required' => 'Month is Required',
                    'year.required' => 'Year is Required',
                    'cvv.required' => 'CVV is Required',
                    'cvv.size' => 'CVV is Invalid',
                    'cvv.numeric' => 'CVV is Invalid',
                ]
            );

            $amount = $request_sess['advance_payment'];
            $authorize = new AuthorizeNet();
            $response = $authorize->checkout($request, $amount);
            if (isset($response['success'])) {
                $store = $this->yb_store_appointment($response);
                if ($store == '1') {
                    return redirect('appointment/payment/success')->with('payment_success', $response['success']);
                }
            } else {
                return redirect('appointment/payment/failed')->with('payment_error', $response['error']);;
            }
        }
    }
    // stripe payment page
    public function yb_stripe_view()
    {
        return view('public.payment.stripe');
    }
    // authorize payment page
    public function yb_authorizeNet_view()
    {
        return view('public.payment.authorizeNet');
    }

    // get service agents
    public function yb_get_service_agents(Request $request)
    {
        $service_id = $request->id;
        $time_id = $request->time_id;
        $date = $request->date;
        $agents = get_filter_service_agents($service_id, $date, $time_id);
        return view('public.partials.agentsList', ['agents' => $agents]);
    }

    // show new client services in modal
    public function yb_show_newClient_services(Request $request)
    {
        $services = $request->services;
        foreach ($services as $key => $value) {
            $service = Service::select(['title', 'price'])->where('id', $value['service'])->first();
            $services[$key]['service_name'] = $service->title;
            $services[$key]['max_qty'] = $service->avail_space;
            $services[$key]['price'] = $service->price;
            $services[$key]['agents_list'] = get_filter_service_agents($value['service'], $request->date, $request->time_id);
        }
        return view('public.partials.service-modal-content', ['services' => $services]);
    }

    public function yb_appointment_payment_success(Request $request)
    {
        return view('public.success');
    }
    // appointment booking success page
    public function yb_appointment_success(Request $request)
    {

        $paypal = new PaypalTest();

        $response = $paypal->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {

            $orderId = session()->get('order_id');

            $store = $this->yb_store_appointment($response);
            if ($store == '1') {
                return redirect('appointment/payment/success')->with('payment_success', $response['status']);
            }
        } else {
            return redirect('appointment/payment/failed')->with('payment_error', $response['error']);
        }
    }
    // appointment failed page
    public function yb_appointment_failed()
    {
        return view('public.failed');
    }

    function stripeSuccess(Request $request)
    {
        $sessionId = $request->session_id;
        $stripe = new Stripe();
        $response = $stripe->retrieve($sessionId);

        if ($response->payment_status === 'paid') {

            $store = $this->yb_store_appointment($response);
            if ($store == '1') {
                return redirect('appointment/payment/success')->with('payment_success', $response['status']);
            }
        } else {
            return redirect('appointment/payment/failed')->with('payment_error', $response['error']);
        }
    }

    function stripeCancel()
    {
        return redirect('appointment/payment/failed')->with('payment_error', 'Cancelled stripe payment');
    }
    // user appointments
    public function yb_MyAppointment()
    {
        Paginator::useBootstrapFive();
        if (Session::has('id')) {
            $client_id = Session::get('id');
            $appointments = Appointment::with('timing', 'services')->where('client', $client_id)->orderBy('id', 'desc')->paginate(10);
            return view('public.my_appointment', ['appointments' => $appointments]);
        } else {
            return redirect('login');
        }
    }

    public function yb_customPage($slug)
    {
        $page = Page::where('page_slug', $slug)->first();
        if ($page) {
            return view('public.custom', ['page' => $page]);
        } else {
            return redirect('404');
        }
    }
}
