<template>
    <div class='group-order'>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#group-menu" data-toggle="tab">Меню</a></li>
            <li><a href="#my-order" data-toggle="tab">Мой заказ</a></li>
            <li><a href="#group-order" data-toggle="tab">Общий заказ</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="group-menu">
                <div class="panel" v-for="category in menu" :key="'category_' + category.id">
                    <div class="panel-heading">
                        <div class="panel-title"><h2>{{category.name}}</h2></div>
                    </div>
                    <div class="panel-body">
                        <div class="row dish" v-for="dish in category.dishes" :key="'dish_' + dish.id">
                            <div class="col-md-6">
                                <h4>{{dish.name}}</h4>
                                <div>
                                    <small>
                                        {{dish.description}}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-2"><em>{{dish.price}} $</em></div>
                            <div class="col-md-2">
                                <div class="btn-group btn-group-sm group-control" v-if="dishes.indexOf(dish.id) !== -1">
                                    <button class="btn" @click="action('decrement', dish.id)">-</button>
                                    <button class="btn btn-info">{{getCount(dish.id)}}</button>
                                    <button class="btn" @click="action('increment', dish.id)">+</button>
                                    <button class="btn btn-danger" @click="action('remove', dish.id)">Удалить</button>
                                </div>
                                <button class="btn btn-primary btn-sm" @click="action('append', dish.id)" v-else>Добавить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="my-order">
                <h4 v-if="selfOrder">Всего: {{selfSummary}} $</h4>
                <div class="row dish" v-for="model in selfOrder">
                    <div class="col-md-8">
                        {{model.name}}
                    </div>
                    <div class="col-md-2">{{model.count}} x {{model.price}} = {{model.count*model.price}} $</div>
                    <div class="col-md-2">
                        <div class="btn-group btn-group-sm group-control">
                            <button class="btn" @click="action('decrement', model.dish_id)">-</button>
                            <button class="btn btn-info">{{model.count}}</button>
                            <button class="btn" @click="action('increment', model.dish_id)">+</button>
                            <button class="btn btn-danger" @click="action('remove', model.dish_id)">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="group-order">
                <h4 v-if="summaryOrder">Всего: {{orderSummary}} $</h4>
                <div class="row dish" v-for="model in summaryOrder">
                    <div class="col-md-10">
                        {{model.name}}
                    </div>
                    <div class="col-md-2">{{model.count}} x {{model.price}} = {{model.count*model.price}} $</div>
                </div>
                <div class="row dish" v-if="canSend && summaryOrder && summaryOrder.length">
                    <div class="col-md-12 clearfix">
                        <a :href="'/order/send?group_id=' + $conn.groupId">
                            <button class="btn btn-success pull-right">Отправить заказ</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'group-order',
        data: function () {
            return {
                menu: null,
                selfOrder: null,
                summaryOrder: null,
                canSend: null
            }
        },
        computed: {
            dishes() {
                return this.selfOrder.map(m => m.dish_id)
            },
            selfSummary() {
                return this.selfOrder.reduce((value, m) => value + m.count * m.price, 0)
            },
            orderSummary() {
                return this.summaryOrder.reduce((value, m) => value + m.count * m.price, 0)
            }
        },
        methods: {
            getCount(id) {
                let model = this.selfOrder.find(m => m.dish_id === id);
                return model ? model.count : 0;
            },
            action(action, dish_id) {
                this.$conn.push({
                    action,
                    params: {
                        dish_id
                    }
                })
            }
        },
        created() {
            this.$conn.on('message', (event, data) => {
                if (data) {
                    this.menu = data.menu || this.menu
                    this.selfOrder = data.selfOrder || this.selfOrder
                    this.summaryOrder = data.summaryOrder || this.summaryOrder
                    this.canSend = data.canSend || this.canSend
                }
            })
            this.$conn.connect()
        }
    }
</script>

<style lang="scss">
    .group-control {
        margin-top: 10px;
    }

    .row.dish {
        border-bottom: 1px dotted gray;
        padding-bottom: 5px;
        padding-top: 5px;
        &:last-child {
            border-bottom: none;
        }
    }
</style>