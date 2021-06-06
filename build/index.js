/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
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
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./blocks/event-detail/block.js":
/*!**************************************!*\
  !*** ./blocks/event-detail/block.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * CAGov Event Detail
 *
 */
const {
  blocks,
  blockEditor,
  i18n,
  element,
  components,
  date,
  data,
  compose
} = wp;
const {
  moment,
  _
} = window;
const {
  dateI18n
} = date;
const {
  DateTimePicker,
  DatePicker,
  Popover,
  Button,
  PanelRow,
  TextControl,
  Panel,
  PanelBody
} = components;
const {
  Fragment,
  useState,
  useEffect,
  createElement
} = element;
const {
  InspectorControls,
  RichText,
  InnerBlocks
} = blockEditor;
const {
  useSelect,
  useDispatch
} = data;
const {
  withState
} = compose;
var __ = i18n.__;
var el = createElement;
blocks.registerBlockType("ca-design-system/event-detail", {
  title: __("CAGov: Event Detail", "ca-design-system"),
  icon: "universal-access-alt",
  category: "layout",
  attributes: {
    startDate: {
      type: "array",
      source: "children",
      selector: "div.start-date"
    },
    endDate: {
      type: "array",
      source: "children",
      selector: "div.end-date"
    },
    location: {
      type: "array",
      source: "children",
      selector: "div.location"
    },
    cost: {
      type: "array",
      source: "children",
      selector: "div.cost"
    }
  },
  example: {
    startDate: __("Start Data & Time", "ca-design-system")
  },
  edit: function (props) {
    const [openDatePopup, setOpenDatePopup] = useState(false);
    var attributes = props.attributes;
    const {
      startDate,
      endDate,
      location,
      cost
    } = props.attributes; // https://developer.wordpress.org/block-editor/reference-guides/components/date-time/

    return createElement("div", {
      className: "cagov-event-detail cagov-stack"
    }, createElement("div", {
      className: "start-date"
    }, "START: ", moment(startDate).format("MMMM Do YYYY, h:mm:ss a"), " "), createElement("div", {
      className: "end-date"
    }, "End: ", moment(endDate).format("MMMM Do YYYY, h:mm:ss a"), " "), createElement("hr", null), "REWORKING THESE:", createElement(DateTimePicker, {
      currentDate: props.attributes.startDate,
      onChange: val => props.setAttributes({
        startDate: val
      }),
      is12Hour: false
    }), createElement(DateTimePicker, {
      currentDate: props.attributes.endDate,
      onChange: val => props.setAttributes({
        endDate: val
      }),
      is12Hour: false
    }), createElement("hr", null), createElement("h4", null, "Location"), createElement(RichText.Content, {
      value: attributes.location,
      tagName: "div",
      className: "location",
      value: attributes.location,
      onChange: location => props.setAttributes({
        location
      }),
      placeholder: __("Enter text...", "ca-design-system")
    }), createElement(RichText.Content, {
      value: props.attributes.cost,
      tagName: "div",
      className: "cost",
      value: attributes.location,
      onChange: cost => props.setAttributes({
        cost
      }),
      placeholder: __("Enter text...", "ca-design-system")
    }));
  },
  save: function (props) {
    var attributes = props.attributes;
    return createElement("div", {
      className: "cagov-event-detail cagov-stack"
    }, createElement("div", {
      className: "start-date"
    }, attributes.startDate), createElement("div", {
      className: "end-date"
    }, attributes.endDate), createElement(RichText.Content, {
      tagName: "div",
      className: "location",
      value: attributes.location
    }));
  } // <div className="cost">{attributes.cost}</div>

});

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _blocks_event_detail_block_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./../blocks/event-detail/block.js */ "./blocks/event-detail/block.js");
/* harmony import */ var _blocks_event_detail_block_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_blocks_event_detail_block_js__WEBPACK_IMPORTED_MODULE_0__);
// Build ES-Next Gutenberg Blocks
 // @TODO try keeping blocks and patterns at root and just mess around with imports here until have it worked out, then consider moving src

/***/ })

/******/ });
//# sourceMappingURL=index.js.map