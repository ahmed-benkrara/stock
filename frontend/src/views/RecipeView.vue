<template>
  <section class="h-fit min-h-screen pb-[50px] w-[calc(100%-250px)] ml-auto px-[50px] pt-[30px]">
    <HeaderAdmin title="Recipe" subtitle="Create a recipe" />
    <div class="w-full h-fit rounded-md mt-[60px] px-[40px] py-[20px]">
      <h1 class="text-[20px] font-[600] text-[#2f3334]">Create a recipe</h1>
      <p class="text-[#2f3334] text-[14px] mb-[30px]">Please fill all fields</p>

      <div class="my-4">
        <label for="" class="text-[14px]">Recipe name</label>
        <input type="text" v-model="recipe.name" class="w-full border h-fit text-[15px] px-4 py-2 rounded-md bg-[#f0f0f041] mt-2 outline-none">
      </div>
      <div class="my-4">
        <label for="" class="text-[14px]">Select Products</label>
        <ul class="mt-4 *:bg-[#f0f9ff] *:text-[#188fcc] *:border *:border-[#e5f4fe] *:w-fit text-[12px] *:rounded-full *:px-4 *:py-[2px] flex gap-x-2 gap-y-4 flex-wrap ">
          <li v-for="(item, index) in selectedProducts" :key="index" @click="removeProduct(item.id)">{{ item.quantity }} {{ products.find(i => i.id == item.id).name }} <i class="fa-solid fa-xmark ml-1 cursor-pointer"></i></li>
        </ul>

        <div class="multiple shadow-sm bg-[#f7fafc] w-full h-[200px] mt-[20px] rounded-md overflow-y-scroll">
          <div v-for="(item, index) in products" :key="index" @click="select(item.id)" :id="'product'+item.id" class="w-full bg-white px-4 py-[10px] text-[15px] mb-[2px] cursor-pointer hover:bg-[#f0f9ff] hover:border-[#188fcc] border-l-[4px]">{{ item.name }}</div>
        </div>
      </div>
      <div class="flex mt-8 w-fit ml-auto gap-x-4">
        <div class="cursor-pointer w-fit text-[14px] rounded-[5px] min-w-[200px] text-center px-4 py-2 text-black border" @click="clear()">Cancel</div>
        <div class="cursor-pointer w-fit text-[14px] rounded-[5px] min-w-[200px] text-center px-4 py-2 text-white bg-[#0046fe]" @click="submit()">Submit</div>
      </div>
    </div>
    <QuantityModal v-if="shown" @showModal="showModal" @sendQuantity="addProduct"/>
  </section>
</template>

<style scoped>
.multiple::-webkit-scrollbar {
  width: 0px;
}

.selected{
  border-color: #188fcc;
}
</style>

<script setup>
  import HeaderAdmin from '../components/HeaderAdmin.vue'
  import QuantityModal from '../components/QuantityModal.vue'
  import { ref, reactive, onMounted } from 'vue'
  import axios from 'axios'
  import { useHead } from '@vueuse/head'
  //module containing api url
  import config from '@/utils/config.js'

  useHead({
    title: 'Create a recipe',
  })

  const products = ref([])
  const selectedProducts = ref([])

  const recipe = reactive({
    name: '',
    products: []
  })

  const shown = ref(false)
  let currentId = 0

  const show = () => {
    shown.value = true
  }

  const showModal = (payload) => {
    shown.value = payload
    currentId = 0
  }

  const addProduct = (qte) => {
    shown.value = false
    if(currentId != 0){
      selectedProducts.value.push({
        id: currentId,
        quantity: parseInt(qte)
      })

      document.getElementById('product'+currentId).classList.add('selected')
    }
  }

  const removeProduct = (id) => {
    selectedProducts.value = selectedProducts.value.filter(item => item.id != id)
    document.getElementById("product"+id).classList.remove('selected')
  }
  
  const select = (id) => {
    const product = selectedProducts.value.find(item => item.id == id)

    if(product){
      currentId = 0
    }else{
      currentId = id
      show()
    }
  }

  const submit = async () => {
    if(recipe.name.trim().length == 0){
      alert('Name is required !')
      return
    }

    if(selectedProducts.value.length == 0){
      alert('Please select recipe products !')
      return
    }

    recipe.products = selectedProducts.value
    try{
      await axios.post(`${config.url}/api/recipe/create`, recipe, {
        headers: {
          'Accept': 'application/vnd.api+json',
          'Content-Type': 'application/vnd.api+json',
        }
      })
      
      alert('Recipe created successfully')
      clear()
    }catch(err){
      alert('Oops something went wrong !')
    }
  }

  const clear = () => {
    recipe.name = ''
    recipe.products = []
    selectedProducts.value.forEach((item) => {
      document.getElementById("product"+item.id).classList.remove('selected')
    })
    selectedProducts.value = []
  }

  onMounted(async () => {
    const response = await axios.get(`${config.url}/api/product/instock`, {
        headers: {
            'Accept': 'application/vnd.api+json',
            'Content-Type': 'application/vnd.api+json',
        }
    })

    products.value = response.data.products
  })
</script>