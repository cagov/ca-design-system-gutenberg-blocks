/**
 * CAGov card
 *
 * Custom block, renders and saves the same content
 *
 */
(function (blocks, editor, i18n, element, components, _) {
  const __ = i18n.__;
  const el = element.createElement;
  const RichText = editor.RichText;
  const BlockControls = editor.BlockControls;
  const URLPopover = editor.URLPopover;

  blocks.registerBlockType('cagov/card', {
    title: __('CAGov: Card', 'cagov-design-system'),
    icon: 'universal-access-alt',
    category: 'layout',
    attributes: {
      title: {
        type: 'array',
        source: 'children',
        selector: 'h3'
      },
      url: {
        type: 'string'
      }
    },
    example: {
      attributes: {
        title: __('Card title', 'cagov-design-system'),
        body: __('Card body', 'cagov-design-system')
      }
    },
    edit: function (props) {
      const attributes = props.attributes;

      const [isURLInputVisible, setIsURLInputVisible] = element.useState(false);

      const openURLInput = () => {
        if (isURLInputVisible) {
          setIsURLInputVisible(false);
        } else {
          setIsURLInputVisible(true);
          document.querySelector('.block-editor-url-popover__row input').focus();
        }
      };
      const closeURLInput = () => {
        setIsURLInputVisible(false);
      };

      const onSubmitSrc = (event) => {
        event.preventDefault();
        closeURLInput();
      };

      return [
        el(
          BlockControls,
          { key: 'controls' },
          el(components.ToolbarGroup, {},
            el(components.ToolbarButton, {
              label: 'Enter card link URL',
              icon: 'admin-links',
              onClick: openURLInput,
              isPressed: isURLInputVisible
            },
            el(URLPopover, { onClose: function () {} },
              el('form', {
                className: isURLInputVisible ? 'block-editor-media-placeholder__url-input-form url-input-form' : 'disp-none',
                onSubmit: onSubmitSrc,
                onClick: function (event) { event.stopPropagation(); },
                onClose: closeURLInput
              },
              el(editor.URLInput, {
                className: 'block-editor-media-placeholder__url-input-field url-input-field--card',
                type: 'url',
                placeholder: 'Paste or type card URL',
                'aria-label': 'Paste or type card URL',
                url: attributes.url,
                value: attributes.url,
                onChange: function (value) {
                  props.setAttributes({ url: value });
                },
                onClose: closeURLInput,
                onSubmit: onSubmitSrc

              }),
              el(components.Button, {
                className: 'block-editor-media-placeholder__url-input-submit-button url-submit-button',
                icon: 'undo',
                label: 'Apply',
                'aria-label': 'Submit',
                type: 'submit'
              })
              )
            )
            )
          )
        ),
        el('div',
          { className: 'cagov-card cagov-stack' },
          el(RichText, {
            tagName: 'h3',
            inline: true,
            withoutInteractiveFormatting: true,
            placeholder: __(
              'Write card title…',
              'cagov-design-system'
            ),
            value: attributes.title,
            onChange: function (value) {
              props.setAttributes({ title: value });
            }
          })
        )
      ];
    },
    save: function (props) {
      const attributes = props.attributes;
      return el('a', {
        href: attributes.url,
        className: 'no-deco cagov-card'
      },
      el(RichText.Content, {
        tagName: 'h3',
        value: attributes.title
      }),
      el('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        'enable-background': 'new 0 0 24 24',
        height: '24px',
        viewBox: '0 0 24 24',
        width: '24px'
      },
      el('g', {},
        el('path', {
          d: 'M0,0h24v24H0V0z',
          fill: 'none'
        })
      ),
      el('g', {},
        el('polygon', {
          points: '6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12'
        })
      )
      )
      );
    }
  });
})(
  window.wp.blocks,
  window.wp.blockEditor,
  window.wp.i18n,
  window.wp.element,
  window.wp.components,
  window._
);
