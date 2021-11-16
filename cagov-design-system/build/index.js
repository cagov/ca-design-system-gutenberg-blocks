/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./blocks/content-navigation/src/index.js":
/*!************************************************!*\
  !*** ./blocks/content-navigation/src/index.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Content Navigation web component
 *
 * @element cagov-content-navigation
 *
 * @attr {string} [data-selector] - "main";
 * @attr {string} [data-type] - "wordpress";
 * @attr {string} [data-label] - "On this page";
 */
class CAGovContentNavigation extends window.HTMLElement {
  connectedCallback() {
    this.type = "wordpress";
    /* https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.min.js */

    /* Smooth scroll polyfill for safari, since it does not support scroll behaviors yet - can be moved to a dependency bundle split out by browser support later or in headless implementation */

    !function () {
      "use strict";

      function o() {
        var o = window,
            t = document;

        if (!("scrollBehavior" in t.documentElement.style && !0 !== o.__forceSmoothScrollPolyfill__)) {
          var l,
              e = o.HTMLElement || o.Element,
              r = 468,
              i = {
            scroll: o.scroll || o.scrollTo,
            scrollBy: o.scrollBy,
            elementScroll: e.prototype.scroll || n,
            scrollIntoView: e.prototype.scrollIntoView
          },
              s = o.performance && o.performance.now ? o.performance.now.bind(o.performance) : Date.now,
              c = (l = o.navigator.userAgent, new RegExp(["MSIE ", "Trident/", "Edge/"].join("|")).test(l) ? 1 : 0);
          o.scroll = o.scrollTo = function () {
            void 0 !== arguments[0] && (!0 !== f(arguments[0]) ? h.call(o, t.body, void 0 !== arguments[0].left ? ~~arguments[0].left : o.scrollX || o.pageXOffset, void 0 !== arguments[0].top ? ~~arguments[0].top : o.scrollY || o.pageYOffset) : i.scroll.call(o, void 0 !== arguments[0].left ? arguments[0].left : "object" != typeof arguments[0] ? arguments[0] : o.scrollX || o.pageXOffset, void 0 !== arguments[0].top ? arguments[0].top : void 0 !== arguments[1] ? arguments[1] : o.scrollY || o.pageYOffset));
          }, o.scrollBy = function () {
            void 0 !== arguments[0] && (f(arguments[0]) ? i.scrollBy.call(o, void 0 !== arguments[0].left ? arguments[0].left : "object" != typeof arguments[0] ? arguments[0] : 0, void 0 !== arguments[0].top ? arguments[0].top : void 0 !== arguments[1] ? arguments[1] : 0) : h.call(o, t.body, ~~arguments[0].left + (o.scrollX || o.pageXOffset), ~~arguments[0].top + (o.scrollY || o.pageYOffset)));
          }, e.prototype.scroll = e.prototype.scrollTo = function () {
            if (void 0 !== arguments[0]) if (!0 !== f(arguments[0])) {
              var o = arguments[0].left,
                  t = arguments[0].top;
              h.call(this, this, void 0 === o ? this.scrollLeft : ~~o, void 0 === t ? this.scrollTop : ~~t);
            } else {
              if ("number" == typeof arguments[0] && void 0 === arguments[1]) throw new SyntaxError("Value could not be converted");
              i.elementScroll.call(this, void 0 !== arguments[0].left ? ~~arguments[0].left : "object" != typeof arguments[0] ? ~~arguments[0] : this.scrollLeft, void 0 !== arguments[0].top ? ~~arguments[0].top : void 0 !== arguments[1] ? ~~arguments[1] : this.scrollTop);
            }
          }, e.prototype.scrollBy = function () {
            void 0 !== arguments[0] && (!0 !== f(arguments[0]) ? this.scroll({
              left: ~~arguments[0].left + this.scrollLeft,
              top: ~~arguments[0].top + this.scrollTop,
              behavior: arguments[0].behavior
            }) : i.elementScroll.call(this, void 0 !== arguments[0].left ? ~~arguments[0].left + this.scrollLeft : ~~arguments[0] + this.scrollLeft, void 0 !== arguments[0].top ? ~~arguments[0].top + this.scrollTop : ~~arguments[1] + this.scrollTop));
          }, e.prototype.scrollIntoView = function () {
            if (!0 !== f(arguments[0])) {
              var l = function (o) {
                for (; o !== t.body && !1 === (e = p(l = o, "Y") && a(l, "Y"), r = p(l, "X") && a(l, "X"), e || r);) o = o.parentNode || o.host;

                var l, e, r;
                return o;
              }(this),
                  e = l.getBoundingClientRect(),
                  r = this.getBoundingClientRect();

              l !== t.body ? (h.call(this, l, l.scrollLeft + r.left - e.left, l.scrollTop + r.top - e.top), "fixed" !== o.getComputedStyle(l).position && o.scrollBy({
                left: e.left,
                top: e.top,
                behavior: "smooth"
              })) : o.scrollBy({
                left: r.left,
                top: r.top,
                behavior: "smooth"
              });
            } else i.scrollIntoView.call(this, void 0 === arguments[0] || arguments[0]);
          };
        }

        function n(o, t) {
          this.scrollLeft = o, this.scrollTop = t;
        }

        function f(o) {
          if (null === o || "object" != typeof o || void 0 === o.behavior || "auto" === o.behavior || "instant" === o.behavior) return !0;
          if ("object" == typeof o && "smooth" === o.behavior) return !1;
          throw new TypeError("behavior member of ScrollOptions " + o.behavior + " is not a valid value for enumeration ScrollBehavior.");
        }

        function p(o, t) {
          return "Y" === t ? o.clientHeight + c < o.scrollHeight : "X" === t ? o.clientWidth + c < o.scrollWidth : void 0;
        }

        function a(t, l) {
          var e = o.getComputedStyle(t, null)["overflow" + l];
          return "auto" === e || "scroll" === e;
        }

        function d(t) {
          var l,
              e,
              i,
              c,
              n = (s() - t.startTime) / r;
          c = n = n > 1 ? 1 : n, l = 0.5 * (1 - Math.cos(Math.PI * c)), e = t.startX + (t.x - t.startX) * l, i = t.startY + (t.y - t.startY) * l, t.method.call(t.scrollable, e, i), e === t.x && i === t.y || o.requestAnimationFrame(d.bind(o, t));
        }

        function h(l, e, r) {
          var c,
              f,
              p,
              a,
              h = s();
          l === t.body ? (c = o, f = o.scrollX || o.pageXOffset, p = o.scrollY || o.pageYOffset, a = i.scroll) : (c = l, f = l.scrollLeft, p = l.scrollTop, a = n), d({
            scrollable: c,
            method: a,
            startTime: h,
            startX: f,
            startY: p,
            x: e,
            y: r
          });
        }
      }

       true ? module.exports = {
        polyfill: o
      } : undefined;
    }();

    if (this.type === "wordpress") {
      document.addEventListener("DOMContentLoaded", () => this.buildContentNavigation());
    }
  }

