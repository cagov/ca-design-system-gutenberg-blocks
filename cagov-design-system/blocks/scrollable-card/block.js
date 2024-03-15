/**
 * CAGov Scrollable Grid
 *
 */
(function (blocks, element, blockEditor, i18n) {
  var __ = i18n.__;
  const el = element.createElement;
  const InnerBlocks = blockEditor.InnerBlocks;
  const ALLOWED_BLOCKS = ["ca-design-system/scrollable-card"];
  blocks.registerBlockType("ca-design-system/scrollable-card-grid", {
    title: "Scrollable card grid",
    icon: "format-aside",
    category: "ca-design-system",
    description: __("DESCRIPTION", "ca-design-system"),
		supports: {
			align: ['wide']
		},
    edit: function (props) {
      return el(
          "div",
          {
            className: "cagov-grid cagov-block cagov-scrollable-card-grid",
          },
        el(InnerBlocks, {
          orientation: "horizontal",
          allowedBlocks: ALLOWED_BLOCKS,
        })
      );
    },
    save: function (props) {
      // return '<div class="glider-container"><div class="glider cagov-grid cagov-block cagov-scrollable-card-grid">' + InnerBlocks.Content + '<button aria-label="Previous" class="glider-prev">«</button><button aria-label="Next" class="glider-next">»</button><div role="tablist" class="dots"></div></div></div>';

      // Deprecate this confusing UI - we can switch to pure components in next version.
      return el(
        "div",
        {
          className: "glider-contain",
        },
        // https://nickpiscitelli.github.io/Glider.js/index.html#demos

          el(
            "div",
            {
              className: "glider cagov-grid cagov-block cagov-scrollable-card-grid",
            },
            el(InnerBlocks.Content),
          ),

          el('button',{
            className: "glider-prev",
            ariaLabel: "Previous",
          }),
          el('button',{
            className: "glider-next",
            ariaLabel: "Next",
          }),
          el('div',{
            role: "tablist",
            className: "dots"
          })

      );
    },
  });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.i18n);

/**
 * CAGov Scrollable Grid Card
 *
 * Simple block, renders and saves the same content without interactivity.
 *
 * Using inline styles - no external stylesheet needed.  Not recommended
 * because all of these styles will appear in `post_content`.
 */
(function (blocks, editor, i18n, element, components, _, data) {
  const __ = i18n.__;
  const el = element.createElement;
  const RichText = editor.RichText;
  const TextControl = components.TextControl;
  const MediaUpload = editor.MediaUpload;
  const InnerBlocks = editor.InnerBlocks;

  blocks.registerBlockType("ca-design-system/scrollable-card", {
    title: __("Scrollable Card (individual)", "cagov-design-system"),
    category: "ca-design-system",
    icon: "format-aside",
    description: __("Description", "ca-design-system"),
    supports: {
      reusable: true,
      multiple: true,
      inserter: true,
    },
    attributes: {
      title: {
        type: "string",
      },
      body: {
        type: "array",
        source: "children",
        selector: "p",
      },
      buttontext: {
        type: "array",
        source: "children",
        selector: "a",
      },
      buttonurl: {
        type: "array",
        source: "children",
        selector: "button",
      },
      mediaID: {
        type: "number",
      },
      cardLink: {
        type: "string",
      },
      previewMediaUrl: {
        type: "string",
      },
    },
    example: {
      attributes: {
        title: __("Campaign title", "cagov-design-system"),
        body: __("Lorem ipsum", "cagov-design-system"),
        cardLink: __("https://example.com", "cagov-design-system"),
        previewMediaUrl: "http://www.fillmurray.com/576/338",
      },
    },
    edit: function (props) {
      const attributes = props.attributes;

      var id = attributes.mediaID;
      const { useSelect } = data;
      // Auto update media preview alt & captions;
      var mediaObject = useSelect(
        (select) => {
          return select("core").getMedia(id);
        },
        [id]
      );
      const onSelectImage = function (media) {
        // Raw media object, not formatted
        // Store data for local use in preview (of alt tags and responsive image sizes) (may deprecate, but not sure yet)
        return props.setAttributes({
          mediaID: media.id,
          previewMediaUrl: media.sizes.thumbnail.url, // thumbnail
        });
      };

      return el(
        "div",
        {
          className:
            "wp-block-ca-design-system-scrollable-card cagov-scrollable-card cagov-block cagov-stack",
        },
				el(
					"div",
					{ className: "cagov-card-image" },
					el(MediaUpload, {
						onSelect: onSelectImage,
						allowedTypes: "image",
						value: attributes.mediaID,
						render: function (obj) {
						// If mediaObject exists, render the image directly
						if (
							mediaObject &&
							mediaObject.media_details.sizes &&
							mediaObject.media_details.sizes.medium
						) {
							const mediaURL = mediaObject.media_details.sizes.medium.source_url;
							const mediaAlt = mediaObject.alt_text;
							const mediaWidth = mediaObject.media_details.sizes.medium.width;
							const mediaHeight = mediaObject.media_details.sizes.medium.height;
							return el(
								"img",
								{
									src: mediaURL,
									className: "cagov-card-image w-100 h-auto d-block",
									alt: mediaAlt,
									width: mediaWidth,
									height: mediaHeight,
								}
							);
						}

						// Render upload button if no image selected
						return el(
							components.Button,
							{
							className: attributes.mediaID ? "image-button" : "button button-large",
							onClick: obj.open,
							},
							!attributes.mediaID
							? __("Upload Image", "cagov-design-system")
							: null
						);
						},
					}),
					!attributes.mediaID
						? el("span", {
								className: "ui-label",
								value: __(
									"Image uploaded must be at least 366px x 260px",
									"cagov-design-system"
								),
							})
						: el(TextControl, {
								className: "cagov-card-image-set-link",
								tagName: "a",
								inline: true,
								placeholder: __(
									"example: /path-to-page, or a hyperlink",
									"cagov-design-system"
								),
								label: __("Image link (optional)", "cagov-design-system"),
								value: attributes.cardLink,
								onChange: function (value) {
									props.setAttributes({ cardLink: value });
								},
							})
				),
				el(
					"div",
					{ className: "cagov-card-content" },
					el(RichText, {
						tagName: "h3",
						className: "card-title",
						inline: true,
						placeholder: __("Card title", "cagov-design-system"),
						value: attributes.title,
						onChange: function (value) {
							props.setAttributes({ title: value });
						},
					}),
					el(
						"div",
						{ className: "cagov-card-body" },
						el(editor.InnerBlocks, {
							allowedBlocks: ["core/paragraph", "core/button"],
							onChange: function (value) {
								console.log(value);
							},
						})
					)
				)
      );
    },
    save: function (props) {
      return el(
        "div",
        {},
        el(
          "div",
          { className: "cagov-card-body-content" },
          el(editor.InnerBlocks.Content)
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
  window.wp.data
);
