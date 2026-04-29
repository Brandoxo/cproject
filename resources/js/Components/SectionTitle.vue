<template>
    <div class="md:col-span-1 flex justify-between">
        <div class="flex gap-2 mb-2 justify-center items-center">
            <div class="w-2 h-2 bg-primary-cyan-100"></div>
            <h3 class="text-sm text-text-secondary/60 uppercase tracking-[0.2em]">
                <slot name="title" />
            </h3>
        </div>

        <div class="px-4 sm:px-0">
            <slot name="aside" />
        </div>
    </div>
</template>
