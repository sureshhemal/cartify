<template>
  <div class="px-4 sm:px-6 lg:px-8 py-6 bg-white rounded-lg">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1
          v-if="$slots.title"
          class="text-base font-semibold leading-6 text-gray-900"
        >
          <slot name="title" />
        </h1>
        <p
          v-if="$slots.description"
          class="mt-2 text-sm text-gray-700"
        >
          <slot name="description" />
        </p>
      </div>
      <div
        v-if="$slots.action"
        class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none"
      >
        <slot name="action" />
      </div>
    </div>
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <slot name="table-header-row" />
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <slot name="table-body" />
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
