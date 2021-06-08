/**
 * CAGov Content Footer
 *
 */
 ( function( blocks, editor, i18n, element, components, _ ) {
	var __ = i18n.__;
	var el = element.createElement;
	var RichText = editor.RichText;

	blocks.registerBlockType( 'ca-design-system/content-footer', {
		title: __( 'Content Footer', 'ca-design-system' ),
		icon: 'universal-access-alt',
		category: 'ca-design-system',
		attributes: {
			title: {
				type: 'array',
				source: 'children',
				selector: 'h3',
			},
			body: {
				type: 'array',
				source: 'children',
				selector: 'p',
			}
		},
		example: {
			attributes: {
				title: __( 'Card title', 'ca-design-system' ),
				body: __( 'Card body', 'ca-design-system' )
			}
		},
		edit: function( props ) {
			var attributes = props.attributes;

			return el(
				'div',
				{ className: 'cagov-content-footer cagov-stack' },
				el( RichText, {
					tagName: 'h3',
					inline: true,
					placeholder: __(
						'Write content-footer title…',
						'ca-design-system'
					),
					value: attributes.title,
					onChange: function( value ) {
						props.setAttributes( { title: value } );
					},
				} ),
				el( RichText, {
					tagName: 'p',
					inline: true,
					placeholder: __(
						'Write content-footer body',
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
				{ className: 'cagov-content-footer cagov-stack' },
				el( RichText.Content, {
					tagName: 'h3',
					value: attributes.title,
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
