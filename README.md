# CA.gov Design System Gutenberg Blocks

- Version 1.1.7
- For WordPress 5.9 or later
- Tested on Pantheon, Flywheel, [WPVIP - not yet]
`@cagov/ca-design-system-gutenberg-blocks`

## What this plugin does
Integrates the State of [California Design System](https://designsystem.webstandards.ca.gov) into the WordPress Gutenberg editor.

The [CA.gov](http://CA.gov) design system defines “Content Components”. 
This can be structured markup with CSS and custom elements, or interactive web components.

[Gutenberg](https://wordpress.org/gutenberg/) is an open-source editor that is included in core WordPress, version 5.0 and later. 
This editor tool allows content editors to use pre-defined markup blocks in content. 


## How to use this plugin

- Install and enable this plugin
- This will create a WordPress Block library that is available in the Gutenberg Editor UI.
- Keep the plugin up-to-date for important security and design updates.
- Check our CHANGELOG for notifications of major updates for database updates to keep content in sync with design system changes.

* DEPRECATING: Version 2.0.0 will split out into pattern with multiple packages https://github.com/cagov/design-system-wordpress-gutenberg. Check back on https://designsystem.webstandards.ca. gov/ for technical information later in 2022. At that point, we will rename this plugin. Version 1.1.9 we will start the transition.

## Content design and using Gutenberg Blocks

- Review guidance for content editors
    - Please also check the [principles](https://designsystem.webstandards.ca.gov/principles/) and [content principles](https://designsystem.webstandards.ca.gov/style/content/) of the design system for more information on improving content for State of California website users.
- The Office of Data and Innovation has drafted content guidance for content editors on our systems. 
    - If needed please [reach out](https://designsystem.webstandards.ca.gov/contact-us/) to the Design System team until we are able to publish the full version for any site using these Gutenberg Blocks.

## Dependencies
- Requires WordPress 5.9 or later. (Testing for WordPress 6.0).
- Requires core Gutenberg feature to be enabled and not blocked.

## Maintenance
- Since the Design System is in continuous development, components are continuously improved.
- All components are versioned, this means you can coordinate your update on your own schedule and test your update to make sure that everything is working well.
- Check the [maintenance](./MAINTENANCE.md) docs on how to perform an update.

## Compatible WordPress themes
- Compatible themes that implement the CA Design System
    - [CAWeb theme](https://github.com/CA-CODE-Works/CAWeb) Version (1.6.3a) - For production sites
    - [Design System WordPress theme](https://github.com/cagov/design-system-wordpress-theme) - In development, for decoupled WordPress instances only. Editor layout doesn't have visual parity with entire Design System yet.

## Using with CAWeb theme
- We are aligning with the [CAWeb](https://github.com/CA-CODE-Works/CAWeb) State Template theme.
- This is the same codebase that will be used in the CAWeb theme in the future.

## Design System Status Update
- The State Template is still being converted to the Design System, and this work will continue throughout 2022. A WordPress theme will be available eventually. Watch this repo for updates, we will try to do our best to notify you. 
- The best way to stay up to date is to join the Digital Web Services Network. This quarterly meeting is open to all State employees and topics on the Design System are presented there. 
- Documentation is one of our top priorities, and many deep plans are underway as we transition to the Design System.

## Using with self-hosted WordPress
- The Office of Data and Innovation maintains several Pantheon instances that seamlessly and securely run our Content Management System (CMS). The cost is generally low, and we have been able to procure it for our own use. 
- Multiple departments are currently prototyping aspects of the Design System and coordinating
- ODI works with CDT and control agencies to make sure that we are following security best practices.
- If you self-host a WordPress site and are poking around looking for guidance, please fill in this form ____. We would like to be sure to include you as the theme develops.
- Here is a spec of the ideal WordPress theme and the plan for the CAWeb theme coming from CAWeb Publishing____.


## Contributions
Thank you for contributing to the CA Design System. 

Your help is important and will help us deliver services to Californians while maintaining our committments to accessibility, performance and equity. 

This plugin is the official and validated set of block plugins for the core California Design System.

**To contribute**
* Please submit a pull request to this repository and the Design System team will review it.


## Custom Gutenberg blocks
We understand that you may want to extend your WordPress site with additional Gutenberg Blocks.

An example of extending a custom site will be found at: https://github.com/cagov/cannabis-ca-gov-wordpress















# CA Design System Gutenberg Blocks
Initial exploratory Gutenberg block integration. 
Includes extra code for static site generation support ("headless") and support for CA Design System pilot.

- Spring/Summer 2022: Splitting this plugin into separate plugin packages for different hosting environments.
- Fall 2022: Switching over to new structure

*Gutenberg Blocks* - This GitHub repository will be archived and updated project code will be moving to 
https://github.com/cagov/design-system-wordpress-gutenberg

*Static site support* - The ODI Headless support plugin is proposed to live at: https://github.com/cagov/design-system-wordpress-11ty

*WordPress Theme* - Divi-less, performant WordPress theme is proposed to live at: https://github.com/cagov/design-system-wordpress-theme
* Code for theme page layout will move to this WordPress Theme

*Content Patterns* - Considering moving to own repos on case-by-case basis.
