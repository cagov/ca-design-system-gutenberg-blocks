/**
 * CAGov Accordion
 */

(function (blocks, blockEditor, i18n, element, components, _) {
  var __ = i18n.__;
  var el = element.createElement;
  var RichText = blockEditor.RichText;
  var PlainText = blockEditor.PlainText;
  var TextControl = components.TextControl;

  blocks.registerBlockType(
    "ca-design-system/accordion",
    {
      title: __("Accordion", "ca-design-system"),
      icon: "plus-alt",
      description: __(
        "An expandable section of content. Can be used on any standard content page. Allows information that is not applicable to the majority of readers to be initially hidden, and opened on demand. Includes accordion label, button, and body content. The label can be a question or a title.",
        "ca-design-system"
      ),
      category: "ca-design-system",
      anchor: "layout", // @TODO - double check: Is this right?
      supports: {
        anchor: true,
      },
      attributes: {
        title: {
          type: "array",
          source: "children",
          selector: "h3",
          default: "Title",
        },
        content: {
          type: "array",
          source: "children",
          selector: "p.content",
        },
        // anchor: {
        //   type: "string",
        //   source: "attribute",
        //   selector: "p.accordion",
        //   default: "#anchor",
        // },
        // isOpen: {
        //   type: "string",
        //   source: "html",
        //   selector: "p.is-open",
        //   default: 'Open',
        // },
      },
      example: {
        attributes: {
          title: __("Accordion title", "ca-design-system"),
          content: __("Accordion content", "ca-design-system"),
          // anchor: __("Link Text", "ca-design-system"),
          // isOpen: __("Open", "ca-design-system"),
        },
      },
      edit: function (props) {
        var attributes = props.attributes;

        return el(
          "div",
          {
            className: "cagov-accordion cagov-stack",
          },
          el(
            "div",
            {},
            el(RichText, {
              tagName: "h3",
              inline: false,
              placeholder: __("Accordion title", "ca-design-system"),
              value: attributes.title,
              onChange: function (value) {
                props.setAttributes({ title: value });
              },
            }),
            el(RichText, {
              tagName: "p.content",
              inline: false,
              placeholder: __("Accordion content", "ca-design-system"),
              value: attributes.content,
              onChange: function (value) {
                props.setAttributes({ content: value });
              },
            })
            // el(RichText, {
            //   tagName: "p.anchor",
            //   inline: false,
            //   placeholder: __("Accordion anchor", "ca-design-system"),
            //   value: attributes.anchor,
            //   onChange: function (value) {
            //     props.setAttributes({ anchor: value });
            //   },
            // }),
            // el(RichText, {
            //   tagName: "p.is-open",
            //   inline: false,
            //   placeholder: __("Accordion is open t/f", "ca-design-system"),
            //   value: attributes.isOpen,
            //   onChange: function (value) {
            //     props.setAttributes({ isOpen: value });
            //   },
            // }),
          )
        );
      },
      // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/
      save: function (props) {
        var attributes = props.attributes;

        // cagov expected markup

        // * Notes - needs different icon handling
        // * anchor?
        //
        /**
       * 
       * <cagov-accordion>
  <div class="card">
    <button class="card-header accordion-alpha" type="button" aria-expanded="false">
      <div class="accordion-title">Who can get a Cal Grant</div>
      <div class="plus-munus">
        <cagov-plus></cagov-plus><cagov-minus></cagov-minus>
      </div>
    </button>
    <div class="card-container aria-hidden="true" style="height: 0px;">
      <div class="card-body">
        <p class="content">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
      </div>
    </div>
  </div>
</cagov-accordion>
       */

        return el(
          "cagov-accordion",
          el(
            "div",
            { className: "card" },
            el(
              "button",
              {
                className: "card-header accordion-alpha",
                type: "button",
                ariaExpanded: false,
              },
              el(
                "div",
                { className: "accordion-title" },

                el(RichText.Content, {
                  tagName: "h3",
                  value: attributes.title,
                })
                // <div class="plus-munus">
                //   <cagov-plus></cagov-plus><cagov-minus></cagov-minus>
                // </div>
              ) // .accordion-title
            ), // button

            el(
              "div",
              {
                className: "card-container",
                type: "button",
                ariaHidden: true,
                style: { height: "0px" },
              },
              el(
                "div",
                { className: "card-body" },
                el(RichText.Content, {
                  tagName: "p",
                  className: "content",
                  value: attributes.content,
                }) // dynamic content
              ) // .card-body
            ) // .card-container
          ) // .card
        ); // cagov-accordion
      },
    }

    //   return el(
    //     "div",
    //     { className: "cagov-accordion cagov-stack" },
    //     el(
    //       "div",
    //       {},
    //       el(RichText.Content, {
    //         tagName: "h3",
    //         value: attributes.title,
    //       }),
    //       el(RichText.Content, {
    //         tagName: "p.content",
    //         value: attributes.content,
    //       }),
    //       el(RichText.Content, {
    //         tagName: "p.anchor",
    //         value: attributes.isOpen,
    //       }),
    //       el(RichText.Content, {
    //         tagName: "p.is-open",
    //         value: attributes.isOpen,
    //       }),
    //     )
    //   );
    // },
  );
})(
  window.wp.blocks,
  window.wp.blockEditor,
  window.wp.i18n,
  window.wp.element,
  window.wp.components,
  window._
);
