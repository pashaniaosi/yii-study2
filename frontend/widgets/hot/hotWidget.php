<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 15:53
 * 热门浏览
 */
namespace frontend\widgets\hot;

use common\models\PostExtend;
use common\models\Post;
use yii\bootstrap\Widget;
use yii\db\Query;

class hotWidget extends Widget
{
    public $title = '';

    public $limit = 6;
    public function run()
    {
        $res = (new Query())
            ->select('a.browser, b.id, b.title')
            ->from(['a'=>PostExtend::tableName()])
            ->join('LEFT JOIN',['b'=>Post::tableName()],'a.post_id = b.id')
            ->where('b.is_valid ='.Post::IS_VALID)
            ->orderBy('browser DESC, id DESC')
            ->limit($this->limit)
            ->all();

        $result['title'] = $this->title?:'热门浏览';
        $result['body'] = $res?:[];


        return $this->render('index', ['data' => $result]);
    }
}
