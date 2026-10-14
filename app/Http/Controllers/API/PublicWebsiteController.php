<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\FrontService;
use App\Models\FrontSetting;
use App\Models\HospitalSchedule;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class PublicWebsiteController extends Controller
{
    /** Explicit public projection: never serialize users or all application settings. */
    public function index(): JsonResponse
    {
        $keys = [
            'home_page_title', 'home_page_description', 'home_page_experience',
            'about_us_title', 'about_us_description', 'about_us_mission',
            'privacy_policy', 'terms_conditions',
        ];

        return response()->json(['data' => [
            'settings' => Setting::whereIn('key', [
                'app_name', 'hospital_email', 'hospital_phone', 'hospital_address',
            ])->pluck('value', 'key'),
            'content' => FrontSetting::whereIn('key', $keys)->pluck('value', 'key')
                ->map(fn ($value) => html_entity_decode(strip_tags(preg_replace('/<\/(p|div|li|h[1-6])>|<br\s*\/?>/i', "\n", $value ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
            'services' => FrontService::orderBy('name')->get(['id', 'name', 'short_description'])
                ->map(fn ($service) => [
                    'id' => $service->id,
                    'name' => $service->name,
                    'description' => strip_tags($service->short_description ?? ''),
                ]),
            'doctors' => Doctor::with(['doctorUser', 'department'])
                ->whereHas('doctorUser', fn ($query) => $query->where('status', 1))
                ->orderBy('id')->get()->map(fn ($doctor) => [
                    'id' => $doctor->id,
                    'name' => $doctor->doctorUser->full_name,
                    'department' => $doctor->department?->title ?? '',
                    'specialist' => $doctor->specialist ?? '',
                    'qualification' => $doctor->doctorUser->qualification ?? '',
                ]),
            'testimonials' => Testimonial::orderByDesc('id')->get(['id', 'name', 'description'])
                ->map(fn ($item) => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => strip_tags($item->description ?? ''),
                ]),
            'hours' => HospitalSchedule::orderBy('day_of_week')->get()
                ->map(fn ($schedule) => [
                    'day' => HospitalSchedule::WEEKDAY_FULL_NAME[$schedule->day_of_week] ?? '',
                    'start' => $schedule->start_time,
                    'end' => $schedule->end_time,
                ]),
        ]]);
    }
}
