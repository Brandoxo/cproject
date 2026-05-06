<script setup>
defineProps({
    label: { type: String, required: true },
    active: { type: Boolean, required: true },
    activeClass: { type: String, default: 'bg-success-green-100/10 text-success-green-100 border-success-green-100' },
});
</script>

<template>
    <span :class="`px-2 py-1 text-xs uppercase border ${active ? activeClass : 'bg-error-red-100/10 text-error-red-100 border-error-red-100'}`">
        {{ label }}
    </span>
</template>
