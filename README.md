# ca-design-system-gutenberg-blocks
Gutenberg blocks to be used in WordPress that are compatible with the California's design system

This folder contains: 

* Wordpress plugin that registers Gutenberg blocks.
* Preliminary design system web components or references to externally hosted web components.


 ## Approach
We are taking a user-centered design approach with the development of user-facing pages.

Because of this, we require fully flexible page layouts, without additional WordPress integrations, and should not be hardening features to hook into the CAWeb Theme yet.

 * Any content that is visible to users between the CA Web Header and Footer elements needs to remain very lightweight, easy to change, requiring minimal adherance to Wordpress coding conventions. We will accomplish this with custom templates that content editors will be instructed to use. 
 * None of the content features should be pulled into the CA Web Theme until design choices are given the chance of more user testing and study and agreed upon as a group.
 * Similarly, we are working towards an improved editorial experience that focuses on content design. Because of this, none of the editorial interactions and conventions of WordPress should be assumed to be optimal in the UI.
 
 ## Engineering notes on Wordpress integration
 * While we are reserving changes for UI/UX, we will still store data and settings in ways that are lined up with core Wordpress features.
 * Where possible, when user content is stored, it will be stored using core Wordpress standards. For example, a content editor might see a more designed, interactive editor interface to set up a page. We might use the Gutenberg blocks API features to trigger updates to metaboxes and custom variables, or pull data from metaboxes, but the content editor might not need to think about metaboxes at all.
 * For Gutenberg Blocks, we are using dynamic blocks that store JSON attributes and allows for rapid UX iteration of our block in response to active user research, feedback and testing. 
 * NOTE: We still have some blocks that use a semantic markup approach, and will develop standard migration paths for those should our UI change. For our user-centered design approach, this allows us to deeply and quickly alter the user and editor experiences in response to user research, testing and feedback.
 
 ## Why is this a plugin and not a theme?
 * For development purposes and rapid iteration in support of our user-centered design approach, our plugin includes design choices as well as features such as gutenberg blocks. The blocks themselves are designed with layouts in mind, but do not yet belong in a the primary theme. 
 * The CA Web theme is composed of a primary theme (Divi) and a child theme (CAWeb.) Wordpress does not allow child themes of child themes, so we are required to use a plugin for development since the theme is only being used for implementation of the State Template (header and footer).
 * Technically design layouts belong in a theme. However, since we are required to use a different theme, we are storing our theme overrides in the cleanest way possible so that our code can be migrated to a theme at a later date. 
 * This plugin is designed and intended to support an iterative design process, and allow selected features to migrate to other places in an agreed upon way.



