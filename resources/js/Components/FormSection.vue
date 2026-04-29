<script setup>
import { computed, useSlots } from 'vue';
import SectionTitle from './SectionTitle.vue';

defineEmits(['submitted']);

const slots = useSlots();
const hasTitle = computed(() => !! slots.title || !! slots.description || !! slots.aside);
const hasActions = computed(() => !! slots.actions);
</script>

<template>
    <div class="mx-auto w-full max-w-7xl">
        <div class="md:grid">
            <SectionTitle v-if="hasTitle">
                <template #title>
                    <slot name="title" />
                </template>

                <template #description>
                    <slot name="description" />
                </template>

                <template #aside>
                    <slot name="aside" />
                </template>
            </SectionTitle>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form @submit.prevent="$emit('submitted')">
                    <div
                        class="px-4 py-5 sm:p-6 shadow items-center bg-background-section border-2 border-text-secondary/10"
                        :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'"
                    >
                        <div class="flex flex-col gap-6">
                            <slot name="form" />
                        </div>
                    </div>

                    <div v-if="hasActions" class="flex items-center justify-end px-4 py-3 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                        <slot name="actions" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
