<template>
  <BaseModal
    :show="show"
    @click-outside="close"
  >
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
        <!-- Product details -->
        <div class="lg:max-w-lg lg:self-end">
          <nav aria-label="Breadcrumb">
            <ol
              role="list"
              class="flex items-center space-x-2"
            >
              <li>
                <div class="flex items-center text-sm">
                  <a
                    class="font-medium text-gray-500 hover:text-gray-900"
                  >{{ product.category.name }}</a>
                  <svg
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    class="ml-2 h-5 w-5 flex-shrink-0 text-gray-300"
                  >
                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                  </svg>
                </div>
              </li>
              <li>
                <div class="flex items-center text-sm">
                  <a
                    class="font-medium text-gray-500 hover:text-gray-900"
                  >{{ product.name }}</a>
                </div>
              </li>
            </ol>
          </nav>

          <div class="mt-4">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
              {{ product.name }}
            </h1>
          </div>

          <section
            aria-labelledby="information-heading"
            class="mt-4"
          >
            <h2
              id="information-heading"
              class="sr-only"
            >
              Product information
            </h2>

            <div class="flex items-center">
              <p class="text-lg text-gray-900 sm:text-xl">
                {{ product.price.currency }} {{ product.price.amount }}
              </p>

              <div class="ml-4 border-l border-gray-300 pl-4">
                <h2 class="sr-only">
                  Reviews
                </h2>
                <div class="flex items-center">
                  <div>
                    <div class="flex items-center">
                      <StarIcon
                        v-for="rating in [0, 1, 2, 3, 4]"
                        :key="rating"
                        :class="[reviews.average > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']"
                        aria-hidden="true"
                      />
                    </div>
                    <p class="sr-only">
                      {{ reviews.average }} out of 5 stars
                    </p>
                  </div>
                  <p class="ml-2 text-sm text-gray-500">
                    {{ reviews.totalCount }} reviews
                  </p>
                </div>
              </div>
            </div>

            <div class="mt-4 space-y-6">
              <p class="text-base text-gray-500">
                {{ product.description }}
              </p>
            </div>

            <div class="mt-6 flex items-center">
              <CheckIcon
                class="h-5 w-5 flex-shrink-0 text-green-500"
                aria-hidden="true"
              />
              <p class="ml-2 text-sm text-gray-500">
                In stock and ready to ship
              </p>
            </div>
          </section>
        </div>

        <!-- Product image -->
        <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">
          <div
            v-if="!product.media.length"
            class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg"
          >
            <img
              :src="product.avatar"
              :alt="product.name"
              class="h-full w-full object-cover object-center"
            >
          </div>

          <!-- Image gallery -->
          <TabGroup
            v-else
            as="div"
            class="flex flex-col-reverse"
          >
            <!-- Image selector -->
            <div class="mx-auto mt-6 hidden w-full max-w-2xl sm:block lg:max-w-none">
              <TabList class="grid grid-cols-4 gap-6">
                <Tab
                  v-for="image in product.media"
                  :key="image.id"
                  v-slot="{ selected }"
                  class="relative flex h-24 cursor-pointer items-center justify-center rounded-md bg-white text-sm font-medium uppercase text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4"
                >
                  <span class="sr-only">{{ image.name }}</span>
                  <span class="absolute inset-0 overflow-hidden rounded-md">
                    <img
                      :src="image.url"
                      alt=""
                      class="h-full w-full object-cover object-center"
                    >
                  </span>
                  <span
                    :class="[selected ? 'ring-indigo-500' : 'ring-transparent', 'pointer-events-none absolute inset-0 rounded-md ring-2 ring-offset-2']"
                    aria-hidden="true"
                  />
                </Tab>
              </TabList>
            </div>

            <TabPanels class="aspect-h-1 aspect-w-1 w-full">
              <TabPanel
                v-for="image in product.media"
                :key="image.id"
              >
                <img
                  :src="image.url"
                  :alt="image.name"
                  class="h-full w-full object-cover object-center sm:rounded-lg"
                >
              </TabPanel>
            </TabPanels>
          </TabGroup>
        </div>

        <!-- Product form -->
        <div class="mt-10 lg:col-start-1 lg:row-start-2 lg:max-w-lg lg:self-start">
          <section aria-labelledby="options-heading">
            <h2
              id="options-heading"
              class="sr-only"
            >
              Product options
            </h2>

            <div>
              <div class="mt-10">
                <button
                  type="submit"
                  class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50"
                >
                  Add to bag
                </button>
              </div>
              <div class="mt-6 text-center">
                <a
                  href="#"
                  class="group inline-flex text-base font-medium"
                >
                  <ShieldCheckIcon
                    class="mr-2 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                    aria-hidden="true"
                  />
                  <span class="text-gray-500 hover:text-gray-700">Lifetime Guarantee</span>
                </a>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </BaseModal>
</template>

<script>
import { CheckIcon, StarIcon } from '@heroicons/vue/20/solid'
import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue'
import { ShieldCheckIcon } from '@heroicons/vue/24/outline'
import BaseModal from '@/Components/BaseModal.vue'
import { closeDialog } from 'vue3-promise-dialog'

export default {
  name: 'ProductPreview',

  components: {
    Tab,
    TabList,
    TabPanel,
    TabPanels,
    TabGroup,
    CheckIcon,
    StarIcon,
    ShieldCheckIcon,
    BaseModal,
  },

  props: {
    product: {
      type: Object,
      default: () => ({
        name: 'Everyday Ruck Snack',
        href: '#',
        price: '$220',
        description:
            'Don\'t compromise on snack-carrying capacity with this lightweight and spacious bag. The drawstring top keeps all your favorite chips, crisps, fries, biscuits, crackers, and cookies secure.',
        imageSrc: 'https://tailwindui.com/plus/img/ecommerce-images/product-page-04-featured-product-shot.jpg',
        imageAlt: 'Model wearing light green backpack with black canvas straps and front zipper pouch.',
        breadcrumbs: [
          { id: 1, name: 'Travel', href: '#' },
          { id: 2, name: 'Bags', href: '#' },
        ],
        sizes: [
          { name: '18L', description: 'Perfect for a reasonable amount of snacks.' },
          { name: '20L', description: 'Enough room for a serious amount of snacks.' },
        ],
      }),
    },
  },

  data() {
    return {
      reviews: { average: 4, totalCount: 1624 },
      show: true,
    }
  },
  
  methods: {
    close() {
      closeDialog(false)
    },
  },
}
</script>