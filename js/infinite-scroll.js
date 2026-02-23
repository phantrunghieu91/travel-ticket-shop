document.addEventListener('DOMContentLoaded', () => {
  const lastPost = document.querySelector(`.${infiniteScroll.observerClass}:last-child`);
  const lastPostContainer = lastPost?.parentElement;
  let currentPage = 2;
  const maxPage = lastPostContainer?.dataset.maxPage;

  /**
   * Object representing the fetching state and behavior.
   * @namespace fetchingObj
   */
  const fetchingObj = (function () {
    let isFetching = false;
    let loadingElement = null;

    /**
     * Get the current fetching state.
     * @memberof fetchingObj
     * @returns {boolean} The current fetching state.
     */
    function getIsFetching() {
      return isFetching;
    }

    /**
     * Toggle the fetching state and perform loading or remove loading element accordingly.
     * @memberof fetchingObj
     */
    function toggleFetching() {
      isFetching = !isFetching;
      if (isFetching) {
        loading();
      } else {
        removeLoading();
      }
    }

    /**
     * Create and append a loading element to the last post container.
     * @memberof fetchingObj
     */
    function loading() {
      loadingElement = document.createElement('div');
      loadingElement.classList.add('loading');
      loadingElement.textContent = 'Loading...';
      lastPostContainer.appendChild(loadingElement);
    }

    /**
     * Remove the loading element from the last post container.
     * @memberof fetchingObj
     */
    function removeLoading() {
      if (loadingElement) {
        lastPostContainer.removeChild(loadingElement);
        loadingElement = null;
      }
    }

    return {
      getIsFetching: getIsFetching,
      toggleFetching: toggleFetching,
    };
  })();

  /**
   * Fetches posts from the server.
   * @returns {Promise<Object>} A promise that resolves to the fetched posts.
   */
  const fetchPosts = async () => {
    // console.log(`isFetching: ${fetchingObj.getIsFetching()}, currentPage: ${currentPage}, maxPage: ${maxPage}`);
    if (fetchingObj.getIsFetching() || currentPage > maxPage) {
      return;
    }
    let fetchUrl = `${infiniteScroll.fetchUrl}?action=load_more_posts&page=${currentPage}&posts_per_page=${infiniteScroll.postsPerPage}&obj_id=${infiniteScroll.objId}&nonce=${infiniteScroll.nonce}&type=${infiniteScroll.type}&date_format=${infiniteScroll.dateFormat}`;
    fetchingObj.toggleFetching();
    try {
      const response = await fetch(fetchUrl);
      if (!response.ok) {
        console.error('Error fetching posts', response.status, response.statusText);
        return;
      }
      currentPage++;
      return await response.json();
    } catch (error) {
      console.error('Catch error fetching posts', error);
    }
  };

  /**
   * Renders the posts on the page.
   * 
   * @param {Array} posts - An array of post objects.
   * @returns {void}
   */
  const renderPosts = async posts => {
    const fragment = document.createDocumentFragment();
    posts.forEach(post => {
      // if post already exists, skip
      if(lastPostContainer.querySelector(`[data-post="${post.id}"]`)) {
        return;
      }

      const article = document.createElement('article');
      article.classList.add(infiniteScroll.observerClass);
      article.dataset.post = post.id;

      const postThumbLink = document.createElement('a');
      postThumbLink.classList.add(`${infiniteScroll.observerClass}-image`);
      postThumbLink.href = post.permalink;
      const postThumb = document.createElement('img');
      postThumb.src = post.thumbnail ? post.thumbnail : 'https://via.placeholder.com/300x200';
      postThumb.alt = post.title;
      postThumbLink.appendChild(postThumb);

      const postHeader = document.createElement('header');
      postHeader.classList.add(`${infiniteScroll.observerClass}-header`);
      const postTitle = document.createElement('a');
      postTitle.classList.add(`${infiniteScroll.observerClass}-title`);
      postTitle.href = post.permalink;
      postTitle.textContent = post.title;
      const postMeta = document.createElement('div');
      postMeta.classList.add(`${infiniteScroll.observerClass}-meta`);
      const postDate = document.createElement('span');
      postDate.classList.add(`${infiniteScroll.observerClass}-date`);
      postDate.textContent = post.date;
      postMeta.appendChild(postDate);
      postHeader.append(postTitle, postMeta);

      const postExcerpt = document.createElement('p');
      postExcerpt.classList.add(`${infiniteScroll.observerClass}-excerpt`);
      postExcerpt.textContent = post.excerpt;

      article.append(postThumbLink, postHeader, postExcerpt);
      fragment.appendChild(article);
    });
    lastPostContainer.appendChild(fragment);
  };

  // observer for infinite scroll
  const infiniteObserver = new IntersectionObserver(
    async entries => {
      // last entry = first entry since we only observe one element
      const lastEntry = entries[0];
      if (!lastEntry.isIntersecting) {
        return;
      }
      const data = await fetchPosts();
      if (data && data.success && data.data.length > 0) {
        renderPosts(data.data);
        fetchingObj.toggleFetching();
        infiniteObserver.unobserve(lastPost);
        infiniteObserver.observe(document.querySelector(`.${infiniteScroll.observerClass}:last-child`));
      }
    },
    {
      threshold: 0,
      rootMargin: '300px',
    }
  );
  lastPost && infiniteObserver.observe(lastPost);
});
