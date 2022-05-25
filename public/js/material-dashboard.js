/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/vue-material-dashboard-2/src/assets/js/nav-pills.js":
/*!***********************************************************************!*\
  !*** ./resources/vue-material-dashboard-2/src/assets/js/nav-pills.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ setNavPills)
/* harmony export */ });
/* eslint-disable */
function setNavPills() {
  var total = document.querySelectorAll('.nav-pills');

  function initNavs() {
    total.forEach(function (item, i) {
      var moving_div = document.createElement('div');
      var first_li = item.querySelector('li:first-child .nav-link');
      var tab = first_li.cloneNode();
      tab.innerHTML = "-";
      moving_div.classList.add('moving-tab', 'position-absolute', 'nav-link');
      moving_div.appendChild(tab);
      item.appendChild(moving_div);
      var list_length = item.getElementsByTagName("li").length;
      moving_div.style.padding = '0px';
      moving_div.style.width = item.querySelector('li:nth-child(1)').offsetWidth + 'px';
      moving_div.style.transform = 'translate3d(0px, 0px, 0px)';
      moving_div.style.transition = '.5s ease';

      item.onmouseover = function (event) {
        var target = getEventTarget(event);
        var li = target.closest('li'); // get reference

        if (li) {
          var nodes = Array.from(li.closest('ul').children); // get array

          var index = nodes.indexOf(li) + 1;

          item.querySelector('li:nth-child(' + index + ') .nav-link').onclick = function () {
            moving_div = item.querySelector('.moving-tab');
            var sum = 0;

            if (item.classList.contains('flex-column')) {
              for (var j = 1; j <= nodes.indexOf(li); j++) {
                sum += item.querySelector('li:nth-child(' + j + ')').offsetHeight;
              }

              moving_div.style.transform = 'translate3d(0px,' + sum + 'px, 0px)';
              moving_div.style.height = item.querySelector('li:nth-child(' + j + ')').offsetHeight;
            } else {
              for (var j = 1; j <= nodes.indexOf(li); j++) {
                sum += item.querySelector('li:nth-child(' + j + ')').offsetWidth;
              }

              moving_div.style.transform = 'translate3d(' + sum + 'px, 0px, 0px)';
              moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
            }
          };
        }
      };
    });
  }

  setTimeout(function () {
    initNavs();
  }, 100); // Tabs navigation resize

  window.addEventListener('resize', function (event) {
    total.forEach(function (item, i) {
      item.querySelector('.moving-tab').remove();
      var moving_div = document.createElement('div');
      var tab = item.querySelector(".nav-link.active").cloneNode();
      tab.innerHTML = "-";
      moving_div.classList.add('moving-tab', 'position-absolute', 'nav-link');
      moving_div.appendChild(tab);
      item.appendChild(moving_div);
      moving_div.style.padding = '0px';
      moving_div.style.transition = '.5s ease';
      var li = item.querySelector(".nav-link.active").parentElement;

      if (li) {
        var nodes = Array.from(li.closest('ul').children); // get array

        var index = nodes.indexOf(li) + 1;
        var sum = 0;

        if (item.classList.contains('flex-column')) {
          for (var j = 1; j <= nodes.indexOf(li); j++) {
            sum += item.querySelector('li:nth-child(' + j + ')').offsetHeight;
          }

          moving_div.style.transform = 'translate3d(0px,' + sum + 'px, 0px)';
          moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
          moving_div.style.height = item.querySelector('li:nth-child(' + j + ')').offsetHeight;
        } else {
          for (var j = 1; j <= nodes.indexOf(li); j++) {
            sum += item.querySelector('li:nth-child(' + j + ')').offsetWidth;
          }

          moving_div.style.transform = 'translate3d(' + sum + 'px, 0px, 0px)';
          moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
        }
      }
    });

    if (window.innerWidth < 991) {
      total.forEach(function (item, i) {
        if (!item.classList.contains('flex-column')) {
          item.classList.remove('flex-row');
          item.classList.add('flex-column', 'on-resize');
          var li = item.querySelector(".nav-link.active").parentElement;
          var nodes = Array.from(li.closest('ul').children); // get array

          var index = nodes.indexOf(li) + 1;
          var sum = 0;

          for (var j = 1; j <= nodes.indexOf(li); j++) {
            sum += item.querySelector('li:nth-child(' + j + ')').offsetHeight;
          }

          var moving_div = document.querySelector('.moving-tab');
          moving_div.style.width = item.querySelector('li:nth-child(1)').offsetWidth + 'px';
          moving_div.style.transform = 'translate3d(0px,' + sum + 'px, 0px)';
        }
      });
    } else {
      total.forEach(function (item, i) {
        if (item.classList.contains('on-resize')) {
          item.classList.remove('flex-column', 'on-resize');
          item.classList.add('flex-row');
          var li = item.querySelector(".nav-link.active").parentElement;
          var nodes = Array.from(li.closest('ul').children); // get array

          var index = nodes.indexOf(li) + 1;
          var sum = 0;

          for (var j = 1; j <= nodes.indexOf(li); j++) {
            sum += item.querySelector('li:nth-child(' + j + ')').offsetWidth;
          }

          var moving_div = document.querySelector('.moving-tab');
          moving_div.style.transform = 'translate3d(' + sum + 'px, 0px, 0px)';
          moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
        }
      });
    }
  }); // Function to remove flex row on mobile devices

  if (window.innerWidth < 991) {
    total.forEach(function (item, i) {
      if (item.classList.contains('flex-row')) {
        item.classList.remove('flex-row');
        item.classList.add('flex-column', 'on-resize');
      }
    });
  }

  function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
  }
}

