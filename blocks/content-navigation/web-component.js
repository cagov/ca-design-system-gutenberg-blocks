/**
 * Content Navigation web component
 * Supported endpoints: Wordpress v2
 * Wordpress Dependencies: window.wp.moment.
 */
class CAGovContentNavigation extends window.HTMLElement {
  // @TODO make sure WP could return a static version of this. (should be possible with our system)
  connectedCallback() {
    console.log("content nav loading");
    this.type = "wordpress";
    if (this.type === "wordpress") {
      document.addEventListener("DOMContentLoaded", () =>
        this.buildNavigation()
      );
    }
  }

  buildNavigation() {
    // Parse header tags
    let markup = this.getHeaderTags();
    this.template({ content: markup }, "wordpress");
  }

  template(data, type) {
    if (data !== undefined && data !== null) {
      if (type === "wordpress") {
        // Rough sketch:
        this.innerHTML = "ON THIS PAGE" + data.content;
      }
    }
    return null;
  }

  renderNoContent() {
    this.innerHTML = "";
  }

  getHeaderTags() {
    console.log("GETTING HEADER TAGS", this.dataset);
    let selector = "#main-content";
    // let selector = this.dataset.selector;
    let editor = this.dataset.editor;
    // let display = this.dataset.display;
    let display = "render";
    let callback = this.dataset.callback; // Editor only right now
    var h = ["h2", "h3", "h4", "h5", "h6"];
    var headings = [];
    for (var i = 0; i < h.length; i++) {
      //   console.log(`${selector}`);
      // Pull out the header tags, in order & render as links with anchor tags
      // auto convert h tags with tag names
      if (selector !== undefined && selector !== null) {
        // data-selector="#main-content" data-editor="textarea.block-editor-plain-text" data-callback="(content) => unescape(content)" data-js-flip="true"

        if (display === "render") {
          // console.log("selector", document, selector);
          let selectorContent = document.querySelector(selector);
          console.log("render content", selectorContent);
          if (selectorContent !== null) {
            let selectedInnerHTML = selectorContent.innerHTML;
            // let headerElements = selectorContent.getElementsByTagName(h[i]);
            let outline = this.outliner(selectedInnerHTML, [selector]);

            console.log("outline", outline);
            // console.log("headerElements", headerElements);
            // if (headerElements !== null && headerElements.length > 0) {
            //     let elements = headerElements.each(el => headings.push(el.textContent));
            //     // @TODO add anchor
            //     return JSON.stringify(elements);
            // }
          }
        }
      } else if (display === "editor") {
        let editorContent = window.document.querySelector(`${editor}`);
        let editorInnerHTML = selectorContent.innerHTML;
        if (callback !== undefined && callback !== null) {
          editorInnerHTML = callback(editorInnerHTML);
        }

        let headerElements = editorContent.getElementsByTagName(h[i]);
        console.log("headerElements", headerElements);

        if (headings[i]) {
          console.log("HEADING", headerElements.textContent);
        }
      } else {
        console.log(h[i] + "doesn't exist");
        return `Doesn't exist`;
      }
    }
    return "may have headings";
  }

