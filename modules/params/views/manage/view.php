Params:
<div class="well well-sm">
    <code>
    <?php foreach (Yii::$app->params as $k => $v): ?>
        <p><?= $k ?> => <?= $v ?></p>
    <?php endforeach; ?>
    </code>
</div>