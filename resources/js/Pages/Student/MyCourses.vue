<script setup>
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    courses: Object,
})
</script>

<template>
    <Head title="كورساتي" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">كورساتي</h1>
                <p class="text-gray-500 mt-1">الكورسات التي اشتركت فيها</p>
            </div>
            <Link :href="route('student.courses.index')" class="text-blue-600 hover:underline text-sm font-medium">
                ← تصفح الكورسات
            </Link>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="course in courses.data" :key="course.id"
                class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden hover:shadow-md transition">
                <div class="h-36 bg-gradient-to-br from-blue-500 to-purple-600 relative">
                    <img v-if="course.thumbnail" :src="`/storage/${course.thumbnail}`"
                        class="w-full h-full object-cover" />
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">{{ course.title }}</h3>
                    <p class="text-xs text-gray-400 mb-4">{{ course.lectures_count }} محاضرة</p>
                    <Link :href="route('student.courses.show', course.id)"
                        class="block text-center bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 rounded-xl transition">
                        متابعة الكورس
                    </Link>
                </div>
            </div>
        </div>

        <div v-if="courses.data.length === 0" class="text-center py-20">
            <p class="text-gray-400 text-lg mb-4">لم تشترك في أي كورس بعد</p>
            <Link :href="route('student.courses.index')"
                class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                تصفح الكورسات
            </Link>
        </div>
    </div>
</template>
