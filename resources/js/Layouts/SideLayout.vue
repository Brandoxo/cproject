<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { House, UserCircle, Users, Database, CardSim, Logs, ChevronRight } from 'lucide-vue-next';
import { hacketText } from '@/utils/hacketText.js';
import FooterButtons from '@/Components/Mobile/FooterButtons.vue';

defineProps({ title: String });

const showingNavigationDropdown = ref(false);
const page = usePage();

const currentPath = computed(() => {
    try {
        return new URL(page.url, window.location.origin).pathname;
    } catch (e) {
        return window.location.pathname;
    }
});

const isActive = (routeName) => {
    try {
        const url = route(routeName);
        const path = new URL(url, window.location.origin).pathname;
        return path === currentPath.value;
    } catch (e) {
        return false;
    }
};

const switchToTeam = (team) => {
    router.put(route('current-team.update'), { team_id: team.id }, { preserveState: false });
};

const logout = () => {
    router.post(route('logout'));
};

const closeMenu = () => {
    showingNavigationDropdown.value = false;
};

const routes = [
    { name: 'dashboard', label: 'Dashboard', icon: House, link: 'dashboard' },
    { name: 'users', label: 'Usuarios', icon: Users, link: 'users', SubPages: [
        { name: 'create_user', label: 'Crear Usuario', link: 'dashboard' },
    ]},
    { name: 'lines', label: 'Lineas', icon: Database, link: 'lines', SubPages: [
        { name: 'create_line', label: 'Crear Linea', link: 'dashboard' },
        { name: 'generate_demo', label: 'Generar Demo', link: 'dashboard' },
    ]},
    { name: 'payments', label: 'Pagos', icon: CardSim, link: 'dashboard' },
    { name: 'system logs', label: 'System Logs', icon: Logs, link: 'dashboard' },
];

const external_panels = [
    { id: '1', panel_name: 'panel1', api_url: 'https://example.com/panel1', api_key: 'your_api_key_here', panel_type: 'XUI.ONE', status: 'active' },
    { id: '2', panel_name: 'panel2', api_url: 'https://example.com/panel2', api_key: 'your_api_key_here', panel_type: 'XUI.ONE', status: 'active' },
    { id: '3', panel_name: 'panel3', api_url: 'https://example.com/panel3', api_key: 'your_api_key_here', panel_type: 'XUI.ONE', status: 'active' },
];
</script>

