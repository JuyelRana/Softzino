<template>
  <!-- Start Wrapper -->
  <div class="wrapper">

    <!-- Section Cards -->
    <section class="cards-block">
      <div class="container">
        <div class="row">
          <!-- CARD -->
          <table class="table table-striped">
            <thead>
            <tr>
              <th scope="col">Sl</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Birthdate</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(user, index) in users" :key="user.id">
              <th scope="row">{{ ++index }}</th>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.birthdates.birthdate }}</td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- END ROW -->
      </div>
      <!--/ End Container -->
    </section>
    <!-- End Cards -->
  </div>
  <!-- End Wrapper -->
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    users: []
  }),

  created() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      axios.get('/users').then((res) => {
        if (res.data.success) {
          this.users = res.data.data;
        }
        // console.log(res);
      }).catch(err => {
        console.log(err);
      })
    }
  }
}
</script>

<style scoped>

</style>