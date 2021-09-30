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
  Placeholder,
  Spinner,
} = components;

const { Fragment, useState, useEffect, createElement, Component } = element;
const {
  InspectorControls,
  RichText,
  InnerBlocks,
  useBlockProps,
  AlignmentToolbar,
  BlockControls,
} = blockEditor;
const { useSelect, useDispatch } = data;
const { withState } = compose;

var __ = i18n.__;
var el = createElement;

const AddToCalendar = ({}) => {};

const EventDateTimePicker = ({ dateTime, setDateTime }) => {
  return (
    <DateTimePicker
      currentDate={dateTime}
      onChange={(newDate) => {
        console.log("changed date time", newDate);
        setDateTime(newDate);
      }}
      is12Hour={true}
    />
  );
};

blocks.registerBlockType("ca-design-system/event-detail", {
  title: __("Event Detail", "ca-design-system"),
  icon: "format-aside",
  category: "ca-design-system",
  description: __("Block for details about an event"),
  supports: {
    reusable: true,
    multiple: false,
    inserter: true,
  },
  attributes: {
    title: {
      type: "string",
      default: __("Event Details", "ca-design-system"),
    },
    startDateTimeUTC: {
      type: "string",
      // default: formattedDateTime, // In UTC
    },
    endDateTimeUTC: {
      type: "string",
      // default: formattedDateTime,
    },
    // @TODO may deprecate
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
    localTimezone: {
      type: "string",
      // default: formattedTimePlusHour
    },
    localTimezoneLabel: {
      type: "string",
      // default: formattedTimePlusHour
    },
    location: {
      type: "string",
    },
    cost: {
      type: "string",
    },
    body: {
      type: 'array',
      source: 'children',
      selector: '.cagov-card-body-content'
    },
  },
  example: {
    attributes: {
      title: "Event Details",
      body: __("Lorem ipsum", "cagov-design-system"),
    },
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
      cost,
    } = props.attributes;

    const setStartDateTime = (dateTime) => {

      var formattedStartDate = null;
      var formattedStartTime = null;

      if (dateTime !== null) {
        formattedStartDate = moment
          .utc(dateTime)
          .tz("America/Los_Angeles")
          .format("MMMM D, YYYY");

        formattedStartTime = moment
          .utc(dateTime)
          .tz("America/Los_Angeles")
          .format("h:mm A");
          console.log("dt", dateTime, formattedStartDate, formattedStartTime);
          props.setAttributes({
            startDateTimeUTC: dateTime,
            startDate: formattedStartDate,
            startTime: formattedStartTime,
            localTimezone: "America/Los_Angeles",
            localTimezoneLabel: "PST",
          });
      }
    };

    const setEndDateTime = (dateTime) => {
      var formattedEndDate = null;
      var formattedEndTime = null;

      if (dateTime !== null) {
        formattedEndDate = moment
          .utc(dateTime)
          .tz("America/Los_Angeles")
          .format("MMMM D, YYYY");
        formattedEndTime = moment
          .utc(dateTime)
          .tz("America/Los_Angeles")
          .format("h:mm A");
      }

      props.setAttributes({
        endDateTimeUTC: dateTime,
        endDate: formattedEndDate,
        endTime: formattedEndTime,
      });
    };

    return (
      <div {...useBlockProps()}>

        <RichText
          value={title}
          tagName="h2"
          className="title"
          onChange={(title) => props.setAttributes({ title })}
          placeholder={__("Event Details", "ca-design-system")}
        />

        <div class="cagov-event-detail">
          <div class="detail-section">
            <h4>{__("Date & time", "ca-design-system")}</h4>
            <div class="startDate">
              {startDate
                ? startDate
                : __("Select start and end date and time.", "ca-design-system")}
            </div>
            {endDate !== startDate && endDate !== null && (
              <div class="endDate">{endDate}</div>
            )}
            <br />
            <div class="startTime">{startTime}</div>
            {endTime !== startTime && endTime !== null && (
              <div class="endTime">{endTime}</div>
            )}
            <div class="timezone-label">{localTimezoneLabel}</div>

            <InspectorControls key="setting">
              <div id="datetime-controls">
                <fieldset>
                  <legend className="blocks-base-control__label">
                    {__("Start Date & Time", "ca-design-system")}
                  </legend>
                  <EventDateTimePicker
                    dateTime={startDateTimeUTC}
                    setDateTime={(startDateTimeUTC) =>
                      setStartDateTime(startDateTimeUTC)
                    }
                  />
                </fieldset>
                <fieldset>
                  <legend className="blocks-base-control__label">
                    {__("End Date & Time", "ca-design-system")}
                  </legend>
                  <EventDateTimePicker
                    dateTime={endDateTimeUTC}
                    setDateTime={(endDateTimeUTC) =>
                      setEndDateTime(endDateTimeUTC)
                    }
                  />
                </fieldset>
              </div>
            </InspectorControls>
          </div>

          <div class="detail-section">
            <h4>{__("Location", "ca-design-system")}</h4>
            <RichText
              value={location}
              tagName="div"
              className="location"
              value={location}
              onChange={(location) => props.setAttributes({ location })}
              placeholder={__("Where will this event happen?", "ca-design-system")}
            />
          </div>

          <div class="detail-section">
            <h4>{__("Cost", "ca-design-system")}</h4>
            <RichText
              value={cost}
              tagName="div"
              className="cost"
              value={cost}
              onChange={(cost) => props.setAttributes({ cost })}
              placeholder={__("What is the cost of this event?", "ca-design-system")}
            />
          </div>
          <div class="detail-section-more-info">
            <div class="cagov-card-body">
              {el(InnerBlocks, {
                orientation: "horizontal",
                allowedBlocks: ["core/paragraph", "core/button"],
              })}
            </div>
          </div>
        </div>
      </div>
    );
  },
  save: function (props) {
    return el('div', {},
          el('div', { className: 'cagov-card-body-content' },
            el(InnerBlocks.Content)
          )
    );
  }
});
