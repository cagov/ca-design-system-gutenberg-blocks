/**
 * Menu Cards web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovEventDetail extends window.HTMLElement {
  connectedCallback() {
    console.log("event-detail loaded");
  }
}

window.customElements.define("cagov-event-detail", CAGovEventDetail);
