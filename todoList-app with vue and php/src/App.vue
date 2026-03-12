<template>
  <v-app>

    <!-- Navbar -->
    <Navbar />

    <!-- Main Content -->
    <v-main>
      <TodoMain />
      <Vtable/>
      
    </v-main>

  </v-app>
</template>

<!-- <script setup> -->
<script setup>
import Navbar from './components/navbar.vue'
import TodoMain from './components/InsertUser.vue'
import Vtable from './components/Vtable.vue'
</script>
