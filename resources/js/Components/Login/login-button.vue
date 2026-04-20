<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="text-spacegrotesk text-center flex justify-center gap-2 bg-gradient-to-r from-[#6DDDFF] to-[#00D2FD] items-center px-4 py-4 border border-transparent rounded-xl font-semibold text-md text-black uppercase hover:bg-primary-cyan-600 focus:bg-primary-cyan-600 active:bg-primary-cyan-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
