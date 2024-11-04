import { loadMoreReplies } from "./api.js";

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".load-more-replies").forEach((button) => {
    button.addEventListener("click", function () {
      const commentId = this.getAttribute("data-id");
      loadMoreReplies(commentId, this);
    });
  });
});
