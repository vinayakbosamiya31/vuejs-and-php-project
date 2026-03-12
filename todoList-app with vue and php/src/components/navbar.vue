<template>
  <!-- <v-app class="app-root"> -->
    
    <v-app-bar
    color="primary"
    height="48"
    
  >
      <v-app-bar-title class="text-h6 ms-3">
        <v-icon icon="mdi-apps" />
        <span class="ms-1">My Application</span>

      </v-app-bar-title>



      <v-btn icon="mdi-home"></v-btn>

      <font-awesome-icon :icon="['fas', 'address-card']" />


      <v-btn icon="mdi-email"></v-btn>

    </v-app-bar>
    

  <!-- </v-app> -->
</template>
<style>
.v-toolbar-title__placeholder {
  justify-self: start !important;
}
.app-root {
  background-color: #ca4343;
}

</style>