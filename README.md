# CA.gov Design System Gutenberg Blocks
- For WordPress 5.9 or later
- Tested on Pantheon, Flywheel
- Github [`@cagov/ca-design-system-gutenberg-blocks`](https://github.com/cagov/ca-design-system-gutenberg-blocks)

## What this plugin does
Integrates the State of [California Design System](https://designsystem.webstandards.ca.gov) into the WordPress Gutenberg editor.

The CA Design System defines “Content Components”. 
Content components are structured markup, with CSS and/or JavaScript as custom elements.

- [Gutenberg](https://wordpress.org/gutenberg/) is an open-source editor that is included in core WordPress, version 5.0 and later. 
- This editor tool allows content editors to use pre-defined markup blocks in content. 
- Supports Office of Data & Innovation headless/static site publishing features.

## How to use this plugin

- Install and enable this plugin
- This will create a WordPress Block library with blocks and patterns that is available in the Gutenberg Editor UI "CA Design System"
- Keep the plugin up-to-date for important security and design updates.
- Check our CHANGELOG for notifications of major upgrades, or to keep content in sync with design system changes.

* DEPRECATION NOTICE: Version 2.0.0 will be a major plugin refactor. Check [ROADMAP](./ROADMAP.md) for more information

## Content design and using Gutenberg Blocks

- Review guidance for content editors
    - Please also check the [principles](https://designsystem.webstandards.ca.gov/principles/) and [content principles](https://designsystem.webstandards.ca.gov/style/content/) of the design system for more information on improving content for State of California website users.
- The Office of Data and Innovation has drafted content guidance for content editors on our systems. 
    - If needed please [reach out](https://designsystem.webstandards.ca.gov/contact-us/) to the Design System team until we are able to publish the full version for any site using these Gutenberg Blocks.

## Dependencies
- Requires WordPress 5.9 or later. (Testing for WordPress 6.0 for 1.1.8).
- Requires core Gutenberg feature to be enabled and not blocked.

## Maintenance
- Since the Design System is in continuous development, components are continuously improved.
- All Design System components are versioned. This means you can coordinate your update on your own schedule and test your update to make sure that everything is working well.
- Check the [maintenance](./MAINTENANCE.md) docs on how to perform a code update.

## Compatible WordPress themes
- Compatible themes that implement the CA Design System
    - [CAWeb theme](https://github.com/CA-CODE-Works/CAWeb) Version (1.6.2) - For production sites (Requires Divi, a third party plugin, not free.)
    - DEVELOPMENT: [Design System WordPress theme](https://github.com/cagov/design-system-wordpress-theme) - *In development* Intended for decoupled WordPress instances only. Note that the editor layout doesn't have visual parity with production because WordPress is only used as a CMS backend with the REST API endpoint, and all previews take place in build code on GitHub.
    A performant, monolithic + headless compatible theme is being discussed, but requires that the Design System matures a little more before this would be something that could be adopted more widely.

## Using with CAWeb theme
- We are aligning with the [CAWeb](https://github.com/CA-CODE-Works/CAWeb) State Template theme.
- This is the same codebase that will be used in the CAWeb theme in the future.

## Design System Status Updates
- The best way to stay up to date is to join the Digital Web Services Network (DWSN). This quarterly meeting is open to all State employees and topics on the Design System are presented there. 
- The State Template is still being converted to the Design System, and this work will continue throughout 2022. Watch this repo for updates, we will try to do our best to notify you until there is public documentation through main channels such as the Design System website or DWSN. 
- Documentation is one of our top priorities, and many deep plans are underway as we transition to the Design System.

## Using with self-hosted WordPress
- The Office of Data and Innovation maintains several Pantheon instances that seamlessly and securely run our Content Management System (CMS). The cost is generally low, and we have been able to procure it for our own use. However, we are creating "headless", "decoupled" sites, which differ from traditional monolithic use of WordPress. We hope to share more information about this system in the future. 
- Multiple departments are currently prototyping aspects of the Design System and coordinating with each other on pilot sites.
- ODI works with CDT and various State control agencies to make sure that we are following security best practices.


## Contributions
Your help is important and will help us deliver services to Californians while maintaining our committments to accessibility, performance and equity. 

**To contribute**
* Please submit a pull request to this repository and the Design System team will review it.
















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
