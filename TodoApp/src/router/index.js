import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Auth/Login'
import Home from '@/components/Home'
import Register from '@/components/Auth/Register'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: Home
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },

    {
      path: '*',
      redirect: '/'
    }
  ]
})
