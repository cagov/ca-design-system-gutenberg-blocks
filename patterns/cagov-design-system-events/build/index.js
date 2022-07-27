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
 * Developer note: run `wp-scripts build` at root of this plugin folder to compile & test this code, which is written as ES6
 */
// import "@wordpress/block-editor";
// import "@wordpress/blocks";
// import "@wordpress/components";
// import "@wordpress/compose";
// import "@wordpress/data";
// import "@wordpress/date";
// import "@wordpress/element";
// import "@wordpress/i18n";
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
  PanelBody,
  Placeholder,
  Spinner
} = components;
const {
  Fragment,
  useState,
  useEffect,
  createElement,
  Component
} = element;
const {
  InspectorControls,
  RichText,
  InnerBlocks,
  useBlockProps,
  AlignmentToolbar,
  BlockControls
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

const AddToCalendar = ({}) => {};

const EventDateTimePicker = ({
  dateTime,
  setDateTime
}) => {
  return createElement(DateTimePicker, {
    currentDate: dateTime,
    onChange: newDate => {
      console.log("changed date time", newDate);
      setDateTime(newDate);
    },
    is12Hour: true
  });
};

blocks.registerBlockType("ca-design-system/event-detail", {
  title: __("Event Detail", "ca-design-system"),
  icon: "format-aside",
  category: "ca-design-system",
  description: __("Block for details about an event"),
  supports: {
    reusable: true,
    multiple: false,
    inserter: true
  },
  attributes: {
    title: {
      type: "string",
      default: __("Event Details", "ca-design-system")
    },
    startDateTimeUTC: {
      type: "string" // default: formattedDateTime, // In UTC

    },
    endDateTimeUTC: {
      type: "string" // default: formattedDateTime,

    },
    // @TODO may deprecate
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
    localTimezone: {
      type: "string" // default: formattedTimePlusHour

    },
    localTimezoneLabel: {
      type: "string" // default: formattedTimePlusHour

    },
    location: {
      type: "string"
    },
    cost: {
      type: "string"
    },
    body: {
      type: 'array',
      source: 'children',
      selector: '.cagov-card-body-content'
    }
  },
  example: {
    attributes: {
      title: "Event Details",
      body: __("Lorem ipsum", "cagov-design-system")
    }
  },
  edit: function (props) {
    // const [openDatePopup, setOpenDatePopup] = useState(false); // @TODO unimplemented can re-implement.
    let {
      title,
      startDateTimeUTC,
      endDateTimeUTC,
      startDate,
      endDate,
      startTime,
      endTime,
      localTimezone,
      localTimezoneLabel,
      location,
      cost
    } = props.attributes;

    const setStartDateTime = dateTime => {
      var formattedStartDate = null;
      var formattedStartTime = null;

      if (dateTime !== null) {
        formattedStartDate = moment.utc(dateTime).tz("America/Los_Angeles").format("MMMM D, YYYY");
        formattedStartTime = moment.utc(dateTime).tz("America/Los_Angeles").format("h:mm A");
        console.log("dt", dateTime, formattedStartDate, formattedStartTime);
        props.setAttributes({
          startDateTimeUTC: dateTime,
          startDate: formattedStartDate,
          startTime: formattedStartTime,
          localTimezone: "America/Los_Angeles",
          localTimezoneLabel: "PST"
        });
      }
    };

    const setEndDateTime = dateTime => {
      var formattedEndDate = null;
      var formattedEndTime = null;

      if (dateTime !== null) {
        formattedEndDate = moment.utc(dateTime).tz("America/Los_Angeles").format("MMMM D, YYYY");
        formattedEndTime = moment.utc(dateTime).tz("America/Los_Angeles").format("h:mm A");
      }

      props.setAttributes({
        endDateTimeUTC: dateTime,
        endDate: formattedEndDate,
        endTime: formattedEndTime
      });
    };

    return createElement("div", useBlockProps(), createElement(RichText, {
      value: title,
      tagName: "h2",
      className: "title",
      onChange: title => props.setAttributes({
        title
      }),
      placeholder: __("Event Details", "ca-design-system")
    }), createElement("div", {
      class: "cagov-event-detail"
    }, createElement("div", {
      class: "detail-section"
    }, createElement("h4", null, __("Date & time", "ca-design-system")), createElement("div", {
      class: "startDate"
    }, startDate ? startDate : __("Select start and end date and time.", "ca-design-system")), endDate !== startDate && endDate !== null && createElement("div", {
      class: "endDate"
    }, endDate), createElement("br", null), createElement("div", {
      class: "startTime"
    }, startTime), endTime !== startTime && endTime !== null && createElement("div", {
      class: "endTime"
    }, endTime), createElement("div", {
      class: "timezone-label"
    }, localTimezoneLabel), createElement(InspectorControls, {
      key: "setting"
    }, createElement("div", {
      id: "datetime-controls"
    }, createElement("fieldset", null, createElement("legend", {
      className: "blocks-base-control__label"
    }, __("Start Date & Time", "ca-design-system")), createElement(EventDateTimePicker, {
      dateTime: startDateTimeUTC,
      setDateTime: startDateTimeUTC => setStartDateTime(startDateTimeUTC)
    })), createElement("fieldset", null, createElement("legend", {
      className: "blocks-base-control__label"
    }, __("End Date & Time", "ca-design-system")), createElement(EventDateTimePicker, {
      dateTime: endDateTimeUTC,
      setDateTime: endDateTimeUTC => setEndDateTime(endDateTimeUTC)
    }))))), createElement("div", {
      class: "detail-section"
    }, createElement("h4", null, __("Location", "ca-design-system")), createElement(RichText, {
      value: location,
      tagName: "div",
      className: "location",
      value: location,
      onChange: location => props.setAttributes({
        location
      }),
      placeholder: __("Where will this event happen?", "ca-design-system")
    })), createElement("div", {
      class: "detail-section"
    }, createElement("h4", null, __("Cost", "ca-design-system")), createElement(RichText, {
      value: cost,
      tagName: "div",
      className: "cost",
      value: cost,
      onChange: cost => props.setAttributes({
        cost
      }),
      placeholder: __("What is the cost of this event?", "ca-design-system")
    })), createElement("div", {
      class: "detail-section-more-info"
    }, createElement("div", {
      class: "cagov-card-body"
    }, el(InnerBlocks, {
      orientation: "horizontal",
      allowedBlocks: ["core/paragraph", "core/button"]
    })))));
  },
  save: function (props) {
    return el('div', {}, el('div', {
      className: 'cagov-card-body-content'
    }, el(InnerBlocks.Content)));
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
  category: "ca-design-system",
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
/* harmony import */ var _blocks_event_detail_block_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../blocks/event-detail/block.js */ "./blocks/event-detail/block.js");
/* harmony import */ var _blocks_event_detail_block_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_blocks_event_detail_block_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _blocks_event_materials_block_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../blocks/event-materials/block.js */ "./blocks/event-materials/block.js");
/* harmony import */ var _blocks_event_materials_block_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_blocks_event_materials_block_js__WEBPACK_IMPORTED_MODULE_1__);
// Build ES-Next Gutenberg Blocks



/***/ })

/******/ });
//# sourceMappingURL=index.js.map