  buildContentNavigation() {
    // Parse header tags
    let markup = this.getHeaderTags();
    let label = null;

    if (markup !== null) {
      label = this.dataset.label || "On this page";
    }

    let content = null;

    if (markup !== null) {
      content = `<div class="label">${label}</div> ${markup}`;
    }

    this.template({
      content
    }, "wordpress");
  }

  template(data, type) {
    if (data !== undefined && data !== null && data.content !== null) {
      if (type === "wordpress") {
        this.innerHTML = `${data.content}`;
      }
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener("click", function (e) {
        let hashval = decodeURI(anchor.getAttribute("href"));

        try {
          let target = document.querySelector(hashval);

          if (target !== null) {
            let position = target.getBoundingClientRect();
            const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion)").matches; // console.log("prefersReducedMotion", prefersReducedMotion);

            if (!prefersReducedMotion) {
              window.scrollTo({
                behavior: "smooth",
                left: position.left,
                top: position.top - 200
              });
            }

            history.pushState(null, null, hashval);
          }
        } catch (error) {
          console.error(error);
        }

        e.preventDefault();
      });
    });
    return null;
  }

  renderNoContent() {
    this.innerHTML = "";
  }

  getHeaderTags() {
    let selector = this.dataset.selector;
    let editor = this.dataset.editor;
    let label = this.dataset.label; // let display = this.dataset.display;

    let display = "render";
    let callback = this.dataset.callback; // Editor only right now

    var h = ["h2"];
    var headings = [];

    for (var i = 0; i < h.length; i++) {
      // Pull out the header tags, in order & render as links with anchor tags
      // auto convert h tags with tag names
      if (selector !== undefined && selector !== null) {
        if (display === "render") {
          let selectorContent = document.querySelector(selector);

          if (selectorContent !== null) {
            let outline = this.outliner(selectorContent);
            return outline;
          }
        }
      }
    }

    return null;
  }

  outliner(content) {
    let headers = content.querySelectorAll("h2");
    let output = ``;

    if (headers !== undefined && headers !== null && headers.length > 0) {
      headers.forEach(tag => {
        let tagId = tag.getAttribute("id");
        let title = tag.innerHTML; // Alt: [a-zA-Z\u00C0-\u017F]+,\s[a-zA-Z\u00C0-\u017F]+

        let anchor = tag.innerHTML.toLowerCase().trim().replace(/ /g, "-") // Strip out unallowed CSS characters (Selector API is used with the anchor links)
        // !, ", #, $, %, &, ', (, ), *, +, ,, -, ., /, :, ;, <, =, >, ?, @, [, \, ], ^, `, {, |, }, and ~.
        .replace(/\(|\)|\!|\"|\#|\$|\%|\&|\'|\*|\+|\,|\.|\/|\:|\;|\<|\=|\>|\?|\@|\[|\]|\\|\^|\`|\{|\||\|\}|\~/g, "") // All other characters are encoded and decoded using encodeURI/decodeURI which escapes UTF-8 characters.
        // If we want to do this with allowed characters only
        // .replace(/a-zA-ZÃ€-Ã–Ã™-Ã¶Ã¹-Ã¿Ä€-Å¾á¸€-á»¿0-9/g,"")
        .replace(/a-zA-ZÃ€-Ã–Ã™-Ã¶Ã¹-Ã¿Ä€-Å¾á¸€-á»¿0-9\u00A0-\u017F/g, ""); // If id not set already, create an id to jump to.

        if (tagId !== undefined && tagId !== null) {
          anchor = tagId;
        }

        if (title !== "" && title !== null) {
          output += `<li><a href="#${encodeURI(anchor)}">${title}</a></li>`;

          if (tagId === undefined || tagId === null) {
            tagId = anchor;
            tag.setAttribute("id", tagId);
          }
        }
      });
      return `<ul>${output}</ul>`;
    }

    return null;
  }

}

if (customElements.get("cagov-content-navigation") === undefined) {
  window.customElements.define("cagov-content-navigation", CAGovContentNavigation);
}

/***/ }),

