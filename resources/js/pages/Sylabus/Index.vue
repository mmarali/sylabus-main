<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

interface University {
    id: number;
    name: string;
    city?: string;
}

interface Syllabus {
    id: number;
    subject_name: string;
    semester?: string;
    hours?: number;
    university?: University;
}

const props = defineProps<{
    syllabuses: Syllabus[];
}>();

const removeSyllabus = (id: number) => {
    if (confirm('Czy na pewno chcesz usunąć ten sylabus?')) {
        router.delete(route('sylabus.destroy', id));
    }
};
</script>

<template>
    <Head title="Uczelnie" />
    <AppLayout>
        <div class="container-fluid mx-auto p-4">
            <div class="mb-4">
                <Link :href="route('sylabus.create')" class="rounded bg-blue-500 px-4 py-2 text-white"> Dodaj nowy sylabus </Link>
            </div>
            <h1 class="text-2xl font-bold mb-4">Lista Sylabusów</h1>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b text-left">Kod</th>
                        <th class="py-2 px-4 border-b text-left">Nazwa</th>
                        <th class="py-2 px-4 border-b text-left">Jednostka</th>
                        <th class="py-2 px-4 border-b text-left">Kierunek</th>
                        <th class="py-2 px-4 border-b text-left">ECTS</th>
                        <th class="py-2 px-4 border-b text-left">Koordynator</th>
                        <th class="py-2 px-4 border-b text-left">Wersja</th>
                        <th class="py-2 px-4 border-b text-left">Data utworzenia</th>
                        <th class="py-2 px-4 border-b text-left">Akcje</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="syllabus in syllabuses" :key="syllabus.id" class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ syllabus.code }}</td>
                        <td class="py-2 px-4 border-b">{{ syllabus.name }}</td>
                        <td class="py-2 px-4 border-b">{{ syllabus.unit || 'Brak' }}</td>
                        <td class="py-2 px-4 border-b">{{ syllabus.major || 'Brak' }}</td>
                        <td class="py-2 px-4 border-b">{{ syllabus.ects || 'Brak' }}</td>
                        <td class="py-2 px-4 border-b">{{ syllabus.coordinator || 'Brak' }}</td>
                        <td class="py-2 px-4 border-b">{{ syllabus.version_number || 'Brak' }}</td>
                        <td class="py-2 px-4 border-b">{{ syllabus.created_at || 'Brak' }}</td>
                        <td class="py-2 px-4 border-b flex space-x-2">
                            <Link
                                :href="route('sylabus.show', { courseId: syllabus.id })"
                                class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600"
                            >
                                Szczegóły
                            </Link>
                            <Link
                                :href="route('sylabus.history', { courseId: syllabus.id })"
                                class="rounded bg-green-500 px-4 py-2 text-white hover:bg-green-600"
                            >
                                Historia
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
