<template>
    <div class="w-full h-screen fixed top-0 left-0 bg-[#0000004d] flex items-center justify-center">
        <div class="bg-white w-full max-w-[400px] rounded-lg shadow relative dark:bg-gray-700">
            <div class="flex justify-end p-2">
                <button @click="show(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>
            <div class="space-y-6 px-6 lg:px-8 pb-4 sm:pb-6 xl:pb-8">
                <h3 class="text-xl font-medium text-gray-900">Quantity</h3>
                <div class="my-4">
                    <label for="" class="text-[14px]">Product quanity</label>
                    <input type="number" placeholder="Quantity" min="1" v-model="quantity" class="w-full border h-fit text-[15px] px-4 py-2 rounded-md bg-[#f0f0f041] mt-2 outline-none">
                </div>

                <div @click="submitQuantity()" class="cursor-pointer w-full text-[14px] rounded-[5px] min-w-[200px] text-center px-4 py-2 text-white bg-[#0046fe]">Submit</div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    const quantity = ref('1')
    const emit = defineEmits()

    const show = (val) => {
        emit('showModal', val)
    }

    const submitQuantity = () => {
        if(isNaN(quantity.value) || quantity.value == ''){
            alert('Quantity isn\'t valid !')
            return
        }
        emit('sendQuantity', quantity.value)
    }
</script>