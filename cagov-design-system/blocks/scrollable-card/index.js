/**
 * Scrollable Card Grid web component
 *
 * @element cagov-scrollable-card-grid
 *
 * @attr {string} [data-selector] - "main";
 * @attr {string} [data-label] - "On this page";
 */
 class CAGovScrollableCardGrid extends window.HTMLElement {
    connectedCallback() {
    }

    createGlider = () => {
        // console.log('creating glider');
        let countToAddGlider = 3;

        if (window.innerWidth <= 770) {
            countToAddGlider = 1;
        }
        // console.log(document.querySelector('.glider'));
        // Has a glider at all
        if (document.querySelector('.glider') !== null) {
            let gliders = document.querySelectorAll('.glider');
            if (gliders.length > 0) {
            // console.log("Has gliders", gliders.length, typeof gliders);
            Object.keys(gliders).map((index) => {
                var glider = gliders[index];
                var cardCount = glider.children.length;
                // console.log("Glider has ", cardCount, " cards", countToAddGlider);
                if (cardCount !== undefined && cardCount > countToAddGlider) {
                    // console.log("Adding Glider interaction");
                        // For each
                        new Glider(glider, {
                            // slidesToShow: countToAddGlider,
                            // slidesToScroll: 1,
                            slidesToShow: 'auto',
                            slidesToScroll: 'auto',
                            itemWidth: 376,
                            dots: '.dots',
                            draggable: true,
                            responsive: [
                                {
                                  // screens greater than >= 775px
                                  breakpoint: 775,
                                  settings: {
                                    // Set to `auto` and provide item width to adjust to viewport
                                    slidesToShow: 'auto',
                                    slidesToScroll: 'auto',
                                    itemWidth: 376,
                                    duration: 0.25
                                  }
                                },{
                                  // screens greater than >= 1024px
                                  breakpoint: 1024,
                                  settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    itemWidth: 376,
                                    duration: 0.25
                                  }
                                }
                            ]
                        });
                    }
                });
            }
        }
    }

    registerGlider() {
        this.createGlider();
    }

  }
  
  if (customElements.get("cagov-scrollable-card-grid") === undefined) {
    window.customElements.define(
      "cagov-scrollable-card-grid",
      CAGovScrollableCardGrid
    );
  }
  