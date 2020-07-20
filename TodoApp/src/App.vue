<template>
<div>
  <header-bar/>
  <div id="app">
    <router-view/>
  </div>
</div>
</template>

<script>
import HeaderBar from './components/Bars/HeaderBar'
export default {
  name: 'App',
  components: {
    headerBar: HeaderBar
  }
}
</script>

<style>

</style>
