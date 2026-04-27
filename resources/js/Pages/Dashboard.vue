<script setup>
import SideLayout from '@/Layouts/SideLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { hacketText } from '@/utils/hacketText.js';
</script>

<template>
    <SideLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-2xl text-white leading-tight">
                {{ hacketText('Dashboard') }}
            </h2>
        </template>

        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <Welcome />
            </div>
        </div>
    </SideLayout>
</template>
