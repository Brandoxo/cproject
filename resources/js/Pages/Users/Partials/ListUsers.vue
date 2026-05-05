<script setup>
import { usePage } from '@inertiajs/vue3';
import { List, Filter, ChevronDown, User, ArrowDown, Circle, Eye, Trash, Pen } from 'lucide-vue-next';

const users = [
    { id: 1, name: 'John Doe', owner: 'Jane Smith', ip: '192.168.1.1', access: 'Disponible', credits: 100, status: 'Activo'},
    { id: 2, name: 'Alice Johnson', owner: 'Bob Brown', ip: '192.168.1.2', access: 'Sin acceso', credits: 200, status: 'Activo'}
]

</script>

<template>
    <div class="flex flex-col gap-4 bg-background ">
        <div class="bg-background-section p-4 flex items-center gap-4 justify-between">
            <div class="flex gap-4">
            <button class="p-2 bg-background-black text-text-secondary flex items-center gap-2 uppercase text-sm">
                <Filter class="size-5" />
                Todos los estados
                <ChevronDown/>
            </button>
            <button class="p-2 bg-background-black text-text-secondary flex items-center gap-2 uppercase text-sm">
                <User class="size-5" />
                Todos los Dueños
                <ChevronDown/>
            </button>
            </div>
            <div class="flex">
            <button class="p-2 px-4 bg-background-black text-primary-cyan-100 flex items-center gap-2 uppercase text-sm">
                Ordenar
            </button>
            <button class="p-2 px-4 bg-background-black text-text-secondary flex items-center gap-2 uppercase text-sm">
                Fecha
                <ArrowDown class="size-5"/>
            </button>
            </div>
        </div>
        
        <div>
            <table class="w-full text-left">
                <thead class="text-text-secondary/60 text-xs uppercase bg-background-black">
                    <tr>
                        <th class="p-6">Nombre</th>
                        <th class="p-6">Dueño</th>
                        <th class="p-6">IP</th>
                        <th class="p-6">Acceso</th>
                        <th class="p-6">Créditos</th>
                        <th class="p-6">Estado</th>
                        <th class="p-6">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id" class=" bg-background-section hover:bg-background-item/10 transition duration-150 text-text-secondary">
                        <td class="px-4 py-3 text-white uppercase">{{ user.name }}
                            <span class="text-text-secondary text-xs block">ID: {{ user.id }}</span>
                        </td>
                        <td class="px-4 py-3 flex items-center gap-2"><img :src="user.owner" :alt="user.owner" class="size-6 rounded-full" />{{ user.owner }}</td>
                        <td class="px-4 py-3">{{ user.ip }}</td>
                        <td class="px-4 py-3">
                            <span :class="`px-4 py-1 text-xs uppercase ${user.access === 'Disponible' ? 'bg-success-green-100/10 text-success-green-100 border border-success-green-100' : 'bg-error-red-100/10 text-error-red-100 border border-error-red-100'}`">
                                {{ user.access }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ user.credits }}</td>
                        <td class="px-4 py-3">
                            <Circle :class="`size-2 rounded-full ${user.status === 'Activo' ? 'bg-primary-cyan-100' : 'bg-error-red-100'}`" />
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <button class="text-sm text-primary-cyan-100 hover:underline">
                                    <Pen class="size-4" />
                                </button>
                                <button class="text-sm text-success-green-100 hover:underline">
                                    <Eye class="size-4" />
                                </button>
                                <button class="text-sm text-error-red-100 hover:underline">
                                    <Trash class="size-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>