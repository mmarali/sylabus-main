<template>
    <Head title="Dodaj sylabus" />
    <AppLayout>
        <div class="container-fluid mx-auto p-4">
            <div class="mt-4">
                <Link :href="route('sylabus')" class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
                    Powrót do listy
                </Link>
            </div>
            <h1 class="mb-4 text-2xl font-bold">Historia wersji dla kursu: {{ course.name }} ({{ course.code }})</h1>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 bg-white">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border-b px-4 py-2 text-left">Numer wersji</th>
                            <th class="border-b px-4 py-2 text-left">Jednostka</th>
                            <th class="border-b px-4 py-2 text-left">Kierunek</th>
                            <th class="border-b px-4 py-2 text-left">ECTS</th>
                            <th class="border-b px-4 py-2 text-left">Koordynator</th>
                            <th class="border-b px-4 py-2 text-left">Data utworzenia</th>
                            <th class="border-b px-4 py-2 text-left">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="version in versions" :key="version.id" class="hover:bg-gray-50">
                            <td class="border-b px-4 py-2">{{ version.version_number }}</td>
                            <td class="border-b px-4 py-2">{{ version.unit }}</td>
                            <td class="border-b px-4 py-2">{{ version.major }}</td>
                            <td class="border-b px-4 py-2">{{ version.ects }}</td>
                            <td class="border-b px-4 py-2">{{ version.coordinator }}</td>
                            <td class="border-b px-4 py-2">{{ version.created_at }}</td>
                            <td class="border-b px-4 py-2">
                                <Link
                                    v-if="version.version_number > 1"
                                    :href="route('syllabus.diff', { courseId: course.id, versionNumber: version.version_number })"
                                    class="rounded bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-600"
                                >
                                    Historia zmian
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

export default {
    components: { Link, AppLayout, Head },
    props: {
        course: {
            type: Object,
            required: true,
        },
        versions: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style>
table {
    width: 100%;
    border-collapse: collapse;
}
th,
td {
    text-align: left;
    padding: 8px;
}
</style>
