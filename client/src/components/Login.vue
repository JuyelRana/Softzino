<template>
  <!-- Section Cards -->
  <section class="authentication">
    <div class="auth-body">
      <h1 class="text-uppercase fw-500 mb-4 text-center font-22">
        Login
      </h1>
      <form class="auth-form" @submit.prevent="login">
        <div class="form-group">
          <input
              v-model="form.email"
              type="text"
              name="email"
              class="form-control form-control-lg font-14 fw-300"
              placeholder="Email"/>


        </div>
        <div class="form-group">

          <input
              v-model="form.password"
              type="password"
              name="password"
              class="form-control form-control-lg font-14 fw-300"
              placeholder="Password"/>


        </div>
        <div class="mt-4 mb-4 clearfix">
          <a class="forgot-pass color-blue font-14 fw-400" href="#"> Forgot password? </a>
        </div>
        <div class="text-right">
          <button
              type="submit"
              class="btn btn-primary primary-bg-color font-16 fw-500 text-uppercase">
            Login
          </button>
        </div>
        <p class="font-14 fw-400 text-center mt-4">
          Don't have an account yet?
          <router-link to="/register">Create an account</router-link>
        </p>
      </form>
    </div>
  </section>
  <!-- End Cards -->
</template>

<script>

import axios from "axios";

export default {
  name: "Login",
  data: () => ({
    form: {
      email: '',
      password: ''
    }
  }),

  methods: {
    login() {
      axios.post('/login', this.form)
          .then((res) => {
            if (res.status === 200) {
              console.log(res.data);
            } else {
              console.log(res);
            }
          }).catch(err => err);
    }
  }
}
</script>

<style scoped>

</style>