<template>
  <div>
    <a-menu v-model="current" mode="horizontal">
      <a-menu-item key="mail"><router-link to="/">Home</router-link></a-menu-item>
      <a-menu-item key="app"><router-link to="/profile">myProfile</router-link>  </a-menu-item>
      <a-sub-menu v-if="loggedIn">
        <span slot="title" class="submenu-title-wrapper"
          ><a-icon type="setting" />Components</span
        >
        <a-menu-item-group title="Todo">
          <a-menu-item key="setting:1">
             <router-link to="/todo">My todos</router-link> 
          </a-menu-item>
          <a-menu-item key="setting:2">
            Create todo
          </a-menu-item>
        </a-menu-item-group>
        <a-menu-item-group title="Admin Only">
          <a-menu-item key="setting:3">
            <router-link to="/admin">All User</router-link> 
          </a-menu-item>
          <a-menu-item key="setting:4">
            Create User
          </a-menu-item>
        </a-menu-item-group>
      </a-sub-menu>
      <a-menu-item key="alipay">
        <a href="https://antdv.com" target="_blank" rel="noopener noreferrer"
          >Navigation Four - Link</a
        >
      </a-menu-item>
      <a-menu-item v-if="!loggedIn">
          <router-link to='/login'>Login</router-link>
      </a-menu-item>
      <a-menu-item v-if="!loggedIn">
          <router-link to='/register'>Register</router-link>
      </a-menu-item>
      <a-menu-item v-if="loggedIn">
        <router-link to="/logout">Logout</router-link>
      </a-menu-item>
    </a-menu>
  </div>
</template>


<script>
import axios from 'axios'
export default {
  computed: {
    loggedIn(){
      return this.$store.getters.loggedIn
    }
  },
  data() {
    return {
      current: ['mail'],
    };
  },
};
</script>
