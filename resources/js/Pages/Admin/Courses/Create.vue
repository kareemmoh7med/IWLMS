<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    title: '',
    description: '',
    instructor: '',
    duration_hours: '',
    thumbnail: null,
    is_active: true,
})

function submit() {
    form.post(route('admin.courses.store'), {
        forceFormData: true,
    })
}
</script>

<template>
    <Head title="إضافة كورس جديد" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
        <div class="max-w-2xl mx-auto">

            <div class="mb-6">
                <Link :href="route('admin.courses.index')"
                    class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1">
                    ← العودة للكورسات
                </Link>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">إضافة كورس جديد</h1>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8">
                <form @submit.prevent="submit" class="space-y-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            عنوان الكورس *
                        </label>
                        <input v-model="form.title" type="text" placeholder="مثال: أساسيات Laravel"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"
                            :class="{ 'border-red-500': form.errors.title }" />
                        <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            وصف الكورس
                        </label>
                        <textarea v-model="form.description" rows="4" placeholder="اكتب وصفاً مختصراً للكورس..."
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                اسم المدرب
                            </label>
                            <input v-model="form.instructor" type="text" placeholder="اسم المدرب"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                عدد الساعات
                            </label>
                            <input v-model="form.duration_hours" type="number" min="0" placeholder="0"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            صورة الكورس (Thumbnail)
                        </label>
                        <input type="file" accept="image/*"
                            @change="form.thumbnail = $event.target.files[0]"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white" />
                    </div>

                    <div class="flex items-center gap-3">
                        <input v-model="form.is_active" type="checkbox" id="is_active"
                            class="w-4 h-4 text-blue-600 rounded" />
                        <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">
                            الكورس نشط (ظاهر للطلاب)
                        </label>
                    </div>

                    <div class="flex gap-4 pt-2">
                        <button type="submit" :disabled="form.processing"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 disabled:opacity-60 text-white font-semibold py-3 rounded-xl transition">
                            {{ form.processing ? 'جاري الحفظ...' : 'حفظ الكورس' }}
                        </button>
                        <Link :href="route('admin.courses.index')"
                            class="flex-1 text-center border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold py-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            إلغاء
                        </Link>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
