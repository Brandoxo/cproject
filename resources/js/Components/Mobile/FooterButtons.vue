<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { LayoutDashboard, Users, Database, Banknote, SquareTerminal } from 'lucide-vue-next';

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

const navItems = [
    { label: 'Dashboard', icon: LayoutDashboard, route: 'dashboard' },
    { label: 'Usuarios',  icon: Users,           route: 'users'     },
    { label: 'Lineas',    icon: Database,         route: 'lines'     },
    { label: 'Pagos',     icon: Banknote,         route: 'dashboard' },
    { label: 'Logs',      icon: SquareTerminal,   route: 'dashboard' },
];
</script>

<template>
    <nav
        class="fixed bottom-0 left-0 right-0 z-30 bg-background-black border-t border-text-secondary/20 md:hidden"
        style="padding-bottom: env(safe-area-inset-bottom)"
    >
        <div class="flex items-stretch h-16">
            <Link
                v-for="item in navItems"
                :key="item.label"
                :href="route(item.route)"
                class="relative flex-1 flex flex-col items-center justify-center gap-1 transition-colors duration-150"
                :class="isActive(item.route)
                    ? 'text-primary-cyan-100'
                    : 'text-text-secondary/50 active:text-text-secondary'"
            >
                <!-- Active indicator -->
                <span
                    v-if="isActive(item.route)"
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-primary-cyan-100 rounded-b-full"
                />

                <component :is="item.icon" class="size-5" />
                <span class="text-[10px] font-medium uppercase tracking-wide leading-none">
                    {{ item.label }}
                </span>
            </Link>
        </div>
    </nav>
</template>
