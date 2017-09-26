<?php
/**
 * Created by PhpStorm.
 * User: lukace
 * Date: 9/25/17
 * Time: 3:44 PM
 */
use frontend\widgets\post\postWidget;
use frontend\widgets\hot\hotWidget;
use yii\helpers\Url;
use frontend\widgets\tag\tagWidget;
$this->title = "文章";
?>
<div class = "row">
    <div class="col-lg-9">
        <?php echo postWidget::widget([]); ?>
    </div>
    <div class="col-lg-3">
        <div class="panel">
            <?php if(!\Yii::$app->user->isGuest): ?>
                <a class="btn btn-success btn-block btn-post" href="<?php echo Url::to(['post/create']); ?>">创建文章</a>
            <?php endif;?>
        </div>
        <!-- 热门浏览 -->
        <?php echo hotWidget::widget(); ?>
        <!-- 标签云 -->
        <?php echo tagWidget::widget(); ?>
    </div>
</div>