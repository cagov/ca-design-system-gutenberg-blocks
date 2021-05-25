/**
 * CAGov card
 *
 * Simple block, renders and saves the same content without interactivity.
 *
 * Using inline styles - no external stylesheet needed.  Not recommended
 * because all of these styles will appear in `post_content`.
 */
 ( function( blocks, editor, i18n, element, components, _ ) {
	var __ = i18n.__;
	var el = element.createElement;
	var RichText = editor.RichText;
	var URLInputButton = editor.URLInputButton;
	var BlockControls = editor.BlockControls;
	

	blocks.registerBlockType( 'cagov/card', {
		title: __( 'CAGov: Card', 'cagov-design-system' ),
		icon: 'universal-access-alt',
		category: 'layout',
		attributes: {
			title: {
				type: 'array',
				source: 'children',
				selector: 'h3',
			},
			url: {
				type: 'string'
			}
		},
		example: {
			attributes: {
				title: __( 'Card title', 'cagov-design-system' ),
				body: __( 'Card body', 'cagov-design-system' )
			}
		},
		edit: function( props ) {
			var attributes = props.attributes;

			return [
				el(
					BlockControls,
					{ key: 'controls' },
					el( components.ToolbarGroup, {},
						el( components.ToolbarButton, {},
							el(URLInputButton, {
								label: "Enter card link URL",
								onClick: function() { console.log('pressed button')},
								url: attributes.url,
								onChange: function( url, post ) {
									props.setAttributes( { url: url, text: (post && post.title) || 'Click here' } );
								}
							} )
						)
					)
				),
				el( 'div',
					{ className: 'cagov-card cagov-stack' },
					el( RichText, {
						tagName: 'h3',
						inline: true,
						withoutInteractiveFormatting: true,
						placeholder: __(
							'Write card title…',
							'cagov-design-system'
						),
						value: attributes.title,
						onChange: function( value ) {
							props.setAttributes( { title: value } );
						},
					} )
				)
			]
		},
		save: function(props) {
			var attributes = props.attributes;
			return el('a', {
					href: attributes.url,
					className: 'no-deco cagov-card'
				},
				el( RichText.Content, {
					tagName: 'h3',
					value: attributes.title,
				} ),
				el( 'svg', {
					xmlns: "http://www.w3.org/2000/svg",
					'enable-background': "new 0 0 24 24",
					height: "24px",
					viewBox: "0 0 24 24",
					width: "24px",
				},
					el('g', {},
						el('path', {
							d: 'M0,0h24v24H0V0z',
							fill: 'none'
						})
					),
					el('g', {},
						el('polygon', {
							points: '6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12',
						})
					),
				)				
			);
		},
	} );
} )(
	window.wp.blocks,
	window.wp.blockEditor,
	window.wp.i18n,
	window.wp.element,
	window.wp.components,
	window._
);
