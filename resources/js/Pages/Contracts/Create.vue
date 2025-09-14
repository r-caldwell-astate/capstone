<script setup>
import { ref, onMounted } from "vue"
import Draggable from "vuedraggable"

const props = defineProps({
  availableFields: {
    type: Array,
    default: () => [],
  },
})

const contractFields = ref([])

function logChange(evt) {
  console.log("Drag event:", evt)
  console.log("Current contractFields:", contractFields.value)
}

onMounted(() => {
  console.log("Available fields from backend:", props.availableFields)
})
</script>

<template>
  <div class="flex gap-6 p-6">
    <!-- Left Panel -->
    <div class="w-1/3 bg-gray-50 border rounded-lg shadow-sm p-4">
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

    <!-- Right Panel -->
    <div class="flex-1 bg-gray-50 border rounded-lg shadow-sm p-4">
      <h2 class="font-bold text-lg mb-3">Contract Builder</h2>
      <Draggable
        v-model="contractFields"
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
          <div v-if="!contractFields.length" class="text-gray-400 italic">
            Drag fields here to build contract
          </div>
        </template>
      </Draggable>
    </div>
  </div>
</template>