/***/ }),

/***/ "./resources/vue-material-dashboard-2/src/assets/js/ripple-effect.js":
/*!***************************************************************************!*\
  !*** ./resources/vue-material-dashboard-2/src/assets/js/ripple-effect.js ***!
  \***************************************************************************/
/***/ (() => {

/* eslint-disable */
window.onload = function () {
  var ripples = document.querySelectorAll(".btn");

  for (var i = 0; i < ripples.length; i++) {
    ripples[i].addEventListener("click", function (e) {
      var targetEl = e.target;
      var rippleDiv = targetEl.querySelector(".ripple");
      rippleDiv = document.createElement("span");
      rippleDiv.classList.add("ripple");
      rippleDiv.style.width = rippleDiv.style.height = Math.max(targetEl.offsetWidth, targetEl.offsetHeight) + "px";
      targetEl.appendChild(rippleDiv);
      rippleDiv.style.left = e.offsetX - rippleDiv.offsetWidth / 2 + "px";
      rippleDiv.style.top = e.offsetY - rippleDiv.offsetHeight / 2 + "px";
      rippleDiv.classList.add("ripple");
      setTimeout(function () {
        rippleDiv.parentElement.removeChild(rippleDiv);
      }, 600);
    }, false);
  }
};

/***/ }),

/***/ "./resources/vue-material-dashboard-2/src/material-dashboard.js":
/*!**********************************************************************!*\
  !*** ./resources/vue-material-dashboard-2/src/material-dashboard.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _assets_js_nav_pills_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./assets/js/nav-pills.js */ "./resources/vue-material-dashboard-2/src/assets/js/nav-pills.js");
/* harmony import */ var _assets_js_ripple_effect_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./assets/js/ripple-effect.js */ "./resources/vue-material-dashboard-2/src/assets/js/ripple-effect.js");
/* harmony import */ var _assets_js_ripple_effect_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_assets_js_ripple_effect_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _assets_scss_material_dashboard_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./assets/scss/material-dashboard.scss */ "./resources/vue-material-dashboard-2/src/assets/scss/material-dashboard.scss");



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  install: function install() {}
});

/***/ }),

/***/ "./resources/vue-material-dashboard-2/src/assets/scss/material-dashboard.scss":
/*!************************************************************************************!*\
  !*** ./resources/vue-material-dashboard-2/src/assets/scss/material-dashboard.scss ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/material-dashboard": 0,
/******/ 			"css/material-dashboard": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/material-dashboard"], () => (__webpack_require__("./resources/vue-material-dashboard-2/src/material-dashboard.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;