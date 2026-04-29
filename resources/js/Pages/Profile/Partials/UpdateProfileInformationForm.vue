<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInputOn from '@/Components/TextInputOn.vue';
import { hacketText } from '@/utils/hacketText';

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    username: props.user.username,
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
        <FormSection @submitted="updateProfileInformation">

        <template #form>
                    <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4 bg-background/10 p-4 rounded-md">
                <!-- Current Profile Photo -->
                <div v-show="! photoPreview" class="mt-2 flex items-center gap-4">
                    <!-- Photo Container with Edit Input -->
                    <div class="relative">
                        <img :src="user.profile_photo_url" :alt="user.name" class="rounded-md size-40 object-cover border-2 border-primary-cyan-100 bg-background-item" />
                        <!-- Profile Photo File Input (positioned overlay) -->
                        <input
                            id="photo"
                            ref="photoInput"
                            type="file"
                            class="absolute bottom-0 right-0 size-12 opacity-0 cursor-pointer rounded-full z-10"
                            @change="updatePhotoPreview"
                            />
                        <div class="absolute bottom-0 right-0 size-12 bg-primary-cyan-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-background" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.343 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                    <p class="text-white text-2xl uppercase">{{ hacketText(user.name) }}</p>
                    <p class="text-primary-cyan-100 text-sm">{{ hacketText(user.email) }}</p>
                
                <div class="flex">
                <SecondaryButton class="mt-2 me-2" type="button" @click.prevent="selectNewPhoto">
                    Cambiar Foto
                </SecondaryButton>
                 <SecondaryButton
                    v-if="user.profile_photo_path"
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto"
                >
                    Eliminar Foto
                </SecondaryButton>
                </div>
                    </div>
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span
                        class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + photoPreview + '\');'"
                    />
                </div>

                <InputError :message="form.errors.photo" class="mt-2" />
            </div>
        </template>
                <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
        </FormSection>
        
    <FormSection @submitted="updateProfileInformation">

        <template #title>
            Información del Perfil
        </template>

        <template #form>

            <!-- Name -->
            <div class="grid grid-cols-2 gap-6 justify-center">
            <div class="c">
                <InputLabel for="name" value="Nombre" />
                <TextInputOn
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="name"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Username -->
            <div class="c">
                <InputLabel for="username" value="Username" />
                <TextInputOn
                    id="name"
                    v-model="form.username"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError :message="form.errors.username" class="mt-2" />
            </div>
            </div>

            <!-- Email -->
            <div class="c">
                <InputLabel for="email" value="Email" />
                <TextInputOn
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" class="mt-2" />

                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email address is unverified.

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click.prevent="sendEmailVerification"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
