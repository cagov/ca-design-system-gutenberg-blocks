# DEPRECATED
This is project is no longer supported. Use at your own risk.

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

## Content design and using Gutenberg Blocks

- Review guidance for content editors
    - Please also check the [principles](https://designsystem.webstandards.ca.gov/principles/) and [content principles](https://designsystem.webstandards.ca.gov/style/content/) of the design system for more information on improving content for State of California website users.
- The Office of Data and Innovation has drafted content guidance for content editors on our systems. 
    - If needed please [reach out](https://designsystem.webstandards.ca.gov/contact-us/) to the Design System team until we are able to publish the full version for any site using these Gutenberg Blocks.


## Dependencies
- Requires WordPress 5.9 or later. (Testing for WordPress 6.0 for 1.1.8).
- Requires core Gutenberg feature to be enabled and not blocked.


## Compatible WordPress themes
- Compatible themes that implement the CA Design System
    - [CAWeb theme](https://github.com/CA-CODE-Works/CAWeb) Version (1.6.2) - For production sites (Requires Divi, a third party plugin, not free.)
    - DEVELOPMENT: [Design System WordPress theme](https://github.com/cagov/design-system-wordpress-theme) - *In development* Intended for decoupled WordPress instances only. Note that the editor layout doesn't have visual parity with production because WordPress is only used as a CMS backend with the REST API endpoint, and all previews take place in build code on GitHub.
   - A performant, monolithic + headless compatible theme is being discussed, but requires that the Design System matures a little more before this would be something that could be adopted and developed for broader use.

## Using with CAWeb theme
- We are aligning with the [CAWeb](https://github.com/CA-CODE-Works/CAWeb) State Template theme.
- This is the same codebase that will be used in the CAWeb theme in the future.
- CDT is working on a gulp bundler. ODI will sync that format with this plugin for 2.0.0 release (requires refactoring some in-production block features.)


## Using with self-hosted WordPress
- The Office of Data and Innovation maintains several Pantheon instances that seamlessly and securely run our Content Management System (CMS). The cost is generally low, and we have been able to procure it for our own use. However, we are creating "headless", "decoupled" sites, which differ from traditional monolithic use of WordPress. We hope to share more information about this system in the future. 

