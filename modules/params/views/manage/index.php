<!--<div class="params-default-index">
    <h1><?/*= $this->context->action->uniqueId */?></h1>
    <p>
        This is the view content for action "<?/*= $this->context->action->id */?>".
        The action belongs to the controller "<?/*= get_class($this->context) */?>"
        in the "<?/*= $this->context->module->id */?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?/*= __FILE__ */?></code>
    </p>
</div>
-->

<div class="params-default-index">
    <h5>DB params:</h5>
    <div class="well well-sm">
        <?=\yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => \zarv1k\params\models\Params::find(),
            ])
        ]);
        ?>
    </div>

    <h5>Config file params:</h5>
    <div class="well well-sm">
        <?=\yii\grid\GridView::widget([
            // TODO: move logic into Params component
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'allModels' => array_map(
                    function($key) {
                        $scopeSeparatorPos = strpos($key, '.');
                        return [
                            'scope' => $scopeSeparatorPos === false ? 'NULL' : substr($key, 0, $scopeSeparatorPos),
                            'code' => $scopeSeparatorPos === false ? $key : substr($key, $scopeSeparatorPos+1, strlen($key)),
                            'value' => Yii::$app->params[$key]
                        ];
                    },
                    array_keys(Yii::$app->params)
                ),
                // TODO: add pagination and sort
            ])
        ]);
        ?>
    </div>
</div>