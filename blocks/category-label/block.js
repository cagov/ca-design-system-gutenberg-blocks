/**
 * CAGov Category Label
 *
 */
(function (blocks, blockEditor, i18n, element, components, _, data, vars) {
  var __ = i18n.__;
  var el = element.createElement;
  var RichText = blockEditor.RichText;

  const getSelectedCategory = function () {
    var postSelectedCategories = data
      .select("core/editor")
      .getEditedPostAttribute("categories");

    let selectedCategory = null;

    // Only one category supported.
    if (
      postSelectedCategories !== undefined &&
      postSelectedCategories.length === 1
    ) {
      selectedCategory = vars.terms.filter((item) => {
        return item.term_id === postSelectedCategories[0];
      });
    }
    return selectedCategory;
  };

  blocks.registerBlockType("ca-design-system/category-label", {
    title: __("Category Label", "ca-design-system"),
    icon: "format-aside",
    category: "ca-design-system-utilities",
    // namespace: "CA Design System", // Version?

    // <div class="wp-block-ca-design-system-category-label cagov-category-label cagov-stack" data-term-id="7">News</div>

    attributes: {
      label: {
        type: "array",
        source: "children",
        selector: "div.cagov-category-label",
      },
      //   term_id: {
      //     type: "string",
      //     source: "attribute",
      //     selector: "div.cagov-category-label[data-term-id]",
      //   },
    },
    // keywords: [__("news"), __("labels")],
    example: {
      attributes: {
        label: __("News", "ca-design-system"),
        // term_id: __("4", "ca-design-system"),
      },
    },
    edit: function (props) {
      var attributes = props.attributes;
      return el(RichText.Content, {
        tagName: "div",
        className: "cagov-category-label cagov-stack",
        value: attributes.label,
        // "data-term-id": attributes.term_id || "",
      });
    },
    save: function (props) {
      var attributes = props.attributes;
      // console.log("save", attributes);

      return el(RichText.Content, {
        tagName: "div",
        className: "cagov-category-label cagov-stack",
        value: attributes.label,
        //   "data-term-id": attributes.term_id || "",
      });
    },
  });

  data.subscribe(function () {
    var blocks = data.select("core/block-editor").getBlocks();

    var isPostDirty = data.select("core/editor").isEditedPostDirty();
    var isAutosavingPost = data.select("core/editor").isAutosavingPost();

    if (isPostDirty && !isAutosavingPost) {
      blocks.map((block) => {
        if (block.name === "ca-design-system/category-label") {
          let categoryLabelBlock = data
            .select("core/block-editor")
            .getBlocksByClientId(block.clientId);

          let updatedSelectedCategory = getSelectedCategory();

          categoryLabelBlock.map((localBlock) => {
            if (
              updatedSelectedCategory !== null &&
              localBlock.attributes !== undefined &&
              localBlock.attributes.label !== null &&
              updatedSelectedCategory !== null &&
              localBlock.attributes.label !== updatedSelectedCategory[0].name &&
              typeof updatedSelectedCategory[0].name === "string"
            ) {
              // console.log("updating", updatedSelectedCategory[0].name);
              // console.log(
              //   "updatedSelectedCategory[0].term_id.toString()",
              //   updatedSelectedCategory[0].term_id.toString()
              // );
              wp.data
                .dispatch("core/block-editor")
                .updateBlockAttributes(localBlock.clientId, {
                  label: updatedSelectedCategory[0].name,
                  //   term_id: updatedSelectedCategory[0].term_id.toString(),
                });
            }
          });
        }
      });
    }
  });
})(
  window.wp.blocks,
  window.wp.blockEditor,
  window.wp.i18n,
  window.wp.element,
  window.wp.components,
  window._,
  window.wp.data,
  window.cagov_category_label_vars
);
