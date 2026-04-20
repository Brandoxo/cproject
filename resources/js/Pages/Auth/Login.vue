<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import LoginButton from '@/Components/Login/login-button.vue';
import { ArrowRight, AtSign, KeyRound } from 'lucide-vue-next';
import bgLogin from '../../../../src/assets/bg-images/bg-login.png';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const options = {
    title: 'CMS_PROJECT',
    description: 'CENTRO DE ADMINISTRACIÓN',
    version: 'v1.0'
}
</script>

<template>
    <Head title="Iniciar Sesion" />
    <div class="bg-black/20 fixed inset-0 -z-10"></div>
    <div class="fixed inset-0 -z-20">
        <img :src="bgLogin" alt="background-image" class="w-full h-full object-cover" />
    </div>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>
        <template #title>
            <div class="mx-auto items-center flex flex-col justify-center text-text-secondary font-spacegrotesk">
            <h1 class="text-2xl font-bold text-white"> {{ options.title }} </h1>
            <span class="text-sm">{{ options.description }}</span>
            <span class="text-sm">{{ options.version }}</span>
            </div>
        </template>
        

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-2">
            <div>
                <InputLabel for="username" value="Usuario" />
                <div class="relative">
                    <AtSign class="absolute left-3 top-1/2 transform -translate-y-1/2 text-[#757578]" />
                    <TextInput
                        id="username"
                        v-model="form.username"
                        class="mt-1 block w-full pl-12 text-[#757578]"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Admin_Alpha"
                    />
                </div>
                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div class="mt-4">
                <div class="flex justify-between">
                <InputLabel for="password" value="Contraseña" />
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-xs text-primary-cyan-200 hover:text-primary-cyan-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    ¿OLVIDASTE LA CONTRASENA?
                </Link>
                </div>
                <div class="relative">
                <KeyRound class="absolute left-3 top-1/2 transform -translate-y-1/2 text-[#757578] rotate-[225deg]" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 pl-12 block w-full text-[#757578]"
                    required
                    autocomplete="current-password"
                />
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" class="bg-[#1E2022] border-[#47484A] checked:bg-primary-cyan-600" />
                    <span class="ms-2 text-sm text-text-secondary">Recuérdame.</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4 mb-4">

                <LoginButton 
                    class="w-full shadow-md shadow-primary-cyan-400 hover:shadow-primary-cyan-600" 
                    :disabled="form.processing"
                >   
                    <div class="flex items-center">
                    <span>INICIAR SESION</span>
                    <ArrowRight class="ml-2" />
                    </div>
                </LoginButton>
            </div>
        </form>
        <div class="flex flex-col items-center gap-2">
        <div class=" bg-[#47484A] h-0.5 mt-4 mx-auto"></div>
        <span class="text-xs text-center text-text-secondary">Sólo personal autorizado. Sesiones externas serán monitoreadas.</span>
        </div>
    </AuthenticationCard>
</template>
