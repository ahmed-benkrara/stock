<template>
  <main class="w-full min-h-screen flex relative font-poppins">
    <aside class="h-screen fixed w-[250px] bg-[#0046fe]">
      <h1 class="text-white text-center text-[22px] font-[500] py-[40px]">eStock</h1>
      <nav class="pl-[30px] mt-[20px] *:text-white *:cursor-pointer *:my-4 *:block *:text-[17px] *:font-[400] *:py-[10px] *:pl-[20px] *:rounded-l-full hover:*:bg-white hover:*:text-[#0046fe]">
        <RouterLink to="/" class=""><i class="fa-solid fa-layer-group mr-[10px]"></i> C-Product</RouterLink>
        <RouterLink to="/recipe" class=""><i class="fa-solid fa-burger mr-[10px]"></i> C-Recipe</RouterLink>
        <RouterLink to="/stock" class=""><i class="fa-solid fa-database mr-[10px]"></i> R-In Stock</RouterLink>
        <RouterLink to="/validation" class=""><i class="fa-solid fa-circle-check mr-[10px]"></i> Validation</RouterLink>
      </nav>
    </aside>
    <RouterView />
  </main>
</template>

<style scoped>
  .router-link-exact-active{
    @apply bg-white text-[#0046fe];
  }
</style>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>