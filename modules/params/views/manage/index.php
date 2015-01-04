<div class="params-default-index">
    <h5>DB params:</h5>

    <div class="well well-sm">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dbParams,
        ]); ?>
    </div>

    <h5>Config file params:</h5>

    <div class="well well-sm">
        <?= \yii\grid\GridView::widget([
            // TODO: move logic into Params component
            'dataProvider' => $fileParams
        ]); ?>
    </div>
</div>