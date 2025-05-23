(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/app"],{

/***/ "./resources/assets/js/FriendRequest/FriendRequestApiService.ts":
/*!**********************************************************************!*\
  !*** ./resources/assets/js/FriendRequest/FriendRequestApiService.ts ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "FriendRequestApiService": () => (/* binding */ FriendRequestApiService)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var FriendRequestApiService = /*#__PURE__*/function () {
  function FriendRequestApiService() {
    _classCallCheck(this, FriendRequestApiService);
  }

  _createClass(FriendRequestApiService, null, [{
    key: "sendRequest",
    value: function sendRequest(id, username) {
      var apiUrl = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '/user/friends/requests';
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var formData, csrfToken, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                formData = new FormData();
                formData.append('id', id);
                formData.append('username', username);
                csrfToken = this.getCsrfToken();
                _context.next = 6;
                return fetch(apiUrl, {
                  method: 'POST',
                  headers: {
                    'X-CSRF-TOKEN': csrfToken
                  },
                  body: formData
                });

              case 6:
                response = _context.sent;

                if (response.ok) {
                  _context.next = 9;
                  break;
                }

                throw new Error('Failed to process friend request');

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));
    }
  }, {
    key: "getCsrfToken",
    value: function getCsrfToken() {
      var _a;

      var token = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.content;

      if (!token) {
        throw new Error('CSRF token not found');
      }

      return token;
    }
  }]);

  return FriendRequestApiService;
}();

/***/ }),

/***/ "./resources/assets/js/FriendRequest/FriendRequestHandler.ts":
/*!*******************************************************************!*\
  !*** ./resources/assets/js/FriendRequest/FriendRequestHandler.ts ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "FriendRequestHandler": () => (/* binding */ FriendRequestHandler)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _FriendRequestApiService__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FriendRequestApiService */ "./resources/assets/js/FriendRequest/FriendRequestApiService.ts");
/* harmony import */ var _FriendRequestUI__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FriendRequestUI */ "./resources/assets/js/FriendRequest/FriendRequestUI.ts");


function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};



var FriendRequestHandler = /*#__PURE__*/function () {
  function FriendRequestHandler() {
    _classCallCheck(this, FriendRequestHandler);
  }

  _createClass(FriendRequestHandler, null, [{
    key: "init",
    value: function init() {
      var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

      var _a;

      this.options = Object.assign(Object.assign({}, this.options), options);
      (_a = document.querySelector(this.options.containerSelector)) === null || _a === void 0 ? void 0 : _a.addEventListener('click', this.handleRequest.bind(this));
    }
  }, {
    key: "handleRequest",
    value: function handleRequest(event) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var button, _button$dataset, id, username;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                button = event.target.closest(this.options.buttonSelector);

                if (button) {
                  _context.next = 3;
                  break;
                }

                return _context.abrupt("return");

              case 3:
                event.preventDefault();
                _context.prev = 4;
                _button$dataset = button.dataset, id = _button$dataset.id, username = _button$dataset.username;

                if (!(!id || !username)) {
                  _context.next = 8;
                  break;
                }

                return _context.abrupt("return");

              case 8:
                _context.next = 10;
                return _FriendRequestApiService__WEBPACK_IMPORTED_MODULE_1__.FriendRequestApiService.sendRequest(id, username, this.options.apiUrl);

              case 10:
                _FriendRequestUI__WEBPACK_IMPORTED_MODULE_2__.FriendRequestUI.updateUI(button, this.options.uiOptions);
                _context.next = 16;
                break;

              case 13:
                _context.prev = 13;
                _context.t0 = _context["catch"](4);
                console.error('Friend request error:', _context.t0);

              case 16:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[4, 13]]);
      }));
    }
  }]);

  return FriendRequestHandler;
}();
FriendRequestHandler.options = {
  apiUrl: '/user/friends/requests',
  buttonSelector: '.friend-request-button',
  containerSelector: '.request-list',
  uiOptions: {
    counterSelector: '.friend-requests',
    parentSelector: '.request-list > *',
    emptyStateSelector: '.request-list-element'
  }
};

/***/ }),

/***/ "./resources/assets/js/FriendRequest/FriendRequestUI.ts":
/*!**************************************************************!*\
  !*** ./resources/assets/js/FriendRequest/FriendRequestUI.ts ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "FriendRequestUI": () => (/* binding */ FriendRequestUI)
/* harmony export */ });
Object(function webpackMissingModule() { var e = new Error("Cannot find module './DomUtils'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }


var FriendRequestUI = /*#__PURE__*/function () {
  function FriendRequestUI() {
    _classCallCheck(this, FriendRequestUI);
  }

  _createClass(FriendRequestUI, null, [{
    key: "updateUI",
    value: function updateUI(button) {
      var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

      var _a;

      var _options$counterSelec = options.counterSelector,
          counterSelector = _options$counterSelec === void 0 ? '.friend-requests' : _options$counterSelec,
          _options$parentSelect = options.parentSelector,
          parentSelector = _options$parentSelect === void 0 ? '.request-list > *' : _options$parentSelect,
          _options$emptyStateSe = options.emptyStateSelector,
          emptyStateSelector = _options$emptyStateSe === void 0 ? '.request-list-element' : _options$emptyStateSe;
      this.setCheckmarkIcon(button);
      var counter = document.querySelector(counterSelector);
      var currentCount = counter ? parseInt(((_a = counter.textContent) === null || _a === void 0 ? void 0 : _a.replace('+', '')) || '0') : 0;
      this.updateCounter(counter, currentCount);
      this.handleParentElement(button, parentSelector, emptyStateSelector, currentCount);
    }
  }, {
    key: "setCheckmarkIcon",
    value: function setCheckmarkIcon(button) {
      button.innerHTML = "\n            <svg version=\"1.1\" class=\"public-user-check\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 26 26\">\n                <path d=\"m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z\"></path>\n            </svg>\n        ";
    }
  }, {
    key: "updateCounter",
    value: function updateCounter(counter, currentCount) {
      if (!counter) return;
      var newCount = currentCount - 1;

      if (newCount > 0) {
        counter.textContent = "+".concat(newCount);
      } else {
        Object(function webpackMissingModule() { var e = new Error("Cannot find module './DomUtils'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(counter, 500);
      }
    }
  }, {
    key: "handleParentElement",
    value: function handleParentElement(button, parentSelector, emptyStateSelector, currentCount) {
      var parent = button.closest(parentSelector);
      if (!parent) return;
      Object(function webpackMissingModule() { var e = new Error("Cannot find module './DomUtils'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(parent, 500, function () {
        if (currentCount <= 1) {
          var emptyState = document.querySelector(emptyStateSelector);
          if (emptyState) Object(function webpackMissingModule() { var e = new Error("Cannot find module './DomUtils'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(emptyState, 500);
        }
      });
    }
  }]);

  return FriendRequestUI;
}();

/***/ }),

/***/ "./resources/assets/js/FriendRequest/index.ts":
/*!****************************************************!*\
  !*** ./resources/assets/js/FriendRequest/index.ts ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _FriendRequestHandler__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FriendRequestHandler */ "./resources/assets/js/FriendRequest/FriendRequestHandler.ts");

document.addEventListener('DOMContentLoaded', function () {
  _FriendRequestHandler__WEBPACK_IMPORTED_MODULE_0__.FriendRequestHandler.init();
});

/***/ }),

/***/ "./resources/assets/js/add-comment.ts":
/*!********************************************!*\
  !*** ./resources/assets/js/add-comment.ts ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _comment_controller__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./comment.controller */ "./resources/assets/js/comment.controller.ts");
 // Инициализация приложения

document.addEventListener('DOMContentLoaded', function () {
  new _comment_controller__WEBPACK_IMPORTED_MODULE_0__.CommentController();
});

/***/ }),

/***/ "./resources/assets/js/album-upload-image.ts":
/*!***************************************************!*\
  !*** ./resources/assets/js/album-upload-image.ts ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var uploadInput = document.getElementById('upload_image_to_album_input');
var addImageButtons = document.querySelectorAll('.add-image-button');
var imageProgress = document.querySelector('.image-progress');
var noImages = document.querySelector('.no-images');
var imageWrapper = document.querySelector('.image-wrapper');
var csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
var csrfToken = (csrfTokenMeta === null || csrfTokenMeta === void 0 ? void 0 : csrfTokenMeta.content) || '';

var handleButtonClick = function handleButtonClick() {
  if (uploadInput) {
    uploadInput.click();
  }
};

var handleUploadSuccess = function handleUploadSuccess(result) {
  if (noImages) {
    noImages.style.display = 'none';
  }

  if (imageProgress) {
    imageProgress.style.display = 'none';
    imageProgress.value = 0;
  }

  if (imageWrapper && imageWrapper.style.display === 'none') {
    imageWrapper.style.display = 'flex';
  }

  if (imageWrapper) {
    var imagesHtml = result.map(createImageHtml).join('');
    imageWrapper.insertAdjacentHTML('afterbegin', imagesHtml);
  }
};

var handleUploadError = function handleUploadError(error) {
  console.error('Upload error:', error);

  if (imageProgress) {
    imageProgress.style.display = 'none';
    imageProgress.value = 0;
  }

  alert('Произошла ошибка при загрузке изображений. Пожалуйста, попробуйте снова.');
};

var createImageHtml = function createImageHtml(_ref) {
  var _ref2 = _slicedToArray(_ref, 5),
      imageUrl = _ref2[1],
      id = _ref2[2],
      username = _ref2[3],
      album = _ref2[4];

  return "\n  <div class=\"image-block\">\n    <div class=\"image-block-top\">\n      <div class=\"image-block-top-button\" data-id=\"".concat(id, "\" data-username=\"").concat(username, "\" data-album=\"").concat(album, "\">\n        <svg version=\"1.1\" class=\"image-block-button-svg\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 94.926 94.926\">\n          <g>\n            <path d=\"M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0\n            c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096\n            c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476\n            c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62\n            s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z\"></path>\n          </g>\n        </svg>\n      </div>\n    </div>\n    <img src=\"").concat(imageUrl, "\" alt=\"Uploaded content\" />\n    <div class=\"image-block-footer\">\n      <div class=\"image-block-footer-counter\">0</div>\n      <div class=\"image-block-footer-wrapper\">\n        <div class=\"image-block-footer-button\" data-id=\"").concat(id, "\" data-username=\"").concat(username, "\">\n          <svg version=\"1.1\" class=\"heart-svg\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 510 510\">\n            <g>\n              <path d=\"M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55 \n              C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z\"></path>\n            </g>\n          </svg>\n        </div>\n      </div>\n    </div>\n  </div>");
};

var trackProgress = function trackProgress(readableStream, progressCallback) {
  var reader = readableStream.getReader();
  var loaded = 0;
  return new ReadableStream({
    start: function start(controller) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var _yield$reader$read, done, value;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (false) {}

                _context.next = 3;
                return reader.read();

              case 3:
                _yield$reader$read = _context.sent;
                done = _yield$reader$read.done;
                value = _yield$reader$read.value;

                if (!done) {
                  _context.next = 8;
                  break;
                }

                return _context.abrupt("break", 13);

              case 8:
                loaded += (value === null || value === void 0 ? void 0 : value.length) || 0;
                progressCallback(loaded);

                if (value) {
                  controller.enqueue(value);
                }

                _context.next = 0;
                break;

              case 13:
                controller.close();
                reader.releaseLock();

              case 15:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }));
    }
  });
};

var initializeUploadHandlers = function initializeUploadHandlers() {
  addImageButtons.forEach(function (button) {
    button.addEventListener('click', handleButtonClick);
  });

  if (uploadInput) {
    uploadInput.addEventListener('change', function (event) {
      return __awaiter(void 0, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var target, _target$dataset, albumName, username, formData, response, result, errorMessage;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                target = event.target;

                if (!(!target.files || target.files.length === 0)) {
                  _context2.next = 3;
                  break;
                }

                return _context2.abrupt("return");

              case 3:
                if (imageProgress) {
                  imageProgress.style.display = 'block';
                  imageProgress.value = 0;
                }

                _target$dataset = target.dataset, albumName = _target$dataset.name, username = _target$dataset.username;
                formData = new FormData();
                Array.from(target.files).forEach(function (file) {
                  formData.append('images_upload[]', file);
                });
                if (albumName) formData.append('album_name', albumName);
                if (username) formData.append('username', username);
                _context2.prev = 9;
                _context2.next = 12;
                return fetch('/user/albums/image/upload', {
                  method: 'POST',
                  headers: {
                    'X-CSRF-TOKEN': csrfToken
                  },
                  body: formData
                });

              case 12:
                response = _context2.sent;

                if (response.ok) {
                  _context2.next = 15;
                  break;
                }

                throw new Error("Server returned status ".concat(response.status));

              case 15:
                _context2.next = 17;
                return response.json();

              case 17:
                result = _context2.sent;
                handleUploadSuccess(result);
                _context2.next = 25;
                break;

              case 21:
                _context2.prev = 21;
                _context2.t0 = _context2["catch"](9);
                errorMessage = _context2.t0 instanceof Error ? _context2.t0.message : 'Unknown error';
                handleUploadError(errorMessage);

              case 25:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[9, 21]]);
      }));
    });
  }
}; // Запуск приложения


initializeUploadHandlers();

/***/ }),

/***/ "./resources/assets/js/app.ts":
/*!************************************!*\
  !*** ./resources/assets/js/app.ts ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var social_likes_next__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! social-likes-next */ "./node_modules/social-likes-next/lib/index.js");
