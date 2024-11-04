export function throttle(func, limit) {
    let lastFunc;
    let lastRan;

    return function(...args) {
        const context = this;

        if (!lastRan) {
            func.apply(context, args);
            lastRan = Date.now();
        } else {
            clearTimeout(lastFunc);
            lastFunc = setTimeout(function() {
                if ((Date.now() - lastRan) >= limit) {
                    func.apply(context, args);
                    lastRan = Date.now();
                }
            }, limit - (Date.now() - lastRan));
        }
    };
}

export function handleReaction() {
    const commentId = this.dataset.commentId;
    const likeType = this.classList.contains('like-button') ? 'like' : 'dislike';

    fetch('/api/forum/likes_dislikes.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_comment: commentId, like_type: likeType })
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector(`#like-count-${commentId}`).innerText = data.likes;
        document.querySelector(`#dislike-count-${commentId}`).innerText = data.dislikes;

        const likeButton = document.querySelector(`.like-button[data-comment-id='${commentId}']`);
        const dislikeButton = document.querySelector(`.dislike-button[data-comment-id='${commentId}']`);

        if (data.userReaction === 'like') {
            likeButton.classList.add('selected');
            dislikeButton.classList.remove('selected');
        } else if (data.userReaction === 'dislike') {
            dislikeButton.classList.add('selected');
            likeButton.classList.remove('selected');
        } else {
            likeButton.classList.remove('selected');
            dislikeButton.classList.remove('selected');
        }
    });
};

export const defaultTimeReaction = 1000;

document.querySelectorAll('.reaction-button').forEach(button => {
    const throttledReaction = throttle(handleReaction, defaultTimeReaction);
    button.addEventListener('click', throttledReaction);
});