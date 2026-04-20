<template>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 px-4 z-10">
        <div class="w-full sm:max-w-md mt-6 px-12 py-12 bg-[#181A1C]/60  shadow-md overflow-hidden rounded-3xl gap-8 flex flex-col">
            <div class="flex justify-center flex-col gap-4 mx-auto items-center">
                <slot name="logo" />
                <slot name="title" />
            </div>

            <div>
                <slot />
            </div>    
        </div>
    </div>
</template>
