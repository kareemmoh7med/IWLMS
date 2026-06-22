<script setup>
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    stats: Object,
    recent_courses: Array,
    recent_enrollments: Array,
})
</script>

<template>
    <Head title="لوحة تحكم المدير" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">لوحة تحكم المدير</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">مرحباً بك في منصة IWLMS</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center gap-4">
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">إجمالي الكورسات</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.total_courses }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center gap-4">
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">إجمالي الطلاب</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.total_students }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center gap-4">
                <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">التسجيلات</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.total_enrollments }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center gap-4">
                <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">كورسات نشطة</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.active_courses }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <Link :href="route('admin.courses.create')"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة كورس جديد
            </Link>
        </div>

        <!-- Recent Courses Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">أحدث الكورسات</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3">اسم الكورس</th>
                            <th class="px-6 py-3">المدرب</th>
                            <th class="px-6 py-3">عدد الطلاب</th>
                            <th class="px-6 py-3">الحالة</th>
                            <th class="px-6 py-3">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="course in recent_courses" :key="course.id"
                            class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <td class="px-6 py-4 font-medium">{{ course.title }}</td>
                            <td class="px-6 py-4">{{ course.instructor ?? '—' }}</td>
                            <td class="px-6 py-4">{{ course.students_count }}</td>
                            <td class="px-6 py-4">
                                <span :class="course.is_active
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'"
                                    class="px-2.5 py-0.5 rounded-full text-xs font-medium">
                                    {{ course.is_active ? 'نشط' : 'موقوف' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <Link :href="route('admin.courses.edit', course.id)"
                                    class="text-blue-600 hover:underline ml-3">تعديل</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
