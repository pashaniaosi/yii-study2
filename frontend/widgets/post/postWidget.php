<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 14:54
 * 自定义一个文章的小组件
 */
namespace frontend\widgets\post;

use common\models\Post;
use frontend\models\PostForm;
use Yii;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Url;

class postWidget extends Widget
{
//    文章列表的标题
    public $title = '';

//    显示每页的文章的数量, 默认显示 6 个
    public $limit = 6;

//    是否显示更多, 默认 true
    public $more = true;

//    是否显示分页, 默认 false
    public $page = true;

    public function run()
    {
//        获取当前页
        $curPage = Yii::$app->request->get('page', 1); //获取当前页, 如果没有, 则赋 page 为值 1
//        查询条件: 该文章是否有效
        $condition = ['=', 'is_valid', Post::IS_VALID];

//        查询数据
        $res = PostForm::getList($condition, $curPage, $this->limit);
        $result['title'] = $this->title?:"最新文章"; // 如果有标题就使用原来的标题, 如果没有标题就为"最新文章"
        $result['more'] = Url::to(['post/index']); // 是否要显示更多, 该操作类似于刷新操作
        $result['body'] = $res['data']?:[]; // 获取文章主体, 没有就为空数组

//        是否显示分页
        if ($this->page){
            $pages = new Pagination(['totalCount' => $res['count']/* 获取有效文章的数量 */, 'pageSize' => $res['pageSize']/* 获取每页的数目 */]);
            $result['page'] = $pages;
        }
        return $this->render('index',['data' => $result]);
    }
}