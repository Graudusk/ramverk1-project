<article class="questionSummary">
    <h3><a href="<?= url("question/show/{$item->slug}"); ?>"><?= $item->title ?></a></h3>
    <p>
        Posted <small><?= $item->created ?></small> by <a href="<?= url("user/view/{$item->user}")?>"><strong><?= $item->name ?></strong></a>
    </p>
    <?php if ($item->updated): ?>
        <p>
            Updated <small><?= $item->updated ?></small>
        </p>
    <?php endif ?>
    <?php if ($item->tags): ?>
        <div class="tags">
            <?php foreach ($item->tags as $tag): ?>
                <a href="<?= url("question/tag/{$tag->slug}")?>" class="tag btn"><?=$tag->tag?>&nbsp;<i class="fas fa-tag"></i></a>
            <?php endforeach ?>
        </div>
        
    <?php endif ?>
</article>
