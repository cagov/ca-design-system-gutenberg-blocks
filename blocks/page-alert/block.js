/**
 * CAGov Page Alert
 *
 */
 ( function( blocks, editor, i18n, element, components, _, compose ) {
    var __ = i18n.__;
    var el = element.createElement;
    var RichText = editor.RichText;

    var { SelectControl } = components;
    // var { withState } = compose;
     
    // const SelectIcon = withState( {
    //     icon: 'bell',
    // } )( ( { size, setState } ) => (
    //     <SelectControl
    //         label="Icon"
    //         value={ icon }
    //         options={ [
    //             { label: 'Bell', value: 'bell' },
    //         ] }
    //         onChange={ ( icon ) => {
    //             setState( { icon } );
    //         } }
    //     />
    // ) );





    blocks.registerBlockType( 'ca-design-system/page-alert', {
        title: __( 'Page Alert', 'ca-design-system' ),
        icon: 'format-aside',
        category: 'ca-design-system',
        description: __("A departmental alert box. Appears on this website, beneath the site navigation on the homepage. Provides brief, important or time-sensitive information. It can include a hyperlink, but not a button or image.", "ca-design-system"),
        attributes: {
            icon: {
                type: 'string',
            },
            body: {
                type: 'string'
            }
        },
        example: {
            attributes: {
                icon: __( 'bell', 'ca-design-system' ),
                body: __( 'We’re accepting applications for regulatory relief due to COVID-19. <a href="#">Find out how to apply.</a>', 'ca-design-system' )
            }
        },
        edit: function( props ) {
            var attributes = props.attributes;
            return el(
                'div',
                { className: 'cagov-page-alert cagov-stack' },
                el(SelectControl, {
                    label: "Icon",
                    inline: true,
                    className: "icon-select",
                    value: attributes.icon,
                    options: [
                        { label: 'None', value: '' },
                        { label: 'Bell', value: 'bell' },
                        { label: 'Warning', value: 'warning' },
                        { label: 'Question', value: 'editor-help' },
                        { label: 'Flag', value: 'flag' },
                        { label: 'Star', value: 'star-filled' },
                    ],
                    onChange: function( value ) {
                        props.setAttributes( { icon: value } );
                    },
                }),
                el( RichText, {
                    tagName: 'p',
                    inline: true,
                    placeholder: __(
                        'Write page alert message',
                        'ca-design-system'
                    ),
                    value: attributes.body,
                    onChange: function( value ) {
                        props.setAttributes( { body: value } );
                    },
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
    window._,
    window.wp.compose
);
