/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./platform/core/acl/resources/assets/js/profile.js":
/*!**********************************************************!*\
  !*** ./platform/core/acl/resources/assets/js/profile.js ***!
  \**********************************************************/
/***/ (() => {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * Created on 06/09/2015.
 */
var CropAvatar = /*#__PURE__*/function () {
  function CropAvatar($element) {
    _classCallCheck(this, CropAvatar);

    this.$container = $element;
    this.$avatarView = this.$container.find('.avatar-view');
    this.$triggerButton = this.$avatarView.find('.mt-overlay .btn-outline');
    this.$avatar = this.$avatarView.find('img');
    this.$avatarModal = this.$container.find('#avatar-modal');
    this.$loading = this.$container.find('.loading');
    this.$avatarForm = this.$avatarModal.find('.avatar-form');
    this.$avatarSrc = this.$avatarForm.find('.avatar-src');
    this.$avatarData = this.$avatarForm.find('.avatar-data');
    this.$avatarInput = this.$avatarForm.find('.avatar-input');
    this.$avatarSave = this.$avatarForm.find('.avatar-save');
    this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');
    this.$avatarPreview = this.$avatarModal.find('.avatar-preview');
    this.support = {
      fileList: !!$('<input type="file">').prop('files'),
      fileReader: !!window.FileReader,
      formData: !!window.FormData
    };
  }

  _createClass(CropAvatar, [{
    key: "init",
    value: function init() {
      this.support.datauri = this.support.fileList && this.support.fileReader;

      if (!this.support.formData) {
        this.initIframe();
      }

      this.initTooltip();
      this.initModal();
      this.addListener();
    }
  }, {
    key: "addListener",
    value: function addListener() {
      this.$triggerButton.on('click', $.proxy(this.click, this));
      this.$avatarInput.on('change', $.proxy(this.change, this));
      this.$avatarForm.on('submit', $.proxy(this.submit, this));
    }
  }, {
    key: "initTooltip",
    value: function initTooltip() {
      this.$avatarView.tooltip({
        placement: 'bottom'
      });
    }
  }, {
    key: "initModal",
    value: function initModal() {
      this.$avatarModal.modal('hide');
      this.initPreview();
    }
  }, {
    key: "initPreview",
    value: function initPreview() {
      var url = this.$avatar.prop('src');
      this.$avatarPreview.empty().html('<img src="' + url + '">');
    }
  }, {
    key: "initIframe",
    value: function initIframe() {
      var iframeName = 'avatar-iframe-' + Math.random().toString().replace('.', ''),
          $iframe = $('<iframe name="' + iframeName + '" style="display:none;"></iframe>'),
          firstLoad = true,
          _this = this;

      this.$iframe = $iframe;
      this.$avatarForm.attr('target', iframeName).after($iframe);
      this.$iframe.on('load', function () {
        var data, win, doc;

        try {
          win = this.contentWindow;
          doc = this.contentDocument;
          doc = doc ? doc : win.document;
          data = doc ? doc.body.innerText : null;
        } catch (e) {}

        if (data) {
          _this.submitDone(data);
        } else if (firstLoad) {
          firstLoad = false;
        } else {
          _this.submitFail('Image upload failed!');
        }

        _this.submitEnd();
      });
    }
  }, {
    key: "click",
    value: function click() {
      this.$avatarModal.modal('show');
    }
  }, {
    key: "change",
    value: function change() {
      var files, file;

      if (this.support.datauri) {
        files = this.$avatarInput.prop('files');

        if (files.length > 0) {
          file = files[0];

          if (CropAvatar.isImageFile(file)) {
            this.read(file);
          }
        }
      } else {
        file = this.$avatarInput.val();

        if (CropAvatar.isImageFile(file)) {
          this.syncUpload();
        }
      }
    }
  }, {
    key: "submit",
    value: function submit() {
      if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
        Botble.showError('Please select image!');
        return false;
      }

      if (this.support.formData) {
        this.ajaxUpload();
        return false;
      }
    }
  }, {
    key: "read",
    value: function read(file) {
      var _this = this,
          fileReader = new FileReader();

      fileReader.readAsDataURL(file);

      fileReader.onload = function () {
        _this.url = this.result;

        _this.startCropper();
      };
    }
  }, {
    key: "startCropper",
    value: function startCropper() {
      var _this = this;

      if (this.active) {
        this.$img.cropper('replace', this.url);
      } else {
        this.$img = $('<img src="' + this.url + '">');
        this.$avatarWrapper.empty().html(this.$img);
        this.$img.cropper({
          aspectRatio: 1,
          rotatable: true,
          preview: this.$avatarPreview.selector,
          done: function done(data) {
            var json = ['{"x":' + data.x, '"y":' + data.y, '"height":' + data.height, '"width":' + data.width + "}"].join();

            _this.$avatarData.val(json);
          }
        });
        this.active = true;
      }
    }
  }, {
    key: "stopCropper",
    value: function stopCropper() {
      if (this.active) {
        this.$img.cropper('destroy');
        this.$img.remove();
        this.active = false;
      }
    }
  }, {
    key: "ajaxUpload",
    value: function ajaxUpload() {
      var url = this.$avatarForm.attr('action'),
          data = new FormData(this.$avatarForm[0]),
          _this = this;

      $.ajax(url, {
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        beforeSend: function beforeSend() {
          _this.submitStart();
        },
        success: function success(data) {
          _this.submitDone(data);
        },
        error: function error(XMLHttpRequest, textStatus, errorThrown) {
          _this.submitFail(XMLHttpRequest.responseJSON, textStatus || errorThrown);
        },
        complete: function complete() {
          _this.submitEnd();
        }
      });
    }
  }, {
    key: "syncUpload",
    value: function syncUpload() {
      this.$avatarSave.trigger('click');
    }
  }, {
    key: "submitStart",
    value: function submitStart() {
      this.$loading.fadeIn();
      this.$avatarSave.attr('disabled', true).text('Saving...');
    }
  }, {
    key: "submitDone",
    value: function submitDone(data) {
      try {
        data = $.parseJSON(data);
      } catch (e) {}

      if (data && !data.error) {
        if (data.data) {
          this.url = data.data.url;

          if (this.support.datauri || this.uploaded) {
            this.uploaded = false;
            this.cropDone();
          } else {
            this.uploaded = true;
            this.$avatarSrc.val(this.url);
            this.startCropper();
          }

          this.$avatarInput.val('');
          Botble.showSuccess(data.message);
        } else {
          Botble.showError(data.message);
        }
      } else {
        Botble.showError(data.message);
      }
    }
  }, {
    key: "submitEnd",
    value: function submitEnd() {
      this.$loading.fadeOut();
      this.$avatarSave.removeAttr('disabled').text('Save');
    }
  }, {
    key: "cropDone",
    value: function cropDone() {
      this.$avatarSrc.val('');
      this.$avatarData.val('');
      this.$avatar.prop('src', this.url);
      $('.user-menu img').prop('src', this.url);
      $('.user.dropdown img').prop('src', this.url);
      this.stopCropper();
      this.initModal();
    }
  }], [{
    key: "isImageFile",
    value: function isImageFile(file) {
      if (file.type) {
        return /^image\/\w+$/.test(file.type);
      }

      return /\.(jpg|jpeg|png|gif)$/.test(file);
    }
  }, {
    key: "submitFail",
    value: function submitFail(errors) {
      Botble.handleError(errors);
    }
  }]);

  return CropAvatar;
}();

$(document).ready(function () {
  new CropAvatar($('.crop-avatar')).init();
});

/***/ }),

