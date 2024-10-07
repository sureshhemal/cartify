<template>
  <BaseModal :show="open">
    <div class="sm:flex sm:items-start">
      <div
        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
      >
        <ExclamationTriangleIcon class="h-6 w-6 text-red-600" />
      </div>
      <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
        <DialogTitle
          v-if="title"
          as="h3"
          class="text-base font-semibold leading-6 text-gray-900"
        >
          {{ title }}
        </DialogTitle>
        <div class="mt-2">
          <p class="text-sm text-gray-500">
            {{ text }}
          </p>
        </div>
      </div>
    </div>
    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
      <button
        type="button"
        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
        @click="confirm"
      >
        {{ confirmButtonText }}
      </button>
      <button
        ref="cancelButtonRef"
        type="button"
        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
        @click="cancel"
      >
        {{ cancelButtonText }}
      </button>
    </div>
  </BaseModal>
</template>

<script setup>
import { ref } from 'vue'
import BaseModal from '@/Components/BaseModal.vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline/index.js'
import { DialogTitle } from '@headlessui/vue'
import { closeDialog } from 'vue3-promise-dialog'

const open = ref(true)

const props = defineProps({
  title: {
    type: String,
    default: () => '',
  },
  
  text: {
    type: String,
    default: () => 'Are your sure?',
  },
  
  confirmButtonText: {
    type: String,
    default: () => 'Confirm',
  },
  
  cancelButtonText: {
    type: String,
    default: () => 'Cancel',
  },
})

const closeModal = () => {
  open.value = false
}

const confirm = () => {
  closeModal()
  closeDialog(true)
}

const cancel = () => {
  closeModal()
  closeDialog(false)
}
</script>