__webpack_require__(/*! ./bootstrap */ "./resources/assets/js/bootstrap.ts");

__webpack_require__(/*! ./post-upload-image */ "./resources/assets/js/post-upload-image.ts");

__webpack_require__(/*! ./editor */ "./resources/assets/js/editor.ts");

__webpack_require__(/*! ./publish-post */ "./resources/assets/js/publish-post.ts");

__webpack_require__(/*! ./small-menu */ "./resources/assets/js/small-menu.ts");

__webpack_require__(/*! ./rating */ "./resources/assets/js/rating.ts");

__webpack_require__(/*! ./add-comment */ "./resources/assets/js/add-comment.ts");

__webpack_require__(/*! ./publish-comment */ "./resources/assets/js/publish-comment.ts");

__webpack_require__(/*! ./album-upload-image */ "./resources/assets/js/album-upload-image.ts");

__webpack_require__(/*! ./favorite */ "./resources/assets/js/favorite.ts");

__webpack_require__(/*! ./image-delete */ "./resources/assets/js/image-delete.ts");

__webpack_require__(/*! ./send-request-to-friend */ "./resources/assets/js/send-request-to-friend.ts");

__webpack_require__(/*! ./channel */ "./resources/assets/js/channel.ts");

__webpack_require__(/*! ./confirm-request */ "./resources/assets/js/confirm-request.ts");

__webpack_require__(/*! ./send-message */ "./resources/assets/js/send-message.ts");

__webpack_require__(/*! ./back-to-top */ "./resources/assets/js/back-to-top.ts");

__webpack_require__(/*! ./upload-avatar */ "./resources/assets/js/upload-avatar.ts");

__webpack_require__(/*! ./user-ban */ "./resources/assets/js/user-ban.ts");

__webpack_require__(/*! ./user-unban */ "./resources/assets/js/user-unban.ts");

__webpack_require__(/*! ./post-chart */ "./resources/assets/js/post-chart.ts");

__webpack_require__(/*! ./fullpage-image */ "./resources/assets/js/fullpage-image.ts");

__webpack_require__(/*! ./flash-messages */ "./resources/assets/js/flash-messages.ts");

__webpack_require__(/*! ./click-menu */ "./resources/assets/js/click-menu.ts");

__webpack_require__(/*! ./test-airlock */ "./resources/assets/js/test-airlock.ts");

__webpack_require__(/*! ./FriendRequest/index.ts */ "./resources/assets/js/FriendRequest/index.ts");



/***/ }),

/***/ "./resources/assets/js/back-to-top.ts":
/*!********************************************!*\
  !*** ./resources/assets/js/back-to-top.ts ***!
  \********************************************/
/***/ (() => {

"use strict";


function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var SCROLL_SHOW_HEIGHT = 500;
var SCROLL_DURATION_MULTIPLIER = 0.5;
var MIN_SCROLL_DURATION = 800;
var MAX_SCROLL_DURATION = 1000;

var BackToTop = /*#__PURE__*/function () {
  function BackToTop(selector) {
    _classCallCheck(this, BackToTop);

    this.scrollFrameId = null;
    this.animationFrameId = null;
    var element = document.querySelector(selector);
    if (!element) throw new Error("Element ".concat(selector, " not found"));
    this.backButton = element;
    this.init();
  }

  _createClass(BackToTop, [{
    key: "init",
    value: function init() {
      var _this = this;

      this.backButton.addEventListener('click', function (e) {
        return _this.scrollToTop(e);
      });
      window.addEventListener('scroll', function () {
        return _this.handleScroll();
      });
    }
  }, {
    key: "handleScroll",
    value: function handleScroll() {
      var _this2 = this;

      if (this.scrollFrameId) {
        cancelAnimationFrame(this.scrollFrameId);
      }

      this.scrollFrameId = requestAnimationFrame(function () {
        var isVisible = window.scrollY > SCROLL_SHOW_HEIGHT;

        _this2.backButton.classList.toggle('back-to-top--visible', isVisible);
      });
    }
  }, {
    key: "scrollToTop",
    value: function scrollToTop(e) {
      var _this3 = this;

      e.preventDefault();
      var startPosition = window.scrollY;
      var duration = Math.min(MAX_SCROLL_DURATION, Math.max(MIN_SCROLL_DURATION, startPosition * SCROLL_DURATION_MULTIPLIER));
      var startTime = performance.now();
      var options = {
        duration: duration,
        easing: this.easeOutQuad
      };

      var animateScroll = function animateScroll(currentTime) {
        var elapsedTime = currentTime - startTime;
        var progress = Math.min(elapsedTime / options.duration, 1);
        var ease = options.easing(progress);
        window.scrollTo(0, startPosition * (1 - ease));

        if (progress < 1) {
          _this3.animationFrameId = requestAnimationFrame(animateScroll);
        } else {
          _this3.animationFrameId = null;
        }
      };

      this.animationFrameId = requestAnimationFrame(animateScroll);
    }
  }, {
    key: "easeOutQuad",
    value: function easeOutQuad(progress) {
      return progress < 0.5 ? 2 * progress * progress : 1 - Math.pow(-2 * progress + 2, 2) / 2;
    }
  }, {
    key: "destroy",
    value: function destroy() {
      if (this.scrollFrameId) cancelAnimationFrame(this.scrollFrameId);
      if (this.animationFrameId) cancelAnimationFrame(this.animationFrameId);
      this.backButton.removeEventListener('click', this.scrollToTop);
      window.removeEventListener('scroll', this.handleScroll);
    }
  }]);

  return BackToTop;
}(); // Инициализация


var backToTop = new BackToTop('.back-to-top'); // Для отключения (если нужно)
// backToTop.destroy();

/***/ }),

/***/ "./resources/assets/js/bootstrap.ts":
/*!******************************************!*\
  !*** ./resources/assets/js/bootstrap.ts ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var laravel_echo__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! laravel-echo */ "./node_modules/laravel-echo/dist/echo.js");
/* harmony import */ var tippy_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! tippy.js */ "./node_modules/tippy.js/dist/tippy.esm.js");
/* harmony import */ var tippy_js_dist_tippy_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! tippy.js/dist/tippy.css */ "./node_modules/tippy.js/dist/tippy.css");
/* harmony import */ var tippy_js_dist_svg_arrow_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! tippy.js/dist/svg-arrow.css */ "./node_modules/tippy.js/dist/svg-arrow.css");
/* harmony import */ var tippy_js_themes_material_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! tippy.js/themes/material.css */ "./node_modules/tippy.js/themes/material.css");
window._ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js"); //window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
} catch (e) {}
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */


window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */







(0,tippy_js__WEBPACK_IMPORTED_MODULE_4__["default"])('.tippy', {
  theme: 'material',
  arrow: tippy_js__WEBPACK_IMPORTED_MODULE_4__.roundArrow,
  duration: 500,
  placement: 'right'
});
window.io = __webpack_require__(/*! socket.io-client */ "./node_modules/socket.io-client/lib/index.js");
window.smartcrop = __webpack_require__(/*! smartcrop */ "./node_modules/smartcrop/smartcrop.js");
window.Echo = new laravel_echo__WEBPACK_IMPORTED_MODULE_0__["default"]({
  broadcaster: 'socket.io',
  host: window.location.hostname //+ ':6001'

});

/***/ }),

/***/ "./resources/assets/js/channel.ts":
/*!****************************************!*\
  !*** ./resources/assets/js/channel.ts ***!
  \****************************************/
/***/ (() => {

"use strict";


function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var RealTimeEventHandler = /*#__PURE__*/function () {
  function RealTimeEventHandler() {
    _classCallCheck(this, RealTimeEventHandler);

    this.channelId = this.getDataAttributeNumber('.channel', 'id');
    this.postId = this.getDataAttributeNumber('.full-post', 'id');
  }

  _createClass(RealTimeEventHandler, [{
    key: "initialize",
    value: function initialize() {
      if (this.channelId) {
        this.setupPrivateChannel();
      }

      if (this.postId) {
        this.setupPostChannel();
      }
    }
  }, {
    key: "getDataAttributeNumber",
    value: function getDataAttributeNumber(selector, attribute) {
      var element = document.querySelector(selector);
      if (!element) return null;
      var value = element.getAttribute("data-".concat(attribute));
      return value ? parseInt(value, 10) : null;
    }
  }, {
    key: "setupPrivateChannel",
    value: function setupPrivateChannel() {
      var _this = this;

      if (!this.channelId) return;
      var echoChannel = window.Echo["private"]("user.".concat(this.channelId));
      echoChannel.listen('MessageSaved', function (e) {
        return _this.handleMessageSaved(e);
      }).listen('FriendRequest', function (e) {
        return _this.handleFriendRequest(e);
      }).listen('ConfirmFriendRequest', function (e) {
        return _this.handleConfirmFriendRequest(e);
      });
    }
  }, {
    key: "setupPostChannel",
    value: function setupPostChannel() {
      var _this2 = this;

      if (!this.postId) return;
      console.log('Post_id is present');
      console.log("post.".concat(this.postId));
      var echoChannel = window.Echo.join("post.".concat(this.postId));
      echoChannel.joining(function (user) {
        return _this2.handleUserJoining(user);
      }).here(function (users) {
        return _this2.handleUsersHere(users);
      }).leaving(function (user) {
        return _this2.handleUserLeaving(user);
      });
    }
  }, {
    key: "handleMessageSaved",
    value: function handleMessageSaved(event) {
      var profileBlock = document.querySelector('.profile-block-content');
      if (!profileBlock) return;
      var friendId = parseInt(profileBlock.getAttribute('data-friend') || '0', 10);

      if (friendId === event.userFrom.id) {
        this.appendMessage(profileBlock, event);
      } else {
        this.updateMessageCounter();
      }
    }
  }, {
    key: "appendMessage",
    value: function appendMessage(container, event) {
      var _a;

      var messageHtml = "\n      <div class=\"message-wrapper\">\n        <div class=\"message-header\">\n          <a href=\"".concat(event.url, "\" class=\"message-header-link\">\n            <img src=\"").concat((_a = event.userFrom.profile) === null || _a === void 0 ? void 0 : _a.avatar, "\" class=\"message-header-avatar\">\n          </a>\n        </div>\n        <div class=\"message-body\">\n          <div class=\"message-body-header\">\n            <a href=\"").concat(event.url, "\" class=\"message-header-name\">").concat(event.userFrom.username, "</a>\n            <div class=\"message-body-header-time\">").concat(event.createdAt, "</div>\n          </div>\n          <div class=\"message-body-content\">").concat(event.text, "</div>\n        </div>\n      </div>\n    ");
      container.insertAdjacentHTML('beforeend', messageHtml);
    }
  }, {
    key: "updateMessageCounter",
    value: function updateMessageCounter() {
      var _a;

      var messageCountElement = document.querySelector('.messages-count');
      if (!messageCountElement) return;
      var currentCount = parseInt(((_a = messageCountElement.textContent) === null || _a === void 0 ? void 0 : _a.replace('+', '')) || '0', 10);
      var newCount = currentCount + 1;
      messageCountElement.textContent = "+".concat(newCount);

      if (messageCountElement instanceof HTMLElement && messageCountElement.style.display === 'none') {
        this.fadeInElement(messageCountElement);
      }
    }
  }, {
    key: "handleFriendRequest",
    value: function handleFriendRequest(event) {
      var _a;

      var friendRequestsElement = document.querySelector('.friend-requests');
      if (!friendRequestsElement) return;
      var currentRequests = parseInt(((_a = friendRequestsElement.textContent) === null || _a === void 0 ? void 0 : _a.replace('+', '')) || '0', 10);
      friendRequestsElement.textContent = "+".concat(currentRequests + 1);

      if (friendRequestsElement instanceof HTMLElement && friendRequestsElement.style.display === 'none') {
        this.fadeInElement(friendRequestsElement);
      }

      this.appendFriendRequest(event);
    }
  }, {
    key: "appendFriendRequest",
    value: function appendFriendRequest(event) {
      var _a;

      var usersList = (_a = document.querySelector('.users-element-request:last-of-type')) === null || _a === void 0 ? void 0 : _a.parentElement;
      if (!usersList) return;
      var requestHtml = "\n      <li class=\"users-element-request\">\n        <a href=\"".concat(event.urlSender, "\" class=\"profile-link\">\n          <img src=\"").concat(event.avatar, "\" class=\"avatar-image\">\n        </a>\n        <a href=\"").concat(event.urlSender, "\" class=\"profile-name\">").concat(event.sender.username, "</a>\n        <div class=\"friend-request-button right\" data-id=\"").concat(event.sender.id, "\" data-username=\"").concat(event.friend.username, "\">\n          <svg version=\"1.1\" class=\"public-user-uncheck\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" viewBox=\"0 0 15.381 15.381\" style=\"enable-background:new 0 0 15.381 15.381;\" xml:space=\"preserve\">\n            <g>\n              <path d=\"M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65\n                c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305\n                c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73\n                c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z\"></path>\n            </g>\n          </svg>\n        </div>\n      </li>\n    ");
      usersList.insertAdjacentHTML('beforeend', requestHtml);
    }
  }, {
    key: "handleConfirmFriendRequest",
    value: function handleConfirmFriendRequest(event) {
      var friendElement = document.querySelector(".friend-id-".concat(event.sender.id));
      if (!friendElement) return;
      var lastChild = friendElement.lastElementChild;
      if (!lastChild) return;
      var confirmedHtml = "\n      <div class=\"confirmed right\">\n        <svg version=\"1.1\" class=\"checked-friend-svg\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 26 26\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" enable-background=\"new 0 0 26 26\">\n          <path d=\"m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z\"></path>\n        </svg>\n      </div>\n    ";
      lastChild.insertAdjacentHTML('afterend', confirmedHtml);
      lastChild.remove();
    }
  }, {
    key: "handleUserJoining",
    value: function handleUserJoining(user) {
      var readersBody = document.querySelector('.article-readers-body');
      if (!readersBody) return;
      var userHtml = "\n      <div class=\"post-reader flex flex-v-center\" id=\"user-".concat(user.id, "\">\n        <a href=\"").concat(user.url, "\" class=\"user-avatar-link\">\n          <img src=\"").concat(user.avatar, "\" class=\"user-avatar\" alt=\"").concat(user.username, "\">\n        </a>\n        <a href=\"").concat(user.url, "\" class=\"post-author\">").concat(user.username, "</a>\n      </div>\n    ");
      readersBody.insertAdjacentHTML('beforeend', userHtml);
    }
  }, {
    key: "handleUsersHere",
    value: function handleUsersHere(users) {
      var readersBody = document.querySelector('.article-readers-body');
      if (!readersBody || readersBody.children.length > 0) return;
      users.forEach(function (user) {
        var userHtml = "\n        <div class=\"post-reader flex flex-v-center\" id=\"user-".concat(user.id, "\">\n          <a href=\"").concat(user.url, "\" class=\"user-avatar-link\">\n            <img src=\"").concat(user.avatar, "\" class=\"user-avatar circle\" alt=\"").concat(user.username, "\">\n          </a>\n          <a href=\"").concat(user.url, "\" class=\"post-author\">").concat(user.username, "</a>\n        </div>\n      ");
        readersBody.insertAdjacentHTML('beforeend', userHtml);
      });
    }
  }, {
    key: "handleUserLeaving",
    value: function handleUserLeaving(user) {
      var userElement = document.getElementById("user-".concat(user.id));

      if (userElement) {
        userElement.remove();
      }
    }
  }, {
    key: "fadeInElement",
    value: function fadeInElement(element) {
      var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 500;
      element.style.display = '';
      element.style.opacity = '0';
      var opacity = 0;
      var interval = 16; // ~60fps

      var delta = interval / duration;

      var fade = function fade() {
        opacity += delta;

        if (opacity >= 1) {
          element.style.opacity = '1';
          return;
        }

        element.style.opacity = opacity.toString();
        requestAnimationFrame(fade);
      };

      requestAnimationFrame(fade);
    }
  }]);

  return RealTimeEventHandler;
}();

/***/ }),

