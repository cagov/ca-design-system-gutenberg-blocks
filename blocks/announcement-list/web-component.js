/**
 * News List web component
 * Supported endpoints: Wordpress v2
 * Wordpress Dependencies: window.wp.moment.
 */
 class CAGovAnnoucementList extends window.HTMLElement {
  connectedCallback() {
    this.endpoint = this.dataset.endpoint;
    this.order = this.dataset.order || "desc";
    this.count = this.dataset.count || "5";
    this.category = this.dataset.category || "Announcement";
    this.type = "wordpress";
    if (this.type === "wordpress") {
      this.getWordpressPosts();
    }
  }

  getWordpressPosts() {
    if (this.endpoint !== undefined) {
      let categoryEndpoint = `${this.endpoint}/categories?slug=${this.category}`;
      console.log("cate", categoryEndpoint)
      // Get data
      window
        .fetch(categoryEndpoint)
        .then((response) => response.json())
        .then(
          function (data) {
            let categoryIds = data.map((item) => {
              console.log(item);
              return item.id;
            });

            let postsEndpoint = `${this.endpoint}/posts?`;

            if (categoryIds !== undefined && categoryIds.length > 0) {
              postsEndpoint += `categories=${categoryIds.join(",")}`;
            }
            if (this.count) {
              postsEndpoint += `&per_page=${this.count}`;
            }
            if (this.order) {
              postsEndpoint += `&order=${this.order}`;
            }
            window
              .fetch(postsEndpoint)
              .then((response) => response.json())
              .then(
                function (posts) {
                  if (posts !== undefined) {
                    // Set posts content.
                    this.innerHTML = this.template(posts, "wordpress");
                  }
                }.bind(this)
              )
              .catch((error) => {
                console.error(error);
                this.renderNoPosts();
              });
          }.bind(this)
        )
        .catch((error) => {
          console.error(error);
          this.renderNoPosts();
        });
    }
  }

  template(posts, type) {
    if (posts !== undefined && posts !== null && posts.length > 0) {
      if (type === "wordpress") {
        let renderedPosts = posts.map((post) =>
          this.renderWordpressPostTitleDate(post)
        );
        return `<ul>${renderedPosts.join("")}</ul>`;
      }
    }
    return null;
  }

  renderNoPosts() {
    this.innerHTML = "";
  }

  /**
   * Render wordpress post with title and date
   * @param {*} param0
   * @returns
   */
  renderWordpressPostTitleDate({
    title = null,
    link = null,
    date = null, // "2021-05-23T18:19:58"
    // content = null,
    // excerpt = null, // @TODO shorten / optional
    // author = null, // 1
    // featured_media = null, // 0
  }) {
    let dateFormatted;
    if (date !== null && window.moment !== undefined) {
      dateFormatted = moment(date).format("MMMM DD, YYYY");
    }
    return `<li>
                <a href="${link}">
                    ${title.rendered}
                </a>
                <div class="date">${dateFormatted && dateFormatted}</div>
            </li>`;
  }
}
if (customElements.get('cagov-announcement-list') === undefined) {
  window.customElements.define("cagov-announcement-list", CAGovAnnoucementList);
}