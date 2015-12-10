<div>
    <label for="title"><?= elgg_echo("title"); ?></label><br />
    <?= elgg_view('input/text', ['name' => 'title', 'id' => 'title']); ?>
</div>

<div>
    <label for="body"><?= elgg_echo("body"); ?></label><br />
    <?= elgg_view('input/longtext', ['name' => 'body', 'id' => 'body']); ?>
</div>

<div>
    <label for="tags"><?= elgg_echo("tags"); ?></label><br />
    <?= elgg_view('input/tags', ['name' => 'tags', 'id' => 'tags']); ?>
</div>

<div>
    <?= elgg_view('input/submit', ['value' => elgg_echo('save')]); ?>
</div>