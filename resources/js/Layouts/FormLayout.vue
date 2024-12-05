<script setup>
import ApplicationLogo from "@/Components/FormHeader.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-200 pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/">
                <ApplicationLogo />
            </Link>
        </div>

        <div
            class="mt-4 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-4xl sm:rounded-2xl"
            >
            <slot />
        </div>

    </div>
</template>
