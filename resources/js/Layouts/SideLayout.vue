<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { House, UserCircle, Users, Database, CardSim, Logs } from 'lucide-vue-next';
import { hacketText } from '@/utils/hacketText.js';

defineProps({
    title: String,

});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

const routes = [
    { name: 'dashboard', label: 'Dashboard', icon: House, link: 'dashboard' },
    { name: 'users', label: 'Usuarios', icon: Users, link: 'dashboard' },
    { name: 'lines', label: 'Lineas', icon: Database, link: 'dashboard' },
    { name: 'payments', label: 'Pagos', icon: CardSim, link: 'dashboard' },
    { name: 'system logs', label: 'System Logs', icon: Logs, link: 'dashboard' },
    // Add more routes here as needed
];
</script>

<template>
    <div class="min-h-screen bg-background">
        <Head :title="title" />

        <Banner />

        <!-- Top Header -->
        <nav class="fixed top-0 left-0 right-0 h-16 bg-background-black border-b border-text-secondary/20 z-20 flex items-center px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-16">
                    <!-- Mobile: Hamburger -->
                    <button class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-primary-cyan-100 transition duration-150 ease-in-out" @click="showingNavigationDropdown = !showingNavigationDropdown">
                        <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Logo -->
                    <Link :href="route('dashboard')">
                        <ApplicationMark />
                    </Link>

                                                <!-- Panel Navigation Links -->
                            <div class="hidden sm:flex sm:items-center gap-10">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    LegendsTV
                                </NavLink>
                            </div>
                </div>

                <!-- Desktop: Home + User controls -->
                <div class="hidden lg:flex items-center gap-4 bg-background-item/10 p-1 rounded-3xl px-4">
                    <Link :href="route('dashboard')">
                        <House class="size-6 text-text-secondary" />
                    </Link>

                    <!-- Teams Dropdown -->
                    <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
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

                    <!-- Account Dropdown -->
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="size-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </button>
                            <span v-else class="inline-flex justify-center items-center rounded-full h-8 w-8">
                                <button type="button">
                                    <UserCircle class="size-6 text-primary-cyan-100" />
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>
                            <DropdownLink :href="route('profile.show')">Profile</DropdownLink>
                            <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">API Tokens</DropdownLink>
                            <div class="border-t border-gray-200" />
                            <form @submit.prevent="logout">
                                <DropdownLink as="button">Log Out</DropdownLink>
                            </form>
                        </template>
                    </Dropdown>
                </div>

                <!-- Mobile: User icon -->
                <div class="lg:hidden flex items-center">
                    <Link :href="route('profile.show')">
                        <UserCircle class="size-6 text-primary-cyan-100" />
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Mobile Responsive Nav -->
        <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="lg:hidden fixed top-16 left-0 right-0 bg-background-black border-b border-text-secondary/20 z-20">
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                </ResponsiveNavLink>
            </div>

            <div class="pt-4 pb-1 border-t border-text-secondary/20">
                <div class="flex items-center px-4">
                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                        <img class="size-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                    </div>
                    <div>
                        <div class="font-medium text-base text-white">{{ $page.props.auth.user.name }}</div>
                        <div class="font-medium text-sm text-text-secondary">{{ $page.props.auth.user.email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">Profile</ResponsiveNavLink>
                    <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">API Tokens</ResponsiveNavLink>

                    <form method="POST" @submit.prevent="logout">
                        <ResponsiveNavLink as="button">Log Out</ResponsiveNavLink>
                    </form>

                    <template v-if="$page.props.jetstream.hasTeamFeatures">
                        <div class="border-t border-text-secondary/20" />
                        <div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>
                        <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">Team Settings</ResponsiveNavLink>
                        <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">Create New Team</ResponsiveNavLink>

                        <template v-if="$page.props.auth.user.all_teams.length > 1">
                            <div class="border-t border-text-secondary/20" />
                            <div class="block px-4 py-2 text-xs text-gray-400">Switch Teams</div>
                            <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                <form @submit.prevent="switchToTeam(team)">
                                    <ResponsiveNavLink as="button">
                                        <div class="flex items-center">
                                            <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>{{ team.name }}</div>
                                        </div>
                                    </ResponsiveNavLink>
                                </form>
                            </template>
                        </template>
                    </template>
                </div>
            </div>
        </div>

        <!-- Desktop Sidebar (below header) -->
        <aside class="hidden lg:flex fixed top-16 left-0 bottom-0 w-64 bg-background border-r border-text-secondary/20 z-10 flex-col">
        <div class="px-8 py-6">
            <h2 class="text-md font-semibold text-primary-cyan-100 tracking-widest">{{ hacketText($page.props.auth.user.name) }}</h2>
            <h3 class="text-sm text-text-secondary/60">{{ hacketText("Sys admin v1") }}</h3>
        </div>        
            <nav class="flex-1 px-4 py-8 space-y-1 overflow-y-auto">
                <Link v-for="navRoute in routes" :key="navRoute.name"
                   :href="route(navRoute.link)"
                    class="flex items-center gap-3 px-3 py-4 text-sm font-medium transition duration-150 ease-in-out"
                    :class="route().current(navRoute.link)
                        ? 'bg-primary-cyan-100/10 text-primary-cyan-100 border-r-4 border-primary-cyan-100'
                        : 'text-text-secondary hover:bg-background-item/10 hover:text-white'"
                >
                    <component :is="navRoute.icon" class="size-5" :class="route().current(navRoute.link) ? 'text-primary-cyan-100' : 'text-text-secondary'" />
                    {{ navRoute.label }}
                </Link>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="lg:ml-64 pt-16 flex flex-col min-h-screen">
            <header v-if="$slots.header" class="bg-background-black border-b border-text-secondary/20">
                <div class="px-6 py-4">
                    <slot name="header" />
                </div>
            </header>

            <main class="flex-1 p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
