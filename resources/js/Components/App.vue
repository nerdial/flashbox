<script setup>

import {onMounted, reactive} from 'vue'

let user = reactive({
    name: '',
    role: null
})

onMounted(async () => {
    let res = await axios('http://localhost:8000/api/app/user');
    user.role = res.data.data.role
    user.name = res.data.data.name
})

</script>
<style>
.menu a {
    margin-left: 20px
}
</style>

<template>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container menu">
                <router-link :to="{name : 'home'}" class="navbar-brand" href="/app">Home</router-link>
                <div v-if="user.role === 'admin'">
                    <router-link
                        :to="{name : 'admin.sellers'}">Seller List
                    </router-link>
                    <router-link
                        :to="{name : 'admin.sellers.add'}"
                    >Add New Seller
                    </router-link>
                </div>

                <div v-else-if="user.role === 'seller'">
                    <router-link
                        :to="{name: 'seller.products'}"
                    >Product List
                    </router-link>
                    <router-link :to="{name: 'seller.products.add'}">
                        Add New Product
                    </router-link>
                </div>

                <div v-else>

                    <router-link :to="{
                        name: 'customer.productList'
                    }">All Nearby Products</router-link>
                </div>

                <router-link style="margin-left: 20px" to="sellers">Logout</router-link>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        {{ user.name }} ({{ user.role }})
                    </ul>
                </div>
            </div>
        </nav>

        <hr>

        <div class="row">
            <router-view/>
        </div>

    </div>


</template>
