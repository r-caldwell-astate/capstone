<script setup>
import { ref } from "vue";
import Draggable from "vuedraggable";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
  availableFields: {
    type: Array,
    default: () => [],
  },
});

// Create a form object to hold all the data we need to save.
// This now includes the contractFields array for the draggable items.
const form = useForm({
    recipient_name: '',
    recipient_email: '',
    parts: [],
});

function logChange(evt) {
  console.log("Drag event:", evt)
  console.log("Current contractFields:", form.contractFields); // Updated to log the form's array
}

// Function to submit the form to the 'contracts.store' route.
const submit = () => {
    form.post(route('contracts.store'));
};
</script>

<template>
    <Head title="Create Contract" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create a New Contract</h2>
        </template>

        <form @submit.prevent="submit" class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-3 gap-6">

                    <div class="col-span-1 bg-gray-50 border rounded-lg shadow-sm p-4 self-start">
                        <h2 class="font-bold text-lg mb-3">Available Fields</h2>
                        <Draggable
                            :list="props.availableFields"
                            :group="{ name: 'fields', pull: 'clone', put: false }"
                            item-key="field_id"
                            class="space-y-2"
                        >
                            <template #item="{ element }">
                                <div class="p-2 bg-white border rounded cursor-grab hover:bg-gray-100">
                                    {{ element.field_name }}
                                </div>
                            </template>
                        </Draggable>
                    </div>

                    <div class="col-span-2 space-y-6">
                        <div class="p-6 bg-white rounded-lg shadow-sm">
                            <h3 class="font-bold mb-4">Recipient Information</h3>
                            <div>
                                <InputLabel for="recipient_name" value="Recipient Name" />
                                <TextInput id="recipient_name" type="text" class="mt-1 block w-full" v-model="form.recipient_name" required autofocus />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="recipient_email" value="Recipient Email" />
                                <TextInput id="recipient_email" type="email" class="mt-1 block w-full" v-model="form.recipient_email" required />
                            </div>
                        </div>

                        <div class="p-6 bg-white rounded-lg shadow-sm">
                            <h2 class="font-bold text-lg mb-3">Contract Builder</h2>
                            <Draggable
                                v-model="form.parts"
                                :group="{ name: 'fields', pull: false, put: true }"
                                item-key="field_id"
                                class="min-h-[300px] space-y-2 p-2 border-2 border-dashed rounded"
                                @change="logChange"
                              >
                                <template #item="{ element, index }">
                                    <div class="p-2 bg-green-50 border rounded cursor-move">
                                        {{ index + 1 }}. {{ element.field_name }}
                                    </div>
                                </template>
                                <template #footer>
                                    <div v-if="!form.parts.length" class="text-gray-400 italic">
                                        Drag fields here to build contract
                                    </div>
                                </template>
                            </Draggable>
                        </div>

                         <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Save Draft</PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>