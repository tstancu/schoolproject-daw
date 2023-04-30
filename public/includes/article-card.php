<!-- article-card.php -->
<div class="col-md-4 mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title font-weight-bold"><?= $article['title'] ?></h5>
            <p class="card-text"><?= substr($article['content'], 0, 200) . '...' ?></p>
            <?php if ($article['subscription_level_id'] == 2): ?>
                <span class="badge bg-primary">Premium</span>
            <?php endif; ?>
            <a href="article.php?title=<?= urlencode($article['title']) ?>" class="stretched-link"></a>
        </div>
    </div>
</div>