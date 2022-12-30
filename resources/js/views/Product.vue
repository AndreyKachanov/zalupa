<template>
<!--<div v-if="hasProduct">-->
<div v-if="hasProductSlug">
<!--            <p>hasProductSlug</p>-->
<!--        {{ hasProductSlug }}-->
        {{ productSlug }}
        <h1>{{ productSlug.title }}</h1>
        <hr>
        <div class="alert alert-success">
            Price - {{ productSlug.price }}
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
        // console.log(this.$route);
    },
    computed: {
        ...mapGetters('products', { productProxy: 'item',  productProxySlug: 'itemSlug' }),
        id(){
            return this.$route.params.id;
        },
        slug(){
            return this.$route.params.slug;
        },
        product(){
            return this.productProxy(this.id);
        },
        productSlug(){
            // console.log(1234);
            return this.productProxySlug(this.slug);
        },
        hasProduct() {
            return this.product !== undefined;
        },
        hasProductSlug() {
            // console.log(123);
            return this.productSlug !== undefined;
        }
    }
}
</script>

<style scoped>

</style>
