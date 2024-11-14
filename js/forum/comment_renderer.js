import {
  throttle,
  handleReaction,
  defaultTimeReaction,
} from "./likes_dislikes.js";

import { handleNewComment } from "./response.js";

import { getSlugPost } from "./api.js";

const throttledReaction = throttle(handleReaction, defaultTimeReaction);

function createElement(
  tag,
  { classes = [], attributes = {}, innerHTML = "" } = {}
) {
  const element = document.createElement(tag);
  element.classList.add(...classes);
  Object.entries(attributes).forEach(([key, value]) => {
    element.setAttribute(key, value);
  });
  element.innerHTML = innerHTML;
  return element;
}

function createReactionButton(type, comment, is_logged = false) {
  const button = createElement("button", {
    classes: [
      "reaction-button",
      `${type}-button`,
      comment.user_reaction === type ? "selected" : "",
    ].filter(Boolean),
    attributes: is_logged
      ? { "data-comment-id": comment.id_comment }
      : { "data-comment-id": comment.id_comment, disabled: "" },
    innerHTML: `<img src="${BASE_PATH}/images/Forum/${type}.svg">(<span id="${type}-count-${
      comment.id_comment
    }">${type === "like" ? comment.like_count : comment.dislike_count}</span>)`,
  });
  button.addEventListener("click", throttledReaction);
  return button;
}

export function createReplyElement(comment, slug, is_logged = false) {
  const commentElement = createElement("div", {
    classes: ["response"],
    attributes: { "data-id": comment.id_comment },
  });

  const header = createElement("div", {
    classes: ["response-header"],
    innerHTML: `
      <p class="author">${comment.username}</p>
      <p class="date">${comment.created_at}</p>
    `,
  });

  const content = createElement("div", {
    classes: ["response-content"],
    innerHTML: `<p>${comment.content}</p>`,
  });

  const actions = createElement("div", { classes: ["response-actions"] });

  const replyButton = createElement("button", {
    classes: ["toggle-reply", "button-background"],
    innerHTML: "Responder",
  });
  replyButton.addEventListener("click", handleNewComment);

  actions.append(
    replyButton,
    createReactionButton("like", comment, is_logged),
    createReactionButton("dislike", comment, is_logged)
  );

  commentElement.append(header, content, actions);

  if (comment.replies?.length) {
    const commentsContainer = createElement("div", {
      classes: ["sub-responses"],
    });
    comment.replies.forEach((subComment) =>
      commentsContainer.appendChild(
        createReplyElement(subComment, slug, is_logged)
      )
    );
    commentElement.appendChild(commentsContainer);
  }

  if (comment.replies?.link) {
    const linkButton = createElement("button", {
      classes: ["view-thread-button", "reaction-button"],
      innerHTML: "Ver conversación completa",
      attributes: {
        onclick: `window.location.href='${BASE_PATH}/pages/forum/discussion/${slug}/comments/${comment.id_comment}'`,
      },
    });
    commentElement.append(linkButton);
  }

  return commentElement;
}

export function renderNewComment(data, container, inside = true) {
  const newComment = createReplyElement(data, getSlugPost(), true);
  newComment.classList.add("highlight");

  if (inside) container.appendChild(newComment);
  else container.insertAdjacentElement("afterend", newComment);

  const offsetTop =
    newComment.getBoundingClientRect().top +
    window.scrollY -
    document.querySelector("header").offsetHeight;
  window.scrollTo({ top: offsetTop, behavior: "smooth" });
}
