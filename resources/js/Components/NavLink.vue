<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center px-1 pt-1pb-1 border-b-2 border-primary-cyan-100 text-sm font-medium leading-5 text-primary-cyan-100 focus:outline-none focus:border-primary-cyan-100 transition duration-150 ease-in-out uppercase font-black'
        : 'inline-flex items-center px-1 pt-1pb-1 border-b-2 border-transparent text-sm font-medium leading-5 text-text-secondary hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out uppercase';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
