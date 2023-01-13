<template>
    <ul class="list-group">
        <router-link
            v-for="category in categories"
            :key="category.route"
            :to="`/category/${category.slug}`"
            v-slot="{ route, isExactActive, navigate }"
            :custom="true">
            <li class="list-group-item" :class="isExactActive ? 'active' : ''">
                <a :href="route.fullPath" @click="navigate">{{ category.title }}</a>
            </li>
        </router-link>
    </ul>
</template>

<script>
export default {
    name: "TopMenu",
    props: ['categories'],
}
</script>

<style scoped>

</style>
