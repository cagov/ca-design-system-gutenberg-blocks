/**
 * Menu Cards web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovBreadcrumb extends window.HTMLElement {
  connectedCallback() {
    console.log("breadcrumb loaded");
  }
}

window.customElements.define("cagov-breadcrumb", CAGovBreadcrumb);
