/**
 * CAGov Post list
 * List of recent posts. Appears on the homepage. Allows people to see the most recent announcements with the ""Announcement"" tag. Includes title, hyperlink to full announcement, date, and a view all link to see longer list.
 *
 */

// https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/creating-dynamic-blocks/

(function (blocks, editor, i18n, element, components, _, moment) {
  var __ = i18n.__;
  var el = element.createElement;
  // https://github.com/WordPress/gutenberg/blob/HEAD/packages/block-editor/src/components/rich-text/README.md

  //http://wordpress.test:8888/wp-json/wp/v2/tags?per_page=10&orderby=count&order=desc&_fields=id%2Cname%2Ccount&context=edit&_locale=user".
  var RichText = editor.RichText;
  var InnerBlocks = editor.InnerBlocks;
  var CheckboxControl = components.CheckboxControl;
  var TextControl = components.TextControl;
  var ToggleControl = components.ToggleControl;

  // Ref: https://developer.wordpress.org/block-editor/reference-guides/components/checkbox-control/

  let siteUrl = window.location.origin;

  blocks.registerBlockType("ca-design-system/post-list", {
    title: __("Post list", "ca-design-system"),
    icon: "universal-access-alt",
    category: "ca-design-system-utilities",
    description: __(
      'List of recent announcements. Appears on the homepage. Allows people to see the most recent announcements with the "Announcement" tag. Includes title, hyperlink to full announcement, date, and a view all link to see longer list.',
      "ca-design-system"
    ),
    attributes: {
      title: {
        type: "string",
        // default: "",
      },
      category: {
        type: "string",
        default: "announcements,press-releases",
      },
      readMore: {
        type: "string",
      },
      order: {
        type: "string",
        default: "desc",
      },
      count: {
        type: "string",
        default: "10",
      },
      endpoint: {
        type: "string",
        default: `${siteUrl}/wp-json/wp/v2`,
      },
      showExcerpt: {
        type: "string",
        default: "true"
      },
    },
    example: {
      attributes: {
        // title: __("Post list title", "ca-design-system"),
        // category: __("Post list categories", "ca-design-system"),
      },
    },
    edit: function (props) {
      var attributes = props.attributes;

      console.log("props", attributes);

      return el(
        "div",
        {
          className: "cagov-post-list cagov-stack",
        },
        el(
          "div",
          {},
          el(RichText, {
            tagName: "div",
            className: "post-list-title",
            inline: false,
            placeholder: __("Post list title", "ca-design-system"),
            value: attributes.title,
            onChange: function (value) {
              props.setAttributes({ title: value });
            },
          }),
          el("cagov-post-list", {
            className: "post-list",
            "data-category": attributes.category,
            "data-count": attributes.count,
            "data-order": attributes.order,
            "data-endpoint": attributes.endpoint,
            "data-show-excerpt": attributes.showExcerpt,
          }),
          // Visual display of endpoint
          // el(RichText, {
          //   tagName: "div",
          //   className: "read-more",
          //   inline: false,
          //   placeholder: __("Link to post page", "ca-design-system"),
          //   value: attributes.readMore,
          //   onChange: function (value) {
          //     props.setAttributes({ readMore: value });
          //   },
          // }),
          el(
            "div",
            {
              tagName: "div",
              className: "read-more",
              inline: false,
              placeholder: __("Link to post page", "ca-design-system"),
            },
            el(InnerBlocks, {
            //   value: attributes.readMore,
              allowedBlocks: ["core/paragraph", "core/button"],
              onChange: function (value) {
                props.setAttributes({ readMore: value });
              },
            })
          ),
          el(
            "div",
            { className: "edit" },
            el(TextControl, {
              label: "Change post category",
              tagName: "div",
              help: "Comma separated list of category slugs", // @TODO Will change to select box
              className: "post-list-category",
              inline: false,
              placeholder: __("Category", "ca-design-system"),
              value: attributes.category,
              onChange: function (value) {
                props.setAttributes({ category: value });
              },
            }),
            el(TextControl, {
              label: "Number of items to display",
              tagName: "div",
              
              className: "post-list-count",
              value: attributes.count,
              inline: false,
              placeholder: __(
                "Number items to display (recommend 10)",
                "ca-design-system"
              ),
              onChange: function (value) {
                console.log("value count", value);
                props.setAttributes({ count: value });
              },
            }),
            el(ToggleControl, {
              label: "Order of posts",
              tagName: "div", // Checkbox desc/asc
              className: "post-list-order",
              inline: false,
              help: attributes.order === "asc" ?  "Oldest first" : "Newest posts first",
              placeholder: __("Newest posts first", "ca-design-system"),
              value: attributes.order === "desc" || "" ? true : false,
              onChange: function (value) {
                props.setAttributes({ 
                  order: value === true ? "desc" : "asc"
                });
              },
            }),
            el(CheckboxControl, {
              label: "Show excerpt",
              tagName: "div", // select box + enter data
              className: "post-list-excerpt",
              help: "Display the excerpt",
              inline: false,
              placeholder: __("Show excerpt", "ca-design-system"),
              checked:  attributes.showExcerpt === "true" ? true : false,
              value: attributes.showExcerpt,
              onChange: function (value) {
                props.setAttributes({ 
                  showExcerpt: value === true ? "true" : "false" 
                });
              },
            }),
            el(TextControl, {
              label: "Endpoint",
              tagName: "div", // select box + enter data
              className: "post-list-endpoint",
              inline: false,
              // type: "hidden",
              placeholder: __("Endpoint", "ca-design-system"),
              value: attributes.endpoint,
              onChange: function (value) {
                props.setAttributes({ endpoint: value });
              },
            })
          )
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
  window.moment
);
