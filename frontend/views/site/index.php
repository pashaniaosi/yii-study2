<?php

/* @var $this yii\web\View */

use frontend\widgets\banner\bannerWidget;
use frontend\widgets\post\postWidget;
use frontend\widgets\chat\chatWidget;
use frontend\widgets\hot\hotWidget;
use frontend\widgets\tag\tagWidget;

$this->title = '博客-首页';
?>

<div class="row">
    <div class="col-lg-9">
        <!-- 图片轮播　-->
        <?php echo bannerWidget::widget(); ?>
        <!-- 文章列表 -->
        <?php echo postWidget::widget();?>
    </div>
    <div class="col-lg-3">
        <!-- 留言板 -->
        <?php echo chatWidget::widget() ;?>
        <!-- 热门浏览 -->
        <?php echo hotWidget::widget() ;?>
        <!-- 标签云　-->
        <?php echo tagWidget::widget() ;?>
    </div>
</div>

