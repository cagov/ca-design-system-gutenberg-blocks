/**
 * Accordion web component
 * Supported endpoints: Wordpress v2
 * Wordpress Dependencies: window.wp.moment.
 */
class CAGovAccordion extends window.HTMLElement {
  connectedCallback() {
    console.log("accordion loaded");
  }
}

window.customElements.define("cagov-accordion", CAGovAccordion);