/***/ "./resources/assets/js/click-menu.ts":
/*!*******************************************!*\
  !*** ./resources/assets/js/click-menu.ts ***!
  \*******************************************/
/***/ (() => {

"use strict";


var ANIMATION_DURATION_MS = 200;

function handleExpandableItemClick() {
  var content = this.nextElementSibling;
  if (!(content instanceof HTMLElement)) return;
  var isExpanded = !content.classList.contains('expanded'); // CSS-анимация через классы

  content.classList.toggle('expanded', isExpanded); // Обновление иконки после задержки

  var caret = this.querySelector('.caret-down');
  window.setTimeout(function () {
    caret === null || caret === void 0 ? void 0 : caret.classList.toggle('rotate-svg', isExpanded);
  }, ANIMATION_DURATION_MS);
}

function initializeExpandableItems() {
  document.querySelectorAll('.expanded-item').forEach(function (item) {
    item.addEventListener('click', handleExpandableItemClick);
  });
} // Инициализация при загрузке документа


if (document.readyState !== 'loading') {
  initializeExpandableItems();
} else {
  document.addEventListener('DOMContentLoaded', initializeExpandableItems);
}

/***/ }),

/***/ "./resources/assets/js/comment.controller.ts":
/*!***************************************************!*\
  !*** ./resources/assets/js/comment.controller.ts ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "CommentController": () => (/* binding */ CommentController)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _dom_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dom.service */ "./resources/assets/js/dom.service.ts");
/* harmony import */ var _comment_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./comment.service */ "./resources/assets/js/comment.service.ts");
/* harmony import */ var _comment_ui__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./comment.ui */ "./resources/assets/js/comment.ui.ts");


function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};




var CommentController = /*#__PURE__*/function () {
  function CommentController() {
    _classCallCheck(this, CommentController);

    this.domService = new _dom_service__WEBPACK_IMPORTED_MODULE_1__.DOMService();
    this.commentService = new _comment_service__WEBPACK_IMPORTED_MODULE_2__.CommentService(this.domService);
    this.commentUI = new _comment_ui__WEBPACK_IMPORTED_MODULE_3__.CommentUI(this.domService);
    this.initializeEvents();
  }

  _createClass(CommentController, [{
    key: "initializeEvents",
    value: function initializeEvents() {
      var commentButton = this.domService.getElement('commentButton');
      var replyButton = this.domService.getElement('replyButton');
      commentButton === null || commentButton === void 0 ? void 0 : commentButton.addEventListener('click', this.handleCommentSubmit.bind(this));
      replyButton === null || replyButton === void 0 ? void 0 : replyButton.addEventListener('click', this.handleReplyClick.bind(this));
    }
  }, {
    key: "handleCommentSubmit",
    value: function handleCommentSubmit(event) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var wrapper, textEditor, commentData, result, commentHtml;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                event.preventDefault();
                wrapper = this.domService.getElement('wrapper');
                textEditor = this.domService.getElement('textEditor');

                if (!(!wrapper || !textEditor)) {
                  _context.next = 5;
                  break;
                }

                return _context.abrupt("return");

              case 5:
                commentData = {
                  post: this.domService.getDatasetValue(wrapper, 'post'),
                  level: this.domService.getDatasetValue(wrapper, 'level'),
                  parent: this.domService.getDatasetValue(wrapper, 'parent'),
                  message: textEditor.innerHTML
                };
                _context.prev = 6;
                _context.next = 9;
                return this.commentService.submitComment(commentData);

              case 9:
                result = _context.sent;
                this.commentUI.clearEditor();
                commentHtml = this.commentUI.createCommentHtml(result);
                this.commentUI.insertComment(commentHtml, this.commentService.getTargetElement());
                this.commentService.setTargetElement(null);
                _context.next = 19;
                break;

              case 16:
                _context.prev = 16;
                _context.t0 = _context["catch"](6);
                console.error('Error submitting comment:', _context.t0); // Можно добавить UI уведомление об ошибке

              case 19:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[6, 16]]);
      }));
    }
  }, {
    key: "handleReplyClick",
    value: function handleReplyClick(event) {
      var element = event.currentTarget;
      var level = parseInt(this.domService.getDatasetValue(element, 'level', '0')) + 1;
      var parent = this.domService.getDatasetValue(element, 'parent');
      var wrapper = this.domService.getElement('wrapper');

      if (wrapper) {
        wrapper.dataset.level = level.toString();
        wrapper.dataset.parent = parent;
      }

      this.commentUI.scrollToCommentElement();
      var clickedParent = element.closest('.comment-item');
      if (!clickedParent) return;
      var clickedParentLevel = parseInt(this.domService.getDatasetValue(clickedParent, 'level', '0')) + 1;
      var currentElement = clickedParent;

      while (currentElement) {
        var nextSibling = currentElement.nextElementSibling;
        var nextSiblingLevel = parseInt(this.domService.getDatasetValue(nextSibling, 'level', '0'));
        if (nextSiblingLevel < clickedParentLevel) break;
        currentElement = nextSibling;
      }

      this.commentService.setTargetElement(currentElement || clickedParent);
    }
  }]);

  return CommentController;
}();

/***/ }),

/***/ "./resources/assets/js/comment.service.ts":
/*!************************************************!*\
  !*** ./resources/assets/js/comment.service.ts ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "CommentService": () => (/* binding */ CommentService)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var CommentService = /*#__PURE__*/function () {
  function CommentService(domService) {
    _classCallCheck(this, CommentService);

    this.domService = domService;
    this.targetElement = null;
  }

  _createClass(CommentService, [{
    key: "submitComment",
    value: function submitComment(data) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var formData, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                formData = new FormData();
                Object.entries(data).forEach(function (_ref) {
                  var _ref2 = _slicedToArray(_ref, 2),
                      key = _ref2[0],
                      value = _ref2[1];

                  return formData.append(key, value);
                });
                _context.next = 4;
                return fetch("/comment/store", {
                  method: "POST",
                  body: formData,
                  headers: {
                    'X-CSRF-TOKEN': this.domService.getCsrfToken()
                  }
                });

              case 4:
                response = _context.sent;

                if (response.ok) {
                  _context.next = 7;
                  break;
                }

                throw new Error('Failed to submit comment');

              case 7:
                return _context.abrupt("return", response.json());

              case 8:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));
    }
  }, {
    key: "setTargetElement",
    value: function setTargetElement(element) {
      this.targetElement = element;
    }
  }, {
    key: "getTargetElement",
    value: function getTargetElement() {
      return this.targetElement;
    }
  }]);

  return CommentService;
}();

/***/ }),

/***/ "./resources/assets/js/comment.ui.ts":
/*!*******************************************!*\
  !*** ./resources/assets/js/comment.ui.ts ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "CommentUI": () => (/* binding */ CommentUI)
/* harmony export */ });
/* harmony import */ var _createHtmlElement__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createHtmlElement */ "./resources/assets/js/createHtmlElement.ts");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }


var CommentUI = /*#__PURE__*/function () {
  function CommentUI(domService) {
    _classCallCheck(this, CommentUI);

    this.domService = domService;
    this.htmlElementCreator = new _createHtmlElement__WEBPACK_IMPORTED_MODULE_0__.HtmlElementCreator();
  }

  _createClass(CommentUI, [{
    key: "clearEditor",
    value: function clearEditor() {
      var editor = this.domService.getElement('textEditor');

      if (editor) {
        localStorage.removeItem('post-body');
        editor.innerHTML = '<div><br /></div>';
      }
    }
  }, {
    key: "createCommentHtml",
    value: function createCommentHtml(comment) {
      return "\n      <div class='comment-item level-".concat(comment.level, "' data-level='").concat(comment.level, "'>\n        <div class='header'>\n          <a href='").concat(comment.url, "' class='user-avatar-link header-item'>\n            <img src='").concat(comment.avatar, "' class='user-avatar' alt='").concat(comment.username, "' /> \n          </a>\n          <a href='").concat(comment.url, "' class='post-author header-item'>").concat(comment.username, "</a>\n          <div class='right'>").concat(comment.created_at, "</div>\n        </div>\n        <div class='body'>\n          <p>").concat(comment.message, "</p>\n        </div>\n      </div>\n    ");
    }
  }, {
    key: "insertComment",
    value: function insertComment(html) {
      var targetElement = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      var commentElement = this.htmlElementCreator.createFromString(html);
      var commentsWrapper = this.domService.getElement('commentsWrapper');

      if (targetElement) {
        targetElement.insertAdjacentElement('afterend', commentElement);
      } else if (commentsWrapper) {
        commentsWrapper.insertAdjacentElement('afterend', commentElement);
      }
    }
  }, {
    key: "scrollToCommentElement",
    value: function scrollToCommentElement() {
      var animateElement = this.domService.getElement('animateElement');
      var addCommentElement = this.domService.getElement('addCommentElement');

      if (animateElement && addCommentElement) {
        animateElement.animate({
          scrollTop: addCommentElement.offsetTop
        }, 2000);
      }
    }
  }]);

  return CommentUI;
}();

/***/ }),

/***/ "./resources/assets/js/confirm-request.ts":
/*!************************************************!*\
  !*** ./resources/assets/js/confirm-request.ts ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var _a;

var handleFriendRequest = function handleFriendRequest(event) {
  return __awaiter(void 0, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
    var _b, _c, element, _element$dataset, id, username, formData, csrfToken, response, friendRequests, parentElement, requestCountElement, requests, fadeOutAndRemove;

    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            element = event.target;
            _element$dataset = element.dataset, id = _element$dataset.id, username = _element$dataset.username;
            _context.prev = 2;
            formData = new FormData();
            formData.append('id', id);
            formData.append('username', username);
            csrfToken = (_b = document.querySelector('meta[name="csrf-token"]')) === null || _b === void 0 ? void 0 : _b.content;
            _context.next = 9;
            return fetch('/user/friends/requests', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': csrfToken || ''
              },
              body: formData
            });

          case 9:
            response = _context.sent;

            if (response.ok) {
              _context.next = 12;
              break;
            }

            throw new Error('Network response was not ok');

          case 12:
            // Update button with checkmark SVG
            element.innerHTML = "\n            <svg version=\"1.1\" class=\"public-user-check\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 26 26\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" enable-background=\"new 0 0 26 26\">\n                <path d=\"m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z\"></path>\n            </svg>\n        ";
            friendRequests = document.querySelector('.friend-requests');

            if (friendRequests) {
              _context.next = 16;
              break;
            }

            return _context.abrupt("return");

          case 16:
            parentElement = element.parentElement;

            if (parentElement) {
              _context.next = 19;
              break;
            }

            return _context.abrupt("return");

          case 19:
            requestCountElement = friendRequests;
            requests = parseInt(((_c = requestCountElement.textContent) === null || _c === void 0 ? void 0 : _c.replace('+', '')) || '0');
            requests -= 1;

            fadeOutAndRemove = function fadeOutAndRemove(element, callback) {
              element.style.opacity = '1';
              var fadeEffect = setInterval(function () {
                if (parseFloat(element.style.opacity) > 0) {
                  element.style.opacity = (parseFloat(element.style.opacity) - 0.1).toString();
                } else {
                  clearInterval(fadeEffect);
                  element.remove();
                  callback === null || callback === void 0 ? void 0 : callback();
                }
              }, 50);
            };

            if (requests > 0) {
              fadeOutAndRemove(parentElement);
              requestCountElement.textContent = "+".concat(requests);
            } else {
              fadeOutAndRemove(friendRequests);
              fadeOutAndRemove(parentElement, function () {
                var requestListElement = document.querySelector('.request-list-element');
                requestListElement === null || requestListElement === void 0 ? void 0 : requestListElement.style.setProperty('display', 'block', 'important');
                requestListElement === null || requestListElement === void 0 ? void 0 : requestListElement.style.setProperty('opacity', '1', 'important');
              });
            }

            _context.next = 29;
            break;

          case 26:
            _context.prev = 26;
            _context.t0 = _context["catch"](2);
            console.error('Error processing friend request:', _context.t0); // Можно добавить обработку ошибок, например, показать сообщение пользователю

          case 29:
          case "end":
            return _context.stop();
        }
      }
    }, _callee, null, [[2, 26]]);
  }));
}; // Инициализация обработчика событий


(_a = document.querySelector('.request-list')) === null || _a === void 0 ? void 0 : _a.addEventListener('click', function (event) {
  var target = event.target;

  if (target.closest('.friend-request-button')) {
    handleFriendRequest(event);
  }
});

/***/ }),

