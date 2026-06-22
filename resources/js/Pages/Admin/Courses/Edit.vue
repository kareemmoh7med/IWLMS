<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3'

const props = defineProps({
    course: Object,
})

const form = useForm({
    title: props.course.title,
    description: props.course.description ?? '',
    instructor: props.course.instructor ?? '',
    duration_hours: props.course.duration_hours,
    thumbnail: null,
    is_active: props.course.is_active,
})

const lectureForm = useForm({
    title: '',
    description: '',
    video_url: '',
    order: props.course.lectures?.length + 1 ?? 1,
})

function updateCourse() {
    form.post(route('admin.courses.update', props.course.id), {
        forceFormData: true,
        _method: 'PUT',
    })
}

function addLecture() {
    lectureForm.post(route('admin.courses.lectures.store', props.course.id), {
        onSuccess: () => lectureForm.reset(),
    })
}

function deleteLecture(lectureId) {
    if (confirm('حذف هذه المحاضرة؟')) {
        router.delete(route('admin.courses.lectures.destroy', [props.course.id, lectureId]))
    }
}
</script>

<template>
    <Head :title="`تعديل: ${course.title}`" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
        <div class="max-w-3xl mx-auto space-y-8">

            <div class="mb-2">
                <Link :href="route('admin.courses.index')" class="text-sm text-gray-500 hover:text-blue-600">
                    ← العودة
                </Link>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">تعديل الكورس</h1>
            </div>

            <!-- Course Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-5">بيانات الكورس</h2>
                <form @submit.prevent="updateCourse" class="space-y-5">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">عنوان الكورس</label>
                        <input v-model="form.title" type="text"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" />
                        <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الوصف</label>
                        <textarea v-model="form.description" rows="3"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المدرب</label>
                            <input v-model="form.instructor" type="text"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الساعات</label>
                            <input v-model="form.duration_hours" type="number" min="0"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" />
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <input v-model="form.is_active" type="checkbox" id="edit_active" class="w-4 h-4 text-blue-600 rounded" />
                        <label for="edit_active" class="text-sm text-gray-700 dark:text-gray-300">الكورس نشط</label>
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-60 text-white font-semibold py-3 rounded-xl transition">
                        {{ form.processing ? 'جاري التحديث...' : 'تحديث الكورس' }}
                    </button>
                </form>
            </div>

            <!-- Lectures Management -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-5">المحاضرات</h2>

                <!-- Existing lectures list -->
                <div class="space-y-3 mb-6">
                    <div v-for="lecture in course.lectures" :key="lecture.id"
                        class="flex items-center justify-between bg-gray-50 dark:bg-gray-750 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white text-sm">{{ lecture.title }}</p>
                            <p class="text-xs text-gray-400">ترتيب: {{ lecture.order }}</p>
                        </div>
                        <button @click="deleteLecture(lecture.id)" class="text-red-500 hover:text-red-700 text-sm">حذف</button>
                    </div>
                    <p v-if="!course.lectures?.length" class="text-sm text-gray-400 text-center py-4">
                        لا توجد محاضرات بعد
                    </p>
                </div>

                <!-- Add lecture form -->
                <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">إضافة محاضرة جديدة</h3>
                    <form @submit.prevent="addLecture" class="space-y-4">
                        <div>
                            <input v-model="lectureForm.title" type="text" placeholder="عنوان المحاضرة *"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" />
                            <p v-if="lectureForm.errors.title" class="text-red-500 text-xs mt-1">{{ lectureForm.errors.title }}</p>
                        </div>
                        <div>
                            <input v-model="lectureForm.video_url" type="url" placeholder="رابط الفيديو (اختياري)"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <textarea v-model="lectureForm.description" rows="2" placeholder="وصف المحاضرة"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" />
                            <input v-model="lectureForm.order" type="number" min="1" placeholder="الترتيب"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" />
                        </div>
                        <button type="submit" :disabled="lectureForm.processing"
                            class="bg-green-600 hover:bg-green-700 disabled:opacity-60 text-white font-medium px-6 py-2.5 rounded-xl transition text-sm">
                            {{ lectureForm.processing ? 'جاري الإضافة...' : '+ إضافة محاضرة' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
