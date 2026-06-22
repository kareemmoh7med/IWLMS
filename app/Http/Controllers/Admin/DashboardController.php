<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_courses'     => Course::count(),
                'total_students'    => User::role('student')->count(),
                'total_enrollments' => Enrollment::count(),
                'active_courses'    => Course::where('is_active', true)->count(),
            ],
            'recent_courses' => Course::withCount('students')
                ->latest()
                ->take(5)
                ->get(),
            'recent_enrollments' => Enrollment::with(['user', 'course'])
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
