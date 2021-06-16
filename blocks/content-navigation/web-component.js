/**
 * Content Navigation web component
 * Supported endpoints: Wordpress v2
 * Wordpress Dependencies: window.wp.moment
 */
class CAGovContentNavigation extends window.HTMLElement {
  connectedCallback() {
    this.type = "wordpress";
    if (this.type === "wordpress") {
      document.addEventListener("DOMContentLoaded", () =>
        this.buildContentNavigation()
      );
    }
  }

  buildContentNavigation() {
    // Parse header tags
    let markup = this.getHeaderTags();
    let label = null;
    if (markup !== null) {
      label = this.dataset.label || "On this page";
    }
    let content = null;
    if (markup !== null) {
      content = `<div class="label">${label}</div> ${markup}`;
    }
    this.template({ content }, "wordpress");
  }

  template(data, type) {
    if (data !== undefined && data !== null && data.content !== null) {
      if (type === "wordpress") {
        this.innerHTML = `${data.content}`;
      }
    }

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener("click", function (e) {
        let hashval = anchor.getAttribute('href');
        let target = document.querySelector(hashval);
        
        // Not working with scroll margin ... weird - @TODO look for conflict with parent themes

        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
            top: 100,
        });

        // let position = target.getBoundingClientRect();
        // console.log("pos", position, position.top + window.scrollY - 128);
        // scrolls to 20px above element
        // window.scrollTo(position.left, position.top + window.scrollY - 128);

        history.pushState(null, null, hashval);
        
        e.preventDefault();
      });
    });

    return null;
  }

  renderNoContent() {
    this.innerHTML = "";
  }

  getHeaderTags() {
    let selector = this.dataset.selector;
    let editor = this.dataset.editor;
    let label = this.dataset.label;
    // let display = this.dataset.display;
    let display = "render";
    let callback = this.dataset.callback; // Editor only right now

    var h = ["h2", "h3", "h4", "h5", "h6"];
    var headings = [];

    for (var i = 0; i < h.length; i++) {
      // Pull out the header tags, in order & render as links with anchor tags
      // auto convert h tags with tag names
      if (selector !== undefined && selector !== null) {
        // Dynamic for editor
        // @TODO update on save like category-label
        // data-selector="#main-content" data-editor="textarea.block-editor-plain-text" data-callback="(content) => unescape(content)" data-js-flip="true"

        if (display === "render") {
          let selectorContent = document.querySelector(selector);
          if (selectorContent !== null) {
            let outline = this.outliner(selectorContent);
            return outline;
          }
        }
      } else if (display === "editor") {
        let editorContent = window.document.querySelector(`${editor}`);
        let editorInnerHTML = selectorContent.innerHTML;
        if (callback !== undefined && callback !== null) {
          editorInnerHTML = callback(editorInnerHTML);
        }

        let outline = this.outliner(editorContent);
        return outline;
      }
    }
    return null;
  }

  outliner(content) {
    let headers = content.querySelectorAll("h2, h3, h4, h5, h6");
    let output = ``;
    if (headers !== undefined && headers !== null && headers.length > 1) {
      headers.forEach((tag) => {
        let tagId = tag.getAttribute("id");
        let title = tag.innerHTML;

        let anchor = tag.innerHTML.toLowerCase().trim().replace(/ /g, "-");

        // If id not set already, create an id to jump to.
        if (tagId !== undefined && tagId !== null) {
          anchor = tagId;
        }

        output += `<li><a href="#${anchor}">${title}</a></li>`;

        if (tagId === undefined || tagId === null) {
          tagId = anchor;
          tag.setAttribute("id", tagId);
        }
      });
      return `<ul>${output}</ul>`;
    }
    return null;
  }
}

window.customElements.define(
  "cagov-content-navigation",
  CAGovContentNavigation
);
