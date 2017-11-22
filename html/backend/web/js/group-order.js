var app =
webpackJsonpapp([1],{

/***/ 15:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


window.axios = __webpack_require__(25);

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

/***/ }),

/***/ 66:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _vue = __webpack_require__(67);

var _vue2 = _interopRequireDefault(_vue);

var _groupOrder = __webpack_require__(70);

var _groupOrder2 = _interopRequireDefault(_groupOrder);

var _connection = __webpack_require__(79);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

__webpack_require__(15);


_vue2.default.prototype.$http = window.axios;
_vue2.default.prototype.$conn = new _connection.Connection();
window.conn = _vue2.default.prototype.$conn;

new _vue2.default({
    el: '#group-order-root',
    components: {
        GroupOrder: _groupOrder2.default
    },
    template: '<group-order/>'
});

/***/ }),

/***/ 70:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_bustCache_group_order_vue__ = __webpack_require__(77);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_58ff9dc2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_bustCache_group_order_vue__ = __webpack_require__(78);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(71)
}
var normalizeComponent = __webpack_require__(76)
/* script */

/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_bustCache_group_order_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_58ff9dc2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_bustCache_group_order_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "js\\group-order\\group-order.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {  return key !== "default" && key.substr(0, 2) !== "__"})) {  console.error("named exports are not supported in *.vue files.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-58ff9dc2", Component.options)
  } else {
    hotAPI.reload("data-v-58ff9dc2", Component.options)
' + '  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 71:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(72);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(74)("bb7dfcce", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../node_modules/css-loader/index.js!../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-58ff9dc2\",\"scoped\":false,\"hasInlineConfig\":false}!../../node_modules/sass-loader/lib/loader.js!../../node_modules/vue-loader/lib/selector.js?type=styles&index=0&bustCache!./group-order.vue", function() {
     var newContent = require("!!../../node_modules/css-loader/index.js!../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-58ff9dc2\",\"scoped\":false,\"hasInlineConfig\":false}!../../node_modules/sass-loader/lib/loader.js!../../node_modules/vue-loader/lib/selector.js?type=styles&index=0&bustCache!./group-order.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 72:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(73)(undefined);
// imports


// module
exports.push([module.i, "\n.group-control {\n  margin-top: 5px;\n}\n.row.dish {\n  border-bottom: 1px dotted gray;\n  padding-bottom: 5px;\n  padding-top: 5px;\n}\n.row.dish:last-child {\n    border-bottom: none;\n}\n", ""]);

// exports


/***/ }),

/***/ 77:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
    name: 'group-order',
    data: function () {
        return {
            menu: null,
            selfOrder: null,
            summaryOrder: null,
            canSend: null
        };
    },
    computed: {
        dishes() {
            return this.selfOrder.map(m => m.dish_id);
        },
        selfSummary() {
            return this.selfOrder.reduce((value, m) => value + m.count * m.price, 0);
        },
        orderSummary() {
            return this.summaryOrder.reduce((value, user) => value + this.sum(user.orderDishes), 0);
        }
    },
    methods: {
        sum(model) {
            return model.reduce((value, orderDish) => value + orderDish.count * orderDish.dish.price, 0);
        },
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
            });
        }
    },
    created() {
        this.$conn.on('message', (event, data) => {
            if (data) {
                this.menu = data.menu || this.menu;
                this.selfOrder = data.selfOrder || this.selfOrder;
                this.summaryOrder = data.summaryOrder || this.summaryOrder;
                this.canSend = data.canSend || this.canSend;
            }
        });
        this.$conn.connect();
    }
});

/***/ }),

