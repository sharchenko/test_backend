require('../bootstrap')
import Vue from 'vue/dist/vue.min'
import GroupOrder from './group-order.vue'
import {connection} from "./connection";

Vue.prototype.$http = window.axios
Vue.prototype.$conn = connection

new Vue({
    el: '#group-order-root',
    components: {
        GroupOrder
    },
    template: '<group-order/>'
})