/**
 * CAGov promotional card
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
  const MediaUpload = editor.MediaUpload;
  const InnerBlocks = editor.InnerBlocks;

  blocks.registerBlockType("ca-design-system/promotional-card", {
    title: __("Promotional card", "cagov-design-system"),
    category: "ca-design-system",
    icon: "format-aside",
    description: __("Description", "ca-design-system"),
    attributes: {
      title: {
        type: "string",
      },
      date: {
        type: "string",
      },
      body: {
        type: 'array',
        source: 'children',
        selector: 'p'
      },
      buttontext: {
        type: 'array',
        source: 'children',
        selector: 'a'
      },
      buttonurl: {
        type: 'array',
        source: 'children',
        selector: 'button'
      },
      // body: {
      //   type: "string",
      // },
      // button: {
      //   type: "string",
      // },
      // buttontext: {
      //   type: "string",
      // },
      // buttonurl: {
      //   type: "string",
      // },
      mediaID: {
        type: "number",
      },
      images: {
        type: "object",
        // mediaAlt: {
        //   type: "string",
        //   source: "attribute",
        //   selector: "img",
        //   attribute: "alt",
        // },
        // desktop: {
          // mediaURL: {
          //   type: "string",
          //   source: "attribute",
          //   selector: "img",
          //   attribute: "src",
          // },
          // mediaWidth: {
          //   type: "string",
          //   source: "attribute",
          //   selector: "img",
          //   attribute: "width",
          // },
          // mediaHeight: {
          //   type: "string",
          //   source: "attribute",
          //   selector: "img",
          //   attribute: "height",
          // },
        // },
        },
    },
    example: {
      attributes: {
        title: __("Campaign title", "cagov-design-system"),
        date: __("Date range", "cagov-design-system"),
        body: __("Lorem ipsum", "cagov-design-system"),
        buttontext: __("View toolkit", "cagov-design-system"),
        buttonurl: __("https://example.com", "cagov-design-system"),
        images: {
          mediaAlt: __("Image Alt", "cagov-design-system"),
          mediaCaption: __("Image Caption", "cagov-design-system"),
          mediaDescription: __("Image Description", "cagov-design-system"),
          mediaTitle: __("Image Title", "cagov-design-system"),
          desktop: {
            mediaURL: "http://www.fillmurray.com/576/338",
            mediaWidth: "576",
            mediaHeight: "338",
          },
          tablet: {
            mediaURL: "http://www.fillmurray.com/576/338",
            mediaWidth: "576",
            mediaHeight: "338",
          },
          mobile: {
            mediaURL: "http://www.fillmurray.com/576/338",
            mediaWidth: "576",
            mediaHeight: "338",
          },
        },
      },
    },
    edit: function (props) {
      const attributes = props.attributes;

      var id = attributes.mediaID;
      var images = attributes.images;
      const { useSelect } = data;

      // Auto update media preview alt & captions;
      var mediaObject = useSelect(
        (select) => {
          return select("core").getMedia(id);
        },
        [id]
      );

      const MediaImageElement = () => {
        console.log("media", mediaObject, attributes);
        if (
          images !== undefined && 
          mediaObject !== undefined &&
          mediaObject.media_details.sizes !== undefined
        ) {
          const mediaURL = mediaObject.media_details.sizes.large.source_url;
          const mediaAlt = mediaObject.alt_text;
          // const mediaCaption = mediaObject.caption.raw;
          // const mediaTitle = mediaObject.title.raw;
          // const mediaDescription = mediaObject.description.raw;
          const mediaWidth = mediaObject.media_details.sizes.large.width;
          const mediaHeight = mediaObject.media_details.sizes.large.height;
            // caption: mediaCaption,
            // description: mediaDescription,
            // title: mediaTitle,
          return el("img", {
            src: mediaURL,
            className: "cagov-card-image",
            alt: mediaAlt,
            width: mediaWidth,
            height: mediaHeight,
          });
        }
        return null;
      };

      var MediaImage;
      if (images !== undefined && images.desktop.mediaURL !== undefined) {
        MediaImage = el("img", {
          src: images.desktop.mediaURL,
          className: "cagov-card-image",
          alt: images.mediaAlt,
          width: images.desktop.mediaWidth,
          height: images.desktop.mediaHeight,
        });
      }

      MediaImage = MediaImageElement(mediaObject);

      const onSelectImage = function (media) {
        // Raw media object, not formatted
        // console.log("select media", media, media.alt_text, media.caption.raw, media.title.raw, media.description.raw);
        // Store data for local use in preview (of alt tags and responsive image sizes) (may deprecate, but not sure yet)
        return props.setAttributes({
          mediaID: media.id,
          images: {
            mediaAlt: media.alt, 
            mediaCaption: media.caption,
            mediaTitle: media.title,
            mediaDescription: media.description,
            desktop: {
              mediaURL: media.sizes.large.url,
              mediaWidth: media.sizes.large.width,
              mediaHeight: media.sizes.large.height,
            },
            tablet: {
              mediaURL: media.sizes.large.url,
              mediaWidth: media.sizes.large.width,
              mediaHeight: media.sizes.large.height,
            },
            mobile: {
              mediaURL: media.sizes.large.url,
              mediaWidth: media.sizes.large.width,
              mediaHeight: media.sizes.large.height,
            }
          },
        });
      };

      // removed: cagov-with-sidebar cagov-with-sidebar-left cagov-featured-section cagov-bkgrd-gry
      // @TODO cards need their own pattern conventions, simplifying this so we have the cagov-block & css only namespace

      return el(
        "div",
        { className: "wp-block-ca-design-system-promotional-card cagov-promotional-card cagov-block" },
        el(
          "div",
          { className: "cagov-stack" },
          el(
            "div",
            { className: "cagov-card-image" },
            el(MediaUpload, {
              onSelect: onSelectImage,
              allowedTypes: "image",
              value: attributes.mediaID,
              render: function (obj) {
                return el(
                  components.Button,
                  {
                    className: attributes.mediaID
                      ? "image-button"
                      : "button button-large",
                    onClick: obj.open,
                  },
                  !attributes.mediaID && (images === undefined || !images.desktop.mediaURL)
                    ? __("Upload Image", "cagov-design-system")
                    : MediaImage
                );
              },
            })
          ),
          el(RichText, {
            tagName: "h2",
            inline: true,
            placeholder: __("Write title…", "cagov-design-system"),
            value: attributes.title,
            onChange: function (value) {
              props.setAttributes({ title: value });
            },
          }),
          el(RichText, {
            tagName: "div",
            className: "cagov-card-date",
            inline: false,
            placeholder: __("Write date range…", "cagov-design-system"),
            value: attributes.date,
            onChange: function (value) {
              props.setAttributes({ date: value });
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
      const attributes = props.attributes;  

      return el('div', {},
            el('div', { className: 'cagov-card-body-content' },
              el(editor.InnerBlocks.Content)
            )
      );

      // return el('div', { className: 'wp-block-ca-design-system-promotional-card cagov-promotional-card cagov-block' },
      //   el('div', {},
      //     el('div', { className: 'cagov-stack cagov-p-2 cagov-featured-sidebar' },
      //       { className: 'cagov-promotional-card cagov-stack' },
      //       el(RichText.Content, {
      //         tagName: 'h2',
      //         value: attributes.title
      //       }),
      //       el('div', { className: 'cagov-promotional-card-body-content' },
      //         el(editor.InnerBlocks.Content)
      //       )
      //     ),
      //     attributes.mediaURL && el('div', { },
      //       el('img', { className: 'cagov-featured-image', src: attributes.mediaURL, alt: attributes.mediaAlt, width: attributes.mediaWidth, height: attributes.mediaHeight }
      //       )
      //     )
      //   )
      // );
    }
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
