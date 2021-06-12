/**
 * Menu Cards web component
 * Supported endpoints: Wordpress v2
 */
 class CAGovBreadcrumb extends window.HTMLElement {
  connectedCallback() {
    let type = "wordpress"
    let endpoint = window.location.origin;
    let navigationMenu = "header-menu";
    let linkToPage = false; // @TODO Change to link to page if needed
    if (type === "wordpress") {
      let menuApiPath = `${endpoint}/wp-json/menus/v1/menus/header-menu`; // Default can refactor to data from data attributes.
      // Fetch
      // items.url === window.location.href
        // title
        // link on off
      // if has child items (@TODO Recursive, currently dropdown is one level)

      // If not found in menu, look up in category (@TODO Separate functions)


    }
    console.log("breadcrumb loaded");
  }
}

window.customElements.define("cagov-breadcrumb", CAGovBreadcrumb);
