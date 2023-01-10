<template>
    <div>
        <h1 style="text-align: center">Контактная информация:</h1>
<!--        <pre>-->
<!--            {{ all }}-->
<!--        </pre>-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-10 offset-lg-1">
                    <div class="contact_info_container d-flex flex-lg-row flex-column justify-content-between align-items-between">

                        <!-- Contact Item -->
                        <div
                            class="contact_info_item d-flex flex-row align-items-center justify-content-start"
                            v-for="setting in settings"
                            :key="setting.prop_key"
                        >
                            <div class="contact_info_image">
                                <img src="https://img.icons8.com/office/24/000000/iphone.png" alt="">
<!--                                    src="https://img.icons8.com/office/24/000000/iphone.png"-->

                            </div>
                            <div class="contact_info_content">
                                <div class="contact_info_title">{{ setting.title }}</div>
                                <div class="contact_info_text">{{ setting.prop_value }}</div>
                            </div>
                        </div>

                        <!-- Contact Item -->
<!--                        <div class="contact_info_item d-flex flex-row align-items-center justify-content-start">-->
<!--                            <div class="contact_info_image"><img src="https://img.icons8.com/ultraviolet/24/000000/instagram.png" alt=""></div>-->
<!--                            <div class="contact_info_content">-->
<!--                                <div class="contact_info_title">Email</div>-->
<!--                                <div class="contact_info_text">contact@bbbootstrap.com</div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Contact Item &ndash;&gt;-->
<!--                        <div class="contact_info_item d-flex flex-row align-items-center justify-content-start">-->
<!--                            <div class="contact_info_image"><img src="https://img.icons8.com/ultraviolet/24/000000/map-marker.png" alt=""></div>-->
<!--                            <div class="contact_info_content">-->
<!--                                <div class="contact_info_title">Address</div>-->
<!--                                <div class="contact_info_text">298,Menlo Park,CA,USA</div>-->
<!--                            </div>-->
<!--                        </div>-->

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
        hasProductsInCart() {
            return this.cartCnt > 0;
        }
    },
    methods: {
        // ...mapActions('cart', ['setCnt', 'remove', 'setInvoiceNumber']),
        // ...mapActions('cart', ['setCnt', 'remove']),
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
    @media (max-width: 768px) {
        width: 100%;
    }

    width: calc((100% - 60px) / 3);
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
