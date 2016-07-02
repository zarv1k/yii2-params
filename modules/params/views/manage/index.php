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
            'dataProvider' => $fileParams,
            'columns' => [
                'id',
                'scope',
                'code',
                'description',
                [
                    'attribute' => 'value',
                    'format' => 'raw',
                    'value' => function($data) {
                        if (is_array($data['value'])) {
                            return json_encode($data['value'], JSON_PRETTY_PRINT);
                        }
                        return $data['value'];
                    }
                ],
                'validation',
                'created',
                'updated',
            ]
        ]); ?>
    </div>
</div>