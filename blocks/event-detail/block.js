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
  title: __("Event Detail", "ca-design-system"),
  icon: "universal-access-alt",
  category: 'ca-design-system-utilities',
  description: __("Block for details about an event"),
  attributes: {
    startDate: {
      type: "array",
      source: "children",
      selector: "div.start-date",
    },
    // endDate: {
    //   type: "array",
    //   source: "children",
    //   selector: "div.end-date",
    // },
    startTime: {
      type: "array",
      source: "children",
      selector: "div.start-date",
    },
    endTime: {
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
        <h4>Date &amp; time</h4>
        <RichText
          value={attributes.startDate}
          tagName="div"
          className="startDate"
          value={attributes.startDate}
          onChange={(startDate) => props.setAttributes({ startDate })}
          placeholder={__("Month Day, Year", "ca-design-system")}
        />

        <RichText
          value={attributes.startTime}
          tagName="div"
          className="startTime"
          value={attributes.startTime}
          onChange={(startTime) => props.setAttributes({ startTime })}
          placeholder={__("HH:mm a", "ca-design-system")}
        />

        <RichText
          value={attributes.endTime}
          tagName="div"
          className="endTime"
          value={attributes.endTime}
          onChange={(endTime) => props.setAttributes({ endTime })}
          placeholder={__("HH:mm a", "ca-design-system")}
        />

        <h4>Location</h4>
        <RichText
          value={attributes.location}
          tagName="div"
          className="location"
          value={attributes.location}
          onChange={(location) => props.setAttributes({ location })}
          placeholder={__("Enter text...", "ca-design-system")}
        />
        <h4>Cost</h4>
        <RichText
          value={props.attributes.cost}
          tagName="div"
          className="cost"
          value={attributes.cost}
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
        <RichText.Content
          tagName="div"
          className="startDate"
          value={attributes.startDate}
        />
        <RichText.Content
          tagName="div"
          className="startTime"
          value={attributes.startTime}
        />
        <RichText.Content
          tagName="div"
          className="endTime"
          value={attributes.endTime}
        />
        <RichText.Content
          tagName="div"
          className="location"
          value={attributes.location}
        />
        <RichText.Content
          tagName="div"
          className="cost"
          value={attributes.cost}
        />
      </div>
    );
  },
  // <div className="cost">{attributes.cost}</div>
});
