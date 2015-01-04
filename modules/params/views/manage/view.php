<div class="params-manage-view">
    Params (<?= Yii::$app->params->count() ?>):
    <div class="well well-sm">
        <code>
            <?php foreach (Yii::$app->params as $k => $v): ?>
                <p><?= $k ?> => <?= $v ?></p>
            <?php endforeach; ?>
        </code>
    </div>
</div>
