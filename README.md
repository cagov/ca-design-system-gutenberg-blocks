# ca-design-system-gutenberg-blocks
Gutenberg blocks to be used in WordPress that are compatible with the California's design system


 ## Approach
We are taking a user-centered design approach with the development of user-facing pages.

Because of this, we require fully flexible page layouts, without additional WordPress integrations, and should not be hardening features to hook into the CAWeb Theme yet.

 * Any content that is visible to users between the CA Web Header and Footer elements needs to remain very lightweight, easy to change, requiring minimal adherance to Wordpress coding conventions. We will accomplish this with custom templates that content editors will be instructed to use. 
 * None of the content features should be pulled into the CA Web Theme until design choices are given the chance of more user testing and study and agreed upon as a group, and 
 * Similarly, we are working towards an improved editorial experience that focuses on content design. Because of this, none of the editorial interactions and conventions of WordPress should be assumed to be optimal.
 
 ## Engineering notes
 * Where possible, when user content is stored, it will be stored using core Wordpress standards. For example, a content editor might see a more designed, interactive editor interface to set up a page. We might use the Gutenberg blocks API features to trigger updates to metaboxes, or pull data from metaboxes, but the editor might not need to think about metaboxes. 
 * For maintenance, the data of the site will mostly be stored as metabox options or as JSON attributes for dynamic Gutenberg blocks. We still have some blocks that use a semantic markup approach, and will be developing migration paths for those should our UI change. The JSON data storage approach is favored for maintainability. For our user-centered design approach, this allows us to deeply alter the user and editor experiences in response to user research, testing and feedback.
 * 
 * Why is this a plugin and not a theme?
 * For development purposes and rapid iteration in support of our user-centered design approach, our plugin includes design choices as well as features such as gutenberg blocks. The blocks themselves are designed with layouts in mind, but do not yet belong in a the primary theme. The CA Web theme is composed of a primary theme (Divi) and a child theme (CAWeb.) Wordpress does not allow child themes of child themes, so we are required to use a plugin for development since the theme is only being used for implementation of the State Template (header and footer).
 * Technically design choices belong in a theme, so we are developing code that belongs in a theme split out so that it can easily be ported into a theme when that time comes.


This folder contains: 

* Wordpress plugin that registers Gutenberg blocks.
* Preliminary design system web components or references to externally hosted web components.

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