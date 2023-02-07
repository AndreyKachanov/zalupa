<template>
    <div class="container top-menu-main">
        <div v-if="parentTitle.length > 0" class="row justify-content-between mb-3">
            <div class="col-12 parent">
                {{ parentTitle }}
            </div>
        </div>
        <div v-if="categories.length > 0" class="front-category-grid front-category-grid">

                <ul>
                    <router-link
                        v-for="category in categories"
                        :key="category.route"
                        :to="`/category/${category.slug}`"
                        v-slot="{ route, isExactActive, navigate }"
                        :custom="true">
                        <li :class="isExactActive ? 'active' : ''">
                            <a :href="route.fullPath" @click="navigate">
                                <div>
                                    <div class="category-cart text-center">
                                        <div class="img-container">
                                            <img :src="getImg(category)" class="img-responsive" alt="">
                                        </div>
                                        <label>{{ category.title }}</label>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </router-link>
                </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "MainMenu",
    props: ['categories', 'parentTitle'],
    methods: {
        getImg(category) {
            return category.img === null ? '/assets/no-image.png' : category.img;
        }
    }
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
    }
    .child {
        text-align: center;
        display: block;
        color: #000000;
        font-weight: 700;
        text-decoration: none;
        user-select: none;
        padding: 1em 2em;
        outline: none;
        border: 2px solid #c1034a;
        border-radius: 1px;
        transition: 0.2s;
        word-break: break-all;
        &:hover {
        }
        &:nth-child(odd) {
        }
    }
}
.top-menu-main {
    .row-bottom-20 {
        margin-bottom: 20px;
    }

    label {
        font-size: 14px;
        font-weight: 400;
        @include media-breakpoint-down(xs) {
            font-size: 11px;
        }
        &:hover {
            cursor: pointer;
        }
    }

    .front-category-grid ul {
        display: grid;
        grid-gap: 15px 15px;
        padding: 10px;
        grid-template-columns: repeat(4, 2fr);

        @include media-breakpoint-down(md) {
            grid-template-columns: repeat(2, 2fr);
        }
        @include media-breakpoint-down(sm) {
            grid-template-columns: repeat(2, 1fr);
            padding: 0 10px;
        }
    }

    ul li {
        list-style: none;
    }

    .category-cart {
        margin: 0 auto;
        background: #fff;
        border-radius: 12px;
        padding-top: 10px;
    }

    .img-container {
        @include media-breakpoint-down(sm) {
            width: 100%;
        }

        img {
            width: 225px;
            height: 225px;
            @include media-breakpoint-down(sm) {
                width: 180px;
                height: 180px;
            }

            @include media-breakpoint-down(xs) {
                width: 150px;
                height: 165px;
            }
        }
        max-width: 255px;
        margin: 10px auto;
    }

    //.child {
    //    text-align: center;
    //    display: block;
    //    color: #000000;
    //    //background-color: #454545;
    //    font-weight: 700;
    //    text-decoration: none;
    //    user-select: none;
    //    padding: 1em 2em;
    //    outline: none;
    //    border: 2px solid #c1034a;
    //    border-radius: 1px;
    //    transition: 0.2s;
    //    word-break: break-all;
    //    &:hover {
    //        //background: #454545bf;
    //    }
    //    &:nth-child(odd) {
    //        //margin-left: 0 !important;
    //    }
    //}
}
</style>
