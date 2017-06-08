/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ 1:
/***/ (function(module, exports) {

;(function () {
    $(document).on('keyup', '[name="weight"]', _checkButtonRegistration).on('change', '[name="image"]', _checkButtonRegistration);

    function _checkButtonRegistration() {
        if (_onChangeFile() && _onChangeWeight()) {
            $('form#registration_perhibition input[type="submit"]').removeAttr('disabled');
            $('.prohibition-error').css('display', 'none');
        } else {
            $('form#registration_perhibition input[type="submit"]').attr('disabled', 'disabled');
            $('.prohibition-error').css('display', 'block').find('span').text("Для регистрации необходимо ввести вес и прикрепить фотографию!");
        }
    }

    function _onChangeWeight(event) {
        var $evt = $('[name="weight"]');
        var value = $evt.val();
        if (value.length > 0) {
            return true;
        } else {
            return false;
        }
    }

    function _onChangeFile(event) {
        var $evt = $('[name="image"]');
        console.log(rightFileExtension());
        var value = $evt.val();
        if (value != "") {
            if (rightFileExtension()) {
                return true;
            } else {
                $('[name="image"]').val('');
                alert("Файл имеет наверное расширение!");
                return false;
            }
        } else {
            return false;
        }
    }

    function rightFileExtension() {
        var exts = ['.jpg', '.png', '.JPG', '.PNG'];
        var fileName = $('[name="image"]').val();
        return new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$').test(fileName);
    }
})();

/***/ }),

/***/ 10:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(1);


/***/ })

/******/ });