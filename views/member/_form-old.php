<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Member */
/* @var $form yii\widgets\ActiveForm */
/* @var $referrer string */
?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'wrapper' => 'col-sm-10',
            'error' => '',
            'hint' => '',
        ],
    ]
]); ?>

<div class="row">
    <div class="container-fluid">
        <div class="member-form card-box">
            <div class="card-body">
                <div class="mb-4">
                    <h4 class="card-title">Form Member</h4>
                </div>


                <?= $form->errorSummary($model) ?>

                <?= $form->field($model, 'id_user')->textInput() ?>

                <?= $form->field($model, 'id_paket')->textInput() ?>

                <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'no_ktp')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'id_reff_kotakab')->textInput() ?>

                <?= $form->field($model, 'id_reff_provinsi')->textInput() ?>

                <?= $form->field($model, 'kotakab')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'provinsi')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'kodepos')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'rekening')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'rekening_an')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'refferal_code')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'id_member_sponsor')->textInput() ?>

                <?= $form->field($model, 'id_member_upline')->textInput() ?>

                <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'is_verified')->textInput() ?>

                <?= $form->field($model, 'is_active')->textInput() ?>

                <?= $form->field($model, 'date_active')->textInput() ?>

                <?= $form->field($model, 'date_created')->textInput() ?>

                <?= $form->field($model, 'is_deleted')->textInput() ?>

                <?= Html::hiddenInput('referrer', $referrer) ?>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="container-fluid">
        <?= Html::submitButton('<i class="fa fa-check"></i> Simpan', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
