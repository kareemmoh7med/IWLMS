<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

const props = defineProps({
    courses: Object,
})

function enroll(courseId) {
    router.post(route('student.courses.enroll', courseId))
}
</script>

<template>
    <Head title="الكورسات المتاحة" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">الكورسات المتاحة</h1>
                <p class="text-gray-500 mt-1">اشترك في الكورسات التي تريدها</p>
            </div>
            <Link :href="route('student.my-courses')"
                class="text-blue-600 hover:underline text-sm font-medium">
                كورساتي ←
            </Link>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div v-for="course in courses.data" :key="course.id"
                class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden hover:shadow-md transition group">

                <!-- Thumbnail -->
                <div class="h-40 bg-gradient-to-br from-blue-500 to-purple-600 relative overflow-hidden">
                    <img v-if="course.thumbnail"
                        :src="`/storage/${course.thumbnail}`"
                        :alt="course.title"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
                    <div v-else class="w-full h-full flex items-center justify-center">
                        <svg class="w-14 h-14 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                    <!-- Enrolled badge -->
                    <div v-if="course.enrollments?.length"
                        class="absolute top-3 right-3 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                        مسجل
                    </div>
                </div>

                <!-- Body -->
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 line-clamp-1">{{ course.title }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3 line-clamp-2">
                        {{ course.description ?? 'لا يوجد وصف' }}
                    </p>

                    <div class="flex items-center gap-3 text-xs text-gray-400 mb-4">
                        <span>{{ course.lectures_count }} محاضرة</span>
                        <span v-if="course.duration_hours">· {{ course.duration_hours }} ساعة</span>
                        <span v-if="course.instructor">· {{ course.instructor }}</span>
                    </div>

                    <div class="flex gap-2">
                        <Link :href="route('student.courses.show', course.id)"
                            class="flex-1 text-center border border-blue-600 text-blue-600 text-sm py-2 rounded-xl hover:bg-blue-50 transition">
                            التفاصيل
                        </Link>
                        <button v-if="!course.enrollments?.length"
                            @click="enroll(course.id)"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 rounded-xl transition">
                            اشتراك
                        </button>
                        <span v-else class="flex-1 text-center bg-green-100 text-green-700 text-sm py-2 rounded-xl">
                            مسجل ✓
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty state -->
        <div v-if="courses.data.length === 0" class="text-center py-20">
            <p class="text-gray-400 text-lg">لا توجد كورسات متاحة حالياً</p>
        </div>

        <!-- Pagination -->
        <div v-if="courses.last_page > 1" class="flex justify-center gap-2 mt-8">
            <Link v-for="link in courses.links" :key="link.label"
                :href="link.url ?? '#'"
                v-html="link.label"
                :class="[
                    'px-4 py-2 rounded-xl text-sm',
                    link.active ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50',
                    !link.url ? 'opacity-40 cursor-not-allowed' : ''
                ]" />
        </div>
    </div>
</template>
