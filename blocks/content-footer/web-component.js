/**
 * Menu Cards web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovContentFooter extends window.HTMLElement {
  connectedCallback() {
    console.log("content-footer loaded");
  }
}

window.customElements.define("cagov-content-footer", CAGovContentFooter);
