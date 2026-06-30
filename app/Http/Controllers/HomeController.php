<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $doctors = Doctor::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $branches = Branch::query()
            ->where('is_active', true)
            ->get();

        return view('home', compact('services', 'doctors', 'branches'));
    }

    public function services()
    {
        $services = Service::query()->where('is_active', true)->orderBy('sort_order')->get();
        return view('pages.services', compact('services'));
    }

    public function doctors()
    {
        $doctors = Doctor::query()->where('is_active', true)->orderBy('sort_order')->get();
        return view('pages.doctors', compact('doctors'));
    }

    public function branches()
    {
        $branches = Branch::query()->where('is_active', true)->get();
        return view('pages.branches', compact('branches'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        $branches = Branch::query()->where('is_active', true)->get();
        return view('pages.contact', compact('branches'));
    }

    public function book()
    {
        $branches = Branch::query()
            ->where('is_active', true)
            ->with(['doctors' => fn ($q) => $q->where('is_active', true)->orderBy('name')])
            ->orderBy('name')
            ->get();

        $doctors = Doctor::query()->where('is_active', true)->orderBy('sort_order')->get();
        $services = Service::query()->where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.book', compact('branches', 'doctors', 'services'));
    }

    public function offers()
    {
        $offers = Offer::query()->active()->latest()->get();
        return view('pages.offers', compact('offers'));
    }

    public function branchDoctors(Branch $branch): JsonResponse
    {
        $doctors = $branch->doctors()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['doctors.id', 'doctors.name', 'doctors.specialty']);

        return response()->json($doctors);
    }
}
