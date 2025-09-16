<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3'; // <-- 1. Import Link

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
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Your Contracts</h3>

                        <div v-if="contracts.length > 0">
                            <ul class="divide-y divide-gray-200">
                                <li v-for="contract in contracts" :key="contract.contract_id">
                                    <Link :href="route('contracts.edit', contract.contract_id)" class="block hover:bg-gray-50">
                                        <div class="py-4 px-2 flex justify-between items-center">
                                            <div>
                                                <div class="font-semibold text-gray-800">Contract for: {{ contract.recipient_name }}</div>
                                                <div class="text-sm text-gray-600">{{ contract.recipient_email }}</div>
                                            </div>
                                            <div class="text-sm font-medium px-3 py-1 rounded-full"
                                                 :class="{ 'bg-blue-100 text-blue-800': contract.status?.status_name === 'Draft' }">
                                                {{ contract.status?.status_name }}
                                            </div>
                                        </div>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                        
                        <div v-else class="text-gray-500">
                            You have not created any contracts yet.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>