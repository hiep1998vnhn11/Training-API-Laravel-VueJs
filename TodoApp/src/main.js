// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import 'ant-design-vue/dist/antd.css';
import Antd from 'ant-design-vue';
import axios from 'axios'
import store from './stores'
import Cookies from 'js-cookie'
import VueToastify from "vue-toastify";

Vue.use(VueToastify);
Vue.config.productionTip = false
Vue.use(Antd)
Vue.use(Cookies)

axios.defaults.baseURL = 'http://myjwtapi.dev.com/api'

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)){
    if(!store.getters.loggedIn) { 
      next({
        name:'Login',
      })
    } else {
      next()
    }
  } else if(to.matched.some(record => record.meta.requiresVisitor)){
    if(store.getters.loggedIn) { 
      next({
        name:'Profile',
      })
    } else {
      next()
    }
  }
   else {
    next()
  }
})

/* eslint-disable no-new */
new Vue({
  store,
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
