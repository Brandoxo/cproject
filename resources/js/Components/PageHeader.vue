<script setup>
import { hacketText } from '@/utils/hacketText.js';
import { ChevronRight } from 'lucide-vue-next';
import CreateUser from '@/Components/Buttons/CreateUser.vue';
import CreateLine from '@/Components/Buttons/CreateLine.vue';

defineProps({
    title: { type: String, default: '' },
    breadcrumbs: { type: Array, default: () => [] },
});
</script>

<template>
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
        <!-- Title + breadcrumbs -->
        <div class="min-w-0">
            <h2 class="font-semibold text-xl sm:text-2xl text-white leading-tight truncate">
                {{ hacketText(title) }}
            </h2>
            <div class="flex flex-wrap items-center gap-1.5 mt-1 text-xs md:text-sm text-text-secondary">
                <template v-for="(item, idx) in breadcrumbs" :key="idx">
                    <span :class="idx === breadcrumbs.length - 1 ? 'text-white' : (idx === 0 ? 'text-primary-cyan-100' : 'text-text-secondary')">
                        {{ hacketText(item) }}
                    </span>
                    <ChevronRight v-if="idx < breadcrumbs.length - 1" class="size-3 text-text-secondary shrink-0" />
                </template>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="gap-2 shrink-0 hidden md:flex">
            <CreateUser />
            <CreateLine />
        </div>
    </div>
</template>
