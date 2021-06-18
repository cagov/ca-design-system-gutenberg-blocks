/**
 * News List web component
 * Supported endpoints: Wordpress v2
 * Wordpress Dependencies: window.wp.moment.
 */
class CAGovPostList extends window.HTMLElement {
  connectedCallback() {
    let siteUrl = window.location.origin;
    this.endpoint = this.dataset.endpoint || `${siteUrl}/wp-json/wp/v2`;
    this.order = this.dataset.order || "desc";
    this.count = this.dataset.count || "10";
    this.category = this.dataset.category || "announcements,press-releases";
    this.showExcerpt = this.dataset.showExcerpt || true;
    this.showPublishedDate = this.dataset.showPublishedDate || true;
    this.type = this.dataset.type || "wordpress";
    if (this.type === "wordpress") {
      this.getWordpressPosts();
    }
  }

  getWordpressPosts() {
    if (this.endpoint !== undefined) {
      if (this.category.indexOf(",") > -1) {
        this.category = this.category.split(",");
      } else {
        this.category = [this.category];
      }

      let categoryEndpoint = `${this.endpoint}/categories?slug=${this.category}`;

      // console.log("category endpoint", categoryEndpoint, this.dataset);

      // Get data
      window
        .fetch(categoryEndpoint)
        .then((response) => response.json())
        .then(
          function (data) {
            let categoryIds = data.map((item) => {
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
        return `<div class="post-list-items">${renderedPosts.join("")}</div>`;
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
    excerpt = null, // @TODO shorten / optional
    // author = null, // 1
    // featured_media = null, // 0
  }) {
    let dateFormatted;
    if (date !== null && window.moment !== undefined) {
      dateFormatted = moment(date).format("MMMM DD, YYYY");
    }

    let getExcerpt = this.showExcerpt === "true" ? `<div class="excerpt"><p>${excerpt.rendered}</p></div>` : ``;

    console.log("this.showPublishedDate", this.showPublishedDate);
    let getDate = this.showPublishedDate === "true" ? `<div class="date">${dateFormatted}</div>` : ``;

    return `<div class="post-list-item">
                <div class="link-title"><a href="${link}">
                    ${title.rendered}
                </a></div>
                ${getExcerpt}
                ${getDate}
            </div>`;
  }
}

if (customElements.get("cagov-post-list") === undefined) {
  window.customElements.define("cagov-post-list", CAGovPostList);
}
