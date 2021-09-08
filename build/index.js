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
 * Developer note:
 * Reminder to run npm start & npm run build to generate this component  (wp-scripts build also works)
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
  category: "ca-design-system-utilities",
  description: __("Block for details about an event"),
  attributes: {
    title: {
      type: "string",
      default: "Event Details"
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
    }
  },
  example: {
    attributes: {
      title: "Event Details"
    }
  },
  edit: function (props) {
    // const [openDatePopup, setOpenDatePopup] = useState(false); // @TODO unimplemented can re-implement.
    const {
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
    } = props.attributes; // @TODO Validation (start time before)

    const setStartDateTime = dateTime => {
      // @TODO TZ settings & label
      var formattedStartDate = null;
      var formattedStartTime = null;

      if (dateTime !== null) {
        formattedStartDate = moment.utc(startDateTimeUTC).tz('America/Los_Angeles').format("MMMM DD, YYYY");
        formattedStartTime = moment.utc(startDateTimeUTC).tz('America/Los_Angeles').format("hh:mm a");
      }

      props.setAttributes({
        startDateTimeUTC: dateTime,
        startDate: formattedStartDate,
        startTime: formattedStartTime,
        localTimezone: 'America/Los_Angeles',
        localTimezoneLabel: 'PST'
      });
    };

    const setEndDateTime = dateTime => {
      var formattedEndDate = null;
      var formattedEndTime = null;

      if (dateTime !== null) {
        formattedEndDate = moment.utc(endDateTimeUTC).tz('America/Los_Angeles').format("MMMM DD, YYYY");
        formattedEndTime = moment.utc(endDateTimeUTC).tz('America/Los_Angeles').format("hh:mm a");
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
      className: "cagov-grid cagov-event-detail cagov-stack cagov-block"
    }, createElement("div", {
      class: "detail-section"
    }, createElement("h4", null, __("Date & time", "ca-design-system")), createElement("div", {
      class: "startDate"
    }, startDate !== null ? startDate : __("Choose date in block settings", "ca-design-system")), endDate !== startDate && endDate !== null && createElement("div", {
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
      placeholder: __("Enter text...", "ca-design-system")
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
      placeholder: __("Enter text...", "ca-design-system")
    })), createElement("div", {
      class: "detail-section-more-info"
    }, el(InnerBlocks, {
      orientation: "horizontal",
      allowedBlocks: ["core/paragraph", "core/button"]
    }))));
  },
  save: function (props) {
    return el("div", {
      className: "wp-block-ca-design-system-event-detail cagov-event-detail cagov-stack"
    }, el(InnerBlocks.Content));
  }
}); // REFERENCE
// Checks we need to do:
// -
// https://bebroide.medium.com/how-to-easily-develop-with-react-your-own-custom-fields-within-gutenberg-wordpress-editor-b868c1e193a9
// Sync date and time field with post custom field data.
// data.subscribe(function () {
//   var blocks = data.select("core/block-editor").getBlocks();
//   var isPostDirty = data.select("core/editor").isEditedPostDirty();
//   var isAutosavingPost = data.select("core/editor").isAutosavingPost();
//   if (isPostDirty && !isAutosavingPost) {
//     blocks.map((block) => {
//       if (block.name === "ca-design-system/cagov-event-detail") {
//         let eventDetailBlock = data
//           .select("core/block-editor")
//           .getBlocksByClientId(block.clientId);
//         console.log(eventDetailBlock);
//         eventDetailBlock.map((localBlock) => {
//           if (
//             localBlock.attributes !== undefined &&
//             localBlock.attributes.label !== null &&
//             // typeof updatedSelectedCategory[0].name === "string"
//           ) {
//             console.log("updating", localBlock);
//           }
//         });
//       }
//     });
//   }
// });
// https://developer.wordpress.org/block-editor/reference-guides/components/date-time/
// <OptionsExample {...props} />
// class OptionsExample extends Component {
//   constructor() {
//     super(...arguments);
//     this.state = {
//       exampleText: "",
//       isAPILoaded: false,
//     };
//   }
//   // https://developer.wordpress.org/block-editor/reference-guides/components/date-time/
//   componentDidMount() {
//     data.subscribe(() => {
//       const { exampleText } = this.state;
//       const isSavingPost = data.select("core/editor").isSavingPost();
//       const isAutosavingPost = data.select("core/editor").isAutosavingPost();
//       if (isAutosavingPost) {
//         return;
//       }
//       if (!isSavingPost) {
//         return;
//       }
//       const settings = new window.wp.api.models.Settings({
//         ["cagov_event_detail_example_text"]: exampleText,
//       });
//       settings.save();
//     });
//     // @TODO This is recommended in guide to this pattern ... but api not registered to window.wp
//     window.wp.api.loadPromise.then(() => {
//       this.settings = new window.wp.api.models.Settings();
//       const { isAPILoaded } = this.state;
//       // console.log("isAPILoaded", isAPILoaded);
//       if (isAPILoaded === false) {
//         this.settings.fetch().then((response) => {
//           // console.log("api response", response.cagov_event_detail_example_text);
//           this.setState({
//             exampleText: response.cagov_event_detail_example_text,
//             isAPILoaded: true,
//           }, () => console.log("set the state", this.state));
//         });
//       }
//     });
//   }
//   render() {
//     const { exampleText, isAPILoaded } = this.state;
//     const { setAttributes } = this.props;
//     // console.log("setAttributes", setAttributes);
//     if (!isAPILoaded) {
//       return (
//         <Placeholder>
//           <Spinner />
//         </Placeholder>
//       );
//     }
//     console.log(this.state);
//     return (
//       <Panel>
//         <PanelBody
//           title={__("Example Meta Box", "cagov_event_detail")}
//           icon="admin-plugins"
//         >
//           <TextControl
//             help={__("This is an example text field.", "cagov-event-detail")}
//             label={__("Example Text", "cagov_event_detail")}
//             onChange={(exampleText) => {
//               this.setState({ exampleText });
//               setAttributes({ exampleText });
//             }}
//             value={exampleText}
//           />
//         </PanelBody>
//       </Panel>
//     );
//   }
// }
// export default function Edit( props ) {
// 	return (
// 		<div { ...useBlockProps() }>
// 			<OptionsExample { ...props }/>
// 		</div>
// 	);
// }
// const onUpdateDate = ( dateTime ) => {
//   console.log("dateTime", dateTime);
//   var newDateTime = moment(dateTime).format( 'YYYY-MM-DD HH:mm' );
//   setAttributes( { datetime: newDateTime } );
// };

{
  /* <RichText
              value={startDate}
              tagName="div"
              className="startDate"
              value={startDate}
              onChange={(startDate) => props.setAttributes({ startDate })}
              placeholder={__(formattedDate, "ca-design-system")}
            /> 
            
            <RichText
              value={endDate}
              tagName="div"
              className="endDate"
              value={endDate}
              onChange={(endDate) => props.setAttributes({ endDate })}
              placeholder={__(formattedDate, "ca-design-system")}
            />
             <RichText
              value={startTime}
              tagName="div"
              className="startTime"
              value={startTime}
              onChange={(startTime) => props.setAttributes({ startTime })}
              placeholder={__(formattedTime, "ca-design-system")}
            />
             <RichText
              value={endTime}
              tagName="div"
              className="endTime"
              value={endTime}
              onChange={(endTime) => props.setAttributes({ endTime })}
              placeholder={__(formattedTimePlusHour, "ca-design-system")}
            /> */
}

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