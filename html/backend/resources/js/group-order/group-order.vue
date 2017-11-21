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
                            <div class="col-md-8">
                                <h4>{{dish.name}}</h4>
                                <div>
                                    <small>
                                        {{dish.description}}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-2"><em>{{dish.price}} $</em></div>
                            <div class="col-md-2">
                                <div class="btn-group btn-group-sm group-control">
                                    <button class="btn">-</button>
                                    <button class="btn btn-info">0</button>
                                    <button class="btn">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="my-order">coming soon...</div>
            <div class="tab-pane" id="group-order">coming soon...</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'group-order',
        data: function () {
            return {
                menu: null
            }
        },
        created() {
            this.$conn.on('message', (event, data) => {
                if (data && data.menu) {
                    this.menu = data.menu
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
        &:last-child {
            border-bottom:none;
        }
    }
</style>