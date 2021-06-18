/**
 * Menu Cards web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovMenuCards extends window.HTMLElement {
  connectedCallback() {
    console.log("menu-cards loaded");
  }
}

window.customElements.define("cagov-menu-cards", CAGovMenuCards);
