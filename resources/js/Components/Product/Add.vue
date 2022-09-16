<script setup>
import {reactive} from 'vue'

const errors = reactive({
    hasError: false,
    list: []
})

const product = reactive({
    title: '',
    description: '',
    price: 0
})

async function createNewProduct(event) {

    resetError()
    try {
        await axios.post(
            'http://localhost:8000/api/app/seller/products/create',
            product
        )
        resetForm()
        alert('Product has been created')
    } catch (e) {
        displayErrors(e.response.data.errors)
    }
}

function resetForm() {
    product.description = ''
    product.title = ''
    product.price = 0
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

        <div class="form-group col-md-6">
            <label for="inputAddress">Name</label>
            <input v-model="product.title" type="text" class="form-control" id="inputAddress" placeholder="">
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress2">Shop Name</label>
            <input v-model="product.description" type="text" class="form-control" id="inputAddress2">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="lat">Price</label>
                <input v-model="product.price" type="number" class="form-control" id="lat">
            </div>
        </div>
        <div class="form-group">
            <hr>
        </div>
        <button type="button" @click="createNewProduct" class="btn btn-primary">Create</button>
    </form>
</template>
