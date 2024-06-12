<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
//use App\Models\SocialSetting;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\Page;
use App\Models\GalleryImage;
use App\Models\PaymentMethod;
use App\Models\Appointment;
use App\Models\Agent;

if (!function_exists('settings')) {
    function settings()
    {
        $siteInfo = DB::table('general_settings')->first();
        return $siteInfo;
    }
}

if (!function_exists('all_services')) {
    function all_services()
    {
        $services = Service::latest()->get();
        return $services;
    }
}
if (!function_exists('time_slots')) {
    function time_slots()
    {
        $time = TimeSlot::where('status', 1)->get();
        return $time;
    }
}

if (!function_exists('site_pages')) {
    function site_pages()
    {
        return Page::where('status', '1')->get();
    }
}

if (!function_exists('footer_gallery')) {
    function footer_gallery()
    {
        $images = GalleryImage::where('status', 1)->limit(9)->get();
        return $images;
    }
}

if (!function_exists('payment_methods')) {
    function payment_methods()
    {
        $methods = PaymentMethod::where('payment_status', 1)->get();
        return $methods;
    }
}


if (!function_exists('get_filter_service_agents')) {
    function get_filter_service_agents($service_id, $date, $time_id)
    {
        $appointments = Appointment::leftJoin('appointment_service', 'appointment_service.appointment', '=', 'appointments.id')
            ->where(['appointments.date' => $date, 'appointments.time' => $time_id, 'appointment_service.service' => $service_id])
            ->pluck('appointment_service.agent')->toArray();

        $agents = Agent::select(['agents.*', 'services.avail_space'])
            ->leftJoin('services', 'services.id', '=', 'agents.service')
            ->where(['agents.service' => $service_id])->get();
        foreach ($agents as $key => $value) {
            if (in_array($value->id, $appointments)) {
                $agents[$key]->booked = '1';
            } else {
                $agents[$key]->booked = '0';
            }
        }
        return $agents;
    }
}
