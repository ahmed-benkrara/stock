<template>
    <section class="h-fit min-h-screen pb-[50px] w-[calc(100%-250px)] ml-auto px-[50px] pt-[30px]">
      <HeaderAdmin title="Recipes" subtitle="Recipe validation" />
      <div class="mt-[50px] mb-[20px] w-fit cursor-pointer">
          <h1 class="text-[14px] font-[600] w-fit">All recipes</h1>
          <div class="w-full h-[2px] bg-[#0046fe] rounded-lg"></div>
      </div>
      <div class="w-full font-poppins overflow-x-scroll noscroll">
          <table class="w-full table-auto min-w-[700px] border-separate border-spacing-y-4" >
            <thead class="bg-[#f9f9f9]">
                <tr class="*:text-left *:font-[600] text-[13px] *:py-2 *:px-4">
                    <th class="rounded-l-lg">Id</th>
                    <th>Recipe name</th>
                    <th>Ingredients</th>
                    <th>Missing Ingredients</th>
                    <th>Status</th>
                    <th class="rounded-r-lg">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in recipes.slice(start, end)" :key="index" class="*:py-4 *:px-4 font-[500] text-[14px]">
                    <td class="font-[600]">{{ index+1 }}</td>
                    <td>{{ item.recipe.name }}</td>
                    <td>
                        <span v-for="(product, index) in item.recipe.ingredients" :key="index"> {{ `${product.pivot.quantity} ${product.name}` }} <span v-if="index < item.recipe.ingredients.length-1">, </span></span>
                    </td>
                    <td>
                        <span v-if="item.isValid == false">{{ item.missingIngredients.join(', ') }}</span>
                        <p v-else>-</p>
                    </td>
                    <td>
                        <div v-if="item.isValid" class="flex items-center">
                            <div class="bg-[#b8e1d1] rounded-full size-[12px] flex items-center justify-center"><div class="size-[6px] bg-[#2cbf70] rounded-full"></div></div>
                            <span class="text-[#2cbf70] text-[13px] ml-1">can make</span>
                        </div>

                        <div v-if="!item.isValid"  class="flex items-center">
                            <div class="bg-[#e2c8ca] rounded-full size-[12px] flex items-center justify-center"><div class="size-[6px] bg-[#d55e56] rounded-full"></div></div>
                            <span class="text-[#d55e56] text-[13px] ml-1">can't make</span>
                        </div>
                    </td>
                    <td>
                        <div @click="validate(item.recipe.id, item.isValid)" class="text-[#262b45] font-[600] cursor-pointer text-[13px] ml-1"><i class="fa-solid fa-utensils mr-2"></i>Cook</div>
                    </td>
                </tr>
            </tbody>
          </table>
      </div>
      <div class="flex items-center justify-between">
        <p class="text-[14px]">Showing {{ start+1 }}-{{ end > recipes.length ? recipes.length : end }} of {{ recipes.length }} </p>
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
  import { onMounted, ref } from 'vue'
  import axios from 'axios'
  //module containing api url
  import config from '@/utils/config.js'
  import { useHead } from '@vueuse/head'

  useHead({
    title: 'Validation',
  })

  const recipes = ref([])
  const start = ref(0)
  const perpage = ref(10)
  const end = ref(perpage.value)

  onMounted(async () => {
    await loadData()
  })

  const loadData = async () => {
    try{
        const response = await axios.get(`${config.url}/api/recipe/all`, {
            headers: {
                'Accept': 'application/vnd.api+json',
                'Content-Type': 'application/vnd.api+json',
            }
        })
        
        recipes.value = response.data.recipes
    }catch(err){
        alert('Oops something went wrong !')
    }
  }

  const next = () => {
    if(recipes.value.length > end.value){
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

  const validate = async (id, valid) => {
    if(!valid){
        alert('Recipe isn\'t valid !')
        return 
    }
    try{
        await axios.post(`${config.url}/api/recipe/validate`, {id}, {
            headers: {
            'Accept': 'application/vnd.api+json',
            'Content-Type': 'application/vnd.api+json',
            }
        })
        await loadData()
        alert('Recipe validated successfully')
    }catch(err){
        alert('Oops something went wrong !')
    }
  }
</script>

<style scoped>
    .noscroll::-webkit-scrollbar {
        width: 0px;
    }
</style>