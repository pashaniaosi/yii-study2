<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('common', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填入下列内容完成注册:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

<!--            能否立即显示用户名已被使用-->
                <?= $form->field($model, 'username', [
                        'inputOptions' => [
                                'placeholder' => '请输入用户名',
                        ]
                ])->textInput(['autofocus' => true]) ?>

<!--            能否立即显示邮箱已被使用-->
                <?= $form->field($model, 'email', [
                        'inputOptions' => [
                                'placeholder' => '请输入邮箱',
                        ]
                ]) ?>

                <?= $form->field($model, 'password', [
                        'inputOptions' => [
                                'placeholder' => '请输入密码',
                        ]
                ])->passwordInput() ?>

<!--            重复密码报错有问题-->
                <?= $form->field($model, 'rePassword', [
                    'inputOptions' => [
                        'placeholder' => '请再次输入密码',
                    ]
                ])->passwordInput() ?>

                <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className()) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('common','Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
