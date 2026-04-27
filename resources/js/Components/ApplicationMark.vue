<script setup lang="ts">
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
</script>

<template>
    <h1 class="text-2xl font-bold text-primary-cyan-100">{{ appName }}</h1>
</template>
