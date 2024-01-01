<template>
    <section class="h-fit min-h-screen pb-[50px] w-[calc(100%-250px)] ml-auto px-[50px] pt-[30px]">
      <HeaderAdmin title="Product" subtitle="Create a product" />

      <div class="w-full h-fit rounded-md mt-[60px] px-[40px] py-[20px]">
        <h1 class="text-[20px] font-[600] text-[#2f3334]">Create a product</h1>
        <p class="text-[#2f3334] text-[14px] mb-[30px]">Please fill all fields</p>

        <div class="my-4">
          <label for="" class="text-[14px]">Product name</label>
          <input type="text" v-model="product.name" class="w-full border h-fit text-[15px] px-4 py-2 rounded-md bg-[#f0f0f041] mt-2 outline-none">
        </div>
        <div class="my-4">
          <label for="" class="text-[14px]">Product quantity</label>
          <input type="number" v-model="product.quantity" class="w-full border h-fit text-[15px] px-4 py-2 rounded-md bg-[#f0f0f041] mt-2 outline-none">
        </div>
        <div class="my-4">
          <label for="" class="text-[14px]">Product expiration</label>
          <input type="date" v-model="product.expiration" class="w-full border h-fit text-[15px] px-4 py-2 rounded-md bg-[#f0f0f041] mt-2 outline-none">
        </div>
        <div class="flex mt-8 w-fit ml-auto gap-x-4">
          <div class="cursor-pointer w-fit text-[14px] rounded-[5px] min-w-[200px] text-center px-4 py-2 text-black border" @click="clear()">Cancel</div>
          <div class="cursor-pointer w-fit text-[14px] rounded-[5px] min-w-[200px] text-center px-4 py-2 text-white bg-[#0046fe]" @click="submit()">Submit</div>
        </div>
      </div>
    </section>
</template>

<script setup>
  import HeaderAdmin from '../components/HeaderAdmin.vue'
  import { reactive } from 'vue'
  import axios from 'axios'
  import { useHead } from '@vueuse/head'
  //module containing api url
  import config from '@/utils/config.js'

  useHead({
    title: 'Create a product',
  })

  const product = reactive({
    name: '',
    quantity: 0,
    expiration: '' 
  })

  const validate = () => {
    if(product.name.trim().length == 0){
      alert('name isn\'t valid')
      return false
    }

    if(product.quantity < 0){
      alert('quantity isn\'t valid')
      return false
    }

    if(product.expiration == ''){
      alert('expiration date isn\'t valid')
      return false
    }

    return true
  }

  //submit the product
  const submit = async () =>{
    if(validate()){
      
      try{
        await axios.post(`${config.url}/api/product/create`, product, {
          headers: {
            'Accept': 'application/vnd.api+json',
            'Content-Type': 'application/vnd.api+json',
          }
        })
        
        alert('Product created successfully')
      }catch(err){
        alert('Oops something went wrong !')
      }
    }
  }

  //clear the form
  const clear = () => {
    product.name = ''
    product.quantity = 0
    product.expiration = ''
  }

</script>