<script setup>
import SideLayout from '@/Layouts/SideLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import PageHeader from '@/Components/PageHeader.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

defineOptions({ layout: SideLayout });
</script>

<template>
    <div class="space-y-6">
        <PageHeader title="Dashboard" :breadcrumbs="[page.props.auth.user.roles[0] || 'No Role', 'current_panel', 'current_page']" />

        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <Welcome />
            </div>
        </div>
    </div>
</template>
