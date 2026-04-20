<script setup>
import { Link } from '@inertiajs/vue3';
import { Terminal } from 'lucide-vue-next';
</script>

<template>
    <Link :href="'/'" class="border-4 border-primary-cyan-100 rounded-md">
        <Terminal class="w-12 h-8 text-primary-cyan-100 border-t-4 border-primary-cyan-100" />
    </Link>
</template>
