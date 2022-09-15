<script setup>
import {ref, onMounted} from 'vue'

const products = ref()
onMounted(async () => {
    let res = await axios('http://localhost:8000/api/app/customer/products');
    products.value = res.data.data
})

async function purchaseThisProduct(product) {

    let url = `http://localhost:8000/api/app/customer/products/purchase/${product.id}`

    try {
        await axios.post(
            url
        )
        alert('Product has been purchased')
    } catch (e) {

    }

}

</script>

<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Product</th>
            <th scope="col">Price($)</th>
            <th scope="col">Shop Name</th>
            <th scope="col">Description</th>
            <th scope="col">Buy</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="product in products">
            <td>{{ product.title }}</td>
            <td>{{ product.price.toLocaleString() }}</td>
            <td>{{ product.shopName }}</td>
            <td>{{ product.description }}</td>
            <td>
                <button @click="purchaseThisProduct(product)" type="button" class="btn btn-primary">Buy</button>
            </td>
        </tr>
        </tbody>
    </table>
</template>
