<template>
<!--    <div class="countItems">-->
<!--        <button @click="$emit('setCnt', this.countFromCart - 1)">-</button>-->
<!--        <span class="ml-1 ml-sm-2 mr-sm-2 mr-1">{{ countFromCart }}</span>-->
<!--        <button  @click="$emit('setCnt', this.countFromCart + 1)">+</button>-->
<!--    </div>-->
    <div class="input-group">
        <span class="input-group-prepend">
            <button @click="$emit('setCnt', this.countFromCart - 1)" type="button" class="btn btn-outline-secondary btn-number">
                <span class="fa fa-minus"></span>
            </button>
        </span>
        <input
            onkeyup="if(value <= 0) value = 1; if(value >= 65536) value = 65535;"
            type="number"
            class="pt-0 pb-0 form-control input-number"
            :value="countFromCart" style="text-align: center; height: auto"
            @change="onInput"
        >
        <span class="input-group-append">
             <button @click="$emit('setCnt', this.countFromCart + 1)" type="button" class="btn btn-outline-secondary btn-number">
                <span class="fa fa-plus"></span>
            </button>
        </span>
    </div>


</template>

<script>
export default {
    props: ['countFromCart'],
    name: "CountCartItems",
    data: () => ({

    }),
    methods: {
        onInput(e) {
            let cnt = Math.max(1, parseInt(e.target.value));
            // Math.max(1, newCnt);
            // console.log('cnt=', cnt);
            this.$emit('setCnt', cnt);
            // console.log(countFromCart);
        },
    },
}
</script>

<style lang="scss">
    .input-group {
        @include media-breakpoint-down(xs) {
            button {
                line-height: 0 !important;
            }
            //border: 1px solid red;
            .fa {
                line-height: 0 !important;
            }
            .fa:before {
                font-size: 8px;
            }
            input[type='number'] {
                padding-left: 0;
                padding-right: 0;
                line-height: 2.2 !important;
                font-size: 8px;
            }
        }
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
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
