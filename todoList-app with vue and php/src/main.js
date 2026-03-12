import { createApp } from 'vue'
import App from './App.vue'
import { vuetify } from './plugins/vuetify'

// Font Awesome
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import * as solidIcons from '@fortawesome/free-solid-svg-icons'
import * as regularIcons from '@fortawesome/free-regular-svg-icons'
import * as brandIcons from '@fortawesome/free-brands-svg-icons'

const extractIcons = (iconSet) =>
  Object.values(iconSet).filter(
    (icon) => icon && icon.iconName
  )

library.add(
  ...extractIcons(solidIcons),
  ...extractIcons(regularIcons),
  ...extractIcons(brandIcons)
)

const app = createApp(App)

app.use(vuetify)
app.component('font-awesome-icon', FontAwesomeIcon)
app.mount('#app')
