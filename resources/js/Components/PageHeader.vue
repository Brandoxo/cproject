<script setup>
import { hacketText } from '@/utils/hacketText.js';
import { ChevronRight } from 'lucide-vue-next';

defineProps({
    title: { type: String, default: '' },
    breadcrumbs: { type: Array, default: () => [] },
});
</script>

<template>
    <div>
        <div>
            <h2 class="font-semibold text-2xl text-white leading-tight">{{ hacketText(title) }}</h2>
        </div>

        <div class="py-1 flex text-sm items-center gap-2 text-text-secondary">
            <template v-for="(item, idx) in breadcrumbs" :key="idx">
                <h3 :class="idx === breadcrumbs.length - 1 ? 'mt-1 text-white' : (idx === 0 ? 'text-primary-cyan-100' : 'mt-1 text-text-secondary')">
                    {{ hacketText(item) }}
                </h3>
                <ChevronRight v-if="idx < breadcrumbs.length - 1" class="text-text-secondary w-3" />
            </template>
        </div>
    </div>
</template>