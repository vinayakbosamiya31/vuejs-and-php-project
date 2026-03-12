<!-- Vtable -->
<template>
  <v-data-table class="mytable" :items="users" :loading="loading" :items-per-page="10" :headers="headers">
    <template #item.action="{ item }">
      <v-tooltip v-for="(ac, name) in Action" :key="name" location="top">

        <template #activator="{ props }">

          <font-awesome-icon v-bind="props" :key="name" :icon="ac.icon" :style="{ color: ac.color }"
          class="action-icon" @click="handleAction(name,item)"/>
        </template>
          <span>{{ name }}</span>
      </v-tooltip>
      </template>
  </v-data-table>

  <v-dialog v-model="EditUserdialog" max-width="600">
    <v-card v-if="EditUserdialog">
          <v-card-title>
            Edit Task Info
          </v-card-title>

          <v-card-text>
            <!-- <v-form @submit.prevent="submitEditForm">           -->
              <v-text-field label="Name" autofocus v-model="formData.Name"/>
              <v-text-field label="Email" v-model="formData.Email"/>
              <v-text-field label="Phone" v-model="formData.Phone"/>
              <v-btn block color="primary" @click="submitEditForm">Update</v-btn>
              <!-- <userForm :userEdit="EditUserdialog" /> -->
            <!-- </v-form> -->
          </v-card-text>
    </v-card>
  </v-dialog>

  <v-dialog v-model="isShowUser" max-width="400">
    <v-card>
      <v-card-title>
      User Information
      </v-card-title>
      <v-card-text v-for="user in showUserInformation">

        <h6>Id : {{ user.Id }}</h6>
        <h6>Name : {{ user.Name }}</h6>
        <h6>Email : {{ user.Email }}</h6>
        <h6>Phone : {{ user.Phone }}</h6>
      </v-card-text >
    </v-card>
  </v-dialog>

</template>
<script>
import axios from 'axios';

export default {
  
  data() {
    return {
      formData: {
    Id:   '',
    Name: '',
    Email:'',
    Phone:''
  },
      loading: false,
      EditUserdialog: false,
      showUserInformation:[],
      isShowUser:false,
      // isDelete:false,
      users: [],

      headers: [
        { title: "Id", key: "Id" },
        { title: "Name", key: "Name" },
        { title: "Email", key: "Email" },
        { title: "Phone Number", key: "Phone" },
        { title: "Action", key: "action" },
      ],

      Action: {
        Info: { icon: "fa-solid fa-circle-info", color: "green",name:"Info"   },
        Edit: { icon: "fa-solid fa-user-pen", color: "blue",name:"Edit"   },
        Delete: { icon: "fa-solid fa-trash-can", color: "red",name:"Delete" },
      },
    }
  }, 
  methods: {
    // show user
    fetchUsers() {
      this.loading = true;
      axios.post('http://localhost/php-oop-2026/php-project/todoList-app/api/action.php', { action: 'view' }).then(res => {

        if(res.data.length>0){
          this.users = res.data;
        }else{
          console.log("Data Is Not Found");
        }
        // console.log( res.data)
      }).catch(error => {
        console.log(error)
      }).finally(() => { this.loading = false });
      console.log(this.users)
    },


    // delete row
    deleteRow(Id) {
      if (confirm("Are You Sure?")) {
        axios.post('http://localhost/php-oop-2026/php-project/todoList-app/api/action.php', { action: 'delete', id: Id })
        .then(res => 
        { console.log(res.data);
        })
      }
    },

  editUser(item){

  this.formData = {
    Id: item.Id,
    Name: item.Name,
    Email: item.Email,
    Phone: item.Phone
  }

  this.EditUserdialog = true
  },

  submitEditForm() {
    if (confirm("Are You Sure?")) {
         axios.post('http://localhost/php-oop-2026/php-project/todoList-app/api/action.php', {
         action: 'update',
         id: this.formData.Id,
         name: this.formData.Name,
         email: this.formData.Email,
         phone: this.formData.Phone})
         .then(res => {
            this.EditUserdialog = false
            if(res.data.status === "success") {
              alert("Updated Successfully")
              this.fetchUsers()
            }
          })
    }
  },

  

    // for shortcut key
    shortcutKeys(event){
      if(event.key === 'Enter'){
        this.EditUserdialog=false
        this.submitEditForm()
      }
      if(event.key === 'e' || event.key === 'E' ){
        this.EditUserdialog = true
      }
      // if(event.key === 'd' || event.key === 'delete'|| event.key === 'Delete'){

    },
    handleAction(typeName, item) {
      if (typeName === "Info"){
        this.isShowUser= true
        this.showUserInformation.push(item)

      }
      if (typeName === "Edit"){
        this.editUser(item)
      }
      if (typeName === "Delete") {
        this.deleteRow(item.Id)
        console.log(item.id)
      }
    },
  },
  mounted() {
    this.fetchUsers();
    window.addEventListener("keydown",this.shortcutKeys);
    
  },
  beforeUnmount(){
    window.removeEventListener("keydown",this.shortcutKeys);

  }
}
</script>
<style scoped>
.mytable {
  padding: 0 70px;
}

.action-icon {
  margin-right: 12px;
  cursor: pointer;
  font-size: 18px;
}
.action-icon:focus {
  outline: none;
}

</style>