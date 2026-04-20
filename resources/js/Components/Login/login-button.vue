<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button 
        :type="type" 
        :disabled="disabled"
        class="text-spacegrotesk text-center flex justify-center gap-2 bg-gradient-to-r from-[#6DDDFF] to-[#00D2FD] items-center px-4 py-4 border border-transparent rounded-xl font-semibold text-md text-black uppercase hover:bg-primary-cyan-600 focus:bg-primary-cyan-600 active:bg-primary-cyan-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150 relative"
    >
        <div v-if="disabled" class="absolute inset-0 flex items-center justify-center">
            <div class="loader"></div>
        </div>
        <div :class="{ 'opacity-0': disabled }">
            <slot />
        </div>
    </button>
</template>

<style scoped>
.loader {
    border: 3px solid rgba(0, 0, 0, 0.1);
    border-top: 3px solid #000;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