  // Based on https://github.com/DylanFM/outliner
  outliner(content, sectioningElements) {
    var headingContent = ["h1", "h2", "h3", "h4", "h5", "h6", "hgroup"];
      
    const isSectioningElement = (el) => {
      return sectioningElements.indexOf(el.tagName) > -1;
    }

    const isDiv = (el) => {
      return el.tagName === "div";
    }

    const isHeadingContentElement = (el) => {
      return headingContent.indexOf(el.tagName) > -1;
    }

    const topInHgroup = (hgroup) => {
      var top;
      // Find the highest heading element within and use its text
      try {
        headingContent.forEach(function (t) {
          var els = hgroup.getElementsByTagName(t);
          if (els.length) {
            top = els[0];
            // Escape from the loop - we've found our content
            throw BreakException;
          }
        });
      } catch (e) {}
      return top;
    }

    const makeOutline = (outlinee, parent) => {

        console.log("outlinee", outlinee);

      var section,
        currentOutlinee,
        heading,
        children,
        sections,
        headingOutline,
        lastSection;

      section = {
        outlinee: outlinee,
        outline: [],
        heading: isHeadingContentElement(outlinee) ? outlinee : undefined, // If we've passed a heading in we're going to set it automatically
      };

      console.log("section", section);

      // Usually we'll walk through children, but that's going to be different if we're making a HTML4-style outline for a heading
      currentOutlinee = isHeadingContentElement(outlinee)
        ? outlinee.nextSibling
        : outlinee.firstChild;

      // Walk
      while (currentOutlinee) {
        // Make sure we're dealing with element nodes
        if (currentOutlinee.nodeType === 1) {
          // If this element is heading content we want it
          if (
            isHeadingContentElement(currentOutlinee) &&
            !currentOutlinee.OLtouched
          ) {
            // SPEC: If the current section has no heading, let the element being entered be the heading for the current section.
            // If we have an hgroup, find its top heading, otherwise just add the heading
            if (
              !section.heading &&
              (heading =
                currentOutlinee.tagName.length > 2
                  ? topInHgroup(currentOutlinee)
                  : currentOutlinee)
            ) {
              // Make sure this heading has content
              if (heading.textContent.length) {
                // Track its content
                section.outline.push(heading.textContent);

                // Track the heading for HTML4-style stuff
                section.heading = heading;
              }

              // SPEC: Otherwise, if the element being entered has a rank equal to or greater than the heading of the last section of the outline of the current outlinee,
              //       then create a new section and append it to the outline of the current outlinee element, so that this new section is the new last section of that outline.
              //       Let current section be that new section. Let the element being entered be the new heading for the current section.
            } else {
              // Make an outline for the heading
              headingOutline = makeOutline(currentOutlinee, section);
              headingOutline.unshift(currentOutlinee.textContent);

              // If it's a heading of higher or equal ranking
              if (currentOutlinee.tagName <= section.heading.tagName) {
                if (parent) {
                  sections = parent.outline.filter(Array.isArray);
                  lastSection = sections[sections.length - 1];

                  if (lastSection && lastSection.outline) {
                    lastSection.outline.push(headingOutline);
                  }
                } else {
                  section.outline.push(headingOutline);
                }

                // SPEC: Otherwise, run these substeps:
                //       Let candidate section be current section.
                //       If the element being entered has a rank lower than the rank of the heading of the candidate section, then create a new section, and append it to candidate section.
                //       (This does not change which section is the last section in the outline.) Let current section be this new section. Let the element being entered be the new heading
                //       for the current section. Abort these substeps.
                //       Let new candidate section be the section that contains candidate section in the outline of current outlinee.
                //       Let candidate section be new candidate section.
                //       Return to step 2.
                //       Push the element being entered onto the stack. (This causes the algorithm to skip any descendants of the element.)
              } else {
                currentOutlinee.OLtouched = true;
                section.outline.push(headingOutline);
                // Doing this instead kinda makes the #test8 test look more correct to me
                // section.outline.push([currentOutlinee.textContent]);
              }
            }
          } else if (
            isSectioningElement(currentOutlinee) ||
            isDiv(currentOutlinee)
          ) {
            // Make an outline for the element
            children = makeOutline(currentOutlinee, section);

            if (children && children.length) {
              // If this is a div, it can still contain content
              if (isDiv(currentOutlinee)) {
                // Don't add a new section, but append it to the current section
                section.outline = section.outline.concat(children);

                // If it's a sectioning element
              } else {
                // Create a section in the outline
                section.outline.push(children);
              }
            }
          }
        }

        // Move on to the next sibling
        currentOutlinee = currentOutlinee.nextSibling;
      }

      // If we're not at the root and there are no headings
      if (parent && !isDiv(outlinee) && !section.heading) {
        // Give it a generated heading
        section.outline.unshift("Untitled " + outlinee.tagName.toLowerCase());
      }
      console.log("section", section);
      return section.outline;
    }

    var outline = makeOutline(content);
    return outline;
  }
}

window.customElements.define(
  "cagov-content-navigation",
  CAGovContentNavigation
);
