<script setup>
import {ref, onMounted} from 'vue'
const sellers = ref()
onMounted(async () => {
    let res = await axios('http://localhost:8000/api/app/admin/sellers');
    sellers.value = res.data.data
})
</script>

<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Seller Name</th>
            <th scope="col">Shop Name</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="seller in sellers">
            <th scope="row">{{ seller.id }}</th>
            <td>{{ seller.name }}</td>
            <td>{{ seller.shop }}</td>
        </tr>
        </tbody>
    </table>
</template>
