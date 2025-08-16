<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Zaloguj się" />

    <!-- Pełnoekranowy gradient -->
    <div class="min-h-screen flex items-center justify-center relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900">
        <!-- Subtelny pattern/tło -->
        <div class="absolute inset-0 bg-[url('/images/stars-bg.png')] bg-cover opacity-20"></div>

        <!-- Karta logowania -->
        <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl p-8 border border-white/20">
            <h1 class="text-3xl font-bold font-cinzel text-center text-white mb-2">
                Zaloguj się
            </h1>
            <p class="text-center text-gray-300 text-sm mb-6">
                Wprowadź swoje dane, aby uzyskać dostęp do systemu
            </p>

            <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-400">
                {{ status }}
            </div>

            <form method="POST" @submit.prevent="submit" class="flex flex-col gap-6">
                <!-- Email -->
                <div class="grid gap-2">
                    <Label for="email" class="text-white">Adres Email</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                        class="bg-white/70 border-white/30 text-white placeholder-gray-300"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <!-- Password -->
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="text-white">Hasło</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm underline text-blue-200 hover:text-blue-400 transition"
                        >
                            Nie pamiętasz hasła?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Password"
                        class="bg-white/70 border-white/30 text-white placeholder-gray-300"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <!-- Remember -->
                <div class="flex items-center space-x-3">
                    <Checkbox id="remember" v-model="form.remember" class="border-white/50 text-blue-300" />
                    <Label for="remember" class="text-sm text-gray-200">Zapamiętaj mnie</Label>
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
                    <span v-else>Zaloguj się</span>
                </Button>
            </form>


            <div class="text-center text-sm text-gray-300 mt-6">
                Nie masz konta?
                <TextLink :href="route('register')" class="underline text-blue-300 hover:text-blue-300 transition">
                    Zarejestruj się
                </TextLink>
            </div>
        </div>
    </div>
</template>
