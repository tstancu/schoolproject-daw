<!-- article-card.php -->
<div class="col-md-4 mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $article['title'] ?></h5>
            <p class="card-text"><?= $article['content'] ?></p>
            <?php if ($article['subscription_level_id'] == 2): ?>
                <span class="badge bg-primary">Premium</span>
            <?php endif; ?>
        </div>
    </div>
</div>