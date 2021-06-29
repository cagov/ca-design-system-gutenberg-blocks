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
 * Developer note: Reminder to run npm start & npm run build to generate this component.
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
var defaultDate = new Date();
var formattedDate = moment(defaultDate).format("MMMM DD, YYYY");
var formattedTime = moment(defaultDate).startOf('hour').format("hh:mm a");
var formattedTimePlusHour = moment(defaultDate).startOf('hour').add(moment.duration(1, 'hours')).format("hh:mm a");
blocks.registerBlockType("ca-design-system/event-detail", {
  title: __("Event Detail", "ca-design-system"),
  icon: "format-aside",
  category: "ca-design-system-utilities",
  description: __("Block for details about an event"),
  attributes: {
    title: {
      type: "string",
      default: "Event Details"
    },
    startDate: {
      type: "string" // default: formattedDate,

    },
    endDate: {
      type: "string" // default: formattedDate,

    },
    startTime: {
      type: "string" // default: formattedTime

    },
    endTime: {
      type: "string" // default: formattedTimePlusHour

    },
    location: {
      type: "string"
    },
    cost: {
      type: "string"
    }
  },
  example: {
    attributes: {
      title: "Event Details"
    }
  },
  edit: function (props) {
    const [openDatePopup, setOpenDatePopup] = useState(false);
    var attributes = props.attributes;
    const {
      title,
      startDate,
      endDate,
      startTime,
      endTime,
      location,
      cost
    } = props.attributes; // https://developer.wordpress.org/block-editor/reference-guides/components/date-time/

    return createElement("div", null, createElement(RichText, {
      value: title,
      tagName: "h2",
      className: "title",
      onChange: title => props.setAttributes({
        title
      }),
      placeholder: __("Event Details", "ca-design-system")
    }), createElement("div", {
      className: "cagov-event-detail cagov-stack"
    }, createElement("h3", null, "Date & time"), createElement(RichText, {
      value: startDate,
      tagName: "div",
      className: "startDate",
      value: startDate,
      onChange: startDate => props.setAttributes({
        startDate
      }),
      placeholder: __(formattedDate, "ca-design-system")
    }), createElement(RichText, {
      value: endDate,
      tagName: "div",
      className: "endDate",
      value: endDate,
      onChange: endDate => props.setAttributes({
        endDate
      }),
      placeholder: __(formattedDate, "ca-design-system")
    }), createElement(RichText, {
      value: startTime,
      tagName: "div",
      className: "startTime",
      value: startTime,
      onChange: startTime => props.setAttributes({
        startTime
      }),
      placeholder: __(formattedTime, "ca-design-system")
    }), createElement(RichText, {
      value: endTime,
      tagName: "div",
      className: "endTime",
      value: endTime,
      onChange: endTime => props.setAttributes({
        endTime
      }),
      placeholder: __(formattedTimePlusHour, "ca-design-system")
    }), createElement("h3", null, "Location"), createElement(RichText, {
      value: location,
      tagName: "div",
      className: "location",
      value: location,
      onChange: location => props.setAttributes({
        location
      }),
      placeholder: __("Enter text...", "ca-design-system")
    }), createElement("h3", null, "Cost"), createElement(RichText, {
      value: cost,
      tagName: "div",
      className: "cost",
      value: cost,
      onChange: cost => props.setAttributes({
        cost
      }),
      placeholder: __("Enter text...", "ca-design-system")
    })));
  }
});

/***/ }),

/***/ "./blocks/event-materials/block.js":
/*!*****************************************!*\
  !*** ./blocks/event-materials/block.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * CAGov Event Materials
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
blocks.registerBlockType("ca-design-system/event-materials", {
  title: __("Event Materials", "ca-design-system"),
  icon: "format-aside",
  category: "ca-design-system-utilities",
  description: __("Block for materials from an event"),
  attributes: {
    title: {
      type: "string",
      default: "Event Materials"
    },
    agenda: {
      type: "string"
    },
    materials: {
      type: "string"
    }
  },
  example: {
    attributes: {}
  },
  edit: function (props) {
    var attributes = props.attributes;
    return createElement("div", null, createElement("h2", null, createElement(RichText, {
      value: attributes.title,
      tagName: "div",
      className: "title",
      onChange: title => props.setAttributes({
        title
      }),
      placeholder: __("Event Materials", "ca-design-system")
    })), createElement("div", {
      className: "cagov-event-materials cagov-stack"
    }, createElement("h3", null, "Agenda"), createElement(RichText, {
      value: attributes.agenda,
      tagName: "div",
      className: "agenda",
      value: attributes.agenda,
      onChange: agenda => props.setAttributes({
        agenda
      }),
      placeholder: __("Link to a plain text agenda and agenda files", "ca-design-system")
    }), createElement("h3", null, "Materials"), createElement(RichText, {
      value: attributes.materials,
      tagName: "div",
      className: "materials",
      value: attributes.materials,
      onChange: materials => props.setAttributes({
        materials
      }),
      placeholder: __("Link to a plain text materials and materials files", "ca-design-system")
    })));
  }
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
/* harmony import */ var _blocks_event_materials_block_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./../blocks/event-materials/block.js */ "./blocks/event-materials/block.js");
/* harmony import */ var _blocks_event_materials_block_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_blocks_event_materials_block_js__WEBPACK_IMPORTED_MODULE_1__);
// Build ES-Next Gutenberg Blocks

 // @TODO try keeping blocks and patterns at root and just mess around with imports here until have it worked out, then consider moving src

/***/ })

/******/ });
//# sourceMappingURL=index.js.map