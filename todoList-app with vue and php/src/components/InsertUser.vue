<!-- insertUser.vue -->
<template>
     
        <v-main class="pa-2">
      <v-container fluid >
        <v-row align="center" justify="space-between">
          

          <!-- LEFT -->
          <v-col>
            <h2 class="text-lg mt- font-semibold">
              All Users
            </h2>
          </v-col>

          <!-- RIGHT -->
          <v-col cols="auto">
            <!-- <v-btn class="mt-" color="success" @click="showAllUsers"> -->
            <v-btn class="mt-" color="success" @click="exportToExcel">
              <font-awesome-icon icon="fa-solid fa-table" class=" pr-2" size="lg" /> Export To Excel
            </v-btn>
          </v-col>
          <v-col cols="auto">
            <v-btn class="mt-" color="primary" @click="dialog = true" >
              <font-awesome-icon icon="fa-solid fa-user-plus" class="mr-2"/> Add New Users
            </v-btn>
          </v-col>

        </v-row>

        <!-- start dialog box -->
        <v-dialog v-model="dialog" max-width="600">
        <v-card>
          <div class="btn">
            <v-card-title>
              Add New Task
            </v-card-title>
              <v-btn color="red" @click="dialog = false">
                X
              </v-btn>
              
            </div>

          <v-card-text>
            <!-- this v-model:dialog="dialog" sent "dialog to chile " and listen the request of updation and parant is update that  -->
           <!-- <userForm v-model:dialog="dialog"/>  -->
            <!-- below lines means connect props and update the props's values -->
           <userForm v-model:dialog="dialog"/> 
          
           <!-- like same 
            <userForm
            :dialog="dialog"
            @update:dialog="dialog = $event"
            />
 -->
           <!-- :dialog is read-only
                v-model:dialog is read + write 
            -->
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red" @click="dialog = false">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      </v-container>
    </v-main>
  
</template>
<style>
.v-app{
  height: fit-content;
}
.btn{
  display: flex; justify-content:space-between;
   position: relative; left: 10px; 
} 
</style>
<script>
import axios from 'axios'
import userForm from './Form.vue'
import Vtable from './Vtable.vue';

// dialog box script
export default {
  data() {
    return {
      dialog: false
    }
  },
  components:{
    userForm,
    Vtable
  },
  methods: {
  exportToExcel() {
  axios.get(
    'http://localhost/php-oop-2026/php-project/todoList-app/api/action.php?export=excel',
    { responseType: 'blob' }
  ).then(res => {

    const blob = new Blob([res.data], {
      type: 'application/vnd.ms-excel'
    });

    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'users.xls';
    link.click();

  });
},
    addNewUser(event){
      if(event.key === "+"){
        this.dialog = true
      }
      
    }
  //   showAllUsers() {
  //     axios.post('http://localhost/php-oop-2026/php-project/todoList-app/api/action.php', { action: 'view' })
  //       .then(res => {
  //         console.log(res.data) // ✅ DB data here
  //       })
  //       .catch(err => {
  //         console.error(err)
  //       })
  //   }
  },
  mounted(){
    window.addEventListener("keydown",this.addNewUser)
  },
  beforeUnmount() {   // If Vue 3
  // beforeDestroy() { // If Vue 2
    window.removeEventListener("keydown", this.addNewUser)
  },
}
</script>