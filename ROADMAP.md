## Roadmap
Planned changes to this plugin

- When complete, summarize changes and move them to CHANGELOG when rolling up a new release.
- Include issue or issue board if available.

## 2.0.1
- Address style changes from components with no base-css code
- Address issues resulting from updating Design System tokens
- Update colors with new accessibile color system

## 2.0.0
- Establish a shared issue board for this project
- Stop using columns, even turn them off completely - too confusing for editors & it doesn't reinforce our grid
- Split cagov-development-headless-wordpress into separate plugin that agencies could fork for custom gutenberg block work.
- Add notifications as settings in separate plugin
- Split autodescription, publishing and redirection code into own plugins once the features are complete
- Splits patterns into own plugins hosted on github
- Move blocks to new format that will be used in State Template
- Rename the plugin https://github.com/cagov/design-system-wordpress-gutenberg

## 1.1.9
* "Feature editor" role
* Include "staging" feature, visually showing which instance is not production

## 1.1.8
- Create a composer.json file for all the design system install profile plugins
- Update design system packages
- Update notes on "DEVELOPMENT.md" and include a link to the wiki
- Update styles to use evolved typography
- Split WP code out in design system and figure out a communication pattern on how to show changes
- Stop using columns, even turn them off completely - too confusing for editors & it doesn't reinforce our grid
- Media Alt support all GB blocks, requires spec coming from Design system
- Update any new component names
- Apply same template hiding filter used for pantheon template handler to CAweb template handlers
- Page feedback is hard coded in this plugin & that seems unscalble
- Delete category-template (or disable the category rendering?)
