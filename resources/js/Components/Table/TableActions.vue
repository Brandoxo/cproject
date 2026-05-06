<script setup>
import { Eye, Trash, Pen, EllipsisVertical } from 'lucide-vue-next';

defineEmits(['edit', 'view', 'delete', 'more']);
</script>

<template>
    <div class="flex gap-2 items-center justify-center bg-background-item/10 p-2 rounded-2xl">
        <button @click="$emit('edit')" class="text-sm text-warning-yellow-100 hover:text-warning-yellow-100/80">
            <Pen class="size-4" />
        </button>
        <button @click="$emit('view')" class="text-sm text-success-green-100 hover:text-success-green-100/80">
            <Eye class="size-4" />
        </button>
        <button @click="$emit('delete')" class="text-sm text-error-red-100 hover:text-error-red-100/80">
            <Trash class="size-4" />
        </button>
        <button @click="$emit('more')" class="text-sm text-text-secondary hover:text-text-secondary/80">
            <EllipsisVertical class="size-4" />
        </button>
    </div>
</template>
