<template>
    <Head title="Dodaj sylabus" />
    <AppLayout>
        <div class="container-fluid mx-auto p-4">
            <div class="mt-4">
                <Link :href="route('sylabus')" class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600"> Powrót do listy </Link>
            </div>

            <h1 class="mb-4 text-2xl font-bold">Sylabus: {{ course.name }} (Wersja {{ version.version_number }})</h1>

            <div class="rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Podstawowe informacje</h2>
                <p><strong>Kod:</strong> {{ course.code }}</p>
                <p><strong>Jednostka:</strong> {{ version.unit }}</p>
                <p><strong>Kierunek:</strong> {{ version.major }}</p>
                <p><strong>Profil:</strong> {{ version.profile }}</p>
                <p><strong>Specjalność:</strong> {{ version.specialty }}</p>
                <p><strong>Typ modułu:</strong> {{ version.module_type }}</p>
                <p><strong>ECTS:</strong> {{ version.ects }}</p>
                <p><strong>Rok/Semestr:</strong> {{ version.year_semester }}</p>
                <p><strong>Koordynator:</strong> {{ version.coordinator }}</p>
            </div>

            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Wymagania wstępne</h2>
                <ul class="list-disc pl-5">
                    <li v-for="req in version.requirements" :key="req.id">{{ req.requirement }}</li>
                </ul>
            </div>

            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Cele</h2>
                <ul class="list-disc pl-5">
                    <li v-for="goal in version.goals" :key="goal.id">{{ goal.goal }}</li>
                </ul>
            </div>

            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Formy nauczania</h2>
                <ul class="list-disc pl-5">
                    <li v-for="form in version.teachingForms" :key="form.id">{{ form.type }} ({{ form.hours }} godzin, {{ form.mode }})</li>
                </ul>
            </div>

            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Metody nauczania</h2>
                <ul class="list-disc pl-5">
                    <li v-for="method in version.teachingMethods" :key="method.id">{{ method.type }}: {{ method.name }}</li>
                </ul>
            </div>

            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Efekty uczenia się</h2>
                <ul class="list-disc pl-5">
                    <li v-for="outcome in version.outcomes" :key="outcome.id">
                        {{ outcome.number }} ({{ outcome.type }}): {{ outcome.description }} [Ref: {{ outcome.reference || 'Brak' }}]
                    </li>
                </ul>
            </div>

            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Treści programowe</h2>
                <ul class="list-disc pl-5">
                    <li v-for="content in version.contents" :key="content.id">
                        {{ content.number }} ({{ content.type }}): {{ content.topic }} - {{ content.effect }}
                    </li>
                </ul>
            </div>

            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Efekty oceniania</h2>
                <ul class="list-disc pl-5">
                    <li v-for="effect in version.effects" :key="effect.id">
                        {{ effect.number }} ({{ effect.method }}): <br />
                        &lt;50: {{ effect.grade_below_50 }}, 50-59: {{ effect.grade_50_59 }}, 60-74: {{ effect.grade_60_74 }}, 75-100:
                        {{ effect.grade_75_100 }}
                    </li>
                </ul>
            </div>

            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Nakład pracy</h2>
                <ul class="list-disc pl-5">
                    <li v-for="workload in version.workloads" :key="workload.id">{{ workload.type }}: {{ workload.hours }} godzin</li>
                </ul>
            </div>

            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h2 class="mb-2 text-xl font-semibold">Literatura</h2>
                <ul class="list-disc pl-5">
                    <li v-for="literature in version.literatures" :key="literature.id">{{ literature.name }} ({{ literature.type }})</li>
                </ul>
            </div>

            <div class="mt-6">
                <router-link :to="{ name: 'syllabus.index' }" class="mr-4 text-blue-600 hover:underline"> Powrót do listy </router-link>
                <router-link :to="{ name: 'syllabus.history', params: { courseId: course.id } }" class="text-green-600 hover:underline">
                    Zobacz historię wersji
                </router-link>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

export default {
    components: { Link, AppLayout, Head },
    props: {
        course: {
            type: Object,
            required: true,
        },
        version: {
            type: Object,
            required: true,
        },
    },
};
</script>

<style>
.container {
    max-width: 1200px;
}
</style>
