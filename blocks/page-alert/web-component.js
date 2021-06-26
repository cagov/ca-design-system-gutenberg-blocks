/**
 * Standard Alert web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovStandardAlert extends window.HTMLElement {
  connectedCallback() {
    // console.log("standard-alert loaded");
  }
}

window.customElements.define("cagov-standard-alert", CAGovStandardAlert);
