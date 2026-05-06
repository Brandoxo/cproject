<script setup>
import { Circle } from 'lucide-vue-next';
import TableToolbar from '@/Components/Table/TableToolbar.vue';
import TableActions from '@/Components/Table/TableActions.vue';
import TablePagination from '@/Components/Table/TablePagination.vue';
import StatusBadge from '@/Components/Table/StatusBadge.vue';
import CreateUser from '@/Components/Buttons/CreateUser.vue';

const users = [
    { id: 1, name: 'John Doe', owner: 'Jane Smith', ip: '192.168.1.1', access: 'Disponible', credits: 100, status: 'Activo' },
    { id: 2, name: 'Alice Johnson', owner: 'Bob Brown', ip: '192.168.1.2', access: 'Sin acceso', credits: 200, status: 'Activo' },
    { id: 1, name: 'John Doe', owner: 'Jane Smith', ip: '192.168.1.1', access: 'Disponible', credits: 100, status: 'Activo' },
    { id: 2, name: 'Alice Johnson', owner: 'Bob Brown', ip: '192.168.1.2', access: 'Sin acceso', credits: 200, status: 'Activo' },
    { id: 1, name: 'John Doe', owner: 'Jane Smith', ip: '192.168.1.1', access: 'Disponible', credits: 100, status: 'Activo' },
];
</script>

<template>
    <div class="flex flex-col gap-4 bg-background">
        <TableToolbar />

        <!-- Mobile: cards -->
        <div class="md:hidden flex flex-col gap-3 px-3">
            <div
                v-for="user in users"
                :key="user.id"
                class="bg-background-section border border-text-secondary/10 p-4 flex flex-col gap-3"
            >
                <!-- Card header -->
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-white text-sm font-medium uppercase">{{ user.name }}</p>
                        <p class="text-text-secondary text-xs">ID: {{ user.id }}</p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <Circle :class="`size-2 rounded-full ${user.status === 'Activo' ? 'bg-primary-cyan-100' : 'bg-error-red-100'}`" />
                        <span class="text-text-secondary text-xs uppercase">{{ user.status }}</span>
                    </div>
                </div>

                <!-- Card body -->
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">Dueño</p>
                        <div class="flex items-center gap-1.5">
                            <img :src="user.owner" :alt="user.owner" class="size-5 rounded-full" />
                            <span class="text-text-secondary">{{ user.owner }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">IP</p>
                        <p class="text-text-secondary">{{ user.ip }}</p>
                    </div>
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">Acceso</p>
                        <StatusBadge
                            :label="user.access"
                            :active="user.access === 'Disponible'"
                            active-class="bg-success-green-100/10 text-success-green-100 border-success-green-100"
                        />
                    </div>
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">Créditos</p>
                        <p class="text-text-secondary">{{ user.credits }}</p>
                    </div>
                </div>

                <!-- Card footer -->
                <div class="pt-2 border-t border-text-secondary/10 flex justify-end">
                    <TableActions />
                </div>
            </div>
        </div>

        <!-- Desktop: table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead class="text-text-secondary/60 text-xs uppercase bg-background-black text-center">
                    <tr>
                        <th class="p-6">Usuario</th>
                        <th class="p-6">Dueño</th>
                        <th class="p-6">IP</th>
                        <th class="p-6">Acceso</th>
                        <th class="p-6">Créditos</th>
                        <th class="p-6">Estado</th>
                        <th class="p-6">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users"
                        :key="user.id"
                        class="bg-background-section hover:bg-background-item/10 transition duration-150 text-text-secondary text-center"
                    >
                        <td class="px-4 py-3 text-white uppercase text-start">
                            {{ user.name }}
                            <span class="text-text-secondary text-xs block">ID: {{ user.id }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2 justify-center">
                                <img :src="user.owner" :alt="user.owner" class="size-6 rounded-full" />
                                {{ user.owner }}
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ user.ip }}</td>
                        <td class="px-4 py-3">
                            <StatusBadge
                                :label="user.access"
                                :active="user.access === 'Disponible'"
                                active-class="bg-success-green-100/10 text-success-green-100 border-success-green-100"
                            />
                        </td>
                        <td class="px-4 py-3">{{ user.credits }}</td>
                        <td class="px-4 py-3">
                            <Circle :class="`size-2 rounded-full mx-auto ${user.status === 'Activo' ? 'bg-primary-cyan-100' : 'bg-error-red-100'}`" />
                        </td>
                        <td class="px-4 py-3 w-14">
                            <TableActions />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <TablePagination showing="Mostrando 1-10 de 100 usuarios" />
    </div>
</template>