/***/ "./node_modules/@cagov/ds-accordion/dist/index.js":
/*!********************************************************!*\
  !*** ./node_modules/@cagov/ds-accordion/dist/index.js ***!
  \********************************************************/
/*! exports provided: CaGovAccordion */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CaGovAccordion", function() { return CaGovAccordion; });
var styles =
  '/* accordion component specific classes */\ncagov-accordion .cagov-accordion-card {\n  border-radius: 0.3rem !important;\n  margin-bottom: 0;\n  min-height: 3rem;\n  margin-top: 0.5rem;\n  border: solid 1px #ededef !important;\n}\n\ncagov-accordion .accordion-card-container {\n  display: block;\n  overflow: hidden;\n}\n\ncagov-accordion button.accordion-card-header {\n  display: flex;\n  justify-content: left;\n  align-items: center;\n  padding: 0 0 0 1rem;\n  background-clip: border-box;\n  background-color: #ededef;\n  border: none;\n  position: relative;\n  width: 100%;\n  line-height: 3rem;\n}\n\ncagov-accordion.prog-enhanced button.accordion-card-header {\n  cursor: pointer;\n}\n\ncagov-accordion .accordion-title {\n  text-align: left;\n  margin-bottom: 0;\n  color: var(--primary-color, #064e66);\n  margin-right: auto;\n  width: 90%;\n  padding: 0 0.5rem 0 0 !important;\n  font-size: 1.125rem;\n  font-weight: bold;\n}\n\ncagov-accordion.prog-enhanced .accordion-card-container {\n  height: 0px;\n  transition: height 0.3s ease;\n}\n\ncagov-accordion.prog-enhanced .accordion-card-container .card-body {\n  padding-left: 1rem;\n  margin-top: 8px;\n}\n\ncagov-accordion.prog-enhanced .accordion-card-container .card-body ul {\n  margin-left: 16px;\n  margin-right: 16px;\n}\n\ncagov-accordion .collapsed {\n  display: block;\n  overflow: hidden;\n  visibility: hidden;\n}\n\n.accordion-title h4,\n.accordion-title h3,\n.accordion-title h2 {\n  padding: 0 !important;\n  margin-top: 0 !important;\n  margin-bottom: 0 !important;\n  font-size: 1.2rem !important;\n  font-weight: 700;\n  color: var(--primary-color, #064e66);\n  text-align: left !important;\n}\n\nbutton.accordion-card-header:hover {\n  background-color: var(--hover-color, #f9f9fa);\n}\n\nbutton.accordion-card-header:hover .accordion-title {\n  text-decoration: underline;\n}\n\nbutton.accordion-card-header:hover .accordion-title:hover {\n  text-decoration: underline;\n}\n\nbutton.accordion-card-header:focus {\n  outline-offset: -2px;\n}\n\n.accordion-icon svg line {\n  stroke-width: 4px;\n}\n\ncagov-accordion.prog-enhanced .accordion-alpha .plus-minus {\n  width: 2.125rem;\n  height: 2.125rem;\n  border: none;\n  overflow: hidden;\n  margin-left: 1rem;\n  color: var(--primary-color, #064e66);\n  align-self: flex-start;\n  margin-top: 0px;\n}\n\n.prog-enhanced .accordion-alpha .plus-minus svg {\n  fill: var(--primary-color, #064e66);\n  width: 25px;\n  height: 25px;\n}\n\n.prog-enhanced .accordion-alpha-open cagov-plus .accordion-icon {\n  display: none !important;\n}\n\n.prog-enhanced .accordion-alpha-open cagov-minus .accordion-icon {\n  display: block !important;\n}\n\n@media only screen and (max-width: 767px) {\n  .accordion-alpha-open + .accordion-card-container {\n    height: 100% !important;\n  }\n}\n\n/*# sourceMappingURL=index.css.map */\n';

/**
 * Accordion web component that collapses and expands content inside itself on click.
 *
 * @element cagov-accordion
 *
 * @prop {class string} prog-enhanced -
 * The element is open before any javascript executes so content
 * can be read if an error occurs that prevents js execution.
 * The prog-enhanced class is added to the element once javascript
 * begins to execute. This triggers default collabsed state.
 *
 * @fires click - Default value, will be defined by this.dataset.eventType.
 *
 * @attr {string} [data-event-type=click] - dataset defined value for event type fired on click.
 * @attr {string} aria=expanded=true -
 * set on the internal element .accordion-card-header.
 * If this is true the accordion will be open before any user interaction.
 *
 * @cssprop --primary-color - Default value of #1f2574, used for all colors of borders and fills
 * @cssprop --hover-color - Default value of #F9F9FA, used for background on hover
 *
 */
class CaGovAccordion extends window.HTMLElement {
  constructor() {
    super();
    if (document.querySelector('api-viewer')) {
      const link = document.createElement('link');
      link.setAttribute('rel', 'stylesheet');
      link.setAttribute('href', './src/css/index.css');
      document.querySelector('api-viewer').shadowRoot.appendChild(link);
    }
  }