/***/ "./resources/assets/js/createHtmlElement.ts":
/*!**************************************************!*\
  !*** ./resources/assets/js/createHtmlElement.ts ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "HtmlElementCreator": () => (/* binding */ HtmlElementCreator)
/* harmony export */ });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

/**
 * Utility class for creating HTML elements from strings
 */
var HtmlElementCreator = /*#__PURE__*/function () {
  function HtmlElementCreator() {
    _classCallCheck(this, HtmlElementCreator);
  }

  _createClass(HtmlElementCreator, [{
    key: "createFromString",
    value:
    /**
     * Creates a DOM element from an HTML string
     * @param html HTML string to parse
     * @returns First child node of the parsed HTML or null if empty
     * @throws {Error} If the HTML string is empty or invalid
     */
    function createFromString(html) {
      var _a, _b;

      if (!(html === null || html === void 0 ? void 0 : html.trim())) {
        throw new Error('HTML string cannot be empty');
      }

      var template = document.createElement('template');
      template.innerHTML = html.trim();
      return (_b = (_a = template.content.firstChild) === null || _a === void 0 ? void 0 : _a.cloneNode(true)) !== null && _b !== void 0 ? _b : null;
    }
  }]);

  return HtmlElementCreator;
}();

/***/ }),

/***/ "./resources/assets/js/dom.service.ts":
/*!********************************************!*\
  !*** ./resources/assets/js/dom.service.ts ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "DOMService": () => (/* binding */ DOMService)
/* harmony export */ });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var DOMService = /*#__PURE__*/function () {
  function DOMService() {
    _classCallCheck(this, DOMService);

    this.elements = {};
    this.csrfToken = '';
    this.initializeElements();
    this.initializeCsrfToken();
  }

  _createClass(DOMService, [{
    key: "initializeElements",
    value: function initializeElements() {
      this.elements = {
        wrapper: document.querySelector('.add-comment-wrapper'),
        commentButton: document.querySelector('.add-comment-button'),
        replyButton: document.querySelector('.reply-button'),
        textEditor: document.querySelector('.text-editor-body'),
        commentsWrapper: document.querySelector('.comments-wrapper'),
        animateElement: document.querySelector('html, body'),
        addCommentElement: document.getElementById('add-comment')
      };
    }
  }, {
    key: "initializeCsrfToken",
    value: function initializeCsrfToken() {
      var csrfMeta = document.querySelector('meta[name="csrf-token"]');
      this.csrfToken = (csrfMeta === null || csrfMeta === void 0 ? void 0 : csrfMeta.getAttribute('content')) || '';
    }
  }, {
    key: "getElement",
    value: function getElement(key) {
      return this.elements[key] || null;
    }
  }, {
    key: "getCsrfToken",
    value: function getCsrfToken() {
      return this.csrfToken;
    }
  }, {
    key: "getDatasetValue",
    value: function getDatasetValue(element, key) {
      var defaultValue = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';

      var _a;

      return (_a = element === null || element === void 0 ? void 0 : element.dataset[key]) !== null && _a !== void 0 ? _a : defaultValue;
    }
  }]);

  return DOMService;
}();

/***/ }),

/***/ "./resources/assets/js/editor.ts":
/*!***************************************!*\
  !*** ./resources/assets/js/editor.ts ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var TextEditor = /*#__PURE__*/function () {
  function TextEditor() {
    _classCallCheck(this, TextEditor);

    this.savedRange = null;
    this.editor = this.getElement('.text-editor-body');
    this.selectItemSub = this.getElement('.select-item-sub');
    this.imageSelectItemSub = this.getElement('.image-select-item-sub');
    this.selectItemInput = this.getElement('.select-item-input');
    this.imageSelectItemInput = this.getElement('.image-select-item-input');
    this.imageItem = this.getElement('.image-item');
    this.uploadImage = this.getElement('#upload_image_form_input');
    this.bodyInput = this.getElement('#body');
    this.init();
  }

  _createClass(TextEditor, [{
    key: "getElement",
    value: function getElement(selector) {
      var element = document.querySelector(selector);

      if (!element) {
        throw new Error("Element not found: ".concat(selector));
      }

      return element;
    }
  }, {
    key: "init",
    value: function init() {
      this.loadContent();
      this.setupAutoSave();
      this.setupEventListeners();
    }
  }, {
    key: "loadContent",
    value: function loadContent() {
      var textPostBody = localStorage.getItem('post-body');

      if (textPostBody && textPostBody !== "undefined") {
        this.editor.innerHTML = textPostBody;
      }

      var bodyText = this.bodyInput.value;

      if (bodyText) {
        this.editor.innerHTML = bodyText;
      }
    }
  }, {
    key: "setupAutoSave",
    value: function setupAutoSave() {
      var _this = this;

      setInterval(function () {
        localStorage.setItem('post-body', _this.editor.innerHTML);
      }, 10000);
    }
  }, {
    key: "setupEventListeners",
    value: function setupEventListeners() {
      var _this2 = this;

      // UI interactions
      var linkItem = this.getElement('.link-item');
      linkItem.addEventListener('mouseenter', function () {
        return _this2.toggleSubMenu(_this2.selectItemSub, true);
      });
      linkItem.addEventListener('mouseleave', function () {
        return _this2.toggleSubMenu(_this2.selectItemSub, false);
      });
      this.imageItem.addEventListener('mouseenter', function () {
        return _this2.toggleSubMenu(_this2.imageSelectItemSub, true);
      });
      this.imageItem.addEventListener('mouseleave', function () {
        return _this2.toggleSubMenu(_this2.imageSelectItemSub, false);
      }); // Editor commands

      this.setupCommandButtons(); // Image handling

      this.setupImageHandling(); // Form submission

      var submitPostForm = this.getElement('.submit-post-form');
      submitPostForm.addEventListener('click', this.handleFormSubmit.bind(this));
      var submitEditPostForm = this.getElement('.submit-edit-post-form');
      submitEditPostForm.addEventListener('click', this.handleEditFormSubmit.bind(this)); // Selection handling

      this.editor.addEventListener('focusout', this.saveSelection.bind(this));
    }
  }, {
    key: "toggleSubMenu",
    value: function toggleSubMenu(element, show) {
      element.style.display = show ? 'block' : 'none';
    }
  }, {
    key: "setupCommandButtons",
    value: function setupCommandButtons() {
      var _this3 = this;

      var commands = {
        '.heading_2': {
          command: 'formatBlock',
          value: 'h2'
        },
        '.heading_3': {
          command: 'formatBlock',
          value: 'h3'
        },
        '.paragraph': {
          command: 'formatBlock',
          value: 'p'
        },
        '.bold-item': {
          command: 'bold'
        },
        '.italic-item': {
          command: 'italic'
        },
        '.broken-item': {
          command: 'unlink'
        },
        '.ordered-item': {
          command: 'insertOrderedList'
        },
        '.unordered-item': {
          command: 'insertUnorderedList'
        },
        '.quotes-item': {
          command: 'formatBlock',
          value: 'BLOCKQUOTE'
        },
        '.indent-item': {
          command: 'indent'
        },
        '.outdent-item': {
          command: 'outdent'
        },
        '.undo-item': {
          command: 'undo'
        },
        '.redo-item': {
          command: 'redo'
        }
      };
      Object.entries(commands).forEach(function (_ref) {
        var _ref2 = _slicedToArray(_ref, 2),
            selector = _ref2[0],
            _ref2$ = _ref2[1],
            command = _ref2$.command,
            value = _ref2$.value;

        var element = _this3.getElement(selector);

        element.addEventListener('click', function () {
          return _this3.executeCommand(command, value);
        });
      }); // Special cases

      var deleteItem = this.getElement('.delete-item');
      deleteItem.addEventListener('click', function () {
        return _this3.selectItemInput.value = '';
      });
      var imageDeleteItem = this.getElement('.image-delete-item');
      imageDeleteItem.addEventListener('click', function (e) {
        e.stopImmediatePropagation();
        _this3.imageSelectItemInput.value = '';
      });
      var checkedItem = this.getElement('.checked-item');
      checkedItem.addEventListener('click', function () {
        var input = _this3.selectItemInput.value;
        _this3.selectItemInput.value = '';

        _this3.toggleSubMenu(_this3.selectItemSub, false);

        _this3.executeCommand('createLink', input);
      });
      var imageCheckedItem = this.getElement('.image-checked-item');
      imageCheckedItem.addEventListener('click', function (e) {
        e.stopImmediatePropagation();
        var input = _this3.imageSelectItemInput.value;
        _this3.imageSelectItemInput.value = '';

        if (input) {
          var images = _this3.editor.querySelectorAll('img');

          if (images.length) {
            var lastImage = images[images.length - 1];
            lastImage.alt = input;

            _this3.toggleSubMenu(_this3.imageSelectItemSub, false);
          }
        }
      });
      this.imageSelectItemSub.addEventListener('click', function (e) {
        return e.stopImmediatePropagation();
      });
    }
  }, {
    key: "setupImageHandling",
    value: function setupImageHandling() {
      var _this4 = this;

      this.imageItem.addEventListener('click', function () {
        return _this4.uploadImage.click();
      });
      this.uploadImage.addEventListener('change', function () {
        var _a;

        var selectedFile = (_a = _this4.uploadImage.files) === null || _a === void 0 ? void 0 : _a[0];
        if (!selectedFile) return;
        var formData = new FormData();
        formData.append('upload_image_form_input', selectedFile);
        var type = _this4.uploadImage.dataset.type;

        if (type === 'post' || type === 'comment') {
          formData.append('type', type);
        }

        var username = _this4.getElement('.add-comment-wrapper').dataset.username;

        if (username) {
          formData.append('username', username);
        }

        _this4.uploadImageToServer(formData);
      });
    }
  }, {
    key: "uploadImageToServer",
    value: function uploadImageToServer(formData) {
      var _a;

      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var csrfToken, response, result;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                csrfToken = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.content;

                if (csrfToken) {
                  _context.next = 4;
                  break;
                }

                throw new Error('CSRF token not found');

              case 4:
                _context.next = 6;
                return fetch('/user/image/upload', {
                  method: 'POST',
                  body: formData,
                  headers: {
                    'X-CSRF-TOKEN': csrfToken
                  }
                });

              case 6:
                response = _context.sent;

                if (response.ok) {
                  _context.next = 9;
                  break;
                }

                throw new Error("HTTP error! status: ".concat(response.status));

              case 9:
                _context.next = 11;
                return response.text();

              case 11:
                result = _context.sent;
                this.executeCommand('insertImage', result);
                _context.next = 18;
                break;

              case 15:
                _context.prev = 15;
                _context.t0 = _context["catch"](0);
                console.error('Error uploading image:', _context.t0); // Здесь можно добавить уведомление пользователю об ошибке

              case 18:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[0, 15]]);
      }));
    }
  }, {
    key: "executeCommand",
    value: function executeCommand(command) {
      var value = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      this.editor.focus();
      this.restoreSelection();
      document.execCommand(command, false, value);
    }
  }, {
    key: "restoreSelection",
    value: function restoreSelection() {
      if (!this.savedRange) return;
      var selection = window.getSelection();

      if (selection) {
        selection.removeAllRanges();
        selection.addRange(this.savedRange);
      } else if (document.selection) {
        // IE fallback
        this.savedRange.select();
      }
    }
  }, {
    key: "saveSelection",
    value: function saveSelection() {
      var selection = window.getSelection();

      if (selection && selection.rangeCount > 0) {
        this.savedRange = selection.getRangeAt(0);
      } else if (document.selection) {
        // IE fallback
        this.savedRange = document.selection.createRange();
      }
    }
  }, {
    key: "handleFormSubmit",
    value: function handleFormSubmit(e) {
      e.preventDefault();
      this.bodyInput.value = this.editor.innerHTML;
      this.cleanupStorage();
      var form = this.getElement('#create-post-form');
      form.submit();
    }
  }, {
    key: "handleEditFormSubmit",
    value: function handleEditFormSubmit(e) {
      e.preventDefault();
      this.bodyInput.value = this.editor.innerHTML;
      var caption = this.getElement('#caption');
      var firstChild = this.editor.children[0];
      caption.value = firstChild ? "<p>".concat(firstChild.innerHTML, "</p>") : '';
      this.cleanupStorage();
      var form = this.getElement('#create-post-form');
      form.submit();
    }
  }, {
    key: "cleanupStorage",
    value: function cleanupStorage() {
      localStorage.removeItem('post-body');
      localStorage.removeItem('title-post-image-url');
    }
  }]);

  return TextEditor;
}(); // Initialize the editor when DOM is loaded


