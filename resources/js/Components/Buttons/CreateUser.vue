<script setup>
import { UserRoundPlus } from 'lucide-vue-next';
</script>

<template>
    <button class="min-h-[40px] px-4 2xl:px-8 py-2 bg-background-item/40 text-white hover:bg-primary-cyan-200 active:bg-primary-cyan-200/80 transition-colors uppercase text-xs flex items-center gap-2">
        <UserRoundPlus class="size-4 shrink-0" />
        <div class="flex flex-col gap-0.5 text-left leading-tight">
            <span>Crear</span>
            <span>Usuario</span>
        </div>
    </button>
</template>