  connectedCallback() {
    this.classList.add('prog-enhanced');
    this.expandTarget = this.querySelector('.accordion-card-container');
    this.expandButton = this.querySelector('.accordion-card-header');
    if (this.expandButton) {
      this.expandButton.addEventListener('click', this.listen.bind(this));
    }
    this.activateButton = this.querySelector('.accordion-card-header');
    this.eventType = this.dataset.eventType ? this.dataset.eventType : 'click';

    // Detect if accordion should open by default
    const expanded = this.activateButton.getAttribute('aria-expanded');
    if (expanded === 'true') {
      this.triggerAccordionClick(); // Open the accordion.
      const allLinks = this.querySelectorAll('.accordion-card-container a');
      const allbuttons = this.querySelectorAll(
        '.accordion-card-container button',
      );
      for (let i = 0; i < allLinks.length; i += 1) {
        allLinks[i].removeAttribute('tabindex'); // remove tabindex from all the links
      }
      for (let i = 0; i < allbuttons.length; i += 1) {
        allbuttons[i].removeAttribute('tabindex'); // remove tabindex from all the buttons
      }
    } else {
      // making sure that all links inside of the accordion container are having tabindex -1
      const allLinks = this.querySelectorAll('.accordion-card-container a');
      const allbuttons = this.querySelectorAll(
        '.accordion-card-container button',
      );
      for (let i = 0; i < allLinks.length; i += 1) {
        allLinks[i].setAttribute('tabindex', '-1');
      }

      for (let i = 0; i < allbuttons.length; i += 1) {
        allbuttons[i].setAttribute('tabindex', '-1');
      }
    }
  }

  listen() {
    if (!this.cardBodyHeight) {
      this.cardBodyHeight = this.querySelector('.card-body').clientHeight + 24;
    }
    if (this.expandTarget.clientHeight > 0) {
      this.closeAccordion();
    } else {
      this.expandAccordion();
    }
  }

  triggerAccordionClick() {
    const event = new MouseEvent(this.eventType, {
      view: window,
      bubbles: true,
      cancelable: true,
    });
    this.expandButton.dispatchEvent(event);
  }

  closeAccordion() {
    this.expandTarget.style.height = '0px';
    this.expandTarget.setAttribute('aria-hidden', 'true');
    this.querySelector('.accordion-card-header').classList.remove(
      'accordion-alpha-open',
    );
    this.activateButton.setAttribute('aria-expanded', 'false');
    const allLinks = this.querySelectorAll('.accordion-card-container a');
    const allbuttons = this.querySelectorAll(
      '.accordion-card-container button',
    );
    for (let i = 0; i < allLinks.length; i += 1) {
      allLinks[i].setAttribute('tabindex', '-1'); // tabindex to all links
    }
    for (let i = 0; i < allbuttons.length; i += 1) {
      allbuttons[i].setAttribute('tabindex', '-1'); // tabindex to all buttons
    }
  }

  expandAccordion() {
    this.expandTarget.style.height = `${this.cardBodyHeight}px`;
    this.expandTarget.setAttribute('aria-hidden', 'false');
    this.querySelector('.accordion-card-header').classList.add(
      'accordion-alpha-open',
    );
    this.querySelector('.accordion-card-container').classList.remove(
      'collapsed',
    );
    this.activateButton.setAttribute('aria-expanded', 'true');
    const allLinks = this.querySelectorAll('.accordion-card-container a');
    const allbuttons = this.querySelectorAll(
      '.accordion-card-container button',
    );
    for (let i = 0; i < allLinks.length; i += 1) {
      allLinks[i].removeAttribute('tabindex'); // remove tabindex from all the links
    }
    for (let i = 0; i < allbuttons.length; i += 1) {
      allbuttons[i].removeAttribute('tabindex'); // remove tabindex from all the buttons
    }
  }
}
window.customElements.define('cagov-accordion', CaGovAccordion);
const style = document.createElement('style');
style.textContent = styles;
document.querySelector('head').appendChild(style);




/***/ }),

/***/ "./node_modules/@cagov/ds-feedback/dist/index.js":
/*!*******************************************************!*\
  !*** ./node_modules/@cagov/ds-feedback/dist/index.js ***!
  \*******************************************************/
/*! exports provided: CAGovFeedback */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CAGovFeedback", function() { return CAGovFeedback; });
function ratingsTemplate(
  question,
  yes,
  no,
  commentPrompt,
  thanksFeedback,
  thanksComments,
  submit,
) {
  return `
  <section aria-label="feedback">
  <div class="feedback-form cagov-stack">
    <div class="js-feedback-form feedback-form-question">
      <h2 class="feedback-form-label" id="feedback-rating">${question}</h2>
      <button class="feedback-form-button js-feedback-yes feedback-yes" id="feedback-yes">${yes}</button>
      <button class="feedback-form-button js-feedback-no" id="feedback-no">${no}</button>
    </div>
          
    <div class="feedback-form-thanks js-feedback-thanks" role="alert">${thanksFeedback}</div>
          
    <div class="feedback-form-add">
      <label class="feedback-form-label js-feedback-field-label" for="add-feedback">${commentPrompt}</label>
      <div class="feedback-form-add-grid">
        <textarea name="add-feedback" class="js-add-feedback feedback-form-textarea" id="add-feedback" rows="1"></textarea>
        <button class="feedback-form-button js-feedback-submit" type="submit" id="feedback-submit">${submit}</button>
      </div>
    </div>

    <div class="feedback-form-thanks feedback-thanks-add" role="alert">${thanksComments}</div>
  </div>
  </section>`;
}

