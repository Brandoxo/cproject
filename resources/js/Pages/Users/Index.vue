<script setup>
import SideLayout from '@/Layouts/SideLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import PageHeader from '@/Components/PageHeader.vue';
import { usePage } from '@inertiajs/vue3';
import { List } from 'lucide-vue-next';
import ListUsers from './Partials/ListUsers.vue';

const page = usePage();

</script>

<template>
    <SideLayout title="">
        <template #header>
            <PageHeader title="Usuarios Externos" :breadcrumbs="[page.props.auth.user.roles[0] || 'No Role', 'current_panel', 'current_page']" />
        </template>

        <div class="">
            <div class="bg-white overflow-hidden shadow-xl">
                <ListUsers />
            </div>
        </div>
    </SideLayout>
</template>
