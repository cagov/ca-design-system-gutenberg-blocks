/**
 * CAGov News List
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

  blocks.registerBlockType("cagov/news-list", {
    title: __("CAGov: News List", "cagov-design-system"),
    icon: "universal-access-alt",
    category: "layout",
    attributes: {
      title: {
        type: "array",
        source: "children",
        selector: "h3",
        default: "News",
      },
      description: {
        type: "array",
        source: "children",
        selector: "p",
      },
      category: {
        type: "string",
        source: "attribute",
        selector: ".news-list[data-category]",
        default: "News",
      },
      order: {
        type: "string",
        source: "attribute",
        selector: ".news-list[data-order]",
        default: "desc",
      },
      count: {
        type: "string",
        source: "attribute",
        selector: ".news-list[data-count]",
        default: "5",
      },
      endpoint: {
        type: "string",
        source: "attribute",
        selector: ".news-list[data-endpoint]",
        default: `${siteUrl}/wp-json/wp/v2`,
      },
      readMore: {
        type: "string",
        source: "html",
        selector: "div.read-more",
        default: '<a href="/news">View all news</a>',
      },
    },
    example: {
      attributes: {
        title: __("News List title", "cagov-design-system"),
        description: __("News List description", "cagov-design-system"),
        readMore: __("Link Text", "cagov-design-system"),
        category: __("Category to include", "cagov-design-system"),
        count: __("Number news items to display", "cagov-design-system"),
        order: __("Order of news posts", "cagov-design-system"),
        endpoint: __("Endpoint to fetch data from", "cagov-design-system"),
      },
    },
    edit: function (props) {
      var attributes = props.attributes;
      return el(
        "div",
        {
          className: "cagov-news-list cagov-stack",
        },
        el(
          "div",
          {},
          el(RichText, {
            tagName: "h3",
            inline: false,
            placeholder: __("News list title", "cagov-design-system"),
            value: attributes.title,
            onChange: function (value) {
              props.setAttributes({ title: value });
            },
          }),
          // el(RichText, {
          //   tagName: "p",
          //   inline: false,
          //   placeholder: __(
          //     "News list message (optional)",
          //     "cagov-design-system"
          //   ),
          //   value: attributes.description,
          //   onChange: function (value) {
          //     props.setAttributes({ description: value });
          //   },
          // }),
          // el('hr'),
          // Visual display of endpoint
          el("cagov-news-list", {
            className: "news-list",
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
            placeholder: __("Link to news page", "cagov-design-system"),
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
                        label: "Change news post category",
                        tagName: "input",
                        className: "news-list-category",
                        inline: false,
                        placeholder: __("Category", "cagov-design-system"),
                        value: attributes.category,
                        onChange: function (value) {
                          props.setAttributes({ category: value });
                        },
                      }),
                      // el(RichText, {
                      //   tagName: "input",
                      //   className: "news-list-count",
                      //   inline: false,
                      //   placeholder: __("Count", "cagov-design-system"),
                      //   value: attributes.count,
                      //   onChange: function (value) {
                      //     props.setAttributes({ count: value });
                      //   },
                      // }),
                      // el(RichText, {
                      //   tagName: "div", // Checkbox desc/asc
                      //   className: "news-list-order",
                      //   inline: false,
                      //   placeholder: __("Order", "cagov-design-system"),
                      //   value: attributes.order,
                      //   onChange: function (value) {
                      //     props.setAttributes({ order: value });
                      //   },
                      // }),
                      // el(RichText, {
                      //   tagName: "div", // select box + enter data
                      //   className: "news-list-endpoint",
                      //   inline: false,
                      //   placeholder: __("Endpoint", "cagov-design-system"),
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
        { className: "cagov-news-list cagov-stack" },
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
          el("cagov-news-list", {
            className: "news-list",
            "data-category": attributes.category || "News",
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
