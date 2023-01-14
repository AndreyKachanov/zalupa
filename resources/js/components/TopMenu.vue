<template>
<!--    <ul class="list-group">-->
<!--        <router-link-->
<!--            v-for="category in categories"-->
<!--            :key="category.route"-->
<!--            :to="`/category/${category.slug}`"-->
<!--            v-slot="{ route, isExactActive, navigate }"-->
<!--            :custom="true">-->
<!--            <li class="list-group-item" :class="isExactActive ? 'active' : ''">-->
<!--                <a :href="route.fullPath" @click="navigate">{{ category.title }}</a>-->
<!--            </li>-->
<!--        </router-link>-->
<!--    </ul>-->
    <div class="container-fluid top-menu">
        <div class="row">
            <router-link
                class="child col-6"
                v-for="category in categories"
                :key="category.route"
                :to="`/category/${category.slug}`"> {{ category.title }}
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "TopMenu",
    props: ['categories'],
}
</script>

<style lang="scss">
.top-menu {
    .parent {
        text-align: center;
        display: block;
        color: white;
        font-weight: 700;
        text-decoration: none;
        user-select: none;
        padding: 1em 2em;
        border: 1px solid;
        border-radius: 1px;
        word-break: break-all;
        background-color: #c1034a;
        //&:hover {
        //    background: #c4205c;
        //}
    }
    .child {
        text-align: center;
        display: block;
        color: white;
        background-color: #454545;
        font-weight: 700;
        text-decoration: none;
        user-select: none;
        padding: 1em 2em;
        outline: none;
        border: 1px solid;
        border-radius: 1px;
        transition: 0.2s;
        word-break: break-all;
        &:hover {
            background: #454545bf;
        }
        &:nth-child(odd) {
            //margin-left: 0 !important;
        }
    }
}
</style>