/***/ 78:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "group-order" }, [
    _vm._m(0, false, false),
    _vm._v(" "),
    _c("div", { staticClass: "tab-content" }, [
      _c(
        "div",
        { staticClass: "tab-pane active", attrs: { id: "group-menu" } },
        _vm._l(_vm.menu, function(category) {
          return _c(
            "div",
            { key: "category_" + category.id, staticClass: "panel" },
            [
              _c("div", { staticClass: "panel-heading" }, [
                _c("div", { staticClass: "panel-title" }, [
                  _c("h2", [_vm._v(_vm._s(category.name))])
                ])
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "panel-body" },
                _vm._l(category.dishes, function(dish) {
                  return _c(
                    "div",
                    { key: "dish_" + dish.id, staticClass: "row dish" },
                    [
                      _c("div", { staticClass: "col-md-6" }, [
                        _c("h4", [_vm._v(_vm._s(dish.name))]),
                        _vm._v(" "),
                        _c("div", [
                          _c("small", [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(dish.description) +
                                "\n                                "
                            )
                          ])
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-2" }, [
                        _c("em", [_vm._v(_vm._s(dish.price) + " $")])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-2" }, [
                        _vm.dishes.indexOf(dish.id) !== -1
                          ? _c(
                              "div",
                              {
                                staticClass:
                                  "btn-group btn-group-sm group-control"
                              },
                              [
                                _c(
                                  "button",
                                  {
                                    staticClass: "btn",
                                    on: {
                                      click: function($event) {
                                        _vm.action("decrement", dish.id)
                                      }
                                    }
                                  },
                                  [_vm._v("-")]
                                ),
                                _vm._v(" "),
                                _c("button", { staticClass: "btn btn-info" }, [
                                  _vm._v(_vm._s(_vm.getCount(dish.id)))
                                ]),
                                _vm._v(" "),
                                _c(
                                  "button",
                                  {
                                    staticClass: "btn",
                                    on: {
                                      click: function($event) {
                                        _vm.action("increment", dish.id)
                                      }
                                    }
                                  },
                                  [_vm._v("+")]
                                ),
                                _vm._v(" "),
                                _c(
                                  "button",
                                  {
                                    staticClass: "btn btn-danger",
                                    on: {
                                      click: function($event) {
                                        _vm.action("remove", dish.id)
                                      }
                                    }
                                  },
                                  [_vm._v("Удалить")]
                                )
                              ]
                            )
                          : _c(
                              "button",
                              {
                                staticClass: "btn btn-primary btn-sm",
                                on: {
                                  click: function($event) {
                                    _vm.action("append", dish.id)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                Добавить\n                            "
                                )
                              ]
                            )
                      ])
                    ]
                  )
                })
              )
            ]
          )
        })
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "tab-pane", attrs: { id: "my-order" } },
        [
          _vm.selfOrder
            ? _c("h4", [_vm._v("Всего: " + _vm._s(_vm.selfSummary) + " $")])
            : _vm._e(),
          _vm._v(" "),
          _vm._l(_vm.selfOrder, function(model) {
            return _c("div", { staticClass: "row dish" }, [
              _c("div", { staticClass: "col-md-8" }, [
                _vm._v(
                  "\n                    " +
                    _vm._s(model.name) +
                    "\n                "
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-2" }, [
                _vm._v(
                  _vm._s(model.count) +
                    " x " +
                    _vm._s(model.price) +
                    " = " +
                    _vm._s(model.count * model.price) +
                    " $"
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-2" }, [
                _c("div", { staticClass: "btn-group btn-group-xs" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn",
                      on: {
                        click: function($event) {
                          _vm.action("decrement", model.dish_id)
                        }
                      }
                    },
                    [_vm._v("-")]
                  ),
                  _vm._v(" "),
                  _c("button", { staticClass: "btn btn-info" }, [
                    _vm._v(_vm._s(model.count))
                  ]),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn",
                      on: {
                        click: function($event) {
                          _vm.action("increment", model.dish_id)
                        }
                      }
                    },
                    [_vm._v("+")]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-danger",
                      on: {
                        click: function($event) {
                          _vm.action("remove", model.dish_id)
                        }
                      }
                    },
                    [_vm._v("Удалить")]
                  )
                ])
              ])
            ])
          })
        ],
        2
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "tab-pane", attrs: { id: "group-order" } },
        [
          _vm._l(_vm.summaryOrder, function(user) {
            return [
              _c("h4", [_vm._v(_vm._s(user.username))]),
              _vm._v(" "),
              _vm._l(user.orderDishes, function(model) {
                return _c("div", { staticClass: "row dish" }, [
                  _c("div", { staticClass: "col-md-10" }, [
                    _vm._v(
                      "\n                        " +
                        _vm._s(model.dish.name) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-2" }, [
                    _vm._v(
                      _vm._s(model.count) +
                        " x " +
                        _vm._s(model.dish.price) +
                        " = " +
                        _vm._s(model.count * model.dish.price) +
                        " $"
                    )
                  ])
                ])
              }),
              _vm._v(" "),
              _c("div", { staticClass: "row dish" }, [
                _c("div", { staticClass: "col-md-12 text-right" }, [
                  _c("strong", [
                    _vm._v(_vm._s(_vm.sum(user.orderDishes)) + " $")
                  ])
                ])
              ])
            ]
          }),
          _vm._v(" "),
          _vm.summaryOrder
            ? _c("h2", { staticClass: "text-right" }, [
                _vm._v("Всего: " + _vm._s(_vm.orderSummary) + " $")
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.canSend && _vm.summaryOrder && _vm.summaryOrder.length
            ? _c("div", { staticClass: "row dish" }, [
                _c("div", { staticClass: "col-md-12 clearfix" }, [
                  _c(
                    "a",
                    {
                      attrs: {
                        href: "/order/send?group_id=" + _vm.$conn.groupId
                      }
                    },
                    [
                      _c(
                        "button",
                        { staticClass: "btn btn-success pull-right" },
                        [_vm._v("Отправить заказ")]
                      )
                    ]
                  )
                ])
              ])
            : _vm._e()
        ],
        2
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("ul", { staticClass: "nav nav-tabs" }, [
      _c("li", { staticClass: "active" }, [
        _c("a", { attrs: { href: "#group-menu", "data-toggle": "tab" } }, [
          _vm._v("Меню")
        ])
      ]),
      _vm._v(" "),
      _c("li", [
        _c("a", { attrs: { href: "#my-order", "data-toggle": "tab" } }, [
          _vm._v("Мой заказ")
        ])
      ]),
      _vm._v(" "),
      _c("li", [
        _c("a", { attrs: { href: "#group-order", "data-toggle": "tab" } }, [
          _vm._v("Общий заказ")
        ])
      ])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-58ff9dc2", esExports)
  }
}

/***/ }),

/***/ 79:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.Connection = undefined;

var _stringify = __webpack_require__(80);

var _stringify2 = _interopRequireDefault(_stringify);

var _regenerator = __webpack_require__(82);

var _regenerator2 = _interopRequireDefault(_regenerator);

var _asyncToGenerator2 = __webpack_require__(85);

var _asyncToGenerator3 = _interopRequireDefault(_asyncToGenerator2);

var _classCallCheck2 = __webpack_require__(121);

var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

var _createClass2 = __webpack_require__(122);

var _createClass3 = _interopRequireDefault(_createClass2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var Connection = exports.Connection = function () {
    function Connection() {
        var params = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
        (0, _classCallCheck3.default)(this, Connection);
        var _params$host = params.host,
            host = _params$host === undefined ? location.hostname : _params$host,
            _params$port = params.port,
            port = _params$port === undefined ? 8081 : _params$port;

        this.url = port ? host + ':' + port : host;
        this.groupId = document.getElementById('group-id').textContent;
        this.handlers = {
            message: [],
            error: [],
            close: [],
            open: []
        };

        this.conn = null;
    }

    (0, _createClass3.default)(Connection, [{
        key: 'connect',
        value: function connect() {
            var _this = this;

            this.conn = new WebSocket('ws://' + this.url);

            this.conn.onopen = function () {
                var _ref = (0, _asyncToGenerator3.default)( /*#__PURE__*/_regenerator2.default.mark(function _callee(event) {
                    var user;
                    return _regenerator2.default.wrap(function _callee$(_context) {
                        while (1) {
                            switch (_context.prev = _context.next) {
                                case 0:
                                    console.info('Connected to ' + _this.url);
                                    _context.next = 3;
                                    return axios.get('/user/auth-key');

                                case 3:
                                    user = _context.sent;

                                    if (user.data.key) _this.push({
                                        auth: user.data.key
                                    });
                                    _this.handle('open', event);

                                case 6:
                                case 'end':
                                    return _context.stop();
                            }
                        }
                    }, _callee, _this);
                }));

                return function (_x2) {
                    return _ref.apply(this, arguments);
                };
            }();

            this.conn.onclose = function (event) {
                console.info('Connection ' + _this.url + ' closed');
                _this.handle('close', event);
            };

            this.conn.onerror = function (error) {
                console.log(event.message);
                _this.handle('error', event);
            };

            this.conn.onmessage = function (event) {
                console.groupCollapsed('socket get data');
                console.info(JSON.parse(event.data));
                console.groupEnd();
                _this.handle('message', event);
            };

            return this;
        }
    }, {
        key: 'handle',
        value: function handle(level, event) {
            var _this2 = this;

            if (this.handlers[level]) {
                this.handlers[level].forEach(function (handler) {
                    try {
                        handler(event, event.data ? JSON.parse(event.data) : undefined, _this2.conn);
                    } catch (e) {
                        console.log(e.message);
                    }
                });
            }
        }
    }, {
        key: 'on',
        value: function on(event, callback) {
            if (this.handlers[event] && typeof callback === 'function') {
                this.handlers[event].push(callback);
            } else {
                throw new Error('Invalid params');
            }
            return this;
        }
    }, {
        key: 'push',
        value: function push(data) {
            data.group_id = this.groupId;
            data = (0, _stringify2.default)(data);

            console.groupCollapsed('socket push data');
            console.info(data);
            console.groupEnd();

            this.conn.send(data);
            return this;
        }
    }]);
    return Connection;
}();

/***/ })

},[66]);