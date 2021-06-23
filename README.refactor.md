@TODO Update this, is out of date.
## Organization

* Plugin: `ca-design-system.php` - Initial starting script for Wordpress plugin
* `blocks` — Individual Gutenberg block code.
* `patterns` - Page guides
* `includes` — Code for the Wordpress plugin
* `core` - WP updater scripts (not yet tested)

## How a Gutenberg block folder is structured

For an individual block:
* `blocks/template` needs to be versioned and periodically updated to be a good starting point.
* `plugin.php` — Main class for Gutenberg block
* `block.js` — Editor and Rendering of Gutenberg block
* `style.css` — Custom styles for the Gutenberg block editor interface and rendering of the block content.
* `languages` — For textdomain settings

### Documentation and packaging
`README.md` — NAME, DESCRIPTION, LINK TO MAIN ISSUE, SCREENSHOTS, link to imported web component.
`package.json` — Versioning notes, import webcomponent from npm
`template.html` — Output markup
`icon` 
`category`

## Process for working on a new Gutenberg block

* You should have a Github issue scoped out with the [correct template]() and agreed upon name.
    * You will need: 
        * short-name
        * Description
        * Content schema (schema.org) (data model)
        * Design 
        * Feature list (rendering & editor workflow)
        * Content design interface notes  

* Set up the new block
* Register new child GB plugin `includes/class-ca-design-system.php`
* Create `block.js` and `style.css` and `languages` folders.
* Define the inputs
* Output the schema.org data
* Define the output
* QA
* Approval process (TBD)

## Getting Started with Gutenberg Blocks
* WP API
* [Writing your first block type](https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/writing-your-first-block-type/)

### CLI
Note: npx @wordpress/create-block will NOT work with this model as is, because it's designed to generate one-off blocks, and we are creating a library.