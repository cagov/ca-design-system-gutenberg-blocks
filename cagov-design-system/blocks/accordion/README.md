# Accordion component

An expandable section of content. Can be used on any standard content page. Allows information that is not applicable to the majority of readers to be initially hidden, and opened on demand. Includes accordion label, button, and body content. The label can be a question or a title.

<img src="https://github.com/cagov/storybook-ca-gov/raw/main/packages/%40cagov/accordion/stories/accordion.png" />

## Sample markup

```
<cagov-accordion>
  <div class="cagov-accordion-card">
    <button class="accordion-card-header accordion-alpha" type="button" aria-expanded="false">
      <div class="accordion-title">Lorem ipsum</div>
      <div class="plus-minus">
        <cagov-plus></cagov-plus>
        <cagov-minus></cagov-minus>
      </div>
    </button>
    <div class="accordion-card-container" aria-hidden=" true" style="height: 0px;">
      <div class="card-body">
        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf
          moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
          Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
          shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea
          proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim
          aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
      </div>
    </div>
  </div>
</cagov-accordion>
```

## Docs

Run: ```npm run start``` to preview elements. This will launch local server with links to component demo pages.

The documentation is generated using the <a href="https://github.com/webcomponents/custom-elements-manifest">custom elements manifest schema</a> draft standard <a href="https://github.com/runem/web-component-analyzer">analyzer</a> command. Here is an example run outside the accordion directory:

```
wca analyze accordion --format json --outFile accordion/custom-elements.json
```

Then the <a href="https://github.com/web-padawan/api-viewer-element">api viewer element</a> references the generated custom-elements.json and builds a live preview playground with docs.