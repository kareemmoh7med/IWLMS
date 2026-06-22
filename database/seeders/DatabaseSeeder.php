<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@iwlms.com'],
            [
                'name'     => 'مدير النظام',
                'password' => bcrypt('admin123'),
            ]
        );
        $admin->assignRole('admin');

        // Create sample student
        $student = User::firstOrCreate(
            ['email' => 'student@iwlms.com'],
            [
                'name'     => 'طالب تجريبي',
                'password' => bcrypt('student123'),
            ]
        );
        $student->assignRole('student');

        // Create sample courses with lectures
        $courses = [
            [
                'title'          => 'أساسيات Laravel',
                'description'    => 'تعلم إطار عمل Laravel من الصفر حتى الاحتراف',
                'instructor'     => 'أحمد محمد',
                'duration_hours' => 20,
                'is_active'      => true,
            ],
            [
                'title'          => 'Vue.js للمبتدئين',
                'description'    => 'دليلك الشامل لتعلم Vue.js وبناء واجهات تفاعلية',
                'instructor'     => 'سارة علي',
                'duration_hours' => 15,
                'is_active'      => true,
            ],
            [
                'title'          => 'قواعد البيانات مع MySQL',
                'description'    => 'تصميم قواعد البيانات وكتابة الاستعلامات بكفاءة',
                'instructor'     => 'محمد خالد',
                'duration_hours' => 12,
                'is_active'      => true,
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create($courseData);

            // Add lectures to each course
            for ($i = 1; $i <= 4; $i++) {
                Lecture::create([
                    'course_id'   => $course->id,
                    'title'       => "المحاضرة {$i}: " . $courseData['title'],
                    'description' => "وصف المحاضرة {$i} من كورس " . $courseData['title'],
                    'video_url'   => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'order'       => $i,
                ]);
            }
        }
    }
}