document.addEventListener('DOMContentLoaded', function () {
  new TextEditor();
});

/***/ }),

/***/ "./resources/assets/js/favorite.ts":
/*!*****************************************!*\
  !*** ./resources/assets/js/favorite.ts ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

function addToFavorites(event) {
  var _a, _b;

  return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
    var button, _button$dataset, id, username, formData, csrfToken, response, result, imageBlock;

    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            button = event.target;

            if (button === null || button === void 0 ? void 0 : button.dataset) {
              _context.next = 3;
              break;
            }

            return _context.abrupt("return");

          case 3:
            _button$dataset = button.dataset, id = _button$dataset.id, username = _button$dataset.username;

            if (!(!id || !username)) {
              _context.next = 6;
              break;
            }

            return _context.abrupt("return");

          case 6:
            formData = new FormData();
            formData.append('id', id);
            formData.append('username', username);
            _context.prev = 9;
            csrfToken = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.content;

            if (csrfToken) {
              _context.next = 13;
              break;
            }

            throw new Error('CSRF token not found');

          case 13:
            _context.next = 15;
            return fetch('/user/favorite/add', {
              method: 'POST',
              body: formData,
              headers: {
                'X-CSRF-TOKEN': csrfToken
              }
            });

          case 15:
            response = _context.sent;

            if (response.ok) {
              _context.next = 18;
              break;
            }

            throw new Error("HTTP error! status: ".concat(response.status));

          case 18:
            _context.next = 20;
            return response.text();

          case 20:
            result = _context.sent;
            imageBlock = (_b = button.closest('.image-block-footer-button')) === null || _b === void 0 ? void 0 : _b.previousElementSibling;

            if (imageBlock) {
              imageBlock.innerHTML = result;
            }

            _context.next = 28;
            break;

          case 25:
            _context.prev = 25;
            _context.t0 = _context["catch"](9);
            console.error('Error adding to favorites:', _context.t0); // Здесь можно добавить обработку ошибок, например, показать уведомление пользователю

          case 28:
          case "end":
            return _context.stop();
        }
      }
    }, _callee, null, [[9, 25]]);
  }));
} // Инициализация обработчиков событий


document.querySelectorAll('.image-wrapper').forEach(function (wrapper) {
  wrapper.addEventListener('click', function (event) {
    var target = event.target;

    if (target.matches('.image-block-footer-button')) {
      addToFavorites(event);
    }
  });
});

/***/ }),

/***/ "./resources/assets/js/flash-messages.ts":
/*!***********************************************!*\
  !*** ./resources/assets/js/flash-messages.ts ***!
  \***********************************************/
/***/ (() => {

"use strict";


var alerts = document.querySelectorAll('.alert');
alerts.forEach(function (alert) {
  // Плавное исчезновение (аналог fadeOut)
  alert.style.transition = 'opacity 0.5s';
  alert.style.opacity = '0'; // Удаление из DOM после анимации

  setTimeout(function () {
    return alert.remove();
  }, 5000);
});

/***/ }),

/***/ "./resources/assets/js/fullpage-image.ts":
/*!***********************************************!*\
  !*** ./resources/assets/js/fullpage-image.ts ***!
  \***********************************************/
/***/ (() => {

"use strict";
 // Основная функция для отображения полноразмерного изображения

function showFullImage(url) {
  var mainElement = document.querySelector('main');
  if (!mainElement) return;
  var fullpageBlock = document.createElement('div');
  fullpageBlock.className = 'fullpage-block';
  var img = document.createElement('img');
  img.className = 'fullpage-image';
  img.src = url;
  img.alt = 'Full size image';
  var messagesDiv = document.createElement('div');
  messagesDiv.className = 'fullpage-messages';
  fullpageBlock.append(img, messagesDiv);
  mainElement.appendChild(fullpageBlock);
} // Инициализация обработчиков событий


function initImageBlocks() {
  document.addEventListener('DOMContentLoaded', function () {
    var imageBlocks = document.querySelectorAll('.image-block');
    imageBlocks.forEach(function (block) {
      block.addEventListener('click', function (event) {
        var imgElement = block.querySelector('img');
        if (!imgElement) return;
        var imageUrl = imgElement.dataset.url;

        if (imageUrl) {
          showFullImage(imageUrl);
        }
      });
    });
  });
} // Запуск инициализации


initImageBlocks();

/***/ }),

/***/ "./resources/assets/js/image-delete.ts":
/*!*********************************************!*\
  !*** ./resources/assets/js/image-delete.ts ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
}; // Функция для удаления изображения


function deleteImage(element) {
  var _a, _b;

  return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
    var _element$dataset, id, username, album, path, thumbnail, csrfToken, params, response, result, parentElement;

    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            _element$dataset = element.dataset, id = _element$dataset.id, username = _element$dataset.username, album = _element$dataset.album, path = _element$dataset.path, thumbnail = _element$dataset.thumbnail;
            csrfToken = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.content;

            if (!(!id || !username || !album || !path || !thumbnail || !csrfToken)) {
              _context.next = 5;
              break;
            }

            console.error('Missing required data attributes or CSRF token');
            return _context.abrupt("return");

          case 5:
            _context.prev = 5;
            params = new URLSearchParams();
            params.append('id', id);
            params.append('username', username);
            params.append('album', album);
            params.append('path', path);
            params.append('thumbnail', thumbnail);
            _context.next = 14;
            return fetch("/user/image/delete?".concat(params.toString()), {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': csrfToken
              }
            });

          case 14:
            response = _context.sent;

            if (!response.ok) {
              _context.next = 22;
              break;
            }

            _context.next = 18;
            return response.text();

          case 18:
            result = _context.sent;

            if (result === 'ok') {
              parentElement = (_b = element.parentElement) === null || _b === void 0 ? void 0 : _b.parentElement;

              if (parentElement) {
                parentElement.remove();
              }
            }

            _context.next = 23;
            break;

          case 22:
            console.error('Delete request failed:', response.status);

          case 23:
            _context.next = 28;
            break;

          case 25:
            _context.prev = 25;
            _context.t0 = _context["catch"](5);
            console.error('Error deleting image:', _context.t0);

          case 28:
          case "end":
            return _context.stop();
        }
      }
    }, _callee, null, [[5, 25]]);
  }));
} // Инициализация обработчиков событий


function initImageDeleteButtons() {
  document.addEventListener('DOMContentLoaded', function () {
    var buttons = document.querySelectorAll('.image-block-top-button');
    buttons.forEach(function (button) {
      button.addEventListener('click', function () {
        return deleteImage(button);
      });
    });
  });
} // Запуск инициализации


initImageDeleteButtons();

/***/ }),

/***/ "./resources/assets/js/post-chart.ts":
/*!*******************************************!*\
  !*** ./resources/assets/js/post-chart.ts ***!
  \*******************************************/
/***/ (() => {

"use strict";
 // Константы для повторно используемых значений

var COLORS = {
  primary: '#573EA4',
  secondary: '#EF4747',
  tertiary: '#BF3985',
  success: '#39BF39',
  warning: '#EFD247',
  palette: ['#EF4747', '#EFD247', '#573EA4', '#39BF39', '#EF9347', '#EFEF47', '#7A369F', '#2B8F8F', '#EFB747', '#ABDF43', '#BF3985', '#3C5AA0']
};
var MONTH_NAMES = {
  1: 'Январь',
  2: 'Февраль',
  3: 'Март',
  4: 'Апрель',
  5: 'Май',
  6: 'Июнь',
  7: 'Июль',
  8: 'Август',
  9: 'Сентябрь',
  10: 'Октябрь',
  11: 'Ноябрь',
  12: 'Декабрь'
}; // Функция для создания подписей месяцев

var createMonthLabels = function createMonthLabels(posts) {
  return posts.map(function (post) {
    var monthName = MONTH_NAMES[post.month] || "\u041C\u0435\u0441\u044F\u0446 ".concat(post.month);
    return "".concat(monthName, " ").concat(post.year);
  });
}; // Функция для создания чарта


var createChart = function createChart(elementId, type, data, options) {
  var ctx = document.getElementById(elementId);

  if (!ctx) {
    console.error("Element with id ".concat(elementId, " not found"));
    return null;
  }

  return new Chart(ctx, {
    type: type,
    data: data,
    options: options
  });
}; // Основная функция инициализации дашборда


var initDashboard = function initDashboard(data) {
  if (!data.posts) return; // Posts chart

  createChart('postChart', 'bar', {
    labels: createMonthLabels(data.posts),
    datasets: [{
      label: 'Количество опубликованных статей',
      data: data.posts.map(function (post) {
        return post.count;
      }),
      backgroundColor: COLORS.primary,
      datalabels: {
        color: '#FFFFFF'
      }
    }]
  }, {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }); // Comments chart

  if (data.commentsVerified !== undefined && data.commentsNotVerified !== undefined) {
    createChart('commentsChart', 'doughnut', {
      labels: ['Одобренные комментарии', 'Неодобренные комментарии'],
      datasets: [{
        data: [data.commentsVerified, data.commentsNotVerified],
        backgroundColor: [COLORS.primary, COLORS.secondary],
        datalabels: {
          color: '#FFFFFF'
        }
      }]
    });
  } // Users chart


  if (data.datesQuery && data.usersQuery && data.sessionQuery && data.hitsQuery) {
    createChart('usersChart', 'line', {
      labels: data.datesQuery,
      datasets: [{
        label: 'Количество пользователей',
        data: data.usersQuery,
        backgroundColor: COLORS.primary,
        borderColor: COLORS.primary,
        fill: 'origin',
        datalabels: {
          display: false
        }
      }, {
        label: 'Количество сессий',
        data: data.sessionQuery,
        backgroundColor: COLORS.secondary,
        borderColor: COLORS.secondary,
        fill: 'origin',
        datalabels: {
          display: false
        }
      }, {
        label: 'Количество взаимодействий',
        data: data.hitsQuery,
        backgroundColor: COLORS.tertiary,
        borderColor: COLORS.tertiary,
        fill: 'origin',
        datalabels: {
          display: false
        }
      }]
    }, {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    });
  } // Country chart


  if (data.countryQueryLabels && data.countryQueryData) {
    createChart('countryChart', 'doughnut', {
      labels: data.countryQueryLabels,
      datasets: [{
        data: data.countryQueryData,
        backgroundColor: COLORS.palette,
        datalabels: {
          color: '#FFFFFF'
        }
      }]
    });
  } // City chart


  if (data.cityQueryLabels && data.cityQueryData) {
    createChart('cityChart', 'doughnut', {
      labels: data.cityQueryLabels,
      datasets: [{
        data: data.cityQueryData,
        backgroundColor: COLORS.palette.slice(0, 10),
        datalabels: {
          color: '#FFFFFF'
        }
      }]
    });
  }
};

document.addEventListener('DOMContentLoaded', function () {
  var dashboardData = {
    posts: typeof posts !== 'undefined' ? posts : undefined,
    commentsVerified: typeof commentsVerified !== 'undefined' ? commentsVerified : undefined,
    commentsNotVerified: typeof commentsNotVerified !== 'undefined' ? commentsNotVerified : undefined,
    datesQuery: typeof datesQuery !== 'undefined' ? datesQuery : undefined,
    usersQuery: typeof usersQuery !== 'undefined' ? usersQuery : undefined,
    sessionQuery: typeof sessionQuery !== 'undefined' ? sessionQuery : undefined,
    hitsQuery: typeof hitsQuery !== 'undefined' ? hitsQuery : undefined,
    countryQueryLabels: typeof countryQueryLabels !== 'undefined' ? countryQueryLabels : undefined,
    countryQueryData: typeof countryQueryData !== 'undefined' ? countryQueryData : undefined,
    cityQueryLabels: typeof cityQueryLabels !== 'undefined' ? cityQueryLabels : undefined,
    cityQueryData: typeof cityQueryData !== 'undefined' ? cityQueryData : undefined
  };
  initDashboard(dashboardData);
});

/***/ }),