var styles =
  'cagov-feedback {\n  width: 100%;\n}\ncagov-feedback .feedback-form {\n  background: var(--primary-dark-color, #003484);\n  padding: 1rem;\n  border-radius: 0.3125rem;\n  max-width: var(--w-lg, 1176px);\n  margin: 0 auto;\n}\ncagov-feedback .feedback-form-question {\n  display: flex;\n  align-items: center;\n  flex-wrap: wrap;\n}\ncagov-feedback .feedback-form-label {\n  color: #fff;\n  background-color: var(--primary-dark-color, #003484);\n  font-size: 1.125rem;\n  display: block;\n  margin-right: 1rem;\n  transition: 0.3s color cubic-bezier(0.57, 0.2, 0.21, 0.89);\n  line-height: 3rem;\n  width: auto;\n}\n@media (max-width: 768px) {\n  cagov-feedback .feedback-form-label {\n    line-height: unset;\n    margin-bottom: 1rem;\n  }\n}\ncagov-feedback .feedback-form-button {\n  padding: 1rem;\n  color: var(--primary-dark-color, #003484);\n  border: none;\n  border-radius: 0.3rem;\n  transition: 0.3s background cubic-bezier(0.57, 0.2, 0.21, 0.89);\n  cursor: pointer;\n  margin: 0 0.5rem 0 0;\n  display: inline !important;\n  /* defensive overrides */\n  position: relative;\n  text-transform: none;\n  top: auto;\n  right: auto;\n  background: #fff;\n}\ncagov-feedback .feedback-form-button:hover {\n  box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.2);\n  text-decoration: underline;\n}\ncagov-feedback .feedback-form-button:focus {\n  box-shadow: 0 0 0 2px #fff;\n}\ncagov-feedback .feedback-form-button .feedback-yes {\n  margin-right: 1rem;\n}\ncagov-feedback .feedback-form-add {\n  padding-top: 0;\n  display: none;\n}\n@media (max-width: 768px) {\n  cagov-feedback .feedback-form-add {\n    text-align: left;\n    padding-top: 0;\n  }\n}\ncagov-feedback .feedback-form-add-grid {\n  position: relative;\n  margin-top: 1rem;\n  display: inline-flex;\n  flex-flow: column;\n  align-items: flex-start;\n}\n@media (max-width: 768px) {\n  cagov-feedback .feedback-form-add-grid {\n    display: block;\n  }\n}\ncagov-feedback .feedback-form-textarea {\n  width: 100%;\n  padding: 1rem;\n  margin-bottom: 1rem;\n  font-family: "Roboto", sans-serif;\n  color: var(--primary-dark-color, #003484);\n  max-width: 90%;\n  height: 127px;\n  width: 600px;\n}\ncagov-feedback .feedback-form-thanks {\n  display: none;\n  color: #fff;\n}\ncagov-feedback .feedback-form-error {\n  position: relative;\n  top: 100%;\n  left: 0;\n  display: none;\n  font-weight: 300;\n  text-align: left;\n}\n\n/*# sourceMappingURL=index.css.map */\n';

/**
 * Page feedback web component that asks if you found what you were looking for,
 * then prompts for comments
 *
 * @element cagov-feedback
 *
 * @fires ratedPage - custom event with object with detail value of whether the user
 *                    clicked yes or no to the first question: {detail: "yes"}.
 *                    This can be used to send that value as a GA event outside this
 *                    component.
 *
 * @attr {string} [data-question] - "Did you find what you were looking for?";
 * @attr {string} [data-yes] - "Yes";
 * @attr {string} [data-no] - "No";
 * @attr {string} [data-commentPrompt] - "What was the problem?";
 * @attr {string} [data-positiveCommentPrompt] - "Great! What were you looking for today?";
 * @attr {string} [data-thanksFeedback] - "Thank you for your feedback!";
 * @attr {string} [data-thanksComments] - "Thank you for your comments!";
 * @attr {string} [data-submit] - "Submit";
 * @attr {string} [data-anythingToAdd] - "If you have anything to add,"
 * @attr {string} [data-anyOtherFeedback] - "If you have any other feedback about this website,"
 *
 * @cssprop --primary-color - Default value of #064E66, used for background
 */
class CAGovFeedback extends window.HTMLElement {
  constructor() {
    super();
    if (document.querySelector('api-viewer')) {
      const link = document.createElement('link');
      link.setAttribute('rel', 'stylesheet');
      link.setAttribute('href', './src/css/index.css');
      document.querySelector('api-viewer').shadowRoot.appendChild(link);
    }
  }

  connectedCallback() {
    const question = this.dataset.question
      ? this.dataset.question
      : 'Did you find what you were looking for?';
    const yes = this.dataset.yes ? this.dataset.yes : 'Yes';
    const no = this.dataset.no ? this.dataset.no : 'No';
    const commentPrompt = this.dataset.commentPrompt
      ? this.dataset.commentPrompt
      : 'What was the problem?';
    this.positiveCommentPrompt = this.dataset.positiveCommentPrompt
      ? this.dataset.positiveCommentPrompt
      : 'Great! What were you looking for today?';
    const thanksFeedback = this.dataset.thanksFeedback
      ? this.dataset.thanksFeedback
      : 'Thank you for your feedback!';
    const thanksComments = this.dataset.thanksComments
      ? this.dataset.thanksComments
      : 'Thank you for your comments!';
    const submit = this.dataset.submit ? this.dataset.submit : 'Submit';
    this.dataset.characterLimit
      ? this.dataset.characterLimit
      : 'You have reached your character limit.';
    this.dataset.anythingToAdd
      ? this.dataset.anythingToAdd
      : 'If you have anything to add,';
    this.dataset.anyOtherFeedback
      ? this.dataset.anyOtherFeedback
      : 'If you have any other feedback about this website,';

    this.endpointUrl = this.dataset.endpointUrl;
    const html = ratingsTemplate(
      question,
      yes,
      no,
      commentPrompt,
      thanksFeedback,
      thanksComments,
      submit,
    );
    this.innerHTML = html;
    this.applyListeners();
  }

