<template>
  <TransitionRoot
    as="template"
    :show="show"
  >
    <Dialog
      class="relative z-10"
    >
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 dialog" />
      </TransitionChild>

      <div
        class="fixed inset-0 z-10 w-screen overflow-y-auto space-y-4"
        @click="$emit('click-outside')"
      >
        <div class="flex min-h-full min-w-full items-end justify-center text-center sm:items-center">
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel class="relative transform overflow-hidden rounded-lg overflow-y-scroll bg-gray-50 dark:bg-gray-800 text-left shadow-xl transition-all">
              <slot />
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'

defineProps({
  show: {
    type: Boolean,
    required: true,
  },
})

defineEmits(['click-outside'])
</script>

<style scoped>
.dialog {
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(3px); /* Add blur effect */
  -webkit-backdrop-filter: blur(3px); /* For Safari */
  overflow: scroll;
}

.center {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 20px;
}

</style>