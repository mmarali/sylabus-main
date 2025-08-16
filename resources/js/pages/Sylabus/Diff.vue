<template>
    <Head title="Dodaj sylabus" />
    <AppLayout>
        <div class="container-fluid mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">
                Historia zmian dla kursu: {{ course.name }} (Wersja {{ currentVersion.version_number }})
            </h1>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">
                    Różnice w porównaniu z wersją {{ previousVersion ? previousVersion.version_number : 'brak' }}
                </h2>

                <div v-if="previousVersion">
                    <h3 class="text-lg font-medium mt-4 mb-2">Zmiany w głównych polach</h3>
                    <ul v-if="Object.keys(mainFieldDifferences).length" class="list-disc pl-5">
                        <li v-for="(diff, field) in mainFieldDifferences" :key="field">
                            <strong>{{ formatFieldName(field) }}: </strong>
                            <span class="text-red-600">{{ formatValue(diff.previous) }}</span>
                            →
                            <span class="text-green-600">{{ formatValue(diff.current) }}</span>
                        </li>
                    </ul>
                    <p v-else class="text-gray-600">Brak zmian w głównych polach.</p>

                    <h3 class="text-lg font-medium mt-4 mb-2">Zmiany w listach</h3>
                    <div v-if="Object.keys(listDifferences).length">
                        <div v-for="(diff, relation) in listDifferences" :key="relation">
                            <h4 class="text-md font-medium mt-2">{{ formatRelationName(relation) }}</h4>
                            <div v-if="diff.added && diff.added.length">
                                <p class="font-semibold">Dodano:</p>
                                <ul class="list-disc pl-5">
                                    <li v-for="(item, index) in diff.added" :key="index" class="text-green-600">
                                        {{ formatItem(item) }}
                                    </li>
                                </ul>
                            </div>
                            <div v-if="diff.removed && diff.removed.length">
                                <p class="font-semibold">Usunięto:</p>
                                <ul class="list-disc pl-5">
                                    <li v-for="(item, index) in diff.removed" :key="index" class="text-red-600">
                                        {{ formatItem(item) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p v-else class="text-gray-600">Brak zmian w listach.</p>
                </div>
                <div v-else class="text-gray-600">
                    {{ message }}
                </div>
            </div>

            <div class="mt-4">
                <Link
                    :href="route('sylabus.history', { courseId: course.id })"
                    class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600"
                >
                    Powrót do historii wersji
                </Link>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

export default {
    components: {
        AppLayout,
        Link,
    },
    props: {
        course: {
            type: Object,
            required: true,
        },
        currentVersion: {
            type: Object,
            required: true,
        },
        previousVersion: {
            type: Object,
            default: null,
        },
        differences: {
            type: Object,
            required: true,
        },
        message: {
            type: String,
            default: '',
        },
    },
    computed: {
        mainFieldDifferences() {
            return Object.fromEntries(
                Object.entries(this.differences).filter(
                    ([_, diff]) => diff.previous !== undefined && diff.current !== undefined
                )
            );
        },
        listDifferences() {
            return Object.fromEntries(
                Object.entries(this.differences).filter(
                    ([_, diff]) => diff.added !== undefined || diff.removed !== undefined
                )
            );
        },
    },
    methods: {
        formatItem(item) {
            if (Array.isArray(item)) {
                return item.join(', ');
            }
            if (typeof item === 'object' && item !== null) {
                return Object.values(item).join(', ');
            }
            return item || 'Brak';
        },
        formatValue(value) {
            if (value === null || value === undefined) {
                return 'Brak';
            }
            if (typeof value === 'boolean') {
                return value ? 'Włączony' : 'Wyłączony';
            }
            return value;
        },
        formatFieldName(field) {
            const fieldNames = {
                unit: 'Jednostka',
                major: 'Kierunek',
                profile: 'Profil',
                specialty: 'Specjalność',
                module_type: 'Typ modułu',
                ects: 'ECTS',
                year_semester: 'Rok/Semestr',
                coordinator: 'Koordynator',
                dark_mode: 'Tryb ciemny',
            };
            return fieldNames[field] || field;
        },
        formatRelationName(relation) {
            const relationNames = {
                requirements: 'Wymagania wstępne',
                goals: 'Cele',
                teachingForms: 'Formy nauczania',
                teachingMethods: 'Metody nauczania',
                outcomes: 'Efekty uczenia się',
                contents: 'Treści programowe',
                effects: 'Efekty oceniania',
                workloads: 'Nakład pracy',
                literatures: 'Literatura',
            };
            return relationNames[relation] || relation;
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
