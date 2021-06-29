/**
 * CAGov Content Navigation
 */

(function (blocks, i18n, element, data) {
  var __ = i18n.__;
  var el = element.createElement;
  // https://github.com/WordPress/gutenberg/blob/HEAD/packages/block-editor/src/components/rich-text/README.md
  //http://wordpress.test:8888/wp-json/wp/v2/tags?per_page=10&orderby=count&order=desc&_fields=id%2Cname%2Ccount&context=edit&_locale=user".
  // var RichText = blockEditor.RichText;
  // var PlainText = blockEditor.PlainText;

  blocks.registerBlockType("ca-design-system/content-navigation", {
    title: __("Content Navigation", "ca-design-system"),
    icon: "format-aside",
    description: __("Render content header tags."),
    category: "ca-design-system-utilities",
    attributes: {},
    example: {
      attributes: {},
    },
    supports: {
      html: false,
      reusable: false,
      multiple: false,
      inserter: true
    },
    edit: function (props) {
      var attributes = props.attributes;
      return el(
        "div",
        {
          className: "cagov-content-navigation cagov-stack",
        },
        el(
          "div",
          {},
          // Visual display of content
          el("cagov-content-navigation", {
            className: "content-navigation",
            "data-selector": "article",
            "data-editor": ".edit-post-visual-editor",
            "data-callback": "(content) => unescape(content)",
          })
        )
      );
    }
  });

  // data.subscribe(function () {
  //   var blocks = data.select("core/block-editor").getBlocks();

  //   var isPostDirty = data.select("core/editor").isEditedPostDirty();
  //   var isAutosavingPost = data.select("core/editor").isAutosavingPost();

  //   if (isPostDirty && !isAutosavingPost) {
  //     console.log("Content updates");
  //     const event = new Event('GutenbergEditorUpdated');
  //     // Dispatch the event.
  //     document.dispatchEvent(event);
  //   }
  // });

})(
  window.wp.blocks,
  window.wp.i18n,
  window.wp.element,
  window.wp.data
);
