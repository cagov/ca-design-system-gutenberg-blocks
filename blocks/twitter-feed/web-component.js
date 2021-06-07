/**
 * Twitter Feed web component
 * Supported endpoints: Wordpress v2
 * Wordpress Dependencies: window.wp.moment.
 */
 class CAGovTwitterFeed extends window.HTMLElement {
    connectedCallback() {
      console.log("twitter feed loaded");
    }
  }
  
  window.customElements.define("cagov-twitter-feed", CAGovTwitterFeed);
  