var app =
webpackJsonpapp([1],{

/***/ 29:
/***/ (function(module, exports) {

/* global $, axios */
var append = {};
$('*[data-action="append"]').click(function () {
  var _this = this;

  var id = $(this).data('id');
  if (append[id]) return;
  append[id] = true;
  axios.get('/order/append', {
    params: {
      id: id
    }
  }).then(function (response) {
    var count = response.data.currentCount;
    $(_this).remove();
    $('#order-indicator a').html("\u0417\u0430\u043A\u0430\u0437 <span class=\"label label-".concat(count ? 'success' : 'warning', "\">").concat(count, "</span>"));
  }, function (error) {
    append[id] = false;
    console.log(error.message);
  });
});
var remove = {};
$('*[data-action="remove"]').click(function () {
  var _this2 = this;

  var id = $(this).data('id');
  if (remove[id]) return;
  remove[id] = true;
  axios.get('/order/remove', {
    params: {
      id: id
    }
  }).then(function (response) {
    var count = response.data.currentCount;

    if (count) {
      $(_this2).closest('tr').remove();
    } else {
      $(_this2).closest('table').parent().html('<h4>Вы еще ничего не заказали, перейдите в <a href="/">меню</a>, чтобы сделать заказ.</h4>\n');
    }

    $('#order-indicator a').html("\u0417\u0430\u043A\u0430\u0437 <span class=\"label label-".concat(count ? 'success' : 'warning', "\">").concat(count, "</span>"));
  }, function (error) {
    remove[id] = false;
    console.log(error.message);
  });
});
var changeCount = {};
$('*[data-action="changeCount"]').click(function () {
  var element = $(this);
  var id = element.data('id');
  if (changeCount[id]) return;
  changeCount[id] = true;
  var type = element.data('type');
  axios.get('/order/change-count', {
    params: {
      id: id,
      type: type
    }
  }).then(function (response) {
    var row = element.closest('tr');
    row.find('.price').text(response.data.price);
    row.find('.count').text(response.data.count);
    changeCount[id] = false;
  }, function (error) {
    changeCount[id] = false;
    console.log(error.message);
  });
});

/***/ }),

/***/ 8:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(9);

__webpack_require__(29);

/***/ }),

/***/ 9:
/***/ (function(module, exports, __webpack_require__) {

window.axios = __webpack_require__(10);
var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found');
}

/***/ })

},[8]);