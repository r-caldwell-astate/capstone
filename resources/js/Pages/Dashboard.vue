<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// This tells the component to expect the 'contracts' prop from the controller
defineProps({
    contracts: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>

                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Your Contracts</h3>

                        <div v-if="contracts.length > 0" class="mt-4">
                            <ul>
                                <li v-for="contract in contracts" :key="contract.contract_id" class="border-b last:border-b-0 py-2 flex justify-between items-center">
                                    <div>
                                        <div class="font-semibold">{{ contract.recipient_name }}</div>
                                        <div class="text-sm text-gray-600">{{ contract.recipient_email }}</div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Status: {{ contract.status?.status_name }}
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div v-else class="mt-4 text-gray-500">
                            You have not created any contracts yet.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>