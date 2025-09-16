<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from "vue";
import Draggable from "vuedraggable";
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    availableFields: Array,
    contract: {
        type: Object,
        default: null,
    },
});

const draggableFields = computed(() => {
    if (!props.availableFields) return [];
    return props.availableFields.map(field => ({
        id: `palette-${field.field_id}`,
        type: 'field',
        data: field
    }));
});

// Function to reconstruct parts from saved contract content
const reconstructParts = () => {
    if (!props.contract) {
        return []; // when not editing, start empty
    }

    const latestVersion = props.contract.versions[props.contract.versions.length - 1];
    if (!latestVersion || !latestVersion.content) {
        return [];
    }

    // Split the saved content by the field placeholders, but keep the placeholders
    const chunks = latestVersion.content.split(/(\{\{.*?\}\})/g).filter(c => c);

    return chunks.map((chunk, index) => {
        // Check if the chunk is a placeholder like {{Client Name}}
        const match = chunk.match(/\{\{(.*?)\}\}/);
        if (match) {
            const fieldName = match[1];
            // Find the full field object from our available fields
            const fieldData = props.availableFields.find(f => f.field_name === fieldName);
            return {
                id: `field-${fieldData.field_id}-${index}`,
                type: 'field',
                data: fieldData,
            };
        } else {
            // Otherwise, it's a plain text block
            return {
                id: `text-${index}-${Date.now()}`,
                type: 'text',
                data: { content: chunk.trim() }
            };
        }
    }).filter(p => p !== null); // Filter out any nulls if a field wasn't found
};

const form = useForm({
    recipient_name: props.contract?.recipient_name ?? '',
    recipient_email: props.contract?.recipient_email ?? '',
    parts: reconstructParts(), // Use the new function to set the initial parts
});

const rawContractText = ref('');

function loadContractText() {
    if (!rawContractText.value) {
        form.parts = [];
        return;
    }
    const paragraphs = rawContractText.value.split('\n').filter(p => p.trim() !== '');
    form.parts = paragraphs.map((p, index) => ({
        id: `text-${index}-${Date.now()}`,
        type: 'text',
        data: { content: p }
    }));
}

const submit = () => {
    const transformedParts = form.parts.map(part => {
        return part.type === 'text' ? { type: 'text', content: part.data.content } : part.data;
    });

    form.transform(data => ({
        ...data,
        parts: transformedParts,
    }));

    if (props.contract) {
        form.put(route('contracts.update', props.contract.contract_id));
    } else {
        form.post(route('contracts.store'));
    }
};
</script>

<template>
    <Head :title="contract ? 'Edit Contract' : 'Create Contract'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ contract ? 'Edit Contract' : 'Create a New Contract' }}
            </h2>
        </template>

        <form @submit.prevent="submit" class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div v-if="!contract" class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-4 text-gray-900">1. Paste Contract Text</h3>
                        <textarea
                            v-model="rawContractText"
                            rows="10"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            placeholder="Paste the full text of your contract here..."
                        ></textarea>
                        <PrimaryButton @click="loadContractText" type="button" class="mt-4">
                            Load Text into Builder
                        </PrimaryButton>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-1 bg-gray-100 p-4 rounded-lg self-start">
                        <h3 class="font-bold text-lg mb-3">2. Drag Fields</h3>
                        <Draggable
                            :list="draggableFields"
                            :group="{ name: 'fields', pull: 'clone', put: false }"
                            item-key="id"
                            class="space-y-2"
                        >
                            <template #item="{ element }">
                                <div class="p-2 bg-white border rounded cursor-grab hover:bg-gray-100">
                                    {{ element.data.field_name }}
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
                            <h3 class="font-bold text-lg mb-3">Contract Builder</h3>
                            <Draggable
                                v-model="form.parts"
                                group="fields"
                                item-key="id"
                                class="min-h-[300px] space-y-2 p-2 border-2 border-dashed rounded"
                              >
                                <template #item="{ element }">
                                    <div class="p-2 rounded cursor-move" :class="element.type === 'text' ? 'text-gray-700' : 'bg-green-50 border'">
                                        <span v-if="element.type === 'text'">{{ element.data.content }}</span>
                                        <span v-else class="font-bold">{{ element.data.field_name }}</span>
                                    </div>
                                </template>
                                <template #footer>
                                    <div v-if="!form.parts?.length" class="text-gray-400 italic py-2">
                                        Drag fields here to build the contract
                                    </div>
                                </template>
                            </Draggable>
                        </div>
                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">
                                {{ contract ? 'Update Draft' : 'Save Draft' }}
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>