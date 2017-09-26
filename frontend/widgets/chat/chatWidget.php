<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 14:22
 * 留言板小插件
 */
namespace frontend\widgets\chat;

use frontend\models\FeedForm;
use Yii;
use yii\bootstrap\Widget;

class chatWidget extends Widget
{
    public function run()
    {
        $feed = new FeedForm();
        $data['feed'] = $feed -> getList();
        return $this->render('index', ['data' => $data]);
    }
}