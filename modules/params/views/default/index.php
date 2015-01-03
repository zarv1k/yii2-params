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
    <h5>Params:</h5>
    <?php echo Yii::$app->dbParam['adminEmail']?>


    <?php
        echo \yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => \zarv1k\params\models\Params::find(),
            ])
        ]);
    ?>
</div>