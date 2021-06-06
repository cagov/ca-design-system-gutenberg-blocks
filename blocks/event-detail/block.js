/**
 * CAGov Event Detail
 *
 */

// This doesn't seem to be necessary if we enqueue all the dependencies.
//  import { InspectorControls, RichText } from '@wordpress/block-editor';
//  import { Fragment, useState, useEffect  } from '@wordpress/element';
//  import { dateI18n  } from '@wordpress/date';
//  import { DateTimePicker, Popover, Button, PanelRow, TextControl, Panel, PanelBody  } from '@wordpress/components';
//  import i18n from '@wordpress/i18n';
//  import { registerBlockType  } from '@wordpress/blocks';

const { blocks, blockEditor, i18n, element, components, date, data } = wp;
const { moment, _ } = window;

const { dateI18n } = date;
const {
  DateTimePicker,
  Popover,
  Button,
  PanelRow,
  TextControl,
  Panel,
  PanelBody,
} = components;
const { Fragment, useState, useEffect, createElement } = element;
const { InspectorControls, RichText } = blockEditor;
const { useSelect, useDispatch } = data;
//   plugins: { registerPlugin },
//   editPost: { PluginDocumentSettingPanel },

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
    const { startDate, endDate, location, cost } = props.attributes;

    const onUpdateDate = (dateTime) => {
      var newDateTime = moment(dateTime).format("YYYY-MM-DD HH:mm");
      props.setAttributes({ datetime: newDateTime });
    };

    return (
      <div className="cagov-event-detail cagov-stack">
        <Fragment>
          //{" "}
          <InspectorControls>
            //{" "}
            <PanelBody title="Panel" icon="" initialOpen={false}>
              //{" "}
              <PanelRow>
                //{" "}
                <DateTimePicker>
                  // currentDate={startDate}
                  // onChange={(val) => onUpdateDate(val)}
                  // is12Hour={true}
                  //{" "}
                </DateTimePicker>
                //{" "}
              </PanelRow>
              //{" "}
            </PanelBody>
            //{" "}
          </InspectorControls>
          //{" "}
        </Fragment>
      </div>
    );

    // <div className="start-date">{attributes.startDate}</div>
    //     <div className="end-date">{attributes.endDate}</div>
    //     <div className="location">{attributes.location}</div>
    //     <div className="cost">{attributes.cost}</div>

    //   return el(
    //     "div",
    //     { className: "cagov-event-detail cagov-stack" },
    //     el(RichText, {
    //       tagName: "div",
    //       className: "start-date",
    //       inline: true,
    //       placeholder: __("Start Date", "ca-design-system"),
    //       value: attributes.startDate,
    //       onChange: function (value) {
    //         props.setAttributes({ startDate: value });
    //       },
    //     },

    //     //   el(InspectorControls, {}),
    //     //   el(PanelBody, { title: "panel", icon: "", initialOpen: false }),
    //     //   el(PanelRow),
    //     //   el(DateTimePicker, {
    //     //     currentDate: startDate,
    //     //     onChange: (val) => onUpdateDate(val),
    //     //     is12Hour: true,
    //     //   })
    //     ),
    //     el(RichText, {
    //       tagName: "div",
    //       className: "end-date",
    //       inline: true,
    //       placeholder: __("End Date", "ca-design-system"),
    //       value: attributes.endDate,
    //       onChange: function (value) {
    //         props.setAttributes({ endDate: value });
    //       },
    //     }),
    //     el(RichText, {
    //       tagName: "div",
    //       className: "location",
    //       inline: true,
    //       placeholder: __("Location", "ca-design-system"),
    //       value: attributes.location,
    //       onChange: function (value) {
    //         props.setAttributes({ location: value });
    //       },
    //     }),
    //     el(RichText, {
    //       tagName: "div",
    //       className: "cost",
    //       inline: true,
    //       placeholder: __("Cost", "ca-design-system"),
    //       value: attributes.cost,
    //       onChange: function (value) {
    //         props.setAttributes({ cost: value });
    //       },
    //     })
    //     // el( RichText, {
    //     // 	tagName: 'p',
    //     // 	inline: true,
    //     // 	placeholder: __(
    //     // 		'Write event-detail body',
    //     // 		'ca-design-system'
    //     // 	),
    //     // 	value: attributes.body,
    //     // 	onChange: function( value ) {
    //     // 		props.setAttributes( { body: value } );
    //     // 	},
    //     // } )
    //   );
  },
  save: function (props) {
    var attributes = props.attributes;

    return (
      <div className="cagov-event-detail cagov-stack">
        <div className="start-date">{attributes.startDate}</div>
        <div className="end-date">{attributes.endDate}</div>
        <div className="location">{attributes.location}</div>
        <div className="cost">{attributes.cost}</div>
      </div>
    );
  },
});
