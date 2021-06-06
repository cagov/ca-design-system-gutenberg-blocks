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
  compose,
} = wp;
const { moment, _ } = window;

const { dateI18n } = date;
const {
  DateTimePicker,
  DatePicker,
  Popover,
  Button,
  PanelRow,
  TextControl,
  Panel,
  PanelBody,
} = components;
const { Fragment, useState, useEffect, createElement } = element;
const { InspectorControls, RichText, InnerBlocks } = blockEditor;
const { useSelect, useDispatch } = data;
const { withState } = compose;

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
      selector: "div.start-date",
    },
    endDate: {
      type: "array",
      source: "children",
      selector: "div.end-date",
    },
    location: {
      type: "array",
      source: "children",
      selector: "div.location",
    },
    cost: {
      type: "array",
      source: "children",
      selector: "div.cost",
    },
  },
  example: {
    startDate: __("Start Data & Time", "ca-design-system"),
  },
  edit: function (props) {
    const [openDatePopup, setOpenDatePopup] = useState(false);
    var attributes = props.attributes;
    const { startDate, endDate, location, cost } = props.attributes;

    // https://developer.wordpress.org/block-editor/reference-guides/components/date-time/

    return (
      <div className="cagov-event-detail cagov-stack">
        <div className="start-date">
          START: {moment(startDate).format("MMMM Do YYYY, h:mm:ss a")}{" "}
        </div>
        <div className="end-date">
          End: {moment(endDate).format("MMMM Do YYYY, h:mm:ss a")}{" "}
        </div>
        <hr />
        REWORKING THESE:
        <DateTimePicker
          currentDate={props.attributes.startDate}
          onChange={(val) => props.setAttributes({ startDate: val })}
          is12Hour={false}
        />
        <DateTimePicker
          currentDate={props.attributes.endDate}
          onChange={(val) => props.setAttributes({ endDate: val })}
          is12Hour={false}
        />
        <hr />
        <h4>Location</h4>
        <RichText.Content
          value={attributes.location}
          tagName="div"
          className="location"
          value={attributes.location}
          onChange={(location) => props.setAttributes({ location })}
          placeholder={__("Enter text...", "ca-design-system")}
        />
        {/* <InnerBlocks
            allowedBlocks={["core/paragraph", "core/button"]}
            onChange={(value) => {
              props.setAttributes({ location: value });
            }}
          /> */}
        <RichText.Content
          value={props.attributes.cost}
          tagName="div"
          className="cost"
          value={attributes.location}
          onChange={(cost) => props.setAttributes({ cost })}
          placeholder={__("Enter text...", "ca-design-system")}
        />
      </div>
    );
  },
  save: function (props) {
    var attributes = props.attributes;

    return (
      <div className="cagov-event-detail cagov-stack">
        <div className="start-date">{attributes.startDate}</div>
        <div className="end-date">{attributes.endDate}</div>
        <RichText.Content tagName="div" className="location" value={ attributes.location } />
      </div>
    );
  },
  // <div className="cost">{attributes.cost}</div>
});
