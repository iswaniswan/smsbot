<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
/* @var $referrer string */
?>

<?= '<?php' ?> $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'wrapper' => 'col-sm-4',
            'error' => '',
            'hint' => '',
        ],
    ]
]); ?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form card card-primary">

    <div class="card-header">
        <h3 class="card-title">Form <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)); ?></h3>
    </div>
	<div class="card-body">

        <?= '<?=' ?> $form->errorSummary($model) ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo '        <?= ' . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
        <?= '<?='; ?> Html::hiddenInput('referrer', $referrer) ?>

	</div>
    <div class="card-footer">
        <div class="col-sm-offset-2 col-sm-3">
            <?= '<?= ' ?>Html::submitButton('<i class="fa fa-check"></i> Simpan', ['class' => 'btn btn-success btn-flat']) ?>
        </div>
    </div>

</div>

<?= '<?php ' ?>ActiveForm::end(); ?>