/***/ "./platform/core/base/resources/assets/sass/base/themes/grey.scss":
/*!************************************************************************!*\
  !*** ./platform/core/base/resources/assets/sass/base/themes/grey.scss ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/base/resources/assets/sass/base/themes/light.scss":
/*!*************************************************************************!*\
  !*** ./platform/core/base/resources/assets/sass/base/themes/light.scss ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/base/resources/assets/sass/core.scss":
/*!************************************************************!*\
  !*** ./platform/core/base/resources/assets/sass/core.scss ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/base/resources/assets/sass/custom/system-info.scss":
/*!**************************************************************************!*\
  !*** ./platform/core/base/resources/assets/sass/custom/system-info.scss ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/base/resources/assets/sass/custom/email.scss":
/*!********************************************************************!*\
  !*** ./platform/core/base/resources/assets/sass/custom/email.scss ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/dashboard/resources/assets/sass/dashboard.scss":
/*!**********************************************************************!*\
  !*** ./platform/core/dashboard/resources/assets/sass/dashboard.scss ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/media/resources/assets/sass/media.scss":
/*!**************************************************************!*\
  !*** ./platform/core/media/resources/assets/sass/media.scss ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/setting/resources/assets/sass/setting.scss":
/*!******************************************************************!*\
  !*** ./platform/core/setting/resources/assets/sass/setting.scss ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/table/resources/assets/sass/table.scss":
/*!**************************************************************!*\
  !*** ./platform/core/table/resources/assets/sass/table.scss ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/packages/menu/resources/assets/sass/menu.scss":
/*!****************************************************************!*\
  !*** ./platform/packages/menu/resources/assets/sass/menu.scss ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/packages/plugin-management/resources/assets/sass/plugin.scss":
/*!*******************************************************************************!*\
  !*** ./platform/packages/plugin-management/resources/assets/sass/plugin.scss ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/packages/revision/resources/assets/sass/revision.scss":
/*!************************************************************************!*\
  !*** ./platform/packages/revision/resources/assets/sass/revision.scss ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/packages/seo-helper/resources/assets/sass/seo-helper.scss":
/*!****************************************************************************!*\
  !*** ./platform/packages/seo-helper/resources/assets/sass/seo-helper.scss ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/packages/slug/resources/assets/sass/slug.scss":
/*!****************************************************************!*\
  !*** ./platform/packages/slug/resources/assets/sass/slug.scss ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/packages/theme/resources/assets/sass/custom-css.scss":
/*!***********************************************************************!*\
  !*** ./platform/packages/theme/resources/assets/sass/custom-css.scss ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/packages/theme/resources/assets/sass/theme-options.scss":
/*!**************************************************************************!*\
  !*** ./platform/packages/theme/resources/assets/sass/theme-options.scss ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/packages/theme/resources/assets/sass/admin-bar.scss":
/*!**********************************************************************!*\
  !*** ./platform/packages/theme/resources/assets/sass/admin-bar.scss ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/backup/resources/assets/sass/backup.scss":
/*!*******************************************************************!*\
  !*** ./platform/plugins/backup/resources/assets/sass/backup.scss ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/contact/resources/assets/sass/contact.scss":
/*!*********************************************************************!*\
  !*** ./platform/plugins/contact/resources/assets/sass/contact.scss ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/contact/resources/assets/sass/contact-public.scss":
/*!****************************************************************************!*\
  !*** ./platform/plugins/contact/resources/assets/sass/contact-public.scss ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/cookie-consent/resources/assets/sass/cookie-consent.scss":
/*!***********************************************************************************!*\
  !*** ./platform/plugins/cookie-consent/resources/assets/sass/cookie-consent.scss ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/ecommerce/resources/assets/sass/ecommerce.scss":
/*!*************************************************************************!*\
  !*** ./platform/plugins/ecommerce/resources/assets/sass/ecommerce.scss ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/ecommerce/resources/assets/sass/ecommerce-product-attributes.scss":
/*!********************************************************************************************!*\
  !*** ./platform/plugins/ecommerce/resources/assets/sass/ecommerce-product-attributes.scss ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/ecommerce/resources/assets/sass/currencies.scss":
/*!**************************************************************************!*\
  !*** ./platform/plugins/ecommerce/resources/assets/sass/currencies.scss ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/ecommerce/resources/assets/sass/review.scss":
/*!**********************************************************************!*\
  !*** ./platform/plugins/ecommerce/resources/assets/sass/review.scss ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/ecommerce/resources/assets/sass/customer.scss":
/*!************************************************************************!*\
  !*** ./platform/plugins/ecommerce/resources/assets/sass/customer.scss ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/ecommerce/resources/assets/sass/invoice.scss":
/*!***********************************************************************!*\
  !*** ./platform/plugins/ecommerce/resources/assets/sass/invoice.scss ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/ecommerce/resources/assets/sass/front-theme.scss":
/*!***************************************************************************!*\
  !*** ./platform/plugins/ecommerce/resources/assets/sass/front-theme.scss ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/ecommerce/resources/assets/sass/front-theme-rtl.scss":
/*!*******************************************************************************!*\
  !*** ./platform/plugins/ecommerce/resources/assets/sass/front-theme-rtl.scss ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/payment/resources/assets/sass/payment.scss":
/*!*********************************************************************!*\
  !*** ./platform/plugins/payment/resources/assets/sass/payment.scss ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/payment/resources/assets/sass/payment-methods.scss":
/*!*****************************************************************************!*\
  !*** ./platform/plugins/payment/resources/assets/sass/payment-methods.scss ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/simple-slider/resources/assets/sass/simple-slider.scss":
/*!*********************************************************************************!*\
  !*** ./platform/plugins/simple-slider/resources/assets/sass/simple-slider.scss ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/simple-slider/resources/assets/sass/simple-slider-admin.scss":
/*!***************************************************************************************!*\
  !*** ./platform/plugins/simple-slider/resources/assets/sass/simple-slider-admin.scss ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/social-login/resources/assets/sass/social-login.scss":
/*!*******************************************************************************!*\
  !*** ./platform/plugins/social-login/resources/assets/sass/social-login.scss ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/translation/resources/assets/sass/translation.scss":
/*!*****************************************************************************!*\
  !*** ./platform/plugins/translation/resources/assets/sass/translation.scss ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/plugins/translation/resources/assets/sass/theme-translations.scss":
/*!************************************************************************************!*\
  !*** ./platform/plugins/translation/resources/assets/sass/theme-translations.scss ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/themes/martfury/assets/sass/style.scss":
/*!*********************************************************!*\
  !*** ./platform/themes/martfury/assets/sass/style.scss ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/themes/martfury/assets/sass/custom.scss":
/*!**********************************************************!*\
  !*** ./platform/themes/martfury/assets/sass/custom.scss ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/acl/resources/assets/sass/login.scss":
/*!************************************************************!*\
  !*** ./platform/core/acl/resources/assets/sass/login.scss ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/base/resources/assets/sass/base/themes/blue.scss":
/*!************************************************************************!*\
  !*** ./platform/core/base/resources/assets/sass/base/themes/blue.scss ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/base/resources/assets/sass/base/themes/darkblue.scss":
/*!****************************************************************************!*\
  !*** ./platform/core/base/resources/assets/sass/base/themes/darkblue.scss ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./platform/core/base/resources/assets/sass/base/themes/default.scss":
/*!***************************************************************************!*\
  !*** ./platform/core/base/resources/assets/sass/base/themes/default.scss ***!
  \***************************************************************************/
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
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
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
/******/ 	// the startup function
/******/ 	// It's empty as some runtime module handles the default behavior
/******/ 	__webpack_require__.x = x => {};
/************************************************************************/
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
/******/ 		// Promise = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/vendor/core/core/acl/js/profile": 0
/******/ 		};
/******/ 		
/******/ 		var deferredModules = [
/******/ 			["./platform/core/acl/resources/assets/js/profile.js"],
/******/ 			["./platform/core/acl/resources/assets/sass/login.scss"],
/******/ 			["./platform/core/base/resources/assets/sass/base/themes/blue.scss"],
/******/ 			["./platform/core/base/resources/assets/sass/base/themes/darkblue.scss"],
/******/ 			["./platform/core/base/resources/assets/sass/base/themes/default.scss"],
/******/ 			["./platform/core/base/resources/assets/sass/base/themes/grey.scss"],
/******/ 			["./platform/core/base/resources/assets/sass/base/themes/light.scss"],
/******/ 			["./platform/core/base/resources/assets/sass/core.scss"],
/******/ 			["./platform/core/base/resources/assets/sass/custom/system-info.scss"],
/******/ 			["./platform/core/base/resources/assets/sass/custom/email.scss"],
/******/ 			["./platform/core/dashboard/resources/assets/sass/dashboard.scss"],
/******/ 			["./platform/core/media/resources/assets/sass/media.scss"],
/******/ 			["./platform/core/setting/resources/assets/sass/setting.scss"],
/******/ 			["./platform/core/table/resources/assets/sass/table.scss"],
/******/ 			["./platform/packages/menu/resources/assets/sass/menu.scss"],
/******/ 			["./platform/packages/plugin-management/resources/assets/sass/plugin.scss"],
/******/ 			["./platform/packages/revision/resources/assets/sass/revision.scss"],
/******/ 			["./platform/packages/seo-helper/resources/assets/sass/seo-helper.scss"],
/******/ 			["./platform/packages/slug/resources/assets/sass/slug.scss"],
/******/ 			["./platform/packages/theme/resources/assets/sass/custom-css.scss"],
/******/ 			["./platform/packages/theme/resources/assets/sass/theme-options.scss"],
/******/ 			["./platform/packages/theme/resources/assets/sass/admin-bar.scss"],
/******/ 			["./platform/plugins/backup/resources/assets/sass/backup.scss"],
/******/ 			["./platform/plugins/contact/resources/assets/sass/contact.scss"],
/******/ 			["./platform/plugins/contact/resources/assets/sass/contact-public.scss"],
/******/ 			["./platform/plugins/cookie-consent/resources/assets/sass/cookie-consent.scss"],
/******/ 			["./platform/plugins/ecommerce/resources/assets/sass/ecommerce.scss"],
/******/ 			["./platform/plugins/ecommerce/resources/assets/sass/ecommerce-product-attributes.scss"],
/******/ 			["./platform/plugins/ecommerce/resources/assets/sass/currencies.scss"],
/******/ 			["./platform/plugins/ecommerce/resources/assets/sass/review.scss"],
/******/ 			["./platform/plugins/ecommerce/resources/assets/sass/customer.scss"],
/******/ 			["./platform/plugins/ecommerce/resources/assets/sass/invoice.scss"],
/******/ 			["./platform/plugins/ecommerce/resources/assets/sass/front-theme.scss"],
/******/ 			["./platform/plugins/ecommerce/resources/assets/sass/front-theme-rtl.scss"],
/******/ 			["./platform/plugins/payment/resources/assets/sass/payment.scss"],
/******/ 			["./platform/plugins/payment/resources/assets/sass/payment-methods.scss"],
/******/ 			["./platform/plugins/simple-slider/resources/assets/sass/simple-slider.scss"],
/******/ 			["./platform/plugins/simple-slider/resources/assets/sass/simple-slider-admin.scss"],
/******/ 			["./platform/plugins/social-login/resources/assets/sass/social-login.scss"],
/******/ 			["./platform/plugins/translation/resources/assets/sass/translation.scss"],
/******/ 			["./platform/plugins/translation/resources/assets/sass/theme-translations.scss"],
/******/ 			["./platform/themes/martfury/assets/sass/style.scss"],
/******/ 			["./platform/themes/martfury/assets/sass/custom.scss"]
/******/ 		];
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
/******/ 		var checkDeferredModules = x => {};
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime, executeModules] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0, resolves = [];
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					resolves.push(installedChunks[chunkId][0]);
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			while(resolves.length) {
/******/ 				resolves.shift()();
/******/ 			}
/******/ 		
/******/ 			// add entry modules from loaded chunk to deferred list
/******/ 			if(executeModules) deferredModules.push.apply(deferredModules, executeModules);
/******/ 		
/******/ 			// run deferred modules when all chunks ready
/******/ 			return checkDeferredModules();
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 		
/******/ 		function checkDeferredModulesImpl() {
/******/ 			var result;
/******/ 			for(var i = 0; i < deferredModules.length; i++) {
/******/ 				var deferredModule = deferredModules[i];
/******/ 				var fulfilled = true;
/******/ 				for(var j = 1; j < deferredModule.length; j++) {
/******/ 					var depId = deferredModule[j];
/******/ 					if(installedChunks[depId] !== 0) fulfilled = false;
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferredModules.splice(i--, 1);
/******/ 					result = __webpack_require__(__webpack_require__.s = deferredModule[0]);
/******/ 				}
/******/ 			}
/******/ 			if(deferredModules.length === 0) {
/******/ 				__webpack_require__.x();
/******/ 				__webpack_require__.x = x => {};
/******/ 			}
/******/ 			return result;
/******/ 		}
/******/ 		var startup = __webpack_require__.x;
/******/ 		__webpack_require__.x = () => {
/******/ 			// reset startup function so it can be called again when more startup code is added
/******/ 			__webpack_require__.x = startup || (x => {});
/******/ 			return (checkDeferredModules = checkDeferredModulesImpl)();
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// run startup
/******/ 	var __webpack_exports__ = __webpack_require__.x();
/******/ 	
/******/ })()
;