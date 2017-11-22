require('../bootstrap')
import Vue from 'vue/dist/vue'
import GroupOrder from './group-order.vue'
import {Connection} from "./connection";

Vue.prototype.$http = window.axios
Vue.prototype.$conn = new Connection()
window.conn = Vue.prototype.$conn

new Vue({
    el: '#group-order-root',
    components: {
        GroupOrder
    },
    template: '<group-order/>'
})