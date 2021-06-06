/**
 * CAGov Event Detail
 *
 */



// (function () {
	// blocks, editor, i18n, element, components, _, moment, date
	// window.wp.blocks,
	// window.wp.editor,
	// window.wp.i18n,
	// window.wp.element,
	// window.wp.components,
	// window._,
	// window.moment,
	// window.wp.date

	const { blocks, editor, i18n, element, components, date } = wp;
	const { moment, _ } = window;

  	var __ = i18n.__;
 	var el = element.createElement;
  	var RichText = editor.RichText;

    const { dateI18n } = date;
    const { DateTimePicker, Popover, Button, PanelRow, TextControl } = components;

    const { useSelect, useDispatch } = data;

//   // //   plugins: { registerPlugin },
//   // //   element: { useState, useEffect },
//   // //   components: { TextControl },
//   // //   editPost: { PluginDocumentSettingPanel },

//   //   const [openDatePopup, setOpenDatePopup] = useState(false);

//   const { Fragment } = element;
//   const { InspectorControls } = editor;
//   const { Panel, PanelBody, PanelRow, DateTimePicker } = components;

  blocks.registerBlockType("ca-design-system/event-detail", {
    title: __("CAGov: Event Detail", "ca-design-system"),
    icon: "universal-access-alt",
    category: "layout",
    attributes: {
    //   startDate: {
    //     type: "array",
    //     source: "children",
    //     selector: "div.start-date",
    //   },
    //   endDate: {
    //     type: "array",
    //     source: "children",
    //     selector: "div.end-date",
    //   },
    //   location: {
    //     type: "array",
    //     source: "children",
    //     selector: "div.location",
    //   },
    //   cost: {
    //     type: "array",
    //     source: "children",
    //     selector: "div.cost",
    //   },
    },
    example: {
      attributes: {
        // startDate: __("Start Data & Time", "ca-design-system"),
      },
    },
    edit: function (props) {
      var attributes = props.attributes;

    //   const { startDate } = attributes;

    //   const onUpdateDate = (dateTime) => {
    //     var newDateTime = moment(dateTime).format("YYYY-MM-DD HH:mm");
    //     props.setAttributes({ datetime: newDateTime });
    //   };

	        return (<h1>Hi</h1>);

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
      return el(
        // "div",
        // { className: "cagov-event-detail cagov-stack" },
        // el(RichText.Content, {
        //   tagName: "div",
        //   className: "start-date",
        //   value: attributes.startDate,
        // }),
        // el(RichText.Content, {
        //   tagName: "div",
        //   className: "end-date",
        //   value: attributes.endDate,
        // }),
        // el(RichText.Content, {
        //   tagName: "div",
        //   className: "location",
        //   value: attributes.location,
        // }),
        // el(RichText.Content, {
        //   tagName: "div",
        //   className: "cost",
        //   value: attributes.cost,
        // })
        // el( RichText.Content, {
        // 	tagName: 'p',
        // 	value: attributes.body,
        // } )
      );
    },
  });
// })(
// //   window.wp.blocks,
// //   window.wp.editor,
// //   window.wp.i18n,
// //   window.wp.element,
// //   window.wp.components,
// //   window._,
// //   window.moment,
// //   window.wp.date
// );
