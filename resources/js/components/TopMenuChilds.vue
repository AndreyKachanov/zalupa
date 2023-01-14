<template>
<!--    <ul class="list-group">-->
    <div class="container">
        <div class="row">
            <div class="col-12">{{ parentTitle }}</div>
                <router-link
                    class="col-6 btn btn-success"
                    v-for="category in categories"
                    :key="category.route"
                    :to="`/category/${category.slug}`"> {{ category.title }}
                </router-link>
        </div>
    </div>

<!--    </ul>-->
</template>

<script>
export default {
    name: "TopMenuChilds",
    props: ['categories', 'parentTitle'],
}
</script>

<style scoped>

</style>
