<script setup>
import SideLayout from '@/Layouts/SideLayout.vue';
import PageHeader from '@/Components/PageHeader.vue';
import ListLines from './Partials/ListLines.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

defineOptions({ layout: SideLayout });
</script>

<template>
    <div class="space-y-6">
        <PageHeader title="Lineas" :breadcrumbs="[page.props.auth.user.roles[0] || 'No Role', 'current_panel', 'current_page']" />

        <div class="bg-white overflow-hidden shadow-xl">
            <ListLines />
        </div>
    </div>
</template>
