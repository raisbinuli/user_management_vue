<template>
  <div>
    <div class="row">
      <div class="col-md-6 mt-5">
        
        <h4>Create new data</h4>
        <div v-if="errors" class="alert alert-danger">
          <ul v-for="(v, k) in errors" :key="k">
            <li v-for="error in v" :key="error" class="text-sm">
              {{ error }}
            </li>
          </ul>
        </div>
        
        <form @submit.prevent="addData()">
          <div class="form-group">
            <label>Name</label>
            <input
              type="textfield"
              class="form-control"
              placeholder="Input your name"
              v-model="form.name"
              required
            >
          </div>
          <div class="form-group">
            <label>Email</label>
            <input
              type="textfield"
              class="form-control"
              placeholder="Input your email"
              v-model="form.email"
              required
            >
          </div>
          <div class="form-group">
            <label>Password</label>
            <input
              type="password"
              class="form-control"
              placeholder="Input your password"
              v-model="form.password"
              required
            >
          </div>
          <button class="btn btn-primary mr-2">Submit</button>
          <a class="btn btn-primary" href="/">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      form:{
        name: '',
        email: '',
        password: '',
      },
      errors: null
    }
  },
  methods: {
    addData() {
      
      axios
        .post("http://localhost:8000/api/user", {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password

        })
        .then(response => {
          
          this.$router.push("/");
        }).catch(error => {
          
          if (error.response.status == 422){
            this.errors = error.response.data.errors;
          }
        });
    }
  }
};
</script>
