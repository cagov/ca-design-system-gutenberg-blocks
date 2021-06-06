/**
 * CAGov Category Label
 *
 */
(function (blocks, editor, i18n, element, components, _, data, vars) {
  var __ = i18n.__;
  var el = element.createElement;
  var RichText = editor.RichText;
  var { SelectControl } = components;

  console.log(vars);

  var { useSelect } = data;
  var { useState } = element;

  blocks.registerBlockType("ca-design-system/category-label", {
    title: __("CAGov: Category Label", "ca-design-system"),
    icon: "universal-access-alt",
    category: "ca-design-system",
    attributes: {
    //   label: {
    //     type: "array",
    //     source: "children",
    //     selector: "div.category-label",
    //   },
    //   id: {
    //     type: "string",
    //     source: "children",
    //     selector: "div.category-label[data-id]",
    //   },
    },
    example: {
      attributes: {
        label: __("News", "ca-design-system"),
      },
    },
    // edit: function (props) {
    //   const categories = useSelect((select) =>
    //     select("core").getEntityRecords("taxonomy", "category")
    //   );

    //   var attributes = props.attributes;
    // count: 4
    // description: ""
    // id: 3
    // link: "http://wordpress.test:8888/category/news/"
    // meta: []
    // name: "News"
    // parent: 0
    // slug: "news"
    // taxonomy: "category"
    //   return el(
    //     "div",
    //     {
    //       className: "cagov-category-label cagov-stack",
    //     },
    //     el(SelectControl, {
    //       multiple: false,
    //       label: "Select Category",
    //       options:
    //         categories !== null
    //           ? categories.map(({ id, name }) => ({ label: name, value: id }))
    //           : [],
    //       className: "category-label",
    //       value: attributes.label,
    //       "data-id": attributes.id,
    //       inline: false,
    //       onChange: function (value) {
    //         console.log(this, value, categories);
    // 		if (value !== undefined && value.length > 0) {
    // 			let selectedCategory = categories.filter((item) => item.id === Number(value));
    // 			props.setAttributes({ label: selectedCategory[0].name, id: selectedCategory.id.toString() });
    // 		}
    //       },
    //     })
    //   );
    // },
    save: function (props) {
      var attributes = props.attributes;
      
	  

      return el(
        "div",
        {
          className: "cagov-category-label cagov-stack",
        },
        el(RichText.Content, {
          tagName: "div",
          className: "category-label",
          value: attributes.label,
          "data-id": attributes.id || "3",
        })
      );
    },
  });
})(
  window.wp.blocks,
  window.wp.editor,
  window.wp.i18n,
  window.wp.element,
  window.wp.components,
  window._,
  window.wp.data,
  window.ca_design_system_gutenberg_blocks_vars
);
