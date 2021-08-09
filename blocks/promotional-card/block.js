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

  // <div class="cagov-promotional-card">
  //         <div class="card-image"><img="{attributes.mediaURL}" alt="{attributes.mediaAlt}" /></div>
  //         <div class="card-content">
  //         <h2>{title}</h2>
  //         <p class="date-range">{startDate: Month Year}-{endDate: Month Year (or present)}</p>
  //         <p class="description>{description}</p>
  //         <div class="wp-block-button">
  //             <a
  //                 class="wp-block-button__link"
  //                 href="{buttonLink}">
  //                     {buttonLabel}
  //             </a>
  //         </div>
  //         </div>
  //     </div>

  blocks.registerBlockType("ca-design-system/promotional-card", {
    title: __("Promotional card", "cagov-design-system"),
    category: "ca-design-system",
    icon: "format-aside",
    description: __("Description", "ca-design-system"),
    attributes: {
      title: {
        type: "string",
      },
      body: {
        type: "string",
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
      mediaURL: {
        type: "string",
        source: "attribute",
        selector: "img",
        attribute: "src",
      },
      mediaAlt: {
        type: "string",
        source: "attribute",
        selector: "img",
        attribute: "alt",
      },
      mediaWidth: {
        type: "string",
        source: "attribute",
        selector: "img",
        attribute: "width",
      },
      mediaHeight: {
        type: "string",
        source: "attribute",
        selector: "img",
        attribute: "height",
      },
    },
    example: {
      attributes: {
        title: __("Campaign title", "cagov-design-system"),
        body: __("Lorem ipsum", "cagov-design-system"),
        buttontext: __("View toolkit", "cagov-design-system"),
        buttonurl: __("https://example.com", "cagov-design-system"),
        mediaURL: "http://www.fillmurray.com/720/240",
        mediaAlt: "Image Description",
        mediaWidth: "576",
        mediaHeight: "338",
      },
    },
    edit: function (props) {
      const attributes = props.attributes;
      var id = attributes.mediaID;
      const { useSelect } = data;
  
      // var mediaObject = data.select("core").getMedia(attributes.mediaID);
      console.log('id', id);
      var mediaObject = useSelect( ( select ) => {
        return select( 'core' ).getMedia( id );
     }, [ id ] );


      console.log("mo", mediaObject);


      // const { withSelect } = data;

      const MediaImageElement = () => {
        console.log("media", mediaObject, attributes);
        return el("img", {
          src: attributes.mediaURL,
          className: "cagov-card-image",
          alt: attributes.mediaAlt,
          // title: media.title,
          // caption: media.caption,
          width: attributes.mediaWidth,
          height: attributes.mediaHeight,
        });
      }

      const MediaImage = MediaImageElement(mediaObject);

      // const MediaImage = withSelect((select) => {
      //   console.log('select', select);
      //   console.log('attributes',attributes); 
      //   return {
      //     media: select("core").getMedia(attributes.mediaID),
      //   }
      // })(MediaImageElement);



      // return props.setAttributes({
      //   mediaID: media.id,

      //   mediaURL: media.sizes.large.url,
      //   mediaAlt: media.description,
      //   mediaWidth: media.sizes.large.width,
      //   mediaHeight: media.sizes.large.height,
      //   // media: media,
      //   // sizeAssignments: {
      //   //   mobile: 'thumbnail',
      //   //   tablet: 'full',
      //   //   desktop: 'full'
      //   // }
      // });


      // console.log(" MediaImage", MediaImage);

      const onSelectImage = function (media) {
        // @TODO since we have the media ID to render, could load large or small size
        // Caching tools from WP (like WP Fastest Cache) can do lazy loading automatically
        return props.setAttributes({
          mediaID: media.id,

          mediaURL: media.sizes.large.url,
          mediaAlt: media.description,
          mediaWidth: media.sizes.large.width,
          mediaHeight: media.sizes.large.height,
          // media: media,
          // sizeAssignments: {
          //   mobile: 'thumbnail',
          //   tablet: 'full',
          //   desktop: 'full'
          // }
        });
      };
      // removed: cagov-with-sidebar cagov-with-sidebar-left cagov-featured-section cagov-bkgrd-gry
      // @TODO cards need their own pattern conventions, simplifying this so we have the cagov-block & css only namespace

      // const currentMediaImage = data.withSelect( ( select, ownProps ) => {
      //   console.log('ownprops', ownProps);
      //   const { localMedia } = data.select( 'core' ).getMedia(ownProps.mediaID);

      //   console.log(localMedia);

      //   return {
      //     localMedia
      //   };
      // } )( );

      // console.log('currentMediaImage', currentMediaImage);

      return el(
        "div",
        { className: "cagov-promotional-card cagov-block" },
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
                  !attributes.mediaID
                    ? __("Upload Image", "cagov-design-system")
                    : el("img", {
                      src: attributes.mediaURL,
                      className: "cagov-card-image",
                      alt: attributes.mediaAlt,
                      // title: media.title,
                      // caption: media.caption,
                      width: attributes.mediaWidth,
                      height: attributes.mediaHeight,
                    })
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
          el(
            "div",
            { className: "cagov-promotional-card-body-content" },
            el(editor.InnerBlocks, {
              allowedBlocks: ["core/paragraph", "core/button"],
              onChange: function (value) {
                // console.log(value);
              },
            })
          )
        )
      );
    },
    // save: function (props) {
    //   const attributes = props.attributes;
    //   return el('div', { className: 'cagov-with-sidebar cagov-with-sidebar-left cagov-featured-section cagov-bkgrd-gry cagov-block' },
    //     el('div', {},
    //       el('div', { className: 'cagov-stack cagov-p-2 cagov-featured-sidebar' },
    //         { className: 'cagov-promotional-card cagov-stack' },
    //         el(RichText.Content, {
    //           tagName: 'h2',
    //           value: attributes.title
    //         }),
    //         el('div', { className: 'cagov-promotional-card-body-content' },
    //           el(editor.InnerBlocks.Content)
    //         )
    //       ),
    //       attributes.mediaURL && el('div', { },
    //         el('img', { className: 'cagov-featured-image', src: attributes.mediaURL, alt: attributes.mediaAlt, width: attributes.mediaWidth, height: attributes.mediaHeight }
    //         )
    //       )
    //     )
    //   );
    // }
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
