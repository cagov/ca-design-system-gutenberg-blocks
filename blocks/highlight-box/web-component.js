/**
 * Menu Cards web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovHighlightBox extends window.HTMLElement {
  connectedCallback() {
    console.log("highlight-box loaded");
  }
}

window.customElements.define("cagov-highlight-box", CAGovHighlightBox);
