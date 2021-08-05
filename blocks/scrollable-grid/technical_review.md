# Technical Review

A component proposal for the design system needs a technical review.

## Development Review Checklist

- [ ] Features
- [ ] Data structure
- [ ] Format
- [ ] Accessibility
- [ ] Performance
- [ ] Testing plan
- [ ] Translations checklist
- [ ] Decoupled architecture checklist

### Features
*Critical features to support initially.*

The data and variations of assets for the campaign toolkit are our reference point for this component. The volume of assets will grow in Wordpress over time, and also this component needs to be able to pull from a variety of sources.

We plan to build this component in a couple of phases (or "layers".)
- A campaign toolkit shares different social media and video assets used to promote a campaign.
- For initial launch, supporting manual entry. No special data sources required. HTML links to media assets will be manual and a little cumbersome.
- The second version will construct markdown based on a structured spreadsheet. This will help to organize and manage media imports, or just keep track of assets, many of which have similar names.
- The third layer involves working with API data. We are prototyping this with structured CSV data, and exploring ways of tagging assets from the default WordPress media library 
- We will also suggest a plugin for improving the media library interface, specifically supplying folders for media asset management, as the library grows over time and the default wordpress interface is difficult to search. The latest version of WordPress includes updates to the Media Library, we will also review this to see if there are any relevant features.
- We will add a scrolling interface. For naming, the scrolling is likely to always be horizontal, so planning to call this `scrollable-grid`. Looking at something like Glider, but will do a little more research for any other alternatives. https://nickpiscitelli.github.io/Glider.js/
- Scroll interface has pagination and swiping. Since we are building web components that are very lightweight, we will also want to find a light but solid interaction library for scroll swiping. 

### Data structure
*If this component maps to an existing schema.org microdata format, please include. If it doesnt, that's ok. We will look it up and provide a data structure. We use schema.org for SEO and data management and round-trip data migration to help keep the component upgradable.*


This is the data structure from the CSV file we are using in Airtable to build sample data for development:

#### Toolkit
* Title
* Campaign - Name of campaign (tag)
* Category - For pulling tagged data from Media library. Need to see what kind of taxonomies will make sense for what we are doing here.
* Description
* Image
* Assets (links to asset records) - Need to research what we can do within the limitation of WordPress
* Accessibility text
* Order

#### Asset
* asset_id
* Title
* Asset Type (taxonomy)
* Asset URL
* Asset File
* Order

- Removed "Asset Embed Code", we will lean on the embed code coming from content hosts and provide screengrabs as needed.


### Format
* Include or reference the expected HTML markup and CSS output (if known)*

```
<cagov-scrollable-grid>
    <div class="cagov-horizontal-grid-card">
        <div class="card-image">
            <img="{attributes.mediaURL}" alt="{attributes.mediaAlt}" />
        </div>
        <div class="card-content">
        <h3>{title}</h3>
        <p class="description>{description}</p>
        <ul class="links">
            <li><a href="/">{assetURL}</a></li>
        </ul>
    </div>
    <div class="cagov-horizontal-grid-card">
        <div class="card-image">
            <img="{attributes.mediaURL}" alt="{attributes.mediaAlt}" />
        </div>
        <div class="card-content">
        <h3>{title}</h3>
        <p class="description>{description}</p>
        <ul class="links">
            <li><a href="/">{assetURL}</a></li>
        </ul>
    </div>
</div>
</cagov-scrollable-grid>
```

### Accessibility
*In our design system, we are creating fully-accessible components, for delivery and for the editor experience. We have a [baseline]() of general accessibility practices we are following. Are there any additional accessibility considerations with this component?* 

* We need to research any ARIA tags that are present in scroll interface.
* Alt content for image needs to be pulled into the interface
* We want to encourage social media accessibility, by encouraging including a description of the asset with the Images, or adding reminders that the video includes captions or transcripts.

### Performance
*We provide a [baseline]() of tests for basic performance. Will this component present additional performance issues, and if so, how can we address them?*

* Responsive image sizes. Same as `promotional-card`, can also be retroactively applied to `hero`/`feature-card`.

### Testing plan
*We provide a [baseline]() of tests for basic component features. Are there additional tests that need to happen for this component?*

### Translations checklist
* With the CSS only layout the markup is easily translated.
* For more complex API generated scrollable grids (using compiled markup from an API), either we need to translate the JSON, an attribute called `data-content` or `data-json`, or store structured data in a way that it can be translated with an API based pipeline and fed into a content generator.

### Decoupled architecture checklist
*The content needs to render in our WordPress editors AND in a headless static site generator. Will it?*

* The "third layer" of building this, using a WordPress API or other API source will need to be described more carefully. Thinking of doing something like a React `<Provider>`, but with an API url & rendering type that can pregenerate the data for the static site. This gets more complex if filtering is needed & should be a separate project.