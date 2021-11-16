# cagov-design-system-headless-wordpress

QUESTION:
* Can we switch OFF the injected design system build code & go to a managed option (requires a more agile WP update flow, which we don't have except for the drought site)

@TODO
- Include note about running monolith AND headless

- These notes:
# Gutenberg Blocks for the California Design System from ca.gov
### Add a new block or pattern
* Blocks should be created one per design system component. 
* New blocks NOT in design system can use `_proposed/design-system-proposals/plugin.php`
* Patterns are more extensive and could become their own separate plugin. 
* Patterns include Gutenberg Patterns as well as content types, REST API integration for headless rendering. 
* To develop ES6 UI interfaces, register the block.js file and run `npm run build` to compile before release.

## Build mode (confusing, @TODO make it not confusing)
- npm install @wordpress/scripts --save-dev, https://www.npmjs.com/package/@wordpress/scripts
- npm run build - update packages

Q: where is the code loaded & can we stop using the WP theme JS function 


---
## OLD README CONTENT

Headless WordPress editor integrations for the California Design System.

* California Design System support
    * This plugin will implement design system packages that are in the 1.1.* and higher range.
* User-researched content patterns with structured data, OG and SEO support
* Agency support
* Statewide support
* Content design and services
* Gutenberg Blocks
* REST API integration
* Publishing features
* Integrated search, translation and public feedback services.
* Insights platform
* Active community

## [Docs]()
* Content guide
* Design 
* Styles
    * Colors
    * Typography
    * Variables
* Organization
* Blocks
* Patterns
* Content schemas

### Dependencies
@TODO `composer.json`

#### OG content
* Autodescription
* How to configure for best results in API
Notes on configuration

#### Menus
* Menu settings (Core WordPress)
* Nested menus
* "Content Admin" Editor role required to manage menus
* `wp-rest-api-v2-menus`
Notes on configuration

#### Media
* `wp-media-categories`
* `wp-media-category-management`
* `wp-media-library-categories`
* `enable-media-replace`
Future:
- Media API publishing
Notes on configuration

#### Security
* `wp-security-audit-log`
* `disable-comments`
* Password handling
* Authentication limits
* Other security features as necessary.
Notes on configuration

#### Content management
* `codepress-admin-columns`

#### Headless 
##### REST Api
`post-tags-and-categories-for-pages`

##### Preview
* Headless preview button integration

#### Redirects
* Redirection

#### Trigger events
* `notifications`

## How to use the plugin

* Install in WordPress
* Configure a new site
* [Guide for content editors]()

### Requirements
* Tested for WordPress 5.8

### Processes
* Connect services: Insight, Feedback, Search, Translations

### Hosting
* AWS S3

## Connect
* 9/22/2021 - This project is in use for the Department of Cannabis Control website and Drought.
* [Issue board](https://github.com/orgs/cagov/projects/11)
* To suggest a new Gutenberg block addition to this plugin: [please submit a new issue.]()
* More information [design system](https://github.com/cagov/design-system) github repo.

