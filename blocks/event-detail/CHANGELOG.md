# CHANGELOG

## 1.0.18
Phase 1
* Get event data and monolithic rendering to match Figma design.
* Use DateTime picker from WordPress core Block UI component library.
* Make event data availabel to WordPress API.
* Migrate custom fields into this plugin so block specific data fields can be made available to custom field data set

Project board: https://github.com/cagov/design-system/projects/3

Next steps:
* Make custom block datetime field sortable in the WordPress API
* Consider:
    * double-saving block data to custom fields
    * copy data into post meta on save
    * carbon field integration
    * checking field availablity requirements for GraphQL
* Address field data structure
* Reenable schema.org data
* Move event excerpt handling to an event content type
* Make it easier to change the content type (WordPress default is too labor intensive and buggy)
* Ideal workflow would be : "Add new event" & that's it.
    * A content type with event schema
    * Set category
    * Set rendering template
    * Connect event type and list content response for formatted teasers
* Compare markup output to original CDT event api spec and make new markup recommendation for design system
     * update plugin renderer to match.
* Sync CSS with design system CSS