<template>
<div>
  <header-bar/>
  <div id="app">
    <router-view/>
  </div>
</div>
</template>

<script>
import Vue from 'vue'
import VueRouter from 'vue-router'
import HeaderBar from './components/Bars/HeaderBar'

Vue.use(VueRouter)
export default {
  name: 'App',
  components: {
    headerBar: HeaderBar
  }
}
</script>

<style>

</style>
