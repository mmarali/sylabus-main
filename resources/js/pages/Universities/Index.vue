<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

interface University {
    id: number;
    name: string;
    city?: string;
    country?: string;
}

const props = defineProps<{
    universities: University[];
}>();

const form = useForm({
    name: '',
    city: '',
});

const submit = () => {
    form.post(route('uczelnie.store'), {
        onSuccess: () => form.reset()
    });
};

const removeUniversity = (id: number) => {
    if (confirm('Czy na pewno chcesz usunąć tę uczelnię?')) {
        router.delete(route('uczelnie.destroy', id));
    }
};
</script>

<template>
    <Head title="Uczelnie" />
    <AppLayout>
        <div class="p-6 space-y-6">
            <h1 class="text-2xl font-bold">Uczelnie</h1>

            <form @submit.prevent="submit" class="flex gap-4 flex-wrap items-end">
                <div>
                    <label class="block">Nazwa</label>
                    <input v-model="form.name" type="text" class="border rounded p-2" required />
                </div>
                <div>
                    <label class="block">Miasto</label>
                    <input v-model="form.city" type="text" class="border rounded p-2" />
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Dodaj</button>
            </form>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Nazwa</th>
                    <th class="border p-2">Miasto</th>
                    <th class="border p-2">Data dodania</th>
                    <th class="border p-2">Akcje</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="u in props.universities" :key="u.id">
                    <td class="border p-2">{{ u.id }}</td>
                    <td class="border p-2">{{ u.name }}</td>
                    <td class="border p-2">{{ u.city }}</td>
                    <td class="border p-2">{{ u.created_at }}</td>
                    <td class="border p-2 text-center">
                        <button
                            @click="removeUniversity(u.id)"
                            class="bg-red-600 text-white px-3 py-1 rounded"
                        >
                            Usuń
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
