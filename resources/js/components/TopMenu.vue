<template>
<!--    <ul class="list-group">-->
    <div class="row">
        <div class="col-6"></div>
    </div>
    <div>
        <router-link
            v-for="category in categories"
            :key="category.route"
            :to="`/category/${category.slug}`"
            v-slot="{ route, isExactActive, navigate }"
            :custom="true">

<!--            <button :class="isExactActive ? 'active' : ''">-->
                <a style="display: block" class="btn btn-danger" :class="isExactActive ? 'active' : ''" :href="route.fullPath" @click="navigate">
                    {{ category.title }}
                </a>
<!--            </button>-->
<!--            <li class="list-group-item" :class="isExactActive ? 'active' : ''">-->
<!--                <a :href="route.fullPath" @click="navigate">{{ category.title }}</a>-->
<!--            </li>-->
        </router-link>
    </div>
<!--    </ul>-->
</template>

<script>
export default {
    name: "TopMenu",
    props: ['categories'],
}
</script>

<style scoped>

</style>
