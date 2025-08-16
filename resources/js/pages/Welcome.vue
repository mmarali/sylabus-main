<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Strona główna">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    </Head>

    <div class="min-h-screen flex flex-col">

        <header class="bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 shadow-lg">
            <nav class="flex items-center max-w-7xl mx-auto px-8 py-4">
                <div class="text-white font-cinzel text-xl font-bold tracking-wide drop-shadow-md">
                    Społeczna Akademia Nauk
                </div>
                <div class="flex gap-6 ml-auto">
                    <template v-if="$page.props.auth.user">
                        <Link
                        :href="route('sylabus')"
                        class="px-6 py-2 rounded-full text-white font-semibold text-base font-cinzel
                        bg-gradient-to-r from-blue-500 via-purple-500 to-purple-700 shadow-lg
                        hover:from-blue-600 hover:via-purple-600 hover:to-purple-800 hover:shadow-xl
                        transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:scale-105 !no-underline"
                        >
                        Sylabus
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-6 py-2 rounded-full text-white font-semibold text-base font-cinzel
                   bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 shadow-lg
                   hover:from-blue-600 hover:via-indigo-600 hover:to-purple-700 hover:shadow-xl
                   transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:scale-105 !no-underline"
                        >
                            Logowanie
                        </Link>

                        <Link
                            :href="route('register')"
                            class="px-6 py-2 rounded-full text-white font-semibold text-base font-cinzel
                   bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-600 shadow-lg
                   hover:from-purple-600 hover:via-indigo-600 hover:to-blue-700 hover:shadow-xl
                   transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:scale-105 !no-underline"
                        >
                            Rejestracja
                        </Link>
                    </template>
                </div>


            </nav>
        </header>

        <main
            class="flex flex-col items-center justify-center flex-grow text-center bg-no-repeat bg-center bg-cover"
            style="background-image: url('images/logo.jpg');"
        >
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white drop-shadow-lg" style="font-family: 'Playfair Display', serif;">
                System zarządzania sylabusami dla uczelni wyższej
            </h2>
        </main>

    </div>
</template>
