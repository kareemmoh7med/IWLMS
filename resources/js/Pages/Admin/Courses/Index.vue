<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    courses: Object, // paginated
})

function deleteCourse(id) {
    if (confirm('هل أنت متأكد من حذف هذا الكورس؟')) {
        router.delete(route('admin.courses.destroy', id))
    }
}
</script>

<template>
    <Head title="إدارة الكورسات" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">إدارة الكورسات</h1>
                <p class="text-gray-500 mt-1">إضافة وتعديل وحذف الكورسات</p>
            </div>
            <Link :href="route('admin.courses.create')"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة كورس
            </Link>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">اسم الكورس</th>
                            <th class="px-6 py-3">المدرب</th>
                            <th class="px-6 py-3">المحاضرات</th>
                            <th class="px-6 py-3">الطلاب</th>
                            <th class="px-6 py-3">الحالة</th>
                            <th class="px-6 py-3">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="course in courses.data" :key="course.id"
                            class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                            <td class="px-6 py-4 text-gray-400">{{ course.id }}</td>
                            <td class="px-6 py-4 font-semibold">{{ course.title }}</td>
                            <td class="px-6 py-4">{{ course.instructor ?? '—' }}</td>
                            <td class="px-6 py-4">{{ course.lectures_count }}</td>
                            <td class="px-6 py-4">{{ course.students_count }}</td>
                            <td class="px-6 py-4">
                                <span :class="course.is_active
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700'"
                                    class="px-2.5 py-1 rounded-full text-xs font-medium">
                                    {{ course.is_active ? 'نشط' : 'موقوف' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <Link :href="route('admin.courses.edit', course.id)"
                                    class="text-blue-600 hover:underline text-sm">تعديل</Link>
                                <button @click="deleteCourse(course.id)"
                                    class="text-red-500 hover:underline text-sm">حذف</button>
                            </td>
                        </tr>
                        <tr v-if="courses.data.length === 0">
                            <td colspan="7" class="px-6 py-10 text-center text-gray-400">لا توجد كورسات بعد</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 flex justify-between items-center border-t border-gray-100 dark:border-gray-700">
                <p class="text-sm text-gray-500">
                    عرض {{ courses.from }}–{{ courses.to }} من {{ courses.total }} كورس
                </p>
                <div class="flex gap-2">
                    <Link v-for="link in courses.links" :key="link.label"
                        :href="link.url ?? '#'"
                        v-html="link.label"
                        :class="[
                            'px-3 py-1 rounded-lg text-sm',
                            link.active ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100',
                            !link.url ? 'opacity-40 cursor-not-allowed' : ''
                        ]" />
                </div>
            </div>
        </div>
    </div>
</template>
