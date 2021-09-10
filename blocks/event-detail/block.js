/**
 * CAGov Event Detail
 * To compile: run `wp-scripts build` at root of this plugin folder to compile this JSX-friendlier code.
 * Notes: We are still exploring best practices and there are many flavors of Gutenberg Block creation. 
 * We can adapt this to match what we can maintain for the design system. 
 */

// Get pre-registered WordPress block editor API methods.
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

// Extract components from API interface to use in this mini-app.
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

// @TODO: Using the data available, create a button that will generate an ICS file.
// Note: Add to calendar could be a new web component.
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

// Make the block available to the Gutenberg Block library editor
blocks.registerBlockType("ca-design-system/event-detail", {
  title: __("Event Detail", "ca-design-system"),
  icon: "format-aside",
  category: "ca-design-system-utilities",
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
      // default: formattedDateTime, // In UTC - disabled because default feature can be buggy.
    },
    endDateTimeUTC: {
      type: "string",
      // default: formattedDateTime,
    },
    // Utility local time display fields
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
    },
    localTimezoneLabel: {
      type: "string",
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
      selector: '.cagov-card-body-content' // @TODO rename to .cagov-inner-block-content
    },
  },
  example: {
    attributes: {
      title: "Event Details",
      startDateTimeUTC: "2020-09-08T17:00:00",
      endDateTimeUTC: "2020-09-08T16:00:00",
      // Utility local time display fields
      startDate: "September 9, 2021",
      endDate: "September 9, 2021",
      startTime: "10:00 AM",
      endTime: "11:00 AM",
      localTimezone: "America/Los_Angeles",
      localTimezoneLabel: "PST",
      location: "",
      cost: "",
    },
  },
  edit: function (props) {
    // Get local props
    let {
      title,
      startDateTimeUTC,
      endDateTimeUTC,
      startDate,
      endDate,
      startTime,
      endTime,
      localTimezoneLabel,
      location,
      cost,
    } = props.attributes;

    // When datetime is selected, update the local start date props.
    // Note: we can also hook into the wp api to double store the data to post meta, or a custom field or another field handler.
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

    // When datetime is selected, update the local end date props
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

    // Create block editor display along with the block options display.
    return (
      <div {...useBlockProps()}>
        {/** Editable block title */}
        <RichText
          value={title}
          tagName="h2"
          className="title"
          onChange={(title) => props.setAttributes({ title })}
          placeholder={__("Event Details", "ca-design-system")}
        />

        {/** Event detail content */}
        <div class="cagov-event-detail">
           {/** Date and time */}
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

            {/** Date and time block options UI */}
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

          {/** Location */}
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

          {/** Cost */}
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
          {/** Additional blocks */}
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
    // Store the inner blocks
    return el('div', {},
          el('div', { className: 'cagov-card-body-content' }, // @TODO rename to .cagov-inner-block-content
            el(InnerBlocks.Content)
          )
    );
  }
});
