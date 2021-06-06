/**
 * CAGov Event Detail
 *
 */

const { blocks, blockEditor, i18n, element, components } = window.wp;
const { moment, _ } = window;

console.log("TEST wp", wp);

var __ = i18n.__;
var el = element.createElement;
blocks.registerBlockType("ca-design-system/event-detail", {
  title: __("CAGov: Event Detail", "ca-design-system"),
  icon: "universal-access-alt",
  category: "layout",
  attributes: {},
  example: {
    attributes: {},
  },
  edit: function (props) {
	  return (<div>TEST1</div>)
  },
  save: function (props) {
	return (<div>TEST2</div>)
  },
});
