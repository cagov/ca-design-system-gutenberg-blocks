/**
 * CAGov Announcement list
 */

(function (blocks, blockEditor, i18n, element, components, _, moment) {

  var __ = i18n.__;
  var el = element.createElement;
  // https://github.com/WordPress/gutenberg/blob/HEAD/packages/block-editor/src/components/rich-text/README.md

  //http://wordpress.test:8888/wp-json/wp/v2/tags?per_page=10&orderby=count&order=desc&_fields=id%2Cname%2Ccount&context=edit&_locale=user".
  var RichText = blockEditor.RichText;
  var PlainText = blockEditor.PlainText;
  var TextControl = components.TextControl;

  let siteUrl = window.location.origin;

  // https://github.com/aduth/hpq Attribute reference
  // ROADMAP
  // - [ ] Figure out tab navigation inside Gutenberg block. Notes: tabIndex react prop doesn't help. aria-labels added automatically, may require accessibiliy add on plugin. Navigating between blocks works with the Block List. Q: Would PlainText work better?
  // - [ ] Figure out easiest localization options

  blocks.registerBlockType("ca-design-system/announcement-list", {
    title: __("Announcement list", "ca-design-system"),
    icon: "universal-access-alt",
    category: 'ca-design-system',
    description: __("List of recent announcements. Appears on the homepage. Allows people to see the most recent announcements with the \"Announcement\" tag. Includes title, hyperlink to full announcement, date, and a view all link to see longer list.", "ca-design-system"),
    attributes: {
      title: {
        type: "array",
        source: "children",
        selector: "h3",
        default: "Announcements",
      },
      description: {
        type: "array",
        source: "children",
        selector: "p",
      },
      category: {
        type: "string",
        source: "attribute",
        selector: ".announcement-list[data-category]",
        default: "Announcement",
      },
      order: {
        type: "string",
        source: "attribute",
        selector: ".announcement-list[data-order]",
        default: "desc",
      },
      count: {
        type: "string",
        source: "attribute",
        selector: ".announcement-list[data-count]",
        default: "5",
      },
      endpoint: {
        type: "string",
        source: "attribute",
        selector: ".announcement-list[data-endpoint]",
        default: `${siteUrl}/wp-json/wp/v2`,
      },
      readMore: {
        type: "string",
        source: "html",
        selector: "div.read-more",
        default: '<a href="/category/announcement">View all announcements</a>',
      },
    },
    example: {
      attributes: {
        title: __("Post List title", "ca-design-system"),
        description: __("Post List description", "ca-design-system"),
        readMore: __("Link Text", "ca-design-system"),
        category: __("Category to include", "ca-design-system"),
        count: __("Number of items to display", "ca-design-system"),
        order: __("Order of posts", "ca-design-system"),
        endpoint: __("Endpoint to fetch data from", "ca-design-system"),
      },
    },
    edit: function (props) {
      var attributes = props.attributes;
      return el(
        "div",
        {
          className: "cagov-announcement-list cagov-stack",
        },
        el(
          "div",
          {},
          el(RichText, {
            tagName: "h3",
            inline: false,
            placeholder: __("Post list title", "ca-design-system"),
            value: attributes.title,
            onChange: function (value) {
              props.setAttributes({ title: value });
            },
          }),
          // el(RichText, {
          //   tagName: "p",
          //   inline: false,
          //   placeholder: __(
          //     "Post list message (optional)",
          //     "ca-design-system"
          //   ),
          //   value: attributes.description,
          //   onChange: function (value) {
          //     props.setAttributes({ description: value });
          //   },
          // }),
          // el('hr'),
          // Visual display of endpoint
          el("cagov-announcement-list", {
            className: "announcement-list",
            "data-category": attributes.category,
            "data-count": attributes.count,
            "data-order": attributes.order,
            "data-endpoint": attributes.endpoint,
          }),
          // el('hr'),
          el(RichText, {
            tagName: "div",
            className: "read-more",
            inline: false,
            placeholder: __("Link to post page", "ca-design-system"),
            value: attributes.readMore,
            onChange: function (value) {
              props.setAttributes({ readMore: value });
            },
          }),
                    // Settings, will reorganize into gear overlay or other interface (TBD)
                    el(
                      "div",
                      { className: "edit" },
                      // @TODO Change to select with categories list.
                      el(TextControl, {
                        label: "Change post category",
                        tagName: "input",
                        className: "post-list-category",
                        inline: false,
                        placeholder: __("Category", "ca-design-system"),
                        value: attributes.category,
                        onChange: function (value) {
                          props.setAttributes({ category: value });
                        },
                      }),
                      // el(RichText, {
                      //   tagName: "input",
                      //   className: "announcement-list-count",
                      //   inline: false,
                      //   placeholder: __("Count", "ca-design-system"),
                      //   value: attributes.count,
                      //   onChange: function (value) {
                      //     props.setAttributes({ count: value });
                      //   },
                      // }),
                      // el(RichText, {
                      //   tagName: "div", // Checkbox desc/asc
                      //   className: "announcement-list-order",
                      //   inline: false,
                      //   placeholder: __("Order", "ca-design-system"),
                      //   value: attributes.order,
                      //   onChange: function (value) {
                      //     props.setAttributes({ order: value });
                      //   },
                      // }),
                      // el(RichText, {
                      //   tagName: "div", // select box + enter data
                      //   className: "announcement-list-endpoint",
                      //   inline: false,
                      //   placeholder: __("Endpoint", "ca-design-system"),
                      //   value: attributes.endpoint,
                      //   onChange: function (value) {
                      //     props.setAttributes({ endpoint: value });
                      //   },
                      // })
                    ),
        )
      );
    },
    // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/
    save: function (props) {
      var attributes = props.attributes;
      return el(
        "div",
        { className: "cagov-announcement-list cagov-stack" },
        el(
          "div",
          {},
          el(RichText.Content, {
            tagName: "h3",
            value: attributes.title,
          }),
          el(RichText.Content, {
            tagName: "p",
            value: attributes.description,
          }),
          el("cagov-announcement-list", {
            className: "announcement-list",
            "data-category": attributes.category || "Announcement",
            "data-count": attributes.count || 5,
            "data-order": attributes.order || "desc",
            "data-endpoint":
              attributes.endpoint || `${siteUrl}/wp-json/wp/v2`,
          }),
          el(RichText.Content, {
            tagName: "div",
            className: "read-more",
            value: attributes.readMore,
          })
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
