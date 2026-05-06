<script setup>
import { ChevronDown } from 'lucide-vue-next';

defineProps({ showing: { type: String, required: true } });
defineEmits(['prev', 'next']);
</script>

<template>
    <div class="bg-background-black flex flex-col sm:flex-row items-center justify-between gap-3 p-3 sm:p-2">
        <span class="text-text-secondary text-xs uppercase">{{ showing }}</span>
        <div class="flex gap-2 w-full sm:w-auto">
            <button
                @click="$emit('prev')"
                class="flex-1 sm:flex-none px-4 py-2 sm:py-1 bg-background-black text-text-secondary text-xs uppercase flex items-center justify-center gap-1 border border-text-secondary/20 active:bg-background-item/20"
            >
                <ChevronDown class="size-3 rotate-180" />
                Anterior
            </button>
            <button
                @click="$emit('next')"
                class="flex-1 sm:flex-none px-4 py-2 sm:py-1 bg-background-black text-text-secondary text-xs uppercase flex items-center justify-center gap-1 border border-text-secondary/20 active:bg-background-item/20"
            >
                Siguiente
                <ChevronDown class="size-3" />
            </button>
        </div>
    </div>
</template>
