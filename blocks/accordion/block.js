/**
 * CAGov Accordion
 */

(function (blocks, blockEditor, i18n, element, components, _) {

  var __ = i18n.__;
  var el = element.createElement;
  var RichText = blockEditor.RichText;
  var PlainText = blockEditor.PlainText;
  var TextControl = components.TextControl;

  blocks.registerBlockType("ca-design-system/accordion", {
    title: __("CAGov: Accordion", "ca-design-system"),
    icon: "universal-access-alt",
    anchor: "layout",
    attributes: {
      title: {
        type: "array",
        source: "children",
        selector: "h3",
        default: "Title",
      },
      content: {
        type: "array",
        source: "children",
        selector: "p.content",
      },
      anchor: {
        type: "string",
        source: "attribute",
        selector: "p.accordion",
        default: "#anchor",
      },
      isOpen: {
        type: "string",
        source: "html",
        selector: "p.is-open",
        default: 'Open',
      },
    },
    example: {
      attributes: {
        title: __("Accordion title", "ca-design-system"),
        content: __("Accordion content", "ca-design-system"),
        anchor: __("Link Text", "ca-design-system"),
        isOpen: __("Open", "ca-design-system"),
      },
    },
    edit: function (props) {
      var attributes = props.attributes;
      return el(
        "div",
        {
          className: "cagov-accordion cagov-stack",
        },
        el(
          "div",
          {},
          el(RichText, {
            tagName: "h3",
            inline: false,
            placeholder: __("Accordion title", "ca-design-system"),
            value: attributes.title,
            onChange: function (value) {
              props.setAttributes({ title: value });
            },
          }),
          el(RichText, {
            tagName: "p.content",
            inline: false,
            placeholder: __("Accordion content", "ca-design-system"),
            value: attributes.content,
            onChange: function (value) {
              props.setAttributes({ content: value });
            },
          }),
          el(RichText, {
            tagName: "p.anchor",
            inline: false,
            placeholder: __("Accordion anchor", "ca-design-system"),
            value: attributes.anchor,
            onChange: function (value) {
              props.setAttributes({ anchor: value });
            },
          }),
          el(RichText, {
            tagName: "p.is-open",
            inline: false,
            placeholder: __("Accordion is open t/f", "ca-design-system"),
            value: attributes.isOpen,
            onChange: function (value) {
              props.setAttributes({ isOpen: value });
            },
          }),
         
        )
      );
    },
    // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/
    save: function (props) {
      var attributes = props.attributes;
      return el(
        "div",
        { className: "cagov-accordion cagov-stack" },
        el(
          "div",
          {},
          el(RichText.Content, {
            tagName: "h3",
            value: attributes.title,
          }),
          el(RichText.Content, {
            tagName: "p.content",
            value: attributes.content,
          }),
          el(RichText.Content, {
            tagName: "p.anchor",
            value: attributes.isOpen,
          }),
          el(RichText.Content, {
            tagName: "p.is-open",
            value: attributes.isOpen,
          }),
        )
      );
    },
  });
})(
  window.wp.blocks,
  window.wp.blockEditor,
  window.wp.i18n,
  window.wp.element,
  window.wp.components,
  window._,
);