  applyListeners() {
    this.wasHelpful = '';
    this.querySelector('.js-add-feedback').addEventListener('focus', () => {
      this.querySelector('.js-feedback-submit').style.display = 'block';
    });
    const feedback = this.querySelector('.js-add-feedback');
    feedback.addEventListener('keyup', () => {
      if (feedback.value.length > 15) {
        feedback.setAttribute('rows', '3');
      } else {
        feedback.setAttribute('rows', '1');
      }
    });

    feedback.addEventListener('blur', () => {
      if (feedback.value.length !== 0) {
        this.querySelector('.js-feedback-submit').style.display = 'block';
      }
    });
    this.querySelector('.js-feedback-yes').addEventListener('click', () => {
      this.querySelector('.js-feedback-field-label').innerHTML =
        this.positiveCommentPrompt;
      this.querySelector('.js-feedback-form').style.display = 'none';
      this.querySelector('.feedback-form-add').style.display = 'block';
      this.wasHelpful = 'yes';
      this.dispatchEvent(
        new CustomEvent('ratedPage', {
          detail: this.wasHelpful,
        }),
      );
    });
    this.querySelector('.js-feedback-no').addEventListener('click', () => {
      this.querySelector('.js-feedback-form').style.display = 'none';
      this.querySelector('.feedback-form-add').style.display = 'block';
      this.wasHelpful = 'no';
      this.dispatchEvent(
        new CustomEvent('ratedPage', {
          detail: this.wasHelpful,
        }),
      );
    });
    this.querySelector('.js-feedback-submit').addEventListener('click', () => {
      this.querySelector('.feedback-form-add').style.display = 'none';
      this.querySelector('.feedback-thanks-add').style.display = 'block';

      const postData = {};
      postData.url = window.location.href;
      postData.helpful = this.wasHelpful;
      postData.comments = feedback.value;
      postData.userAgent = navigator.userAgent;

      fetch(this.endpointUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(postData),
      })
        .then((response) => response.json())
        .then((data) => console.log(data));
    });
  }
}
window.customElements.define('cagov-feedback', CAGovFeedback);
const style = document.createElement('style');
style.textContent = styles;
document.querySelector('head').appendChild(style);




/***/ }),

/***/ "./node_modules/@cagov/ds-minus/index.js":
/*!***********************************************!*\
  !*** ./node_modules/@cagov/ds-minus/index.js ***!
  \***********************************************/
/*! exports provided: CaGovMinus */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CaGovMinus", function() { return CaGovMinus; });
/**
 * Minus web component, inlines an svg minus symbol so it can be styled dynamically
 *
 * @element cagov-minus
 *
 */
class CaGovMinus extends window.HTMLElement {
  connectedCallback() {
    this.innerHTML = `<div class="accordion-icon" aria-hidden="true">
        <svg viewbox="0 0 25 25">
            <title>Minus</title>
            <line x1="6" y1="12.5" x2="19" y2="12.5"  fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round" vector-effect="non-scaling-stroke" />
        </svg>
      </div>`;
  }
}
window.customElements.define('cagov-minus', CaGovMinus);


/***/ }),

/***/ "./node_modules/@cagov/ds-pagination/dist/index.js":
/*!*********************************************************!*\
  !*** ./node_modules/@cagov/ds-pagination/dist/index.js ***!
  \*********************************************************/
/*! exports provided: CAGovPagination */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CAGovPagination", function() { return CAGovPagination; });
function pageListItem(label, number) {
  return `<li class="cagov-pagination__item">
    <a
      href="javascript:void(0);"
      class="cagov-pagination__button"
      aria-label="${label} ${number}"
      data-page-num="${number}"
    >
      ${number}
    </a>
  </li>`;
}

function pageOverflow() {
  return `<li
    class="cagov-pagination__item cagov-pagination__overflow"
    role="presentation"
  >
    <span> … </span>
  </li>`;
}

function templateHTML(next, previous, page, currentPage, totalPages) {
  return `<nav aria-label="Pagination" class="cagov-pagination">
    <ul class="cagov-pagination__list">
      <li class="cagov-pagination__item">
        <a
          href="javascript:void(0);"
          class="cagov-pagination__link cagov-pagination__previous-page"
          aria-label="${previous} ${page}"
        >
          <span class="cagov-pagination__link-text ${
            currentPage > 2 ? '' : 'cagov-pagination__link-inactive'
          }"> ${previous} </span>
        </a>
      </li>
      ${currentPage > 2 ? pageListItem(page, 1) : ''}

      ${currentPage > 3 ? pageOverflow() : ''}

      ${currentPage > 1 ? pageListItem(page, currentPage - 1) : ''}

      <li class="cagov-pagination__item cagov-pagination-current">
        <a
          href="javascript:void(0);"
          class="cagov-pagination__button"
          aria-label="Page ${currentPage}"
          aria-current="page"
          data-page-num="${currentPage}"
        >
          ${currentPage}
        </a>
      </li>

      ${currentPage < totalPages ? pageListItem(page, currentPage + 1) : ''}

      ${currentPage < totalPages - 3 ? pageOverflow() : ''}

      ${currentPage < totalPages - 1 ? pageListItem(page, totalPages) : ''}

      <li class="cagov-pagination__item">
        <a
          href="javascript:void(0);"
          class="cagov-pagination__link cagov-pagination__next-page"
          aria-label="${next} ${page}"
        >
          <span class="cagov-pagination__link-text ${
            currentPage > totalPages - 1
              ? 'cagov-pagination__link-inactive'
              : ''
          }"> ${next} </span>
        </a>
      </li>
    </ul>
  </nav>`;
}

