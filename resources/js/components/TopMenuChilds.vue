<template>
<!--    <ul class="list-group">-->
    <div class="container-fluid top-menu">
        <div class="row">
            <div class="col-8 offset-2 parent">
                <p>
                    {{ parentTitle }}
                </p>
            </div>
                <router-link
                    class="child col-4 offset-2 btn btn-success"
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

<style lang="scss">
    .top-menu {
        .parent {
            border: 1px solid red;
            text-align: center;
        }
        .child {
            &:nth-child(odd) {
                margin-left: 0 !important;
            }
        }
    }
</style>
