<template>
    <div class="menu">
        <div v-if="parentTitle.length > 0" class="row justify-content-between mb-3">
            <div class="col-12 parent-title">
                {{ parentTitle }}
            </div>
        </div>
        <ul v-if="categories.length > 0">
            <router-link
                v-for="category in categories"
                :key="category.route"
                :to="`/category/${category.slug}`"
                v-slot="{ route, isExactActive, navigate }"
                :custom="true">
                <li :class="isExactActive ? 'active' : ''">
                    <a :href="route.fullPath"
                       @click="navigate">
                        <div class="img-container">
                            <img :src="getImg(category)" class="img-responsive" alt="">
                        </div>
                        <label>{{ category.title }}</label>
                    </a>
                </li>
            </router-link>
        </ul>
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
    .menu {
        .parent-title {
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
        ul {
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            //align-items: stretch;
            gap: .5rem;

            li {
                flex: 0 0 calc(16.66% - 20px);
                //@include media-breakpoint-down(xs) {
                //    flex: 0 0 calc(40% - 20px);
                //}
                list-style: none;
                height: 260px;
                @include media-breakpoint-down(md) {
                    height: 210px;
                }
                @include media-breakpoint-down(sm) {
                    height: 200px;
                }
                @include media-breakpoint-down(xs) {
                    height: 195px;
                }
                a {
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    height: 100%;
                    margin: 0 auto;
                    background: #fff;
                    border-radius: 12px;
                    text-align: center;

                    &:hover {
                        text-decoration: none;
                    }

                    .img-container {
                        padding: 13px 20px 0 20px;
                        img {

                            width: 160px;

                            @include media-breakpoint-down(md) {
                                width: 110px;
                            }

                            //@include media-breakpoint-down(sm) {
                            //    width: 120px;
                            //}
                            @include media-breakpoint-down(xs) {
                                width: 110px;
                            }
                        }

                    }

                    label {
                        margin-top: 10px;
                        padding: 0 6px;
                        font-size: 14px;
                        font-weight: 400;
                        @include media-breakpoint-down(xs) {
                            font-size: 13px;
                        }
                        &:hover {
                            color: #1b1e21;
                            cursor: pointer;
                        }
                    }
                }
            }
        }
    }
</style>
