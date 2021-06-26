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
  PanelBody
} = components;
const { Fragment, useState, useEffect, createElement } = element;
const { InspectorControls, RichText, InnerBlocks } = blockEditor;
const { useSelect, useDispatch } = data;
const { withState } = compose;

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
      default: "Event Details",
    },
    startDate: {
      type: "string",
      // default: formattedDate,
    },
    endDate: {
      type: "string",
      // default: formattedDate,
    },
    startTime: {
      type: "string",
      // default: formattedTime
    },
    endTime: {
      type: "string",
      // default: formattedTimePlusHour
    },
    location: {
      type: "string",
    },
    cost: {
      type: "string",
    },
  },
  example: {
    attributes: {
      title: "Event Details"
    },
  },
  edit: function (props) {

    const [openDatePopup, setOpenDatePopup] = useState(false);
    var attributes = props.attributes;

    const { title, startDate, endDate, startTime, endTime, location, cost } = props.attributes;

    // https://developer.wordpress.org/block-editor/reference-guides/components/date-time/

    return (
      <div>
        <RichText
          value={title}
          tagName="h2"
          className="title"
          onChange={(title) => props.setAttributes({ title })}
          placeholder={__("Event Details", "ca-design-system")}
        />

        <div className="cagov-event-detail cagov-stack">
          <h3>Date &amp; time</h3>
          <RichText
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
          />

          <h3>Location</h3>

          <RichText
            value={location}
            tagName="div"
            className="location"
            value={location}
            onChange={(location) => props.setAttributes({ location })}
            placeholder={__("Enter text...", "ca-design-system")}
          />

          <h3>Cost</h3>

          <RichText
            value={cost}
            tagName="div"
            className="cost"
            value={cost}
            onChange={(cost) => props.setAttributes({ cost })}
            placeholder={__("Enter text...", "ca-design-system")}
          />
        </div>
      </div>
    );
  },
});
