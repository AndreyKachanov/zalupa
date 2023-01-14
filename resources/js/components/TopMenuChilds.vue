<template>
<!--    <ul class="list-group">-->
    <div class="container">
        <div class="row">
            <a class="col-12 btn btn-success" href="#">{{ parent }}</a>
<!--            <pre>{{ categories }}</pre>-->
                <router-link
                    class="col-6 btn btn-success"
                    v-for="category in categories"
                    :key="category.route"
                    :to="`/category/${category.slug}`"> {{ category.title }}
                    <!--            <li class="list-group-item" :class="isExactActive ? 'active' : ''">-->
                    <!--                <a :href="route.fullPath" @click="navigate">{{ category.title }}</a>-->
                    <!--            </li>-->
                </router-link>
        </div>
    </div>

<!--    </ul>-->
</template>

<script>
export default {
    name: "TopMenuChilds",
    props: ['categories', 'parent'],
}
</script>

<style scoped>

</style>