/***/ "./resources/assets/js/post-upload-image.ts":
/*!**************************************************!*\
  !*** ./resources/assets/js/post-upload-image.ts ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var PostImageUploader = /*#__PURE__*/function () {
  function PostImageUploader() {
    _classCallCheck(this, PostImageUploader);
  }

  _createClass(PostImageUploader, null, [{
    key: "init",
    value: function init() {
      this.loadStoredImage();
      this.setupEventListeners();
    }
  }, {
    key: "loadStoredImage",
    value: function loadStoredImage() {
      var imageUrl = localStorage.getItem(this.STORAGE_KEYS.URL);
      if (!imageUrl) return;
      this.createImageElement(imageUrl);
      document.querySelector(this.ELEMENTS.imageInput).value = imageUrl;
    }
  }, {
    key: "setupEventListeners",
    value: function setupEventListeners() {
      var _this = this;

      var _a, _b;

      (_a = document.querySelector(this.ELEMENTS.uploadButton)) === null || _a === void 0 ? void 0 : _a.addEventListener('click', function () {
        var _a;

        (_a = document.querySelector(_this.ELEMENTS.fileInput)) === null || _a === void 0 ? void 0 : _a.click();
      });
      (_b = document.querySelector(this.ELEMENTS.fileInput)) === null || _b === void 0 ? void 0 : _b.addEventListener('change', function () {
        return __awaiter(_this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  _context.next = 2;
                  return this.handleImageUpload();

                case 2:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee, this);
        }));
      });
    }
  }, {
    key: "handleImageUpload",
    value: function handleImageUpload() {
      var _a, _b;

      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var fileInput, currentUrl, file;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                fileInput = document.querySelector(this.ELEMENTS.fileInput);

                if ((_a = fileInput === null || fileInput === void 0 ? void 0 : fileInput.files) === null || _a === void 0 ? void 0 : _a.length) {
                  _context2.next = 3;
                  break;
                }

                return _context2.abrupt("return");

              case 3:
                currentUrl = (_b = document.querySelector(this.ELEMENTS.imageInput)) === null || _b === void 0 ? void 0 : _b.value;
                file = fileInput.files[0];
                _context2.prev = 5;

                if (!currentUrl) {
                  _context2.next = 9;
                  break;
                }

                _context2.next = 9;
                return this.deleteExistingImage(currentUrl);

              case 9:
                _context2.next = 11;
                return this.uploadNewImage(file);

              case 11:
                _context2.next = 16;
                break;

              case 13:
                _context2.prev = 13;
                _context2.t0 = _context2["catch"](5);
                console.error('Image upload failed:', _context2.t0); // Здесь можно добавить уведомление пользователю об ошибке

              case 16:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this, [[5, 13]]);
      }));
    }
  }, {
    key: "deleteExistingImage",
    value: function deleteExistingImage(url) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var path, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                path = localStorage.getItem(this.STORAGE_KEYS.PATH);
                params = new URLSearchParams({
                  url: url,
                  path: path || ''
                });
                _context3.next = 4;
                return fetch("/admin/posts/image-destroy?".concat(params), {
                  method: 'DELETE',
                  headers: this.getHeaders()
                });

              case 4:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));
    }
  }, {
    key: "uploadNewImage",
    value: function uploadNewImage(file) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var formData, response, result;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                formData = new FormData();
                formData.append('post_upload', file);
                _context4.next = 4;
                return fetch('/admin/posts/image-upload', {
                  method: 'POST',
                  body: formData,
                  headers: this.getHeaders()
                });

              case 4:
                response = _context4.sent;

                if (response.ok) {
                  _context4.next = 7;
                  break;
                }

                throw new Error("Upload failed with status ".concat(response.status));

              case 7:
                _context4.next = 9;
                return response.json();

              case 9:
                result = _context4.sent;
                this.clearExistingImage();
                this.createImageElement(result.url);
                this.updateFormAndStorage(result);

              case 13:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, this);
      }));
    }
  }, {
    key: "clearExistingImage",
    value: function clearExistingImage() {
      var _a;

      (_a = document.querySelector(this.ELEMENTS.uploadedImage)) === null || _a === void 0 ? void 0 : _a.remove();
    }
  }, {
    key: "createImageElement",
    value: function createImageElement(url) {
      var _a;

      var img = document.createElement('img');
      img.src = url;
      img.className = 'uploaded-image';
      (_a = document.querySelector(this.ELEMENTS.blockWrapper)) === null || _a === void 0 ? void 0 : _a.after(img);
    }
  }, {
    key: "updateFormAndStorage",
    value: function updateFormAndStorage(result) {
      var imageInput = document.querySelector(this.ELEMENTS.imageInput);

      if (imageInput) {
        imageInput.value = result.url;
      }

      localStorage.setItem(this.STORAGE_KEYS.URL, result.url);

      if (result.path) {
        localStorage.setItem(this.STORAGE_KEYS.PATH, result.path);
      }
    }
  }, {
    key: "getHeaders",
    value: function getHeaders() {
      var _a;

      var headers = new Headers();
      var token = (_a = document.querySelector(this.ELEMENTS.csrfToken)) === null || _a === void 0 ? void 0 : _a.getAttribute('content');

      if (token) {
        headers.append('X-CSRF-TOKEN', token);
      }

      return headers;
    }
  }]);

  return PostImageUploader;
}();

PostImageUploader.STORAGE_KEYS = {
  URL: 'title-post-image-url',
  PATH: 'title-post-image-path'
};
PostImageUploader.ELEMENTS = {
  blockWrapper: '.block-wrapper',
  uploadButton: '.post_upload_image_button',
  fileInput: '#post_upload_image_input',
  imageInput: '#image',
  uploadedImage: '.uploaded-image',
  csrfToken: 'meta[name="csrf-token"]'
}; // Инициализация при загрузке страницы

document.addEventListener('DOMContentLoaded', function () {
  PostImageUploader.init();
});

/***/ }),

/***/ "./resources/assets/js/publish-comment.ts":
/*!************************************************!*\
  !*** ./resources/assets/js/publish-comment.ts ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var CommentPublisher = /*#__PURE__*/function () {
  function CommentPublisher() {
    _classCallCheck(this, CommentPublisher);
  }

  _createClass(CommentPublisher, null, [{
    key: "init",
    value: function init() {
      var _this = this;

      document.addEventListener('click', function (event) {
        var target = event.target;
        var button = target.closest('.comment-publish-button');

        if (button) {
          _this.handlePublishClick(button);
        }
      });
    }
  }, {
    key: "handlePublishClick",
    value: function handlePublishClick(button) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var commentId;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                commentId = button.dataset.id;
                _context.prev = 1;
                _context.next = 4;
                return this.togglePublishStatus(commentId);

              case 4:
                this.toggleButtonIcon(button);
                _context.next = 10;
                break;

              case 7:
                _context.prev = 7;
                _context.t0 = _context["catch"](1);
                console.error('Failed to toggle publish status:', _context.t0); // Здесь можно добавить уведомление пользователю об ошибке

              case 10:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[1, 7]]);
      }));
    }
  }, {
    key: "togglePublishStatus",
    value: function togglePublishStatus(commentId) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var formData, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                formData = new URLSearchParams();
                formData.append('id', commentId);
                _context2.next = 4;
                return fetch('/admin/comments/publish', {
                  method: 'PUT',
                  body: formData,
                  headers: this.getHeaders()
                });

              case 4:
                response = _context2.sent;

                if (response.ok) {
                  _context2.next = 7;
                  break;
                }

                throw new Error("HTTP error! status: ".concat(response.status));

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));
    }
  }, {
    key: "toggleButtonIcon",
    value: function toggleButtonIcon(button) {
      var isPublished = button.querySelector('.comment-unpublish-svg');
      button.innerHTML = isPublished ? this.PUBLISH_ICON : this.UNPUBLISH_ICON;
    }
  }, {
    key: "getHeaders",
    value: function getHeaders() {
      var _a;

      var headers = new Headers();
      var token = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.getAttribute('content');

      if (token) {
        headers.append('X-CSRF-TOKEN', token);
      }

      return headers;
    }
  }]);

  return CommentPublisher;
}();

CommentPublisher.PUBLISH_ICON = "\n        <svg version=\"1.1\" class=\"comment-publish-svg\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 26 26\" enable-background=\"new 0 0 26 26\">\n            <path d=\"m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z\"/>\n        </svg>\n    ";
CommentPublisher.UNPUBLISH_ICON = "\n        <svg version=\"1.1\" class=\"comment-unpublish-svg\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 15.381 15.381\" style=\"enable-background:new 0 0 15.381 15.381\" xml:space=\"preserve\">\n            <g>\n                <path d=\"M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z\"/>\n            </g>\n        </svg>\n    "; // Инициализация при загрузке страницы

document.addEventListener('DOMContentLoaded', function () {
  CommentPublisher.init();
});

/***/ }),

/***/ "./resources/assets/js/publish-post.ts":
/*!*********************************************!*\
  !*** ./resources/assets/js/publish-post.ts ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var PostPublisher = /*#__PURE__*/function () {
  function PostPublisher() {
    _classCallCheck(this, PostPublisher);
  }

  _createClass(PostPublisher, null, [{
    key: "init",
    value: function init() {
      var _this = this;

      document.addEventListener('click', function (event) {
        var target = event.target;
        var button = target.closest('.publish');

        if (button) {
          event.preventDefault();

          _this.handlePublishClick(button);
        }
      });
    }
  }, {
    key: "handlePublishClick",
    value: function handlePublishClick(button) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var postId;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                postId = button.dataset.id;
                _context.prev = 1;
                _context.next = 4;
                return this.togglePublishStatus(postId);

              case 4:
                this.toggleButtonIcon(button);
                _context.next = 10;
                break;

              case 7:
                _context.prev = 7;
                _context.t0 = _context["catch"](1);
                console.error('Failed to toggle publish status:', _context.t0); // Можно добавить уведомление пользователю

              case 10:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[1, 7]]);
      }));
    }
  }, {
    key: "togglePublishStatus",
    value: function togglePublishStatus(postId) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var formData, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                formData = new URLSearchParams();
                formData.append('id', postId);
                _context2.next = 4;
                return fetch('/admin/posts/publish', {
                  method: 'PUT',
                  body: formData,
                  headers: this.getHeaders()
                });

              case 4:
                response = _context2.sent;

                if (response.ok) {
                  _context2.next = 7;
                  break;
                }

                throw new Error("HTTP error! status: ".concat(response.status));

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));
    }
  }, {
    key: "toggleButtonIcon",
    value: function toggleButtonIcon(button) {
      var isPublished = button.querySelector('.unpublish-svg');
      button.innerHTML = isPublished ? this.PUBLISH_ICON : this.UNPUBLISH_ICON;
    }
  }, {
    key: "getHeaders",
    value: function getHeaders() {
      var _a;

      var headers = new Headers();
      var token = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.getAttribute('content');

      if (token) {
        headers.append('X-CSRF-TOKEN', token);
      }

      return headers;
    }
  }]);

  return PostPublisher;
}();

PostPublisher.PUBLISH_ICON = "\n        <svg version=\"1.1\" class=\"publish-svg\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 26 26\" enable-background=\"new 0 0 26 26\">\n            <path d=\"m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z\"/>\n        </svg>\n    ";
PostPublisher.UNPUBLISH_ICON = "\n        <svg version=\"1.1\" class=\"unpublish-svg\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 15.381 15.381\" style=\"enable-background:new 0 0 15.381 15.381\" xml:space=\"preserve\">\n            <g>\n                <path d=\"M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z\"/>\n            </g>\n        </svg>\n    "; // Инициализация при загрузке страницы

document.addEventListener('DOMContentLoaded', function () {
  PostPublisher.init();
});

/***/ }),

/***/ "./resources/assets/js/rating.ts":
/*!***************************************!*\
  !*** ./resources/assets/js/rating.ts ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var PostRating = /*#__PURE__*/function () {
  function PostRating() {
    _classCallCheck(this, PostRating);
  }

  _createClass(PostRating, null, [{
    key: "init",
    value: function init() {
      var _this = this;

      document.addEventListener('click', function (event) {
        return __awaiter(_this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
          var target, ratingBlock;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  target = event.target;
                  ratingBlock = target.closest('.rating-block');

                  if (!ratingBlock) {
                    _context.next = 6;
                    break;
                  }

                  event.preventDefault();
                  _context.next = 6;
                  return this.handleRatingClick(ratingBlock);

                case 6:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee, this);
        }));
      });
    }
  }, {
    key: "handleRatingClick",
    value: function handleRatingClick(ratingBlock) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var postId, paragraph, newRating;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                postId = ratingBlock.getAttribute('data-id');
                paragraph = ratingBlock.querySelector('p');

                if (!(!postId || !paragraph)) {
                  _context2.next = 4;
                  break;
                }

                return _context2.abrupt("return");

              case 4:
                _context2.prev = 4;
                _context2.next = 7;
                return this.submitRating(postId);

              case 7:
                newRating = _context2.sent;
                paragraph.textContent = newRating;
                _context2.next = 14;
                break;

              case 11:
                _context2.prev = 11;
                _context2.t0 = _context2["catch"](4);
                console.error('Rating submission failed:', _context2.t0); // Можно добавить уведомление пользователю

              case 14:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this, [[4, 11]]);
      }));
    }
  }, {
    key: "submitRating",
    value: function submitRating(postId) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var formData, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                formData = new FormData();
                formData.append('id', postId);
                _context3.next = 4;
                return fetch('/rating/post', {
                  method: 'POST',
                  body: formData,
                  headers: this.getHeaders()
                });

              case 4:
                response = _context3.sent;

                if (response.ok) {
                  _context3.next = 7;
                  break;
                }

                throw new Error("HTTP error! status: ".concat(response.status));

              case 7:
                _context3.next = 9;
                return response.text();

              case 9:
                return _context3.abrupt("return", _context3.sent);

              case 10:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));
    }
  }, {
    key: "getHeaders",
    value: function getHeaders() {
      var _a;

      var headers = new Headers();
      var token = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.getAttribute('content');

      if (token) {
        headers.append('X-CSRF-TOKEN', token);
      }

      return headers;
    }
  }]);

  return PostRating;
}(); // Инициализация при загрузке страницы


document.addEventListener('DOMContentLoaded', function () {
  PostRating.init();
});

/***/ }),

