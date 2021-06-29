
## Page CSS

 This style inherits from updates to the CA State Template (an HTML based style template.)
 https://github.com/Office-of-Digital-Innovation/California-State-Template/blob/cannabis/source/scss/cagov/type.scss

 The css variables and properties are set in a custom theme css file and added to WordPress (with CAWeb theme installed under CA Web Options Custom CSS, as a file and a manual override. 
 Currently in: https://github.com/cagov/cannabis.ca.gov/tree/main/src/css
 * colorscheme-cannabis.v1.0.7.min.css (or latest increment) - sets css variables and main page typography.
 * manual-caweb.v1.0.1.css

 The manual override contains style overrides for the Site Header and Footer elements.
 This file applies global layout styles for the page container, main content region.

 Additionally Custom Gutenberg blocks may have additional styles.
 Any imported Web components may also be bundled with their CSS.

Editor styles: in editor.css. 
Typography and styles are re-implemented for the editor. Editor css needs to target specific block editor classes.

## Sidebar

* Based on EveryLayout sidebar: https://every-layout.dev/layouts/sidebar/. 
Intention: We are keeping a clean and clear page-container so that we can do more css for design prototypes without requiring full integration with Wordpress Theme until user testing and research has concluding and layouts and templates are finalized.
We are interested to use more of these kinds of layouts. 
Talk to Koji for more information.
See also: https://shop.smashingmagazine.com/products/inclusive-design-patterns

* Integration with CAWeb theme. For any main page elements that need to also render in the default template, the suffix is -default for layouts in the main theme, and -ds for layouts that are tied to templates provided by the design system WP code.
