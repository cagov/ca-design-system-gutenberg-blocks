/**
 * CAGov Breadcrumb
 *
 */
 ( function( blocks, editor, i18n, element, components, _ ) {
	var __ = i18n.__;
	var el = element.createElement;
	var RichText = editor.RichText;

	// https://wp.zacgordon.com/2017/12/07/how-to-add-custom-icons-to-gutenberg-editor-blocks-in-wordpress/
	// @TODO Make CA Design System Icon component or pull in CA Gov icons svg paths.

	// https://thenounproject.com/search/?q=california&i=363011
	var californiaPath = "M11.9413 21C11.9386 20.8245 11.7834 20.7291 11.7286 20.2937C11.6778 19.4689 10.4617 18.315 10.1451 18.372C9.8284 18.4289 9.71005 18.4466 9.72285 18.35C9.73543 18.2534 9.87062 17.727 9.23304 17.762C8.59545 17.797 8.31247 17.6041 8.05061 17.1521C7.78875 16.7001 7.46378 17.0774 7.29894 16.9153C7.13432 16.7529 6.58095 16.7704 6.18838 16.8142C5.79558 16.8581 5.8167 16.4369 5.83781 16.2878C5.85892 16.1387 5.69857 16.1212 5.77447 15.8184C5.85038 15.5157 5.82927 15.2217 5.72372 15.2173C5.61817 15.2129 5.29724 15.2304 5.43648 14.9672C5.57572 14.704 5.09017 14.4319 5.01426 14.3397C4.93836 14.2476 4.61586 14.004 4.56241 13.7562C4.50895 13.5084 4.33872 13.6554 4.25832 13.2517C4.17815 12.848 3.78962 12.9885 3.73482 12.6418C3.68002 12.2953 3.34629 12.1154 3.78535 12.0846C4.22441 12.0538 3.89091 11.0448 3.70518 11.0973C3.51945 11.1501 3.54033 11.2992 3.1983 10.9877C2.85626 10.6762 3.01683 10.5182 2.84368 10.0049C2.67053 9.49153 2.69164 9.45653 2.96271 9.80397C3.23378 10.1516 3.78109 10.3822 3.4898 9.961C3.19852 9.53983 3.00673 9.55967 3.21963 8.95183C3.43253 8.344 2.7635 8.57453 2.75946 8.93877C2.7552 9.303 2.55262 9.08787 2.14725 8.7941C1.74188 8.5001 2.29929 8.6492 2.22743 8.55727C2.15556 8.4651 2.0289 8.2502 1.99948 8.1186C1.96983 7.987 1.7293 7.76977 1.7293 7.76977C1.38727 7.5152 1.8645 7.8554 1.21838 7.14887C0.572259 6.44257 1.15932 6.6927 1.01985 6.40313C0.741144 5.85923 0.872076 5.59137 0.872076 5.59137C1.21838 4.97723 0.369461 4.07773 0.166889 3.89783C-0.0356844 3.71793 0.0402244 3.52497 0.00227001 3.38893C-0.0356843 3.2529 0.41348 2.4738 0.514092 2.2176C0.614705 1.9614 0.420891 1.9698 0.470748 1.89303C0.778874 1.26117 0.582365 0.847467 0.555415 0.6251C0.528466 0.402733 0.335774 0.629533 0.398882 0.473433C0.461765 0.317333 0.496126 0 0.496126 0L7.06627 0.289333L7.00069 6.804L16.1079 15.5332C16.1079 15.5332 16.057 15.7684 16.1225 15.8214C16.1881 15.8746 16.1868 16.0165 16.3707 16.1173C16.5546 16.2181 16.3925 16.4435 16.5751 16.6255C16.7574 16.8075 16.9254 16.9062 16.9692 16.9591C17.013 17.0123 17.0422 17.164 16.8232 17.3005C16.6043 17.437 16.4601 17.3605 16.5167 17.5964C16.5733 17.832 16.2739 17.8127 16.2739 17.8127C16.2739 17.8127 16.4073 17.9529 16.3927 18.1727C16.3781 18.3925 16.3855 18.9642 16.152 18.9765C15.9184 18.9889 16.0862 19.2572 16.1153 19.2799C16.1445 19.3027 16.1897 19.5342 16.1008 19.6894C16.0118 19.8445 16.2029 19.841 16.2905 19.8259C16.3781 19.8107 16.4949 19.8333 16.5095 19.9397C16.5241 20.0459 16.5971 20.2963 16.4439 20.3873C16.2907 20.4783 16.1156 20.5011 16.1156 20.5011L11.9413 21Z";
	
	const iconElement = el('svg', { width: 17, height: 21},
  		el('path', { d: californiaPath } )
	);

	blocks.registerBlockType( 'ca-design-system/breadcrumb', {
		title: __( 'Breadcrumb', 'ca-design-system' ),
		icon: iconElement,//  "plus-alt",
		description: __('Site navigation breadcrumb. Used in Gutenberg block patterns. Allows users to navigate the menu structure of the site. Configured through default Wordpress menu system.'),
		category: 'ca-design-system-utilities',
		supports: {
			multiple: false,
			reusable: false,
			// inserter: false, // @TODO Disable in interface when development cycle is complete.
		},
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
				{ className: 'cagov-breadcrumb cagov-stack' },
				el( RichText, {
					tagName: 'h3',
					inline: true,
					placeholder: __(
						'Write breadcrumb title…',
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
						'Write breadcrumb body',
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
				{ className: 'cagov-breadcrumb cagov-stack' },
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
