import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Auth/Login'
import Home from '@/components/Home'
import Register from '@/components/Auth/Register'
import Logout from '@/components/Auth/Logout'
import Profile from '@/components/Profile/Profile'
import Todo from '@/components/Todo/Todo'
import Admin from '@/components/Admin/Admin'
import Test from '@/components/Admin/Test'
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/profile',
      name: 'Profile',
      component: Profile,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/admin',
      name: 'Admin',
      component: Admin
    },
    {
      path: '/test',
      name: 'Test',
      component: Test
    },
    {
      path: '/login',
      name: 'Login',
      component: Login,
      meta: {
        requiresVisitor: true
      }

    },
    {
      path: '/logout',
      name: 'Logout',
      component: Logout
    },
    {
      path: '/register',
      name: 'Register',
      component: Register,
      meta: {
        requiresVisitor: true
      }
    },
    {
      path: '/todo',
      name: 'Todo',
      component: Todo
    },

    {
      path: '*',
      redirect: '/'
    }
  ]
})
