<script setup>
import {reactive} from 'vue'

const errors = reactive({
    hasError: false,
    list: []
})

const seller = reactive({
    name: '',
    email: '',
    address : '',
    password: '',
    shopTitle: '',
    lat: 0,
    lng: 0
})

async function createNewSeller(event) {

    resetError()
    try {
        await axios.post(
            'http://localhost:8000/api/app/admin/sellers/create',
            seller
        )
        this.$router.push({
            name : 'seller.products'
        });
    } catch (e) {
        displayErrors(e.response.data.errors)
    }
}


function resetError() {
    errors.hasError = false
    errors.list = []
}

function displayErrors(list) {
    errors.hasError = true
    errors.list = list
}

</script>

<template>

    <div v-if="errors.hasError" class="alert alert-danger" role="alert">
        <h4 v-for="(val) in errors.list">
            {{ val }}
        </h4>
    </div>

    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Email</label>
                <input v-model="seller.email" type="email" class="form-control" id="inputEmail4" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Password</label>
                <input v-model="seller.password" type="password" class="form-control" id="inputPassword4"
                       placeholder="Password">
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress">Name</label>
            <input v-model="seller.name" type="text" class="form-control" id="inputAddress" placeholder="">
        </div>

        <div class="form-group col-md-6">
            <label for="inputAddress2">Shop Title</label>
            <input v-model="seller.shopTitle" type="text" class="form-control" id="inputAddress2">
        </div>

        <div class="form-group col-md-6">
            <label for="inputAddress3">Shop Address</label>
            <input v-model="seller.address" type="text" class="form-control" id="inputAddress3" placeholder="">
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="lat">Latitude</label>
                <input v-model="seller.lat" type="number" class="form-control" id="lat">
            </div>
            <div class="form-group col-md-6">
                <label for="lng">Longitude</label>
                <input v-model="seller.lng" type="number" class="form-control" id="lng">
            </div>
        </div>
        <div class="form-group">
            <hr>
        </div>
        <button type="button" @click="createNewSeller" class="btn btn-primary">Create</button>
    </form>
</template>
