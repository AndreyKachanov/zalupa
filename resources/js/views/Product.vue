<template>
    <div v-if="hasProduct">
        {{ product }}
        <h1>{{ product.title }}</h1>
        <hr>
        <div class="alert alert-success">
            Price - {{ product.price }}
        </div>
    </div>
    <app-e404 v-else title="Product not found"></app-e404>
</template>

<script>
import AppE404 from '../components/E404';
import {mapGetters} from "vuex";
export default {
    name: "Product",
    components: {
        AppE404
    },
    created() {
        console.log(this.$route);
    },
    computed: {
        ...mapGetters('products', { productProxy: 'item' }),
        id(){
            return this.$route.params.id;
        },
        product(){
            return this.productProxy(this.id);
        },
        hasProduct() {
            return this.product !== undefined;
        }
    }
}
</script>

<style scoped>

</style>
