<template>
    <div class="countItems">
        <button @click="$emit('setCnt', this.countFromCart - 1)">-</button>
        <span class="ml-1 ml-sm-2 mr-sm-2 mr-1">{{ countFromCart }}</span>
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

<style lang="scss">
    .countItems {
        display: flex;
        align-items: center;

        button, span {
            font-size: 12px;
            @include media-breakpoint-down(xs) {
                font-size: 10px;
            }
        }

        button {
            width: 24px;
            @include media-breakpoint-down(xs) {
                width: 20px;
            }
        }
    }
</style>
