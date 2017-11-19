require('../bootstrap')
import Vue from 'vue/dist/vue.min'
import GroupOrder from './group-order.vue'

Vue.prototype.$http = window.axios

new Vue({
    el: '#group-order-root',
    components: {
        GroupOrder
    },
    template: '<group-order/>'
})