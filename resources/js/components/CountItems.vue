<template>
    <div class="countItems" style="border: 1px solid red;">
<!--        <div>{{ cntInCart }}</div>-->
        <button @click="$emit('setCnt', this.countFromCart - 1)">-</button>
        {{ countFromCart }}
        <button  @click="$emit('setCnt', this.countFromCart + 1)">+</button>
<!--        {{ modelValue }}-->
<!--        <input-->
<!--            :value="test"-->
<!--            @input="$emit('test', $event.target.value)"-->
<!--        />-->
    </div>
</template>

<script>
export default {
    props: ['countFromCart'],
    // props: ['modelValue'],
    // emits: ['update:modelValue'],
    name: "CountCartItems",
    data: () => ({
        // cntInCart: 1,
        // cnt: 1
    }),
    methods: {
        // updateCnt() {
        //     // 1. вариант, когда событие мы называем как хотим
        //     this.test++;
        //     // console.log(e);
        //     // this.$emit('updatedCnt', { cnt: this.count, test: 'test'});
        //     this.$emit('cnt', this.test);
        // }
    },
    // created() {
    //     console.log(this.test);
    // }
}
</script>

<style scoped>

</style>
