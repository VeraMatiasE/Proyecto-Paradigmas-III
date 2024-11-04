<?php
function getIdFromSlug(PDO $pdo, string $slug): int
{
    $sql = "SELECT id_post FROM posts
                WHERE slug = :slug";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['id_post'];
}
function getMainComments(PDO $pdo, int $id_post, int $offset = 0, int $limit = 5, ?int $id_user = null): array
{
    $sql = "SELECT c.id_comment, c.id_reply, c.like_count, c.dislike_count, u.username, c.content, c.created_at,
                   IFNULL(cl.like_type, '') AS user_reaction
            FROM comments AS c
            LEFT JOIN users AS u ON u.id_user = c.id_user
            LEFT JOIN comment_likes AS cl ON cl.id_comment = c.id_comment AND cl.id_user = :id_user
            WHERE c.id_post = :id_post AND c.id_reply IS NULL
            LIMIT :offset, :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRepliesWithLimit(PDO $pdo, int $id_comment, int $depth = 1, int $maxDepth = 3, ?int $id_user = null): array
{
    if ($depth > $maxDepth) {
        return [
            'link' => true,
            'id_comment' => $id_comment
        ];
    }

    $sql = "SELECT c.id_comment, c.id_reply, c.like_count, c.dislike_count, u.username, c.content, c.created_at,
            IFNULL(cl.like_type, '') AS user_reaction
            FROM comments AS c
            LEFT JOIN users AS u ON u.id_user = c.id_user
            LEFT JOIN comment_likes AS cl ON cl.id_comment = c.id_comment AND cl.id_user = :id_user
            WHERE id_reply = :id_comment";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
    $stmt->execute();
    $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($replies as &$reply) {
        $reply['replies'] = getRepliesWithLimit($pdo, $reply['id_comment'], $depth + 1, $maxDepth, $id_user);
    }

    return $replies;
}

function getFormattedDate($datetime)
{
    try {
        $dateTimeObj = new DateTime($datetime, new DateTimeZone('America/Argentina/Buenos_Aires'));

        $dateFormatted = IntlDateFormatter::formatObject(
            $dateTimeObj,
            'eeee d MMMM y, HH:mm',
            'es'
        );

        return htmlspecialchars(ucwords($dateFormatted), ENT_QUOTES, 'UTF-8');

    } catch (Exception $e) {
        return 'Fecha inválida';
    }
}
function renderComments(array $comments, int $maxDepth = 3): void
{
    foreach ($comments as $comment) {
        $likeSelected = ($comment['user_reaction'] === 'like') ? 'selected' : '';
        $dislikeSelected = ($comment['user_reaction'] === 'dislike') ? 'selected' : '';
        ?>
        <div class="response" data-id="<?php echo $comment['id_comment']; ?>">
            <div class="response-header">
                <p class="author"><?php echo htmlspecialchars($comment['username'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="date">
                    <?php echo getFormattedDate($comment['created_at']) ?>
                </p>
            </div>
            <div class="response-content">
                <p><?php echo htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div class="response-actions">
                <?php if (isset($_SESSION["id_user"])): ?>
                    <button class="toggle-reply button-background">Responder</button>
                    <button class="reaction-button like-button <?= $likeSelected; ?>"
                        data-comment-id="<?= $comment['id_comment']; ?>">
                        <img src="/images/Forum/like.svg">(<span
                            id="like-count-<?= $comment['id_comment']; ?>"><?= $comment['like_count']; ?></span>)
                    </button>
                    <button class="reaction-button dislike-button <?= $dislikeSelected; ?>"
                        data-comment-id="<?= $comment['id_comment']; ?>">
                        <img src="/images/Forum/dislike.svg">(<span
                            id="dislike-count-<?= $comment['id_comment']; ?>"><?= $comment['dislike_count']; ?></span>)
                    </button>
                <?php else: ?>
                    <button class="toggle-reply button-background" disabled>Responder</button>
                    <button class="reaction-button like-button" data-comment-id="<?= $comment['id_comment']; ?>" disabled>
                        <img src="/images/Forum/like.svg">(<span
                            id="like-count-<?= $comment['id_comment']; ?>"><?= $comment['like_count']; ?></span>)
                    </button>
                    <button class="reaction-button dislike-button" data-comment-id="<?= $comment['id_comment']; ?>" disabled>
                        <img src="/images/Forum/dislike.svg">(<span
                            id="dislike-count-<?= $comment['id_comment']; ?>"><?= $comment['dislike_count']; ?></span>)
                    </button>
                <?php endif; ?>
            </div>
            <?php
            if (!empty($comment['replies'])) {
                if (isset($comment['replies']['link']) && $comment['replies']['link'] === true) {
                    echo "<button class='load-more-replies' data-id='{$comment['id_comment']}'>Cargar más respuestas</button>";
                } else {
                    echo "<div class='sub-responses'>";
                    renderComments($comment['replies'], $maxDepth);
                    echo "</div>";
                }
            }
            ?>
        </div>
        <?php
    }
}