/***/ "./resources/assets/js/send-message.ts":
/*!*********************************************!*\
  !*** ./resources/assets/js/send-message.ts ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var MessageEditor = /*#__PURE__*/function () {
  function MessageEditor() {
    _classCallCheck(this, MessageEditor);
  }

  _createClass(MessageEditor, null, [{
    key: "init",
    value: function init() {
      var _this = this;

      var editor = document.querySelector('.text-editor-body');
      if (!editor) return;
      editor.addEventListener('keydown', function (e) {
        return __awaiter(_this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  if (!(e.ctrlKey && e.key === 'Enter')) {
                    _context.next = 4;
                    break;
                  }

                  e.preventDefault();
                  _context.next = 4;
                  return this.handleMessageSubmit();

                case 4:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee, this);
        }));
      });
    }
  }, {
    key: "handleMessageSubmit",
    value: function handleMessageSubmit() {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var dataElement, username, friendId, editor, message, result;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                dataElement = document.querySelector('.profile-block-content');

                if (dataElement) {
                  _context2.next = 3;
                  break;
                }

                return _context2.abrupt("return");

              case 3:
                username = dataElement.getAttribute('data-username');
                friendId = dataElement.getAttribute('data-friend');
                editor = document.querySelector('.text-editor-body');

                if (!(!username || !friendId || !editor)) {
                  _context2.next = 8;
                  break;
                }

                return _context2.abrupt("return");

              case 8:
                message = editor.innerHTML;
                editor.innerHTML = '<div><br></div>';
                localStorage.removeItem('post-body');
                _context2.prev = 11;
                _context2.next = 14;
                return this.sendMessage(username, friendId, message);

              case 14:
                result = _context2.sent;
                this.displayNewMessage(result);
                this.hideWelcomeChat();
                _context2.next = 22;
                break;

              case 19:
                _context2.prev = 19;
                _context2.t0 = _context2["catch"](11);
                console.error('Message sending failed:', _context2.t0); // Можно добавить уведомление пользователю

              case 22:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this, [[11, 19]]);
      }));
    }
  }, {
    key: "sendMessage",
    value: function sendMessage(username, friendId, message) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var formData, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                formData = new FormData();
                formData.append('username', username);
                formData.append('friend_id', friendId);
                formData.append('message', message);
                _context3.next = 6;
                return fetch('/user/messages/store', {
                  method: 'POST',
                  body: formData,
                  headers: this.getHeaders()
                });

              case 6:
                response = _context3.sent;

                if (response.ok) {
                  _context3.next = 9;
                  break;
                }

                throw new Error("HTTP error! status: ".concat(response.status));

              case 9:
                _context3.next = 11;
                return response.json();

              case 11:
                return _context3.abrupt("return", _context3.sent);

              case 12:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));
    }
  }, {
    key: "displayNewMessage",
    value: function displayNewMessage(result) {
      var messageHTML = "\n            <div class=\"message-wrapper\">\n                <div class=\"message-header\">\n                    <a href=\"".concat(result.url, "\" class=\"message-header-link\">\n                        <img src=\"").concat(result.avatar, "\" class=\"message-header-avatar circle\">\n                    </a>\n                </div>\n                <div class=\"message-body\">\n                    <div class=\"message-body-header\">\n                        <a href=\"").concat(result.url, "\" class=\"message-header-name\">").concat(result.username, "</a>\n                        <div class=\"message-body-header-time\">").concat(result.time, "</div>\n                    </div>\n                    <div class=\"message-body-content\">\n                        ").concat(result.text, "\n                    </div>\n                </div>\n            </div>\n        ");
      var contentBlock = document.querySelector('.profile-block-content');

      if (contentBlock) {
        contentBlock.insertAdjacentHTML('beforeend', messageHTML);
      }
    }
  }, {
    key: "hideWelcomeChat",
    value: function hideWelcomeChat() {
      var welcomeChat = document.querySelector('.welcome-chat');

      if (welcomeChat && window.getComputedStyle(welcomeChat).display === 'block') {
        welcomeChat.classList.add('fade-out');
        setTimeout(function () {
          welcomeChat.style.display = 'none';
        }, 200);
      }
    }
  }, {
    key: "getHeaders",
    value: function getHeaders() {
      var _a;

      var headers = new Headers();
      var token = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.getAttribute('content');

      if (token) {
        headers.append('X-CSRF-TOKEN', token);
      }

      return headers;
    }
  }]);

  return MessageEditor;
}(); // Инициализация при загрузке страницы


document.addEventListener('DOMContentLoaded', function () {
  MessageEditor.init();
}); // CSS для анимации

var style = document.createElement('style');
style.textContent = "\n    .fade-out {\n        opacity: 0;\n        transition: opacity 200ms ease-in-out;\n    }\n";
document.head.appendChild(style);

/***/ }),

/***/ "./resources/assets/js/send-request-to-friend.ts":
/*!*******************************************************!*\
  !*** ./resources/assets/js/send-request-to-friend.ts ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var _a;

var FriendRequest = /*#__PURE__*/function () {
  function FriendRequest() {
    _classCallCheck(this, FriendRequest);
  }

  _createClass(FriendRequest, null, [{
    key: "init",
    value: function init() {
      var _this = this;

      document.addEventListener('click', function (event) {
        var target = event.target;
        var button = target.closest('.request-friend');

        if (button) {
          event.preventDefault();

          _this.handleFriendRequest(button);
        }
      });
    }
  }, {
    key: "handleFriendRequest",
    value: function handleFriendRequest(button) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var friendId, username;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                friendId = button.dataset.friend;
                username = button.dataset.username;

                if (!(!friendId || !username)) {
                  _context.next = 4;
                  break;
                }

                return _context.abrupt("return");

              case 4:
                _context.prev = 4;
                _context.next = 7;
                return this.sendFriendRequest(friendId, username);

              case 7:
                this.replaceWithWaitingButton(button);
                _context.next = 13;
                break;

              case 10:
                _context.prev = 10;
                _context.t0 = _context["catch"](4);
                console.error('Friend request failed:', _context.t0); // Можно добавить уведомление пользователю

              case 13:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[4, 10]]);
      }));
    }
  }, {
    key: "sendFriendRequest",
    value: function sendFriendRequest(friendId, username) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var formData, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                formData = new FormData();
                formData.append('friend', friendId);
                formData.append('username', username);
                _context2.next = 5;
                return fetch('/user/friends/add', {
                  method: 'POST',
                  body: formData,
                  headers: this.getHeaders()
                });

              case 5:
                response = _context2.sent;

                if (response.ok) {
                  _context2.next = 8;
                  break;
                }

                throw new Error("HTTP error! status: ".concat(response.status));

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));
    }
  }, {
    key: "replaceWithWaitingButton",
    value: function replaceWithWaitingButton(button) {
      var wrapper = document.createElement('div');
      wrapper.innerHTML = this.WAITING_BUTTON_HTML.trim();
      button.replaceWith(wrapper.firstChild);
    }
  }, {
    key: "getHeaders",
    value: function getHeaders() {
      var _b;

      var headers = new Headers();
      var token = (_b = document.querySelector('meta[name="csrf-token"]')) === null || _b === void 0 ? void 0 : _b.getAttribute('content');

      if (token) {
        headers.append('X-CSRF-TOKEN', token);
      }

      return headers;
    }
  }]);

  return FriendRequest;
}();

_a = FriendRequest;
FriendRequest.HOURGLASS_ICON = "\n        <svg version=\"1.1\" class=\"hourglass-friend-svg\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 60 60\" style=\"enable-background:new 0 0 60 60\" xml:space=\"preserve\">\n            <g>\n                <path d=\"M54,58h-3v-4h-5V43.778c0-2.7-1.342-5.208-3.589-6.706L31.803,30l10.608-7.072C44.658,21.43,46,18.922,46,16.222V6h5V2h3\n                c0.552,0,1-0.447,1-1s-0.448-1-1-1h-3h-1H10H9H6C5.448,0,5,0.447,5,1s0.448,1,1,1h3v4h5v10.222c0,2.7,1.342,5.208,3.589,6.706\n                L28.197,30l-10.608,7.072C15.342,38.57,14,41.078,14,43.778V54H9v4H6c-0.552,0-1,0.447-1,1s0.448,1,1,1h3h1h40h1h3\n                c0.552,0,1-0.447,1-1S54.552,58,54,58z M18.698,21.264C17.009,20.137,16,18.252,16,16.222V6h28v10.222\n                c0,2.03-1.009,3.915-2.698,5.042L30,28.798L18.698,21.264z M16,43.778c0-2.03,1.009-3.915,2.698-5.042L30,31.202l11.302,7.534\n                C42.991,39.863,44,41.748,44,43.778V54H16V43.778z\"/>\n            </g>\n        </svg>\n    ";
FriendRequest.WAITING_BUTTON_HTML = "\n        <div class=\"waiting\" title=\"\u041E\u0436\u0438\u0434\u0430\u043D\u0438\u0435 \u043F\u043E\u0434\u0442\u0432\u0435\u0440\u0436\u0434\u0435\u043D\u0438\u044F.\">\n            <div class=\"svg-wrapper\">\n                ".concat(_a.HOURGLASS_ICON, "\n            </div>\n            <div class=\"button-title\">\u041E\u0436\u0438\u0434\u0430\u043D\u0438\u0435</div>\n        </div>\n    "); // Инициализация при загрузке страницы

document.addEventListener('DOMContentLoaded', function () {
  FriendRequest.init();
});

/***/ }),

/***/ "./resources/assets/js/small-menu.ts":
/*!*******************************************!*\
  !*** ./resources/assets/js/small-menu.ts ***!
  \*******************************************/
/***/ (() => {

"use strict";


function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var MobileMenu = /*#__PURE__*/function () {
  function MobileMenu() {
    _classCallCheck(this, MobileMenu);

    this.smallNav = document.querySelector('.small-nav');
    this.smallFirstLevel = document.querySelector('.small-first-level');
    this.initEventListeners();
  }

  _createClass(MobileMenu, [{
    key: "initEventListeners",
    value: function initEventListeners() {
      var _this = this;

      var _a, _b, _c; // Menu icon click handler


      (_a = document.querySelector('.menu-icon-svg')) === null || _a === void 0 ? void 0 : _a.addEventListener('click', function () {
        _this.hideSmallNav();

        _this.fadeInFirstLevel();
      }); // Delete button click handler

      (_b = document.querySelector('.small-delete-button')) === null || _b === void 0 ? void 0 : _b.addEventListener('click', function () {
        _this.hideFirstLevel();

        _this.fadeInSmallNav();
      }); // Deleted item click handler

      (_c = document.querySelector('.small-deleted-item')) === null || _c === void 0 ? void 0 : _c.addEventListener('click', function () {
        _this.hideFirstLevel();

        _this.fadeInSmallNav();
      });
    }
  }, {
    key: "hideSmallNav",
    value: function hideSmallNav() {
      if (this.smallNav) {
        this.smallNav.style.display = 'none';
      }
    }
  }, {
    key: "fadeInFirstLevel",
    value: function fadeInFirstLevel() {
      var _this2 = this;

      if (this.smallFirstLevel) {
        this.smallFirstLevel.style.display = 'block';
        this.smallFirstLevel.style.opacity = '0';
        var opacity = 0;

        var fadeIn = function fadeIn() {
          opacity += 0.05;

          if (_this2.smallFirstLevel) {
            _this2.smallFirstLevel.style.opacity = opacity.toString();
          }

          if (opacity < 1) {
            requestAnimationFrame(fadeIn);
          }
        };

        fadeIn();
      }
    }
  }, {
    key: "hideFirstLevel",
    value: function hideFirstLevel() {
      if (this.smallFirstLevel) {
        this.smallFirstLevel.style.display = 'none';
      }
    }
  }, {
    key: "fadeInSmallNav",
    value: function fadeInSmallNav() {
      var _this3 = this;

      if (this.smallNav) {
        this.smallNav.style.display = 'block';
        this.smallNav.style.opacity = '0';
        var opacity = 0;

        var fadeIn = function fadeIn() {
          opacity += 0.05;

          if (_this3.smallNav) {
            _this3.smallNav.style.opacity = opacity.toString();
          }

          if (opacity < 1) {
            requestAnimationFrame(fadeIn);
          }
        };

        fadeIn();
      }
    }
  }]);

  return MobileMenu;
}(); // Initialize when DOM is loaded


document.addEventListener('DOMContentLoaded', function () {
  new MobileMenu();
});

/***/ }),

/***/ "./resources/assets/js/test-airlock.ts":
/*!*********************************************!*\
  !*** ./resources/assets/js/test-airlock.ts ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var UserApiService = /*#__PURE__*/function () {
  function UserApiService() {
    _classCallCheck(this, UserApiService);
  }

  _createClass(UserApiService, null, [{
    key: "init",
    value: function init() {
      var _this = this;

      document.addEventListener('click', function (event) {
        var target = event.target;

        if (target.closest('.test-airlock')) {
          event.preventDefault();

          _this.fetchUserData();
        }
      });
    }
  }, {
    key: "fetchUserData",
    value: function fetchUserData() {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var response, data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _context.next = 3;
                return fetch(this.API_ENDPOINT, {
                  method: 'GET',
                  headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                  },
                  credentials: 'include' // For sending cookies if needed

                });

              case 3:
                response = _context.sent;

                if (response.ok) {
                  _context.next = 6;
                  break;
                }

                throw new Error("HTTP error! status: ".concat(response.status));

              case 6:
                _context.next = 8;
                return response.json();

              case 8:
                data = _context.sent;
                console.log(data.slug);
                _context.next = 15;
                break;

              case 12:
                _context.prev = 12;
                _context.t0 = _context["catch"](0);

                if (_context.t0 instanceof Error) {
                  if (_context.t0.message.includes('401')) {
                    console.log('Unauthorized');
                  } else {
                    console.error('API request failed:', _context.t0);
                  }
                }

              case 15:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[0, 12]]);
      }));
    }
  }]);

  return UserApiService;
}();

