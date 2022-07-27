/**
 * CAGov Event list
 * "List of recent events. Appears on the homepage. Allows people to see the most recent events with the ""Event"" tag. Includes title, hyperlink to full event, date, and a view all link to see longer list.
 * DEPENDENCY - event-post-list
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

  blocks.registerBlockType("ca-design-system/event-list", {
    title: __("Event list", "ca-design-system"),
    icon: "format-aside",
    category: "ca-design-system",
    description: __(
      'List of recent events. Allows people to see the most recent events with the "Event" tag. Includes title, hyperlink to full event, date, and a view all link to see longer list.',
      "ca-design-system"
    ),
    attributes: {
      title: {
        type: "string",
        default: "Upcoming events",
      },
      description: {
        type: "string",
        default: "events",
      },
      category: {
        type: "string",
        default: "events",
      },
      order: {
        type: "string",
        default: "asc",
      },
      count: {
        type: "string",
        default: "3",
      },
      endpoint: {
        type: "string",
        default: `${siteUrl}/wp-json/wp/v2`,
      },
      readMore: {
        type: "string",
        // default: '<a href="#">View all events</a>',
      },
      noResults: {
        type: "string",
        default: "No upcoming events found"
      },
    },
    // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/#example-optional
    example: {
      attributes: {
        title: __("Events", "ca-design-system"),
        category: __("events", "ca-design-system"),
        readMore: __("<a href=\"#\">View all events</a>", "ca-design-system"),
        order: "desc",
        count: "3",
        endpoint: `${siteUrl}/wp-json/wp/v2`,
        showExcerpt: "false",
        showPublishedDate: "true",
        noResults: "No events found",
      },
    },
    edit: function (props) {
      var attributes = props.attributes;
      return el(
        "div",
        {
          className: "cagov-event-list cagov-stack",
        },
        el(
          "div",
          {},
          // Display output of component.
          // @TODO refresh on change
          el("cagov-event-post-list", {
            className: "event-post-list",
            "data-category": attributes.category,
            "data-count": attributes.count,
            "data-order": attributes.order,
            "data-endpoint": attributes.endpoint,
            "data-show-excerpt" : "false",
            "data-show-published-date" : "true",
            "data-no-results": "No results found",
            "data-show-paginator": "false",
            "data-filter": "today-or-after",
          }),
          el(RichText, {
            tagName: "div",
            className: "read-more",
            inline: false,
            placeholder: __("Add link to read more posts", "ca-design-system"),
            value: attributes.readMore,
            onChange: function (value) {
              props.setAttributes({ readMore: value });
            },
          }),
          el("hr"),
          el("h3", { children: "Post list settings"}),
          el(
            "div",
            { className: "edit" },
            // @TODO Change to select with categories list.
            el(TextControl, {
              label: "Change post category",
              tagName: "input",
              className: "event-post-list-category",
              inline: false,
              placeholder: __("Category", "ca-design-system"),
              value: attributes.category,
              onChange: function (value) {
                props.setAttributes({ category: value });
              },
            }),
            el(TextControl, {
              label: "No results message",
              tagName: "input",
              className: "event-post-list-no-results",
              inline: false,
              placeholder: __("No results found", "ca-design-system"),
              value: attributes.noResults,
              onChange: function (value) {
                props.setAttributes({ noResults: value });
              },
            }),
          ),
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
