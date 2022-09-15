<script setup>
import {ref, onMounted} from 'vue'

const products = ref()
onMounted(async () => {
    let res = await axios('http://localhost:8000/api/app/seller/products');
    products.value = res.data.data
})
</script>

<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Product</th>
            <th scope="col">Price($)</th>
            <th scope="col">Description</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="product in products">
            <td>{{ product.title }}</td>
            <td>{{ product.price.toLocaleString() }}</td>
            <td>{{ product.description }}</td>
        </tr>
        </tbody>
    </table>
</template>
