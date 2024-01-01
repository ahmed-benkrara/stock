<template>
    <section class="h-fit min-h-screen pb-[50px] w-[calc(100%-250px)] ml-auto px-[50px] pt-[30px]">
      <HeaderAdmin title="Products" subtitle="Products in stock" />
      <div class="mt-[50px] mb-[20px] w-fit cursor-pointer">
          <h1 class="text-[14px] font-[600] w-fit">In stock</h1>
          <div class="w-full h-[2px] bg-[#0046fe] rounded-lg"></div>
      </div>
      <div class="w-full font-poppins overflow-x-scroll noscroll">
          <table class="w-full min-w-[600px] border-separate border-spacing-y-4" >
            <thead class="bg-[#f9f9f9]">
                <tr class="*:text-left *:font-[600] text-[13px] *:py-2 *:px-4">
                    <th class="rounded-l-lg">Id</th>
                    <th>Product name</th>
                    <th>Product quantity</th>
                    <th class="rounded-r-lg">Expiration date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in products.slice(start, end)" :key="item.key" class="*:py-4 *:px-4 font-[500] text-[14px]">
                    <td class="font-[600]">{{ index+1 }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ item.expiration }}</td>
                </tr>
            </tbody>
          </table>
      </div>
      <div class="flex items-center justify-between">
        <p class="text-[14px]">Showing {{ start+1 }}-{{ end > products.length ? products.length : end }} of {{ products.length }} </p>
        <div class="w-fit flex">
            <div @click="previous()" class="px-[13px] text-[14px] cursor-pointer py-1 rounded-md bg-[#f3f4f6] w-fit">
                <i class="fa-solid fa-angle-left"></i>
            </div>
            <div @click="next()" class="px-[13px] text-[14px] cursor-pointer py-1 rounded-md bg-[#f3f4f6] w-fit ml-2">
                <i class="fa-solid fa-angle-right"></i>
            </div>
        </div>
      </div>
    </section>
</template>

<script setup>
  import HeaderAdmin from '../components/HeaderAdmin.vue'
  import { ref, onMounted } from 'vue'
  import { useHead } from '@vueuse/head'
  import axios from 'axios'
  //module containing api url
  import config from '@/utils/config.js'
  useHead({
    title: 'In Stock',
  })
  const products = ref([])

  const start = ref(0)
  const perpage = ref(10)
  const end = ref(perpage.value)

  onMounted(async () => {
    const response = await axios.get(`${config.url}/api/product/instock`, {
        headers: {
            'Accept': 'application/vnd.api+json',
            'Content-Type': 'application/vnd.api+json',
        }
    })

    products.value = response.data.products
  })

  const next = () => {
    if(products.value.length > end.value){
        start.value += perpage.value 
        end.value += perpage.value 
    }
  }

  const previous = () => {
    if(start.value > 0){
        start.value -= perpage.value 
        end.value -= perpage.value 
    }
  }

</script>

<style scoped>
    .noscroll::-webkit-scrollbar {
        width: 0px;
    }
</style>