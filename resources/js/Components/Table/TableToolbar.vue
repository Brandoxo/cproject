<script setup>
import { ListFilter, ChevronDown, User, ArrowDown } from 'lucide-vue-next';
</script>

<template>
    <div class="bg-background-section p-3 sm:p-4 flex flex-col sm:flex-row gap-3 sm:gap-4 sm:items-center sm:justify-between">
        <div class="flex gap-2 overflow-x-auto pb-0.5 sm:pb-0 scrollbar-hide">
            <button class="shrink-0 p-2 bg-background-black text-text-secondary flex items-center gap-2 uppercase text-xs">
                <ListFilter class="size-3" />
                Todos los estados
                <ChevronDown class="size-3" />
            </button>
            <button class="shrink-0 p-2 bg-background-black text-text-secondary flex items-center gap-2 uppercase text-xs">
                <User class="size-3" />
                Todos los Dueños
                <ChevronDown class="size-3" />
            </button>
        </div>
        <div class="flex shrink-0 self-end sm:self-auto">
            <button class="p-2 px-4 bg-background-black text-primary-cyan-100 flex items-center gap-2 uppercase text-xs">
                Ordenar
            </button>
            <button class="p-2 px-4 bg-background-black text-text-secondary flex items-center gap-2 uppercase text-xs">
                Fecha
                <ArrowDown class="size-3" />
            </button>
        </div>
    </div>
</template>