var styles =
  'cagov-pagination .cagov-pagination__list {\n  list-style: none;\n  margin: 0;\n  padding: 0 !important;\n  display: flex;\n}\ncagov-pagination .cagov-pagination__item {\n  border: 1px solid #EDEDEF;\n  border-radius: 0.3rem;\n  margin: 0.25rem;\n}\ncagov-pagination .cagov-pagination__item a {\n  padding: 0.75rem 0.875rem;\n  display: inline-block;\n  color: var(--primary-color, #064E66);\n  text-decoration: none;\n}\ncagov-pagination .cagov-pagination__item:hover {\n  background: #F9F9FA;\n}\ncagov-pagination .cagov-pagination__item:hover a {\n  text-decoration: underline;\n}\ncagov-pagination .cagov-pagination__item.cagov-pagination-current {\n  background-color: #064E66;\n  background-color: var(--primary-color, #064E66);\n}\ncagov-pagination .cagov-pagination__item.cagov-pagination-current a {\n  color: #fff;\n}\ncagov-pagination .cagov-pagination__item.cagov-pagination__overflow {\n  border: none;\n  padding: 0.875rem 0;\n}\ncagov-pagination .cagov-pagination__item.cagov-pagination__overflow:hover {\n  background: inherit;\n}\ncagov-pagination .cagov-pagination__link-inactive {\n  color: grey;\n  border-color: grey;\n  cursor: not-allowed;\n  opacity: 0.5;\n}\n\n/*# sourceMappingURL=index.css.map */\n';

/**
 * Pagination web component
 *
 * @element cagov-pagination
 *
 * @fires paginationClick - custom event with object with detail value of current page: {detail: 1}
 *
 * @attr {string} [data-yes] - "Yes";
 * @attr {string} [data-no] - "No";
 *
 * @cssprop --primary-color - Default value of #064E66, used for text, border color
 */
class CAGovPagination extends window.HTMLElement {
  constructor() {
    super();
    if (document.querySelector('api-viewer')) {
      const link = document.createElement('link');
      link.setAttribute('rel', 'stylesheet');
      link.setAttribute('href', './src/css/index.css');
      document.querySelector('api-viewer').shadowRoot.appendChild(link);
    }
  }

  // add jsdoc event
  // add jsdoc event to feedback too

  connectedCallback() {
    this.currentPage = parseInt(
      this.dataset.currentPage ? this.dataset.currentPage : '1',
      10,
    );
    this.render();
  }

  render() {
    const previous = this.dataset.previous ? this.dataset.previous : '&#60;';
    const next = this.dataset.next ? this.dataset.next : '&#62;';
    const page = this.dataset.page ? this.dataset.page : 'Page';
    this.totalPages = this.dataset.totalPages ? this.dataset.totalPages : '1';
    const html = templateHTML(
      next,
      previous,
      page,
      this.currentPage,
      this.totalPages,
    );
    this.innerHTML = html;
    this.applyListeners();
  }

  static get observedAttributes() {
    return ['data-current-page', 'data-total-pages'];
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (name === 'data-current-page') {
      this.currentPage = parseInt(newValue, 10);
      this.render();
    }
  }

  applyListeners() {
    const pageLinks = this.querySelectorAll('.cagov-pagination__button');
    pageLinks.forEach((pl) => {
      pl.addEventListener('click', (event) => {
        this.currentPage = parseInt(event.target.dataset.pageNum, 10);
        this.dispatchEvent(
          new CustomEvent('paginationClick', {
            detail: this.currentPage,
          }),
        );
        this.dataset.currentPage = this.currentPage;
      });
    });
    this.querySelector('.cagov-pagination__previous-page').addEventListener(
      'click',
      (event) => {
        if (
          !event.target.classList.contains('cagov-pagination__link-inactive')
        ) {
          this.currentPage -= 1;
          if (this.currentPage < 1) {
            this.currentPage = 1;
          }
          this.dispatchEvent(
            new CustomEvent('paginationClick', {
              detail: this.currentPage,
            }),
          );
          this.dataset.currentPage = this.currentPage;
        }
      },
    );
    this.querySelector('.cagov-pagination__next-page').addEventListener(
      'click',
      (event) => {
        if (
          !event.target.classList.contains('cagov-pagination__link-inactive')
        ) {
          this.currentPage += 1;
          if (this.currentPage > this.totalPages) {
            this.currentPage = this.totalPages;
          }
          this.dispatchEvent(
            new CustomEvent('paginationClick', {
              detail: this.currentPage,
            }),
          );
          this.dataset.currentPage = this.currentPage;
        }
      },
    );
  }
}
window.customElements.define('cagov-pagination', CAGovPagination);
const style = document.createElement('style');
style.textContent = styles;
document.querySelector('head').appendChild(style);




/***/ }),

/***/ "./node_modules/@cagov/ds-pdf-icon/src/index.js":
/*!******************************************************!*\
  !*** ./node_modules/@cagov/ds-pdf-icon/src/index.js ***!
  \******************************************************/
