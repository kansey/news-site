<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\alert\AlertBlock;
$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to signup:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'login'); ?>
                <?= $form->field($model, 'password')->passwordInput(); ?>
                <?= $form->field($model, 'repeatPassword')->passwordInput(); ?>
                <?= $form->field($model, 'email')->input('email'); ?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php echo AlertBlock::widget([
                    'type' => AlertBlock::TYPE_ALERT,
                    'useSessionFlash' => true]);
                ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