UserApiService.API_ENDPOINT = '/api/user'; // Initialize when DOM is loaded

document.addEventListener('DOMContentLoaded', function () {
  UserApiService.init();
});

/***/ }),

/***/ "./resources/assets/js/upload-avatar.ts":
/*!**********************************************!*\
  !*** ./resources/assets/js/upload-avatar.ts ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var AvatarUploader = /*#__PURE__*/function () {
  function AvatarUploader() {
    _classCallCheck(this, AvatarUploader);
  }

  _createClass(AvatarUploader, null, [{
    key: "init",
    value: function init() {
      var _this = this;

      var _a, _b; // Trigger file input when button is clicked


      (_a = document.querySelector('.upload-button')) === null || _a === void 0 ? void 0 : _a.addEventListener('click', function () {
        var _a;

        (_a = document.getElementById('change-avatar-input')) === null || _a === void 0 ? void 0 : _a.click();
      }); // Handle file selection

      (_b = document.getElementById('change-avatar-input')) === null || _b === void 0 ? void 0 : _b.addEventListener('change', function (event) {
        var _a;

        var input = event.target;

        if ((_a = input.files) === null || _a === void 0 ? void 0 : _a.length) {
          _this.handleFileUpload(input.files[0], input.dataset.username || '');
        }
      });
    }
  }, {
    key: "handleFileUpload",
    value: function handleFileUpload(file, username) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var formData, cropData, result;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                // Create FormData and add basic fields
                formData = new FormData();
                formData.append('avatar_upload', file);
                formData.append('username', username); // Get image dimensions and perform smart cropping

                _context.next = 6;
                return this.getCropData(file);

              case 6:
                cropData = _context.sent;
                Object.entries(cropData).forEach(function (_ref) {
                  var _ref2 = _slicedToArray(_ref, 2),
                      key = _ref2[0],
                      value = _ref2[1];

                  formData.append(key, value.toString());
                }); // Upload the cropped image

                _context.next = 10;
                return this.uploadAvatar(formData);

              case 10:
                result = _context.sent;
                this.updateAvatarImage(result);
                _context.next = 17;
                break;

              case 14:
                _context.prev = 14;
                _context.t0 = _context["catch"](0);
                console.error('Avatar upload failed:', _context.t0); // Add user notification here

              case 17:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[0, 14]]);
      }));
    }
  }, {
    key: "getCropData",
    value: function getCropData(file) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var _this2 = this;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                return _context2.abrupt("return", new Promise(function (resolve, reject) {
                  var img = new Image();
                  img.src = URL.createObjectURL(file);

                  img.onload = function () {
                    URL.revokeObjectURL(img.src);
                    console.log('Original dimensions:', img.width, img.height);
                    smartcrop.crop(img, _this2.AVATAR_SIZE).then(function (result) {
                      console.log('Crop dimensions:', result.topCrop);
                      resolve({
                        x: result.topCrop.x,
                        y: result.topCrop.y,
                        width: result.topCrop.width,
                        height: result.topCrop.height
                      });
                    })["catch"](reject);
                  };

                  img.onerror = function () {
                    return reject(new Error('Failed to load image'));
                  };
                }));

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }));
    }
  }, {
    key: "uploadAvatar",
    value: function uploadAvatar(formData) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.next = 2;
                return fetch('/user/avatar/upload', {
                  method: 'POST',
                  body: formData,
                  headers: this.getHeaders()
                });

              case 2:
                response = _context3.sent;

                if (response.ok) {
                  _context3.next = 5;
                  break;
                }

                throw new Error("Upload failed with status ".concat(response.status));

              case 5:
                _context3.next = 7;
                return response.text();

              case 7:
                return _context3.abrupt("return", _context3.sent);

              case 8:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));
    }
  }, {
    key: "updateAvatarImage",
    value: function updateAvatarImage(newSrc) {
      var avatarImg = document.querySelector('.avatar-inner img');

      if (avatarImg) {
        avatarImg.src = newSrc;
      }
    }
  }, {
    key: "getHeaders",
    value: function getHeaders() {
      var _a;

      var headers = new Headers();
      var token = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.getAttribute('content');

      if (token) {
        headers.append('X-CSRF-TOKEN', token);
      }

      return headers;
    }
  }]);

  return AvatarUploader;
}();

AvatarUploader.AVATAR_SIZE = {
  width: 200,
  height: 200
}; // Initialize when DOM is loaded

document.addEventListener('DOMContentLoaded', function () {
  AvatarUploader.init();
});

/***/ }),

/***/ "./resources/assets/js/user-ban.ts":
/*!*****************************************!*\
  !*** ./resources/assets/js/user-ban.ts ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var DeleteConfirmation = /*#__PURE__*/function () {
  function DeleteConfirmation() {
    _classCallCheck(this, DeleteConfirmation);
  }

  _createClass(DeleteConfirmation, null, [{
    key: "init",
    value: function init() {
      var _this = this;

      document.addEventListener('click', function (event) {
        return __awaiter(_this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
          var button;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  button = event.target.closest('.confirm-delete-button');

                  if (!button) {
                    _context.next = 5;
                    break;
                  }

                  event.preventDefault();
                  _context.next = 5;
                  return this.handleDeleteConfirmation(button);

                case 5:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee, this);
        }));
      });
    }
  }, {
    key: "handleDeleteConfirmation",
    value: function handleDeleteConfirmation(button) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var id, message, buttonText, result;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                id = button.dataset.id;
                message = button.dataset.message;
                buttonText = button.dataset.button;

                if (!(!id || !message || !buttonText)) {
                  _context2.next = 6;
                  break;
                }

                console.error('Missing required data attributes');
                return _context2.abrupt("return");

              case 6:
                _context2.prev = 6;
                _context2.next = 9;
                return this.sendDeleteRequest(id);

              case 9:
                result = _context2.sent;

                if (result.status === 'ok') {
                  this.showSuccessMessage(message, buttonText, result.url);
                }

                _context2.next = 16;
                break;

              case 13:
                _context2.prev = 13;
                _context2.t0 = _context2["catch"](6);
                console.error('Delete failed:', _context2.t0); // Add user notification here

              case 16:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this, [[6, 13]]);
      }));
    }
  }, {
    key: "sendDeleteRequest",
    value: function sendDeleteRequest(id) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var formData, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                formData = new FormData();
                formData.append('id', id);
                _context3.next = 4;
                return fetch('/admin/rips', {
                  method: 'POST',
                  body: formData,
                  headers: this.getHeaders()
                });

              case 4:
                response = _context3.sent;

                if (response.ok) {
                  _context3.next = 7;
                  break;
                }

                throw new Error("HTTP error! status: ".concat(response.status));

              case 7:
                _context3.next = 9;
                return response.json();

              case 9:
                return _context3.abrupt("return", _context3.sent);

              case 10:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));
    }
  }, {
    key: "showSuccessMessage",
    value: function showSuccessMessage(message, buttonText, url) {
      var mainContent = document.querySelector('.main-content-wrapper');
      if (!mainContent) return; // Hide existing content

      var flexElements = mainContent.querySelectorAll('.flex');
      flexElements.forEach(function (el) {
        return el.classList.add('hidden');
      }); // Create success message

      var successDiv = document.createElement('div');
      successDiv.className = 'flex flex-justify-space';
      successDiv.innerHTML = "\n            <p class=\"lockout-message\">".concat(message, "</p>\n            <a href=\"").concat(url, "\" class=\"button confirm-button\">").concat(buttonText, "</a>\n        ");
      mainContent.appendChild(successDiv);
    }
  }, {
    key: "getHeaders",
    value: function getHeaders() {
      var _a;

      var headers = new Headers();
      var token = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.getAttribute('content');

      if (token) {
        headers.append('X-CSRF-TOKEN', token);
      }

      return headers;
    }
  }]);

  return DeleteConfirmation;
}(); // Initialize when DOM is loaded


document.addEventListener('DOMContentLoaded', function () {
  DeleteConfirmation.init();
});

/***/ }),

/***/ "./resources/assets/js/user-unban.ts":
/*!*******************************************!*\
  !*** ./resources/assets/js/user-unban.ts ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);




function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
  function adopt(value) {
    return value instanceof P ? value : new P(function (resolve) {
      resolve(value);
    });
  }

  return new (P || (P = Promise))(function (resolve, reject) {
    function fulfilled(value) {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    }

    function rejected(value) {
      try {
        step(generator["throw"](value));
      } catch (e) {
        reject(e);
      }
    }

    function step(result) {
      result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
    }

    step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
};

var UserUnbanHandler = /*#__PURE__*/function () {
  function UserUnbanHandler() {
    _classCallCheck(this, UserUnbanHandler);
  }

  _createClass(UserUnbanHandler, null, [{
    key: "init",
    value: function init() {
      var _this = this;

      document.addEventListener('click', function (event) {
        return __awaiter(_this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
          var target, button;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  target = event.target;
                  button = target.closest('.unban-user-button');

                  if (!button) {
                    _context.next = 6;
                    break;
                  }

                  event.preventDefault();
                  _context.next = 6;
                  return this.handleUnbanRequest(button);

                case 6:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee, this);
        }));
      });
    }
  }, {
    key: "handleUnbanRequest",
    value: function handleUnbanRequest(button) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var userId, message, result;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                userId = button.dataset.id;
                message = button.dataset.message;

                if (!(!userId || !message)) {
                  _context2.next = 5;
                  break;
                }

                console.error('Missing required data attributes');
                return _context2.abrupt("return");

              case 5:
                _context2.prev = 5;
                _context2.next = 8;
                return this.sendUnbanRequest(userId);

              case 8:
                result = _context2.sent;

                if (result === 'ok') {
                  this.updateUI(button, message);
                }

                _context2.next = 15;
                break;

              case 12:
                _context2.prev = 12;
                _context2.t0 = _context2["catch"](5);
                console.error('Unban request failed:', _context2.t0); // Add user notification here

              case 15:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this, [[5, 12]]);
      }));
    }
  }, {
    key: "sendUnbanRequest",
    value: function sendUnbanRequest(userId) {
      return __awaiter(this, void 0, void 0, /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var params, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                params = new URLSearchParams({
                  id: userId
                });
                _context3.next = 3;
                return fetch("/admin/rips?".concat(params), {
                  method: 'DELETE',
                  headers: this.getHeaders()
                });

              case 3:
                response = _context3.sent;

                if (response.ok) {
                  _context3.next = 6;
                  break;
                }

                throw new Error("HTTP error! status: ".concat(response.status));

              case 6:
                _context3.next = 8;
                return response.text();

              case 8:
                return _context3.abrupt("return", _context3.sent);

              case 9:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));
    }
  }, {
    key: "updateUI",
    value: function updateUI(button, message) {
      // Remove the unban button
      button.remove(); // Add success message

      var userInfo = document.querySelector('.user-info');

      if (userInfo) {
        var messageDiv = document.createElement('div');
        messageDiv.className = 'button info-button right';
        messageDiv.textContent = message;
        userInfo.appendChild(messageDiv);
      }
    }
  }, {
    key: "getHeaders",
    value: function getHeaders() {
      var _a;

      var headers = new Headers();
      var token = (_a = document.querySelector('meta[name="csrf-token"]')) === null || _a === void 0 ? void 0 : _a.getAttribute('content');

      if (token) {
        headers.append('X-CSRF-TOKEN', token);
      }

      return headers;
    }
  }]);

  return UserUnbanHandler;
}(); // Initialize when DOM is loaded


document.addEventListener('DOMContentLoaded', function () {
  UserUnbanHandler.init();
});

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/*!****************************************!*\
  !*** ./resources/assets/sass/app.scss ***!
  \****************************************/
/***/ (() => {

throw new Error("Module build failed (from ./node_modules/mini-css-extract-plugin/dist/loader.js):\nModuleBuildError: Module build failed (from ./node_modules/sass-loader/dist/cjs.js):\nSassError: Undefined mixin.\n   ╷\n30 │   @include clearfix;\n   │   ^^^^^^^^^^^^^^^^^\n   ╵\n  resources/assets/sass/_grid.scss 30:3  @import\n  resources/assets/sass/app.scss 2:9     root stylesheet\n    at new WebpackError (/home/project/node_modules/webpack/lib/WebpackError.js:21:3)\n    at new ModuleBuildError (/home/project/node_modules/webpack/lib/ModuleBuildError.js:51:3)\n    at processResult (/home/project/node_modules/webpack/lib/NormalModule.js:753:19)\n    at eval (/home/project/node_modules/webpack/lib/NormalModule.js:855:5)\n    at eval (/home/project/node_modules/loader-runner/lib/LoaderRunner.js:399:11)\n    at eval (/home/project/node_modules/loader-runner/lib/LoaderRunner.js:251:18)\n    at context.callback (/home/project/node_modules/loader-runner/lib/LoaderRunner.js:124:13)\n    at eval (/home/project/node_modules/sass-loader/dist/index.js:54:7)\n    at Function.call$2 (/home/project/node_modules/sass/sass.dart.js:99012:16)\n    at render_closure1.call$2 (/home/project/node_modules/sass/sass.dart.js:84527:12)");

/***/ }),

/***/ "?ac64":
/*!********************!*\
  !*** ws (ignored) ***!
  \********************/
/***/ (() => {

/* (ignored) */

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/assets/js/app.ts"), __webpack_exec__("./resources/assets/sass/app.scss")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);