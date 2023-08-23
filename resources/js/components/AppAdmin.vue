<template @click="test123">
    <div>
        <h3 class="text-center">Заказы из {{ category.title }}</h3>
        <vue-good-table
            :columns="columns"
            :rows="rows"
            theme="polar-bear"
            :search-options="{
                enabled: true
            }"
        />
    </div>
</template>

<script>
    import moment from 'moment';
export default {
    props: {
        category: Object
    },
    components: {
    },
    data: () => ({
        columns: [
            {
                label: 'Дата',
                field: 'createdAt',
                type: 'date',
                formatFn: function (value) {
                    return value != null ? moment(value).format('DD.MM.YYYY') : null
                }
            },
            {
                label: 'Название',
                field: 'itemTitle',
            },
            {
                label: 'Цена',
                field: 'itemPrice',
            },
            {
                label: 'Кол-во',
                field: 'itemCnt',
                type: 'number'
            },
            {
                label: 'Сумма',
                field: 'orderTotal',
                type: 'number'
            },
            {
                label: 'Имя',
                field: 'contactName',
            },
            {
                label: 'Телефон',
                field: 'contactPhone',
                sortable: false
            },
        ],
    }),
    computed: {
        rows() {
            return this.category.orders.map((order, index) => {
                const { item, contact } = order;
                return {
                    'createdAt': order.created_at,
                    'itemTitle': item.title,
                    'itemPrice': item.price,
                    'itemCnt': order.cnt,
                    'orderTotal': item.price * order.cnt,
                    'contactName': contact ? contact.name : '',
                    'contactPhone': contact ? contact.phone : ''
                };
            });
        },
    },
    methods: {
    }
}
</script>

<style scoped>
</style>
