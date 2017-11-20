require('../bootstrap')
import Vue from 'vue/dist/vue'
import GroupOrder from './group-order.vue'
import {Connection} from "./connection";

Vue.prototype.$http = window.axios
Vue.prototype.$conn = new Connection()
Vue.prototype.$conn.on('message', function (event, data) {
    console.log(data)
})

new Vue({
    el: '#group-order-root',
    components: {
        GroupOrder
    },
    template: '<group-order/>'
})