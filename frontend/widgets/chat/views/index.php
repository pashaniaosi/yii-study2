<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 14:22
 */

use yii\helpers\Url;
?>
<div class="panel">
<div class="panel-title box-title">
    <span><strong>只言片语</strong></span>
    <span class="pull-right"><a href="#" class="font-12">更多>></a></span>
</div>
<div class="panel-boy">
<form id="w0" action="/" method="post">
    <div class="form-group input-group field-feed-content required">
        <textarea id="feed-content" class="form-control" name="content" placeholder="我的留言" rows="" cols=""></textarea>
        <span class="input-group-btn">
            <button type="button" data-url="<?=Url::to(['site/add-feed'])?>" class='btn btn-success btn-feed j-feed'>发布</button>
        </span>
    </div>
</form>
<?php if(!empty($data['feed'])):?>
        <ul class="media-list media-feed feed-index ps-container ps-active-y">
            <?php foreach($data['feed'] as $list):?>
                <li class="media">
                    <div class="media-left">
                        <a href="#" rel="author" data-original-title="" title="">
                            <img alt="" class="avatar-img" style="width:37px;height:37px;" src="/images/avatar/default.jpg"/>
<!--                            --><?//=$list['user']['avatar'];?>
                        </a>
                    </div>
                    <div class="media-body">
                        <div class="media-content">
                            <a href="#" rel="author" data-original-title="" title=""></a>
                            <?=$list['user']['username']?>说:<?=$list['content']?>
                        </div>
                        <div class="media-action">
                            <?=date('Y-m-d h:i:s',$list['created_at'])?>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
    <?php endif;?>
</div>
</div>