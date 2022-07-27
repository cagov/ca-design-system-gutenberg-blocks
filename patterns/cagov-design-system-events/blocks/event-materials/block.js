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
      type: "string",
    },
    materials: {
      type: "string",
    },
  },
  example: {
    attributes: {
    },
  },
  edit: function (props) {
    var attributes = props.attributes;
    return (
      <div>
        <h2><RichText
            value={attributes.title}
            tagName="div"
            className="title"
            onChange={(title) => props.setAttributes({ title })}
            placeholder={__("Event Materials", "ca-design-system")}
          /></h2>
        <div className="cagov-event-materials cagov-stack">
          <h3>Agenda</h3>
          <RichText
            value={attributes.agenda}
            tagName="div"
            className="agenda"
            value={attributes.agenda}
            onChange={(agenda) => props.setAttributes({ agenda })}
            placeholder={__("Link to a plain text agenda and agenda files", "ca-design-system")}
          />
          <h3>Materials</h3>
          <RichText
            value={attributes.materials}
            tagName="div"
            className="materials"
            value={attributes.materials}
            onChange={(materials) => props.setAttributes({ materials })}
            placeholder={__("Link to a plain text materials and materials files", "ca-design-system")}
          />
        </div>
      </div>
    );
  },
});
