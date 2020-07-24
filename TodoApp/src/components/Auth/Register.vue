<template>
<div>
  <a-row>
  <a-col :span="8" :offset="8">
  <a-form
    id="components-form-demo-normal-login"
    class="login-form"
    @submit.prevent="register"
  >
    <a-form-item>
      <a-input
        placeholder="Name"
        v-model="name"
      >
        <a-icon slot="prefix" type="user" style="color: rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item>
      <a-input
        placeholder="Email"
        v-model="email"
      >
        <a-icon slot="prefix" type="user" style="color: rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item>
      <a-input
        type="password"
        placeholder="Password"
        v-model="password"
      >
        <a-icon slot="prefix" type="lock" style="color: rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item>
      <a-input
        type="password"
        placeholder="Reset Password"
        v-model="password_comfirmation"
      >
        <a-icon slot="prefix" type="lock" style="color: rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item>
      <a-button type="primary" html-type="submit" class="login-form-button">
        Register
      </a-button>
      Or
      <router-link to="/login">login now!</router-link>
    </a-form-item>
  </a-form>
  </a-col>
  </a-row>
</div>
</template>

<script>
import {mapActions} from 'vuex'
export default {
  name: "register",
  data(){
    return {
      name :'',
      email : '',
      password: '',
      password_comfirmation: ''
    }
  },
  methods: {
    register(){
      this.$store.dispatch('register', {
        name: this.name,
        email: this.email,
        password: this.password
      })
      .then(response => {
        this.$router.push({name: 'Login'})
      })
    }
  },
};
</script>
<style>
#components-form-demo-normal-login .login-form {
  max-width: 300px;
}
#components-form-demo-normal-login .login-form-forgot {
  float: right;
}
#components-form-demo-normal-login .login-form-button {
  width: 100%;
}
</style>