import './bootstrap'
import '../css/app.css'

import 'notivue/notification.css'
import 'notivue/animations.css'
import 'floating-vue/dist/style.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

import notify from '@/Mixins/notify.js'
import hasPermissionAs from '@/Mixins/hasPermissionAs.js'

import wait from '@meforma/vue-wait-for'
import { createNotivue } from 'notivue'
import FloatingVue from 'floating-vue'

import  './Validation/rules'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'
createInertiaApp({
  title: title => `${title} - ${appName}`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(wait)
      .use(ZiggyVue)
      .use(createNotivue({ position: 'top-right' }))
      .use(FloatingVue)
      .mixin(notify)
      .mixin(hasPermissionAs)
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})