<template>
    <div class="min-h-screen bg-background">
        <Head :title="title" />
        <Banner />

        <!-- Top Header — single nav, panels rendered inside -->
        <nav class="fixed top-0 left-0 right-0 h-16 bg-background-black border-b border-text-secondary/20 z-20 flex items-center px-4 sm:px-6 lg:px-8">
            <div class="flex">
                <div class="flex items-center gap-4 lg:gap-10 min-w-0">

                    <!-- Hamburger (mobile/tablet) -->
                    <button
                        class="lg:hidden inline-flex items-center justify-center min-h-[44px] min-w-[44px] text-primary-cyan-100 transition duration-150 shrink-0"
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                    >
                        <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Logo -->
                    <Link :href="route('dashboard')" class="shrink-0">
                        <ApplicationMark />
                    </Link>

                    <!-- Panel tabs (desktop) -->
                    <div class="hidden sm:flex items-center gap-6 overflow-x-auto scrollbar-hide">
                        <NavLink
                            v-for="panel in external_panels"
                            :key="panel.id"
                            :href="route('dashboard')"
                            :active="isActive('dashboard')"
                            class="shrink-0"
                        >
                            {{ hacketText(panel.panel_name) }}
                        </NavLink>
                    </div>
                </div>

                <!-- Desktop: user controls -->
                <div class="hidden lg:flex items-center gap-3 bg-background-item/10 p-1 rounded-3xl px-4 shrink-0">
                    <Link :href="route('dashboard')">
                        <House class="size-5 text-text-secondary" />
                    </Link>

                    <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    {{ $page.props.auth.user.current_team.name }}
                                    <svg class="ms-2 -me-0.5 size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </span>
                        </template>
                        <template #content>
                            <div class="w-60">
                                <div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>
                                <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">Team Settings</DropdownLink>
                                <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">Create New Team</DropdownLink>
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200" />
                                    <div class="block px-4 py-2 text-xs text-gray-400">Switch Teams</div>
                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <DropdownLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </template>
                            </div>
                        </template>
                    </Dropdown>

                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition">
                                <img class="size-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </button>
                            <button type="button" class="flex items-center justify-center min-h-[40px] min-w-[40px]">
                                <UserCircle class="size-5 text-primary-cyan-100" />
                            </button>
                        </template>
                        <template #content>
                            <div class="block px-4 py-2 text-xs text-text-secondary">Cuenta</div>
                            <DropdownLink :href="route('profile.show')">Perfil</DropdownLink>
                            <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">API Tokens</DropdownLink>
                            <div class="border-t border-gray-200" />
                            <form @submit.prevent="logout">
                                <DropdownLink as="button">Cerrar Sesión</DropdownLink>
                            </form>
                        </template>
                    </Dropdown>
                </div>

                <!-- Mobile: user icon -->
                <Link :href="route('profile.show')" class="lg:hidden flex items-center justify-center min-h-[44px] min-w-[44px]">
                    <UserCircle class="size-6 text-primary-cyan-100" />
                </Link>
            </div>
        </nav>

        <!-- Mobile drawer -->
        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-1"
        >
            <div
                v-show="showingNavigationDropdown"
                class="lg:hidden fixed top-16 left-0 right-0 bg-background-black border-b border-text-secondary/20 z-20 overflow-y-auto max-h-[calc(100dvh-4rem)] scrollbar-hide"
            >
                <!-- Panel tabs -->
                <div class="flex overflow-x-auto scrollbar-hide px-4 py-3 gap-4 border-b border-text-secondary/10">
                    <NavLink
                        v-for="panel in external_panels"
                        :key="panel.id"
                        :href="route('dashboard')"
                        :active="isActive('dashboard')"
                        class="shrink-0"
                    >
                        {{ hacketText(panel.panel_name) }}
                    </NavLink>
                </div>

                <!-- User section -->
                <div class="pt-4 pb-3 border-t border-text-secondary/20">
                    <div class="flex items-center gap-3 px-6">
                        <img v-if="$page.props.auth.user.profile_photo_url" class="size-10 rounded-md object-cover shrink-0" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                        <div class="min-w-0">
                            <div class="font-medium text-base text-white truncate">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-text-secondary truncate">{{ $page.props.auth.user.email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.show')" :active="isActive('profile.show')">Perfil</ResponsiveNavLink>
                        <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="isActive('api-tokens.index')">API Tokens</ResponsiveNavLink>
                        <form method="POST" @submit.prevent="logout">
                            <ResponsiveNavLink as="button">Cerrar Sesión</ResponsiveNavLink>
                        </form>
                        <template v-if="$page.props.jetstream.hasTeamFeatures">
                            <div class="border-t border-text-secondary/20 mx-4" />
                            <div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>
                            <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="isActive('teams.show')">Team Settings</ResponsiveNavLink>
                            <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="isActive('teams.create')">Create New Team</ResponsiveNavLink>
                        </template>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex fixed top-16 left-0 bottom-0 w-64 bg-background border-r border-text-secondary/20 z-10 flex-col">
            <div class="px-8 py-6">
                <h2 class="text-md font-semibold text-primary-cyan-100 tracking-widest">{{ hacketText($page.props.auth.user.name) }}</h2>
                <h3 class="text-sm text-text-secondary/60">{{ hacketText("Sys admin v1") }}</h3>
            </div>
            <nav class="flex-1 px-4 space-y-1 overflow-y-auto scrollbar-hide">
                <template v-for="navRoute in routes" :key="navRoute.name">
                    <Link
                        :href="route(navRoute.link)"
                        class="flex items-center justify-between gap-3 px-3 py-4 text-sm font-medium transition duration-150 ease-in-out"
                        :class="isActive(navRoute.link)
                            ? 'bg-primary-cyan-100/10 text-primary-cyan-100 border-r-4 border-primary-cyan-100'
                            : 'text-text-secondary hover:bg-background-item/10 hover:text-white'"
                    >
                        <div class="flex items-center gap-2">
                            <component :is="navRoute.icon" class="size-5 shrink-0" :class="isActive(navRoute.link) ? 'text-primary-cyan-100' : 'text-text-secondary'" />
                            {{ navRoute.label }}
                        </div>
                        <ChevronRight v-if="navRoute.SubPages" class="size-4 shrink-0 transition-transform" :class="isActive(navRoute.link) ? 'text-primary-cyan-100 rotate-90' : 'text-text-secondary'" />
                    </Link>
                    <template v-if="navRoute.SubPages && isActive(navRoute.link)">
                        <Link
                            v-for="sub in navRoute.SubPages"
                            :key="sub.name"
                            :href="route(sub.link)"
                            class="flex items-center gap-2 px-3 py-2 pl-10 text-sm font-medium transition duration-150 ease-in-out"
                            :class="isActive(sub.link) ? 'bg-primary-cyan-100/10 text-primary-cyan-100' : 'text-text-secondary hover:bg-background-item/10 hover:text-white'"
                        >
                            {{ sub.label }}
                        </Link>
                    </template>
                </template>
            </nav>

            <!-- Sidebar user card -->
            <div v-if="$page.props.auth.user" class="px-4 py-5 border-t border-text-secondary/20">
                <div class="flex items-center gap-3">
                    <img v-if="$page.props.auth.user.profile_photo_url" class="size-8 rounded-md object-cover shrink-0" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                    <div class="min-w-0">
                        <div class="font-medium text-sm text-white truncate">{{ hacketText($page.props.auth.user.name) }}</div>
                        <div class="font-medium text-xs text-text-secondary truncate">{{ hacketText($page.props.auth.user.roles[0]) }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <FooterButtons />

        <!-- Main Content -->
        <div class="lg:ml-64 pt-16 flex flex-col min-h-screen">
            <main class="p-4 sm:p-6 pb-24 md:pb-6 bg-background space-y-6">
                <header v-if="$slots.header">
                    <slot name="header" />
                    <div class="py-1 flex text-sm items-center gap-2 text-text-secondary">
                        <slot name="slug" />
                    </div>
                </header>
                <slot />
            </main>
        </div>
    </div>
</template>
