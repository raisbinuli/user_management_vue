<template>
  <div>
    
    <div class="row">
      <div class="col-md-12">
        <br>
        <br>
        <div class="row">
          <div class="col-md-10">
            <h4>Users</h4>
          </div>
          <div class="col-md-2">
            
            <router-link class="btn btn-primary w-100" to="/create"><i class="fa fa-plus" aria-hidden="true"></i> Add more user</router-link>
          </div>
        </div>
        <br>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            
            <tr v-for="user in users.data" :key="user.id">
              <td style="width:40%">{{user.name}}</td>
              <td style="width:40%">{{user.email}}</td>
              <td style="width:20%">
                <router-link class="btn btn-info" :to="'/detail/'+user.id"><i class="fa fa-pencil" aria-hidden="true"></i> Update</router-link>
                <button class="btn btn-danger" v-on:click="deleteData(user.id)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
        

        <pagination :data="users" @pagination-change-page="loadData"></pagination>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      
      users: []
    };
  },
  created() {
    this.loadData();
  },
  methods: {
    loadData(page=1) {
      
      axios.get("http://localhost:8000/api/user?page=" + page).then(response => {
        
        this.users = response.data;
      });
    },
    deleteData(id) {
      let conf = confirm("Are You sure want to delete this data?");
      if(conf){
        axios.delete("http://localhost:8000/api/user/" + id).then(response => {
          this.loadData();
        });
      }
      
    }
  }
};
</script>