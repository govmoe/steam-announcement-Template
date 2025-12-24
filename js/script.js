// Steam公告主题JavaScript文件

// 页面加载完成后执行
document.addEventListener("DOMContentLoaded", function () {
  // 平滑滚动效果
  smoothScroll();

  // 导航菜单交互
  initNavigation();

  // 搜索框交互
  initSearch();

  // 卡片悬停效果
  initCardHover();

  // 响应式导航
  initResponsiveNav();

  // 初始化评论模块
  initComments();
});

// 平滑滚动函数
function smoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });
}

// 初始化导航菜单
function initNavigation() {
  const navLinks = document.querySelectorAll(".nav-link");
  navLinks.forEach((link) => {
    link.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-2px)";
    });

    link.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)";
    });
  });
}

// 初始化搜索框
function initSearch() {
  const searchInput = document.querySelector(".search-input");
  if (searchInput) {
    searchInput.addEventListener("focus", function () {
      this.parentElement.style.boxShadow = "0 0 0 2px rgba(102, 192, 244, 0.2)";
    });

    searchInput.addEventListener("blur", function () {
      this.parentElement.style.boxShadow = "none";
    });
  }
}

// 卡片悬停效果
function initCardHover() {
  const cards = document.querySelectorAll(".announcement-card");
  cards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-4px)";
      this.style.boxShadow = "0 8px 24px rgba(0, 0, 0, 0.3)";
    });

    card.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)";
      this.style.boxShadow = "0 4px 16px rgba(0, 0, 0, 0.2)";
    });
  });
}

// 响应式导航
function initResponsiveNav() {
  const navMenu = document.querySelector(".nav-menu");
  const navToggle = document.querySelector(".nav-toggle");

  if (navToggle) {
    navToggle.addEventListener("click", function () {
      navMenu.classList.toggle("active");
      this.classList.toggle("active");
    });
  }
}

// 加载更多功能
function loadMore() {
  // 这里可以添加加载更多文章的逻辑
  console.log("加载更多文章");
}

// 回到顶部按钮
function initBackToTop() {
  const backToTop = document.querySelector(".back-to-top");
  if (!backToTop) {
    return;
  }

  window.addEventListener("scroll", function () {
    if (window.pageYOffset > 300) {
      backToTop.classList.add("visible");
    } else {
      backToTop.classList.remove("visible");
    }
  });

  backToTop.addEventListener("click", function (e) {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
}

// 文章阅读进度
function initReadingProgress() {
  const progressBar = document.querySelector(".reading-progress");
  if (!progressBar) {
    return;
  }

  window.addEventListener("scroll", function () {
    const winScroll =
      document.body.scrollTop || document.documentElement.scrollTop;
    const height =
      document.documentElement.scrollHeight -
      document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    progressBar.style.width = scrolled + "%";
  });
}

// 添加评论功能
function initComments() {
  const commentForm = document.querySelector(".comment-form");
  if (!commentForm) {
    console.log("没有找到评论表单");
    return;
  } else {
    console.log(commentForm);
    console.log("评论表单已找到");
  }

  commentForm.addEventListener("submit", function (e) {
    // 这里可以添加评论提交前的验证逻辑
    console.log("评论提交");
  });
}

// 分享功能
function initShare() {
  const shareButtons = document.querySelectorAll(".share-button");
  shareButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const url = window.location.href;
      const title = document.title;
      const platform = this.dataset.platform;

      let shareUrl = "";
      switch (platform) {
        case "twitter":
          shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(
            url
          )}&text=${encodeURIComponent(title)}`;
          break;
        case "facebook":
          shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
            url
          )}`;
          break;
        case "reddit":
          shareUrl = `https://www.reddit.com/submit?url=${encodeURIComponent(
            url
          )}&title=${encodeURIComponent(title)}`;
          break;
        default:
          return;
      }

      window.open(shareUrl, "_blank", "width=600,height=400");
    });
  });
}

// 图片懒加载
function initLazyLoad() {
  if ("IntersectionObserver" in window) {
    const lazyImages = document.querySelectorAll("img.lazy");
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const image = entry.target;
          image.src = image.dataset.src;
          image.classList.remove("lazy");
          imageObserver.unobserve(image);
        }
      });
    });

    lazyImages.forEach((image) => {
      imageObserver.observe(image);
    });
  }
}

// 代码高亮初始化
function initCodeHighlight() {
  // 这里可以添加代码高亮的初始化逻辑
  // 例如使用Prism.js或Highlight.js
  console.log("代码高亮初始化");
}
