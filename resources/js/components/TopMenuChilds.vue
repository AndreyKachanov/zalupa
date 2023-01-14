<template>
<!--    <ul class="list-group">-->
    <div class="container-fluid top-menu">
        <div class="row">
            <div class="col-12 parent">
                    {{ parentTitle }}
            </div>
                <router-link
                    class="child col-6"
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
