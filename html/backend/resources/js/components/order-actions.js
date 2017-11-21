/* global $, axios */

let append = {}

$('*[data-action="append"]').click(function () {
    let id = $(this).data('id');
    if (append[id]) return
    append[id] = true

    axios.get('/order/append', {
        params: {
            id
        }
    }).then(
        response => {
            let count = response.data.currentCount;
            $(this).remove()
            $('#order-indicator a').html(`Заказ <span class="label label-${count ? 'success' : 'warning'}">${count}</span>`)
        },
        error => {
            append[id] = false
            console.log(error.message)
        }
    )
})

let remove = {}

$('*[data-action="remove"]').click(function () {
    let id = $(this).data('id');
    if (remove[id]) return
    remove[id] = true

    axios.get('/order/remove', {
        params: {
            id
        }
    }).then(
        response => {
            let count = response.data.currentCount
            if (count) {
                $(this).closest('tr').remove()
            } else {
                $(this).closest('table').parent().html('<h4>Вы еще ничего не заказали, перейдите в <a href="/">меню</a>, чтобы сделать заказ.</h4>\n')
            }
            $('#order-indicator a').html(`Заказ <span class="label label-${count ? 'success' : 'warning'}">${count}</span>`)

        },
        error => {
            remove[id] = false
            console.log(error.message)
        }
    )
})

let changeCount = {}

$('*[data-action="changeCount"]').click(function () {
    let element = $(this);
    let id = element.data('id');
    if (changeCount[id]) return
    changeCount[id] = true

    let type = element.data('type')

    axios.get('/order/change-count', {
        params: {
            id,
            type
        }
    }).then(
        response => {
            let row = element.closest('tr')
            row.find('.price').text(response.data.price)
            row.find('.count').text(response.data.count)
            changeCount[id] = false
        },
        error => {
            changeCount[id] = false
            console.log(error.message)
        }
    )
})
