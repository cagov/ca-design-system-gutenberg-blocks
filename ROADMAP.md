## Roadmap
Planned changes to this plugin

When complete, summarize changes and move them to CHANGELOG when rolling up a new release.
Include issue board if available.

## 1.1.13+
* Update the README based on the template (README_DRAFT.md has some information).
* Create a composer.json file for all the design system install profile plugins
* Update design system packages
* Update notes on "DEVELOPMENT.md" and include a link to the wiki
* Update styles to use evolved typography
* Split WP code out in design system and figure out a communication pattern on how to show changes
* Stop using columns, even turn them off completely - too confusing for editors & it doesn't reinforce our grid
* Media Alt support all GB blocks, requires spec coming from Design system
* Update any new component names
* Apply same template hiding filter used for pantheon template handler to CAweb template handlers
* Page feedback is hard coded in this plugin & that seems unscalble
* Delete category-template (or disable the category rendering?)
## Far future changes
* Split cagov-development-headless-wordpress into separate plugin that agencies could fork for custom gutenberg block work.
* Split autodescription, publishign and redirection code into own plugins once the features are complete
* Split patterns into own plugins hosted on github
* Start to work on _proposed plugin connectors for making it easier to configure many instances of this version of WordPress (for the design system + more user research flexibility.)
* Have a sprint that is just WordPress code standards
* Decide on simple unit tests that could help developers to collaborate in a distributed way
* Rename namespace when project name is solidified and update with a TESTED upgrade migration script
* Add example of migration handling
