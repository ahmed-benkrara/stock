import { createRouter, createWebHistory } from 'vue-router'
import ProductView from '../views/ProductView.vue'
import RecipeView from '../views/RecipeView.vue'
import InstockView from '../views/InstockView.vue'
import ValidationView from '../views/ValidationView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'product',
      component: ProductView
    },
    {
      path: '/recipe',
      name: 'recipe',
      component: RecipeView
    },
    {
      path: '/stock',
      name: 'stock',
      component: InstockView
    },
    {
      path: '/validation',
      name: 'validation',
      component: ValidationView
    },
  ]
})

export default router
