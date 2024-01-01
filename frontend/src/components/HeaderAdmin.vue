<template>
    <div class="w-full flex justify-between">
      <div>
        <h1 class="text-[24px] font-bold text-[#2f3334]">{{ title }}</h1>
        <p class="text-[#2f3334] text-[14px] mt-1">{{ subtitle }}</p>
      </div>
      <div class="flex">
        <div class="cursor-pointer size-[35px] bg-[#f9f9f9] rounded-lg mr-4 flex justify-center items-center text-[14px]"><i class="fa-solid fa-bell"></i></div>
        <div class="cursor-pointer size-[35px] bg-[#f9f9f9] rounded-lg mr-4 flex justify-center items-center text-[14px]"><i class="fa-solid fa-magnifying-glass"></i></div>
        <img class="cursor-pointer size-[35px] mr-2 block object-cover rounded-lg" src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
      </div>
    </div>
</template>

<script setup>
    defineProps(['title', 'subtitle'])
</script>