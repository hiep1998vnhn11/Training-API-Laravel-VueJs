<template>
<div>
  <a-row>
  <a-alert v-if="error" type="error" message="Login false!" banner />

  <a-col :span="8" :offset="8">
  <a-form
    id="components-form-demo-normal-login"
    :form="form"
    class="login-form"
    @submit.prevent="login"
  >
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
      <a-checkbox>
        Remember me
      </a-checkbox>
      <a class="login-form-forgot" href="">
        Forgot password
      </a>
      <a-button type="primary" html-type="submit" class="login-form-button">
        Log in
      </a-button>
      Or
      <router-link to="/register">Register now!</router-link>
    </a-form-item>
  </a-form>
  </a-col>
  </a-row>
</div>
</template>

<script>
export default {
  beforeCreate() {
    this.form = this.$form.createForm(this, { name: 'normal_login' });
  },
  name: 'login',
  data() {
    return {
      email: '',
      password: '',
      error: false
    }
  },
  methods: {
    login(){
      this.$store.dispatch('retrieveToken', {
        email: this.email,
        password: this.password
      })
      .then(response => {
        this.$router.push({name: 'Profile'})
      })
      .catch(error => {
        console.log('fail')
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