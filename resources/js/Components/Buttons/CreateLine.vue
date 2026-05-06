<script setup>
import { TvMinimalPlay } from 'lucide-vue-next';
</script>

<template>
    <button class="min-h-[40px] px-4 py-2 bg-primary-cyan-100 text-black hover:bg-primary-cyan-200 active:bg-primary-cyan-200/80 transition-colors uppercase text-xs flex items-center gap-2">
        <TvMinimalPlay class="size-4 shrink-0" />
        <div class="flex flex-col gap-0.5 text-left leading-tight">
            <span>Crear</span>
            <span>Linea</span>
        </div>
    </button>
</template>
