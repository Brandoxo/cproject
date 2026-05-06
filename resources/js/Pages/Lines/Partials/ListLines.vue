<script setup>
import { Circle } from 'lucide-vue-next';
import TableToolbar from '@/Components/Table/TableToolbar.vue';
import TableActions from '@/Components/Table/TableActions.vue';
import TablePagination from '@/Components/Table/TablePagination.vue';
import StatusBadge from '@/Components/Table/StatusBadge.vue';

const lines = [
    { external_account_id: 1, owner: 'John Doe', cached_username: 'Username', email: 'john.doe@example.com', whatsapp_number: '123456789', cached_status: 'Activo', cached_is_trial: true, avisos: '1/3', cached_max_connections: 1, cached_expiration_date: '2024-12-31' },
    { external_account_id: 2, owner: 'Alice Johnson', cached_username: 'Username', email: 'alice.johnson@example.com', whatsapp_number: '123456789', cached_status: 'Expirado', cached_is_trial: false, avisos: '1/3', cached_max_connections: 1, cached_expiration_date: '2024-12-31' },
    { external_account_id: 1, owner: 'John Doe', cached_username: 'Username', email: 'john.doe@example.com', whatsapp_number: '123456789', cached_status: 'Activo', cached_is_trial: true, avisos: '1/3', cached_max_connections: 1, cached_expiration_date: '2024-12-31' },
    { external_account_id: 2, owner: 'Alice Johnson', cached_username: 'Username', email: 'alice.johnson@example.com', whatsapp_number: '123456789', cached_status: 'Expirado', cached_is_trial: false, avisos: '1/3', cached_max_connections: 1, cached_expiration_date: '2024-12-31' },
    { external_account_id: 1, owner: 'John Doe', cached_username: 'Username', email: 'john.doe@example.com', whatsapp_number: '123456789', cached_status: 'Activo', cached_is_trial: true, avisos: '1/3', cached_max_connections: 1, cached_expiration_date: '2024-12-31' },
];
</script>

<template>
    <div class="flex flex-col gap-4 bg-background">
        <TableToolbar />

        <!-- Mobile: cards -->
        <div class="md:hidden flex flex-col gap-3 px-3">
            <div
                v-for="line in lines"
                :key="line.external_account_id"
                class="bg-background-section border border-text-secondary/10 p-4 flex flex-col gap-3"
            >
                <!-- Card header -->
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-white text-sm font-medium uppercase">{{ line.cached_username }}</p>
                        <p class="text-text-secondary text-xs">ID: {{ line.external_account_id }}</p>
                    </div>
                    <StatusBadge
                        :label="line.cached_status"
                        :active="line.cached_status === 'Activo'"
                        active-class="bg-primary-cyan-100/10 text-primary-cyan-100 border-primary-cyan-100"
                    />
                </div>

                <!-- Card body -->
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">Dueño</p>
                        <div class="flex items-center gap-1.5">
                            <img :src="line.email" :alt="line.owner" class="size-5 rounded-full" />
                            <span class="text-text-secondary">{{ line.owner }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">Correo</p>
                        <p class="text-text-secondary truncate">{{ line.email }}</p>
                    </div>
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">Teléfono</p>
                        <p class="text-primary-cyan-100">{{ line.whatsapp_number }}</p>
                    </div>
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">Vence</p>
                        <p class="text-white">{{ line.cached_expiration_date }}</p>
                    </div>
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">Max / Avisos</p>
                        <p class="text-white">{{ line.cached_max_connections }} / {{ line.avisos }}</p>
                    </div>
                    <div>
                        <p class="text-text-secondary/60 uppercase mb-0.5">Demo</p>
                        <Circle :class="`size-2 rounded-full mt-1 ${line.cached_status === 'Activo' ? 'bg-primary-cyan-100' : 'bg-primary-cyan-100/20'}`" />
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
                        <th class="p-6">Correo</th>
                        <th class="p-6">Teléfono</th>
                        <th class="p-6">Estado</th>
                        <th class="p-6">Demo</th>
                        <th class="p-6">Max</th>
                        <th class="p-6">Aviso</th>
                        <th class="p-6">Fecha de expiración</th>
                        <th class="p-6">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="line in lines"
                        :key="line.external_account_id"
                        class="bg-background-section hover:bg-background-item/10 transition duration-150 text-text-secondary text-center"
                    >
                        <td class="px-4 py-3 text-white uppercase text-start">
                            {{ line.cached_username }}
                            <span class="text-text-secondary text-xs block">ID: {{ line.external_account_id }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2 justify-center">
                                <img :src="line.email" :alt="line.owner" class="size-6 rounded-full" />
                                {{ line.owner }}
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ line.email }}</td>
                        <td class="px-4 py-3 text-primary-cyan-100">{{ line.whatsapp_number }}</td>
                        <td class="px-4 py-3">
                            <StatusBadge
                                :label="line.cached_status"
                                :active="line.cached_status === 'Activo'"
                                active-class="bg-primary-cyan-100/10 text-primary-cyan-100 border-primary-cyan-100"
                            />
                        </td>
                        <td class="px-4 py-3">
                            <Circle :class="`size-2 rounded-full mx-auto ${line.cached_status === 'Activo' ? 'bg-primary-cyan-100' : 'bg-primary-cyan-100/20'}`" />
                        </td>
                        <td class="px-4 py-3 text-white">{{ line.cached_max_connections }}</td>
                        <td class="px-4 py-3 text-white">{{ line.avisos }}</td>
                        <td class="py-3 text-white">{{ line.cached_expiration_date }}</td>
                        <td class="px-4 py-3">
                            <TableActions />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <TablePagination showing="Mostrando 1-10 de 100 usuarios" />
    </div>
</template>
