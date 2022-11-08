<template>
    <div style="border: 1px solid red;">
        <h1>{{ title }}</h1>
        <hr>
        Start from <router-link :to="{name: 'catalog'}">main page</router-link>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: "Page not found"
        }
    }
}
</script>

<style scoped>

</style>
