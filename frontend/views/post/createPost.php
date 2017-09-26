<?php
/**
 * Created by PhpStorm.
 * User: lukace
 * Date: 9/25/17
 * Time: 3:47 PM
 */

use yii\bootstrap\ActiveForm;
$this->title = Yii::t('app', '创建');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '文章'), 'url' => ['post/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="panel-title box-title">
            <span>创建文章</span>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin()?>

            <?php echo $form->field($model, 'title',[
                'inputOptions' => [
                    'placeholder' => '请输入标题',
                ]
            ])->textInput(['maxlength' => true]); ?>

            <?php echo $form->field($model, 'cat_id')->dropDownList($cat); ?>

            <?php echo $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
                'config' => [
//                        图片显示路径, 没有就是默认路径
                    'domain_url' => 'http://www.frontend.com',
                ]
            ]); ?>

            <?php echo $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
                'options' => [
                    'initialFrameHeight' => 400,
                ]
            ]); ?>

            <?php echo $form->field($model, 'tag')->widget('common\widgets\tags\TagWidget'); ?>

            <div class="form-group">
                <?php echo \yii\helpers\Html::submitButton('发布', ['class' => 'btn btn-success', 'name' => 'release-button']);?>
            </div>
            <?php ActiveForm::end()?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel-title box-title">
            <span>注意事项</span>
        </div>
        <div class="panel-body">
            <p>1. 不能发表任何有关黑框眼镜的话题</p>
            <p>2. 不能公开崇拜某位领导人</p>
        </div>
    </div>
</div>