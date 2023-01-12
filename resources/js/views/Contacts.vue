<template>
    <h1 class="h1 text-center mb-4">Контактная информация</h1>
        <div class="row">
            <div
                class="col-sm-10 offset-sm-1 offset-md-0 col-md-6 col-lg-4"
                v-for="setting in settings"
                :key="setting.prop_key"
            >
                <div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
                    <div class="contact_info_image">
                        <i
                            :class="`${setting.fa_icon} fa-2x`"
                            aria-hidden="true">
                        </i>
                    </div>
                    <div class="contact_info_content">
                        <div class="contact_info_title">{{ setting.title }}</div>
                        <div class="contact_info_text">
<!--                            {{ this.isUrl(setting.prop_value) }}-->
                            <a v-if="this.isUrl(setting.prop_value)" target="_blank" :href="`${setting.prop_value}`">
                                {{ setting.prop_value }}
                            </a>
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
    },
    methods: {
        isUrl(str) {
            // console.log(str);
            // let pattern = /^[a-zA-Z0-9]{2,30}$/;
            // return pattern.test(str);
            let pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
            '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
            return !!pattern.test(str)
        },
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
