<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

const props = defineProps({
    course: Object,
    isEnrolled: Boolean,
})

function enroll() {
    router.post(route('student.courses.enroll', props.course.id))
}

function unenroll() {
    if (confirm('هل تريد إلغاء التسجيل في هذا الكورس؟')) {
        router.delete(route('student.courses.unenroll', props.course.id))
    }
}
</script>

<template>
    <Head :title="course.title" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
        <div class="max-w-3xl mx-auto">

            <Link :href="route('student.courses.index')" class="text-sm text-gray-500 hover:text-blue-600 mb-4 inline-block">
                ← العودة للكورسات
            </Link>

            <!-- Course Header -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden mb-6">
                <div class="h-52 bg-gradient-to-br from-blue-500 to-purple-600 relative">
                    <img v-if="course.thumbnail"
                        :src="`/storage/${course.thumbnail}`"
                        class="w-full h-full object-cover" />
                </div>
                <div class="p-8">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ course.title }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ course.description }}</p>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <span v-if="course.instructor">👤 {{ course.instructor }}</span>
                        <span>📚 {{ course.lectures?.length }} محاضرة</span>
                        <span v-if="course.duration_hours">⏱️ {{ course.duration_hours }} ساعة</span>
                    </div>

                    <button v-if="!isEnrolled" @click="enroll"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition text-lg">
                        اشترك في الكورس الآن
                    </button>
                    <div v-else class="space-y-3">
                        <div class="flex items-center gap-2 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            أنت مسجل في هذا الكورس
                        </div>
                        <button @click="unenroll" class="text-sm text-red-500 hover:underline">
                            إلغاء التسجيل
                        </button>
                    </div>
                </div>
            </div>

            <!-- Lectures List -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">محتوى الكورس</h2>

                <div v-if="course.lectures?.length" class="space-y-3">
                    <div v-for="lecture in course.lectures" :key="lecture.id"
                        :class="[
                            'flex items-center gap-4 p-4 rounded-xl border transition',
                            isEnrolled
                                ? 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750 cursor-pointer'
                                : 'border-gray-100 dark:border-gray-800 opacity-60'
                        ]">
                        <div class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 dark:text-blue-300 font-bold text-sm">{{ lecture.order }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800 dark:text-white text-sm">{{ lecture.title }}</p>
                            <p v-if="lecture.description" class="text-xs text-gray-400 mt-0.5 line-clamp-1">
                                {{ lecture.description }}
                            </p>
                        </div>
                        <svg v-if="!isEnrolled" class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>

                <p v-else class="text-gray-400 text-sm text-center py-6">
                    لا توجد محاضرات بعد
                </p>
            </div>
        </div>
    </div>
</template>
