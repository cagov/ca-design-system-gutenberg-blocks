# Notes on templates

(Based on work ODI is doing with the Department of Cannabis Control and the CA Department of Technology.)

Since these templates are going to be reused by multiple systems, let's
- Spell out the differences between templates and why they exist
- Require that content editors use our templates for new content (not defaults)

## CSS
- CSS for header, footer come from CAWeb theme and custom CSS overrides
- CSS for headers and basic typography comes from CAWeb theme
- CSS for content block globals, relative spacing comes from the plugin and needs to be included with page templates
- CSS for editor is re-implemented for Wordpress since each block is reset at the very end of the WP page load & inheritance is  broken by Wordpress. We are forced to fix some typography with !important tags (which is not recommended). 

## /includes/templates
Templates that content editors see.
* Ideally we let them choose a template for a kind of content and that's all they need to do. No configurations, options, category selection.
* Content editors are guided to use templates for certain kinds of pages. The settings and differences in design and layout are embedded in those templates.

* Ideally only Post and Page templates will be visible to editors, but we also have not optimized their workflow at all because they are just getting started.
* It would be nice to give them a landing page that kicks them off to create a new page or post of a particular type.
* Since we are not allowed to set the default, but we also do not want to use the default templates yet, we need another way to onboard content editors. Choosing "Posts" and "Pages" might also not be great UI and we can think about an alternative interface to the design system templates. It will be confusing to train (even if it's a core behavior of Wordpress.) We will still use the core behaviors of WordPress but can try to find some alternative methods of doing the same thing that don't require extra steps.

## /includes/templates/plugin

## /includes/templates/design-system-templates

- Template short names will be available in the WP api in {design_system_fields: {template: "page"}}
- Phase 1: 
    - breadcrumbs, socialmedia and content menu will be provided by the API as markup. 
        - Webcomponents that use the menu API need to be written for both.
    - There will be some schema.org data based on custom field data from custom patterns that will be available to the API but will need alignment with design system.
- WP API "template" field is system specific (and may change to not be an absolute path)
- Page layouts would live on design system website and ingest data from WP API
- They would be imported via npm & data would feed into them.
- They would have dependencies of headers and footers
- Any blocks and feature dependencies need to be specified, possibly in a package.json for each GB 
    - e.g. dashicons CSS vs. cagov icons


- Container started out as a clone of the CAWeb theme, with the idea that we would not be injecting any class variables or accommodating too many options until it's clear what hooks and dependencies are required by the CA Web theme.
- Dependencies (CSS & JS) are: #page-container, #main-container
- JS: back to top connects to #main-container
- CAWeb creates a sidebar, but we are considering alternative layout methods that minimize configuration for content editors, but our idea is that the default template let the settings be set. We might be able to create some patterns/templates with just settings properties via JS when a pattern is selected. 
- We are keeping templates as simple markup through our user testing period and then deciding as a group what features make sense.
- Based on the initial content framing, we have templates for the kinds of content our partners/designers wanted, based on how they think about the content. While the templates all look the same now, they are spelled out as "different" because they are all likely to change, likely to diverge after user and editor feedback and testing.
- These templates are meant to move eventually to the design system, but are being hard-coded for now.