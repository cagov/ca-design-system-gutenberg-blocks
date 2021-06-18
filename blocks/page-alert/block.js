/**
 * CAGov Page Alert
 *
 */
 ( function( blocks, editor, i18n, element, components, _ ) {
    var __ = i18n.__;
    var el = element.createElement;
    var RichText = editor.RichText;

    blocks.registerBlockType( 'ca-design-system/page-alert', {
        title: __( 'Page Alert', 'ca-design-system' ),
        icon: 'universal-access-alt',
        category: 'ca-design-system',
        description: __("A departmental alert box. Appears on this website, beneath the site navigation on the homepage. Provides brief, important or time-sensitive information. It can include a hyperlink, but not a button or image.", "ca-design-system"),
        attributes: {
            icon: {
                type: 'array',
                source: 'children',
                selector: 'span.icon',
            },
            body: {
                type: 'array',
                source: 'children',
                selector: 'p',
            }
        },
        example: {
            attributes: {
                icon: __( 'Icon', 'ca-design-system' ),
                body: __( 'Card body', 'ca-design-system' )
            }
        },
        edit: function( props ) {
            var attributes = props.attributes;

            return el(
                'div',
                { className: 'cagov-page-alert cagov-stack' },
                el( RichText, {
                    tagName: 'span',
                    className: 'icon',
                    inline: true,
                    placeholder: __(
                        'Insert icon',
                        'ca-design-system'
                    ),
                    value: attributes.icon,
                    onChange: function( value ) {
                        props.setAttributes( { icon: value } );
                    },
                } ),
                el( RichText, {
                    tagName: 'p',
                    inline: true,
                    placeholder: __(
                        'Write page-alert message',
                        'ca-design-system'
                    ),
                    value: attributes.body,
                    onChange: function( value ) {
                        props.setAttributes( { body: value } );
                    },
                } )
            );
        },
        save: function(props) {
            var attributes = props.attributes;
            return el(
                'div',
                { className: 'cagov-page-alert cagov-stack' },
                el( RichText.Content, {
                    tagName: 'span',
                    className: 'icon',
                    value: attributes.icon,
                } ),
                el( RichText.Content, {
                    tagName: 'p',
                    value: attributes.body,
                } )
            );
        },
    } );
} )(
    window.wp.blocks,
    window.wp.editor,
    window.wp.i18n,
    window.wp.element,
    window.wp.components,
    window._
);
