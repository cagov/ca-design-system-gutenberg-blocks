// this snippet is inserted into the custom js section of the WordPress CAWeb theme in order to deliver the bundle of client side web components
let newScript = document.createElement("script");
newScript.type="module";
newScript.src = "https://cagov.github.io/cannabis.ca.gov/src/js/index.min.js";
document.querySelector('head').appendChild(newScript);
