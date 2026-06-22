<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:student']);
    }

    public function index()
    {
        $user = Auth::user();

        $courses = Course::where('is_active', true)
            ->withCount('lectures')
            ->with(['enrollments' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->latest()
            ->paginate(12);

        return Inertia::render('Student/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function show(Course $course)
    {
        $course->load('lectures');
        $isEnrolled = Auth::user()->isEnrolledIn($course);

        return Inertia::render('Student/Courses/Show', [
            'course'     => $course,
            'isEnrolled' => $isEnrolled,
        ]);
    }

    public function enroll(Course $course)
    {
        $user = Auth::user();

        if ($user->isEnrolledIn($course)) {
            return back()->with('error', 'أنت مسجل بالفعل في هذا الكورس');
        }

        Enrollment::create([
            'user_id'     => $user->id,
            'course_id'   => $course->id,
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'تم التسجيل في الكورس بنجاح!');
    }

    public function unenroll(Course $course)
    {
        Auth::user()->enrollments()
            ->where('course_id', $course->id)
            ->delete();

        return back()->with('success', 'تم إلغاء التسجيل بنجاح');
    }

    public function myCourses()
    {
        $courses = Auth::user()->courses()
            ->withCount('lectures')
            ->latest('enrollments.created_at')
            ->paginate(12);

        return Inertia::render('Student/MyCourses', [
            'courses' => $courses,
        ]);
    }
}
