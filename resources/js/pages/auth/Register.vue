<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>


<template>
    <Head title="Rejestracja" />

    <div class="min-h-screen flex items-center justify-center relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900">
        <div class="absolute inset-0 bg-[url('/images/stars-bg.png')] bg-cover opacity-20"></div>


        <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl p-8 border border-white/20">
            <h1 class="text-3xl font-bold font-cinzel text-center text-white mb-2">
                Zarejestruj się
            </h1>
            <p class="text-center text-gray-300 text-sm mb-6">
                Wprowadź swoje dane, aby utworzyć konto
            </p>

            <form method="POST" @submit.prevent="submit" class="flex flex-col gap-6">
                <!-- Name -->
                <div class="grid gap-2">
                    <Label for="name" class="text-white">Imię i nazwisko</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        v-model="form.name"
                        placeholder="Jan Kowalski"
                        class="bg-white/70 border-white/30 text-white placeholder-gray-300"
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <!-- Email -->
                <div class="grid gap-2">
                    <Label for="email" class="text-white">Adres Email</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                        class="bg-white/70 border-white/30 text-white placeholder-gray-70"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <!-- Password -->
                <div class="grid gap-2">
                    <Label for="password" class="text-white">Hasło</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        v-model="form.password"
                        placeholder="Hasło"
                        class="bg-white/70 border-white/30 text-white placeholder-gray-300"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <!-- Confirm Password -->
                <div class="grid gap-2">
                    <Label for="password_confirmation" class="text-white">Potwierdź hasło</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        placeholder="Powtórz hasło"
                        class="bg-white/70 border-white/30 text-white placeholder-gray-300"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <!-- Button -->
                <Button
                    type="submit"
                    class="mt-4 w-full px-6 py-3 rounded-full text-white font-semibold font-cinzel
                 bg-gradient-to-r from-indigo-500 to-indigo-700 shadow-lg
                 hover:from-indigo-600 hover:to-indigo-800 hover:shadow-xl
                 transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:scale-105"
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    <span v-else>Zarejestruj się</span>
                </Button>
            </form>

            <!-- Link do logowania -->
            <div class="text-center text-sm text-gray-300 mt-6">
                Masz już konto?
                <TextLink :href="route('login')" class="underline text-blue-300 hover:text-blue-400 transition">
                    Zaloguj się
                </TextLink>
            </div>
        </div>
    </div>
</template>
