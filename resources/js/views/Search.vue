<template>
        <div class="search_bar">
            <input type="text" v-model="search" placeholder="Поиск товаров..." />

            <div class="item fruit" v-for="product in filteredProducts" :key="product.id">
                <p>{{ product.name }}</p>
            </div>
            <div class="item error" v-if="search&&!filteredProducts.length">
                <p>No results found!</p>
            </div>
        </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
    name: "Search",
    data: () => ({
        products: [
            {id: 1, name: "Foo"},
            {id: 2, name: "Bar"},
            {id: 3, name: "Baz"},
            {id: 4, name: "Foobar"}
        ],
        search: ''
    }),
    components: {
    },
    mounted() {
    },
    created() {
    },

    computed: {
        filteredProducts() {
            return this.products.filter(p => {
                // return true if the product should be visible

                // in this example we just check if the search string
                // is a substring of the product name (case insensitive)
                return p.name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1;
            });
        }
    },
    methods: {
    }
}
</script>

<style lang="scss">
    .search_bar {
        input {
            display: block;
            width: 350px;
            margin: 20px auto;
            padding: 10px 45px;
            //background: white url("assets/search-icon.svg") no-repeat 15px center;
            background-size: 15px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px,
            rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
        }

        .item {
            width: 350px;
            margin: 0 auto 10px auto;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px,
            rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
        }

        .fruit {
            background-color: rgb(97, 62, 252);
            cursor: pointer;
        }

        .error {
            background-color: tomato;
        }
    }
</style>
