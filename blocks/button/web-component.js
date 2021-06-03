/**
 * Menu Cards web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovButton extends window.HTMLElement {
  connectedCallback() {
    console.log("button loaded");
  }
}

window.customElements.define("cagov-button", CAGovButton);