/*! exports provided: placePdfIcons */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "placePdfIcons", function() { return placePdfIcons; });
function placePdfIcons() {
  // pdf-icon component svg icon
  const pdf =
    '<span class="pdf-link-icon" aria-hidden="true"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"width="25.1px" height="13.6px" viewBox="0 0 25.1 13.6" style="enable-background:new 0 0 25.1 13.6;" xml:space="preserve"><path d="M11.7,9.9h1.5c1.7,0,3.1-1.4,3.1-3.1s-1.4-3.1-3.1-3.1h-1.5c-0.3,0-0.6,0.3-0.6,0.6v4.9c0,0.2,0.1,0.3,0.2,0.4C11.4,9.9,11.6,9.9,11.7,9.9L11.7,9.9z M12.3,5h0.9c1,0,1.8,0.8,1.8,1.8s-0.8,1.8-1.8,1.8h-0.9V5z"/><path d="M17.8,9.9c0.2,0,0.3-0.1,0.4-0.2c0.1-0.1,0.2-0.3,0.2-0.4V7.5h1.2c0.3,0,0.6-0.3,0.6-0.6c0-0.3-0.3-0.6-0.6-0.6h-1.2V5h2.1c0.3,0,0.6-0.3,0.6-0.6c0-0.3-0.3-0.6-0.6-0.6h-2.8c-0.3,0-0.6,0.3-0.6,0.6v4.9c0,0.2,0.1,0.3,0.2,0.4C17.5,9.9,17.7,9.9,17.8,9.9L17.8,9.9z"/><path d="M6.2,9.9c0.2,0,0.3-0.1,0.4-0.2c0.1-0.1,0.2-0.3,0.2-0.4V8.1H8c1.2,0,2.1-1,2.1-2.1c0-1.2-1-2.1-2.1-2.1H6.2c-0.3,0-0.6,0.3-0.6,0.6v4.9c0,0.2,0.1,0.3,0.2,0.4C5.9,9.9,6,9.9,6.2,9.9L6.2,9.9z M9,6c0,0.3-0.1,0.5-0.2,0.7C8.5,6.8,8.3,6.9,8,6.9H6.8V5H8c0.2,0,0.5,0.1,0.7,0.2C8.9,5.5,9,5.7,9,6L9,6z"/><path d="M5,9.3c0,0.8-1.2,0.8-1.2,0C3.8,8.5,5,8.5,5,9.3z"/></svg></span><span class="sr-only"> (this is a pdf file)</span>';

  // selector is looking for links with pdf extension in the href
  const pdfLink = document.querySelectorAll("a[href*='.pdf']");
  for (let i = 0; i < pdfLink.length; i += 1) {
    pdfLink[i].innerHTML += pdf; // += concatenates to pdf links
    // Fixing search results PDF links
    if (pdfLink[i].innerHTML.indexOf('*PDF (this is a pdf file)*') !== -1) {
      pdfLink[i].innerHTML += pdf.replace(/PDF (this is a pdf file)]/g, ''); // += concatenates to pdf links
    }
  }
}

placePdfIcons();




/***/ }),

/***/ "./node_modules/@cagov/ds-plus/index.js":
/*!**********************************************!*\
  !*** ./node_modules/@cagov/ds-plus/index.js ***!
  \**********************************************/
/*! exports provided: CaGovPlus */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CaGovPlus", function() { return CaGovPlus; });
/**
 * Plus web component, inlines an svg plus symbol so it can be styled dynamically
 *
 * @element cagov-plus
 *
 */
class CaGovPlus extends window.HTMLElement {
  connectedCallback() {
    this.innerHTML = `<div class="accordion-icon" aria-hidden="true">
        <svg viewbox="0 0 25 25">
            <title>Plus</title>
            <line x1="6" y1="12.5" x2="19" y2="12.5" fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round" vector-effect="non-scaling-stroke" />
            <line y1="6" x1="12.5" y2="19" x2="12.5" fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round" vector-effect="non-scaling-stroke" />
        </svg>
      </div>`;
  }
}
window.customElements.define('cagov-plus', CaGovPlus);


/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_cagov_ds_accordion_dist_index_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./../node_modules/@cagov/ds-accordion/dist/index.js */ "./node_modules/@cagov/ds-accordion/dist/index.js");
/* harmony import */ var _blocks_content_navigation_src_index_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./../blocks/content-navigation/src/index.js */ "./blocks/content-navigation/src/index.js");
/* harmony import */ var _blocks_content_navigation_src_index_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_blocks_content_navigation_src_index_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _node_modules_cagov_ds_feedback_dist_index_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./../node_modules/@cagov/ds-feedback/dist/index.js */ "./node_modules/@cagov/ds-feedback/dist/index.js");
/* harmony import */ var _node_modules_cagov_ds_minus_index_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./../node_modules/@cagov/ds-minus/index.js */ "./node_modules/@cagov/ds-minus/index.js");
/* harmony import */ var _node_modules_cagov_ds_pagination_dist_index_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./../node_modules/@cagov/ds-pagination/dist/index.js */ "./node_modules/@cagov/ds-pagination/dist/index.js");
/* harmony import */ var _node_modules_cagov_ds_pdf_icon_src_index_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./../node_modules/@cagov/ds-pdf-icon/src/index.js */ "./node_modules/@cagov/ds-pdf-icon/src/index.js");
/* harmony import */ var _node_modules_cagov_ds_plus_index_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./../node_modules/@cagov/ds-plus/index.js */ "./node_modules/@cagov/ds-plus/index.js");
// Build ES-Next Gutenberg Blocks
// import '../blocks/event-detail/block.js';
// import '../blocks/event-materials/block.js';
// import './../node_modules/@cagov/ds-base-css';
 // 1.0.6 not working 
// import './../blocks/accordion/dist/index.js';
// import './../node_modules/@cagov/ds-card-grid'; // Just CSS - has css grid issues
// import './../node_modules/@cagov/ds-content-navigation/src/index.js';

 // import './../node_modules/@cagov/ds-feature-card'; // Just CSS





 // import './../node_modules/@cagov/ds-regulatory-outline'; // Just CSS
// import './../node_modules/@cagov/ds-step-list'; // Just CSS

/***/ })

/******/ });
//# sourceMappingURL=index.js.map