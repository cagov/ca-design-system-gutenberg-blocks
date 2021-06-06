/**
 * CAGov Event Detail
 *
 */
(function (blocks, editor, i18n, element, components, _) {
  var __ = i18n.__;
  var el = element.createElement;
  var RichText = editor.RichText;

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
      // title: {
      // 	type: 'array',
      // 	source: 'children',
      // 	selector: 'h3',
      // },
      // body: {
      // 	type: 'array',
      // 	source: 'children',
      // 	selector: 'p',
      // }
    },
    example: {
      attributes: {
        startDate: __("Start Data & Time", "ca-design-system"),
        // body: __( 'Card body', 'ca-design-system' )
      },
    },
    edit: function (props) {
      var attributes = props.attributes;

      return el(
        "div",
        { className: "cagov-event-detail cagov-stack" },
        el(RichText, {
          tagName: "div",
          className: "start-date",
          inline: true,
          placeholder: __("Start Date", "ca-design-system"),
          value: attributes.startDate,
          onChange: function (value) {
            props.setAttributes({ startDate: value });
          },
        }),
        el(RichText, {
          tagName: "div",
          className: "end-date",
          inline: true,
          placeholder: __("End Date", "ca-design-system"),
          value: attributes.endDate,
          onChange: function (value) {
            props.setAttributes({ endDate: value });
          },
        }),
        el(RichText, {
          tagName: "div",
          className: "location",
          inline: true,
          placeholder: __("Location", "ca-design-system"),
          value: attributes.location,
          onChange: function (value) {
            props.setAttributes({ location: value });
          },
        }),
        el(RichText, {
          tagName: "div",
          className: "cost",
          inline: true,
          placeholder: __("Cost", "ca-design-system"),
          value: attributes.cost,
          onChange: function (value) {
            props.setAttributes({ cost: value });
          },
        })
        // el( RichText, {
        // 	tagName: 'p',
        // 	inline: true,
        // 	placeholder: __(
        // 		'Write event-detail body',
        // 		'ca-design-system'
        // 	),
        // 	value: attributes.body,
        // 	onChange: function( value ) {
        // 		props.setAttributes( { body: value } );
        // 	},
        // } )
      );
    },
    save: function (props) {
      var attributes = props.attributes;
      return el(
        "div",
        { className: "cagov-event-detail cagov-stack" },
        el(RichText.Content, {
          tagName: "div",
          className: "start-date",
          value: attributes.startDate,
        }),
        el(RichText.Content, {
          tagName: "div",
          className: "end-date",
          value: attributes.endDate,
        }),
        el(RichText.Content, {
          tagName: "div",
          className: "location",
          value: attributes.location,
        }),
        el(RichText.Content, {
          tagName: "div",
          className: "cost",
          value: attributes.cost,
        })
        // el( RichText.Content, {
        // 	tagName: 'p',
        // 	value: attributes.body,
        // } )
      );
    },
  });
})(
  window.wp.blocks,
  window.wp.editor,
  window.wp.i18n,
  window.wp.element,
  window.wp.components,
  window._
);
