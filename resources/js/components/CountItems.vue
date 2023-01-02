<template>
    <div class="countItems">
        <button @click="$emit('setCnt', this.countFromCart - 1)">-</button>
        <span class="ml-2 mr-2">{{ countFromCart }}</span>
        <button  @click="$emit('setCnt', this.countFromCart + 1)">+</button>
    </div>
</template>

<script>
export default {
    props: ['countFromCart'],
    name: "CountCartItems",
    data: () => ({

    }),
    methods: {

    },
}
</script>

<style scoped>

</style>
