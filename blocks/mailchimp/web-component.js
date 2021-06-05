/**
 * Menu Cards web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovMailchimp extends window.HTMLElement {
  connectedCallback() {
    console.log("mailchimp loaded");
  }
}

window.customElements.define("cagov-mailchimp", CAGovMailchimp);
