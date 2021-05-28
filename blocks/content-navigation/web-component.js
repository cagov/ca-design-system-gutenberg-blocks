/**
 * Content Navigation web component
 * Supported endpoints: Wordpress v2
 * Wordpress Dependencies: window.wp.moment.
 */
 class CAGovContentNavigation extends window.HTMLElement {
    connectedCallback() {
      this.type = "wordpress";
      if (this.type === "wordpress") {
        this.buildNavigation();
      }
    }
  
    buildNavigation() {
      
    }
  
    template(data, type) {
      if (data !== undefined && data !== null) {
        if (type === "wordpress") {
          return ``;
        }
      }
      return null;
    }
  
    renderNoContent() {
      this.innerHTML = "";
    }
  }
  
  window.customElements.define("cagov-content-navigation", CAGovContentNavigation);
  