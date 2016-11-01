<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'form-create']); ?>
                    <?= $form->field($model, 'login'); ?>
                    <?= $form->field($model, 'password')->passwordInput(); ?>
                    <?= $form->field($model, 'email')->input('email'); ?>
                    <?= $form->field($model, 'status')->dropDownList([
                        '0' => 'moder',
                        '1' => 'admin'
                    ]); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

</div>
