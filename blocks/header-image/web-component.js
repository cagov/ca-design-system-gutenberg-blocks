/**
 * Menu Cards web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovHeaderImage extends window.HTMLElement {
  connectedCallback() {
    console.log("header-image loaded");
  }
}

window.customElements.define("cagov-header-image", CAGovHeaderImage);
