/**
 * CAGov Announcement list
 * "List of recent announcements. Appears on the homepage. Allows people to see the most recent announcements with the ""Announcement"" tag. Includes title, hyperlink to full announcement, date, and a view all link to see longer list.
 * DEPENDENCY - post-list
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
    icon: "format-aside",
    category: "ca-design-system",
    description: __(
      'List of recent announcements. Appears on the homepage. Allows people to see the most recent announcements with the "Announcement" tag. Includes title, hyperlink to full announcement, date, and a view all link to see longer list.',
      "ca-design-system"
    ),
    attributes: {
      title: {
        type: "string",
        default: "Announcements",
      },
      description: {
        type: "string",
        default: "announcements,press-releases",
      },
      category: {
        type: "string",
        default: "announcements,press-releases",
      },
      order: {
        type: "string",
        default: "desc",
      },
      count: {
        type: "string",
        default: "5",
      },
      endpoint: {
        type: "string",
        default: `${siteUrl}/wp-json/wp/v2`,
      },
      readMore: {
        type: "string",
        // default: '<a href="#">View all announcements</a>',
      },
      noResults: {
        type: "string",
        default: "No posts found"
      },
    },
    // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/#example-optional
    example: {
      attributes: {
        title: __("Announcements", "ca-design-system"),
        category: __("announcements,press-releases", "ca-design-system"),
        readMore: __("<a href=\"#\">View all posts</a>", "ca-design-system"),
        order: "desc",
        count: "3",
        endpoint: `${siteUrl}/wp-json/wp/v2`,
        showExcerpt: "false",
        showPublishedDate: "true",
        noResults: "No posts found",
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
            tagName: "h2",
            inline: false,
            placeholder: __("Announcement list block title", "ca-design-system"),
            value: attributes.title,
            onChange: function (value) {
              props.setAttributes({ title: value });
            },
          }),
          // Display output of component.
          // @TODO refresh on change
          el("cagov-post-list", {
            className: "post-list",
            "data-category": attributes.category,
            "data-count": attributes.count,
            "data-order": attributes.order,
            "data-endpoint": attributes.endpoint,
            "data-show-excerpt" : "false",
            "data-show-published-date" : "true",
            "data-no-results": "No results found",
            "date-show-paginator": "false"
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
              className: "post-list-category",
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
              className: "post-list-no-results",
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
