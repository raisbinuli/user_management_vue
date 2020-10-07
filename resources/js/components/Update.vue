<template>
  <div>
    <div class="row">
      <div class="col-md-6 mt-5">
        
        <h4>Update data</h4>
        <div v-if="errors" class="alert alert-danger">
          <ul v-for="(v, k) in errors" :key="k">
            <li v-for="error in v" :key="error" class="text-sm">
              {{ error }}
            </li>
          </ul>
        </div>        
        
        <form @submit.prevent="updateData()">
          <div class="form-group">
            <label>Name</label>
            <input
              type="textfield"
              class="form-control"
              placeholder="Input your first name"
              v-model="form.name"
              required
            >
          </div>
          <div class="form-group">
            <label>Email</label>
            <input
              type="textfield"
              class="form-control"
              placeholder="Input your last name"
              v-model="form.email"
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
  data() {
    return {
      form: {
        name: "",
        email: ""
      },
      errors: null
    };
  },
  created() {
    
    this.loadData();
  },
  methods: {
    loadData() {
      
      axios
        .get("http://localhost:8000/api/user/" + this.$route.params.id)
        .then(response => {
          
          this.form.name = response.data.name;
          this.form.email = response.data.email;
        });
    },
    updateData() {
      
      axios
        .put("http://localhost:8000/api/user/" + this.$route.params.id, {
          name: this.form.name,
          email: this.form.email
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
