/**
 * CAGov Accordion
 */
(function (blocks, editor, i18n, element, components, _) {
  var __ = i18n.__;
  var el = element.createElement;
  var RichText = editor.RichText;

  let newScript = document.createElement("script");
  newScript.type="module";
  newScript.src = "https://files.covid19.ca.gov/js/components/accordion/v1/index.js";
  newScript.defer = true;
  document.querySelector('head').appendChild(newScript);


  blocks.registerBlockType(
    "ca-design-system/accordion",
    {
      title: __("Accordion", "ca-design-system"),
      icon: "format-aside",
      description: __(
        "An expandable section of content. Can be used on any standard content page. Allows information that is not applicable to the majority of readers to be initially hidden, and opened on demand. Includes accordion label, button, and body content. The label can be a question or a title.",
        "ca-design-system"
      ),
      category: "ca-design-system",
      attributes: {
        title: {
          type: 'string'
        },
        body: {
          type: 'array',
          source: 'children',
          selector: '.card-body'
        }
      },
      example: {
        attributes: {
          title: __('accordion title', 'cagov-design-system'),
          body: __('accordion body', 'cagov-design-system')
        }
      },
      edit: function (props) {



        const attributes = props.attributes;
        return el('cagov-accordion', { },
          el('div', { className: 'cagov-accordion-card' },
            el('button', { className: 'accordion-card-header accordion-alpha', type: 'button', 'aria-expanded': "true" },
              el(RichText, {
                tagName: 'div',
                inline: true,
                classname: 'accordion-title',
                placeholder: __(
                  'Write accordion title…',
                  'cagov-design-system'
                ),
                value: attributes.title,
                onChange: function (value) {
                  props.setAttributes({ title: value });
                }
              }),
              el('div', { className: 'plus-minus' },
                el('cagov-plus', {}),
                el('cagov-minus', {}),
              )
            ),
            el('div', { className: 'accordion-card-container' },
              el(
                'div',
                { className: 'card-body' },
                el(editor.InnerBlocks,
                  {
                    allowedBlocks: ['core/heading', 'core/paragraph', 'core/button', 'core/list'],
                    onChange: function (value) {
                      // console.log(value);
                    }
                  }
                )
              )
            ),
          )
        );
      },
      save: function (props) {
        const attributes = props.attributes;
        return el(editor.InnerBlocks.Content)
      }
    }
  );
})(
  window.wp.blocks,
  window.wp.blockEditor,
  window.wp.i18n,
  window.wp.element,
  window.wp.components,
  window._
);
