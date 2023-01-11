<template>
    <h1 class="h1 text-center mb-4">Контактная информация</h1>
<!--            <pre>{{ settings }}</pre>-->
        <div class="row">
            <div
                class="col-sm-10 offset-sm-1 offset-md-0 col-md-6 col-lg-4"
                v-for="setting in settings"
                :key="setting.prop_key"
            >
                <div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
                    <div class="contact_info_image">
                        <i
                            :class="`${setting.fa_icon}`"
                            aria-hidden="true">
                        </i>
                    </div>
                    <div class="contact_info_content">
                        <div class="contact_info_title">{{ setting.title }}</div>
                        <div class="contact_info_text">
                            <a v-if="setting.is_url" target="_blank" :href="`${setting.prop_value}`">{{ setting.prop_value }}</a>
                            <span v-else>{{ setting.prop_value }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
export default {
    name: "Contacts",
    components: {
    },
    computed: {
        ...mapGetters('settings', {
            settings: 'allSettings'

        }),
        // hasProductsInCart() {
        //     return this.cartCnt > 0;
        // }


    },
    methods: {
    }
}
</script>

<style lang="scss">

.contact_info
{
    width: 100%;
    padding-top: 70px;
}
.contact_info_item {
    margin-bottom: 20px;
    //@media (max-width: 768px) {
    //    width: 100%;
    //}

    //width: calc((100% - 60px) / 3);
    height: 100px;
    border: solid 1px #e8e8e8;
    box-shadow: 0px 1px 5px rgba(0,0,0,0.1);
    padding-left: 32px;
    padding-right: 15px;


}
.contact_info_image
{
    width: 35px;
    height: 35px;
    text-align: center;
    i {
        color: red;
    }
}
.contact_info_image img
{
    max-width: 100%;
}
.contact_info_content
{
    padding-left: 17px;
}
.contact_info_title
{
    font-weight: 500;
}
.contact_info_text
{
    font-size: 12px;
    color: rgba(0,0,0,0.5);
}
</style>
