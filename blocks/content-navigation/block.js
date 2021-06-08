/**
 * CAGov Content Navigation
 */

 (function (blocks, blockEditor, i18n, element, components, _, moment) {
	var __ = i18n.__;
	var el = element.createElement;
	// https://github.com/WordPress/gutenberg/blob/HEAD/packages/block-editor/src/components/rich-text/README.md  
	//http://wordpress.test:8888/wp-json/wp/v2/tags?per_page=10&orderby=count&order=desc&_fields=id%2Cname%2Ccount&context=edit&_locale=user".
	// var RichText = blockEditor.RichText;
	// var PlainText = blockEditor.PlainText;
	
	blocks.registerBlockType("ca-design-system/content-navigation", {
	  title: __("CAGov: Content Navigation", "ca-design-system"),
	  icon: "universal-access-alt",
	  description: __( 'TBD: Content navigation description here.' ),
	  category: 'ca-design-system',
	  attributes: {
	  },
	  example: {
		attributes: {
		},
	  },
	  supports: {
		html: false,
		// reusable: false,
		// multiple: false,
		// inserter: false
	  },
	  edit: function (props) {
		var attributes = props.attributes;
		return el(
		  "div",
		  {
			className: "cagov-content-navigation cagov-stack",
		  },
		  el(
			"div",
			{},
			// Visual display of content
			el("cagov-content-navigation", {
			  className: "content-navigation",
			  'data-selector': "#main-content",
			  'data-editor': "textarea.block-editor-plain-text",
			  'data-callback': "(content) => unescape(content)"
			}),
		  )
		);
	  },
	  // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/
	  save: function (props) {
		var attributes = props.attributes;
		return el(
			"div",
			{
			  className: "cagov-content-navigation cagov-stack",
			},
			el(
			  "div",
			  {},
			  // Visual display of content
			  el("cagov-content-navigation", {
				className: "content-navigation",
				'data-selector': "#main-content",
				'data-editor': "textarea.block-editor-plain-text",
				'data-callback': "(content) => content"
			  }),
			)
		  );
	  },
	});
  })(
	window.wp.blocks,
	window.wp.blockEditor,
	window.wp.i18n,
	window.wp.element,
	window.wp.components,
	window._,
	window.moment
  );
  