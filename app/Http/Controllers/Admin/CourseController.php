<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $courses = Course::withCount(['lectures', 'students'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Courses/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'instructor'     => 'nullable|string|max:255',
            'duration_hours' => 'nullable|integer|min:0',
            'thumbnail'      => 'nullable|image|max:2048',
            'is_active'      => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'تم إنشاء الكورس بنجاح');
    }

    public function edit(Course $course)
    {
        $course->load('lectures');

        return Inertia::render('Admin/Courses/Edit', [
            'course' => $course,
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'instructor'     => 'nullable|string|max:255',
            'duration_hours' => 'nullable|integer|min:0',
            'thumbnail'      => 'nullable|image|max:2048',
            'is_active'      => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'تم تحديث الكورس بنجاح');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'تم حذف الكورس بنجاح');
    }

    // -------- Lectures inside a course --------

    public function storeLecture(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'nullable|url',
            'order'       => 'integer|min:0',
        ]);

        $course->lectures()->create($validated);

        return back()->with('success', 'تم إضافة المحاضرة بنجاح');
    }

    public function destroyLecture(Course $course, Lecture $lecture)
    {
        $lecture->delete();

        return back()->with('success', 'تم حذف المحاضرة بنجاح');
    }
}
