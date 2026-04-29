<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class=" px-4 py-4 w-full  border-2 border-text-secondary/20 focus:border-primary-cyan-500 focus:ring-primary-cyan-500 bg-background-black text-white"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
