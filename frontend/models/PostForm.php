<?php
/**
 * Created by PhpStorm.
 * User: lukace
 * Date: 9/26/17
 * Time: 3:11 PM
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use common\models\Post;
use common\models\RelationPostTag;

class PostForm extends Model
{
    public $id;
    public $tag;
    public $cat_id;
    public $label_img;
    public $title;
    public $content;
//    记录最新的错误
    public $_lastError;
    /**
     * 定义场景
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * 定义事件
     * EVENT_AFTER_CREATE 创建之后的事件
     * EVENT_AFTER_UPDATE 更新之后的事件
     */
    const EVENT_AFTER_CREATE = 'eventAfterCreate';
    const EVENT_AFTER_UPDATE = 'eventAfterUpdate';
    /**
     * @return array
     * 场景设置
     */
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIO_CREATE => ['title', 'content', 'label_img', 'tag', 'cat_id'],
            self::SCENARIO_UPDATE => ['title', 'content', 'label_img', 'tag', 'cat_id'],
        ];
        return array_merge(parent::scenarios(), $scenarios);
    }
    public function rules()
    {
        return [
            [['id', 'cat_id', 'title', 'content'], 'required'],
            ['title', 'string', 'min' => 4, 'max' => 20],
            [['id', 'cat_id'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id'=>Yii::t('common', 'ID'),
            'tag' => Yii::t('common', 'Tag'),
            'cat_id' => Yii::t('common', 'Cat ID'),
            'label_img' => Yii::t('common', 'Label Img'),
            'title' => Yii::t('common', 'Title'),
            'content' => Yii::t('common', 'Content'),
        ];
    }
    /**
     * @return bool
     * 文章创建
     */
    public function create()
    {
//        事务
        $transaction= Yii::$app->db->beginTransaction();
        try{
            $model = new Post();
            $model->setAttributes($this->attributes);
//            获取文章的简介
            $model->summary = $this->_getSummary();
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->is_valid = Post::IS_VALID;
            $model->created_at = time();
            $model->updated_at = time();
            if(!$model->save())
                throw new \Exception(Yii::t('app', '文章保存失败'));
            $this->id = $model->id;
//            调用事件
//            事件该调用的数据
            $data = array_merge($this->getAttributes(), $model->getAttributes());
            $this->_eventAfterCreate($data); // 该事件定义创建完文章后的该干的事
            $transaction->commit();
            return true;
        } catch (\Exception $e){
            $this->_lastError = $e->getMessage();
            $transaction->rollBack();
            return false;
        }
    }
    /**
     * @param int $start
     * @param int $end
     * @param string $charset
     * @return null|string
     * 截取文章摘要
     */
    private function _getSummary($start = 0, $end = 90, $charset = 'utf-8')
    {
//        如果没有文章, 就返回空值
        if(empty($this->content))
            return null;
//        返回文章的简介, 同时替换掉文章中的空格、标签等字符
        return (mb_substr(str_replace('&nbsp;', ' ', strip_tags($this->content)), $start, $end, $charset));
    }
    /**
     * @param $data
     * 创建文章之后的事件
     */
    public function _eventAfterCreate($data)
    {
//        添加事件, 文章创建后, 可以添加标签, 可以添加分类等等
//        添加标签
        $this->on(self::EVENT_AFTER_CREATE, [$this, '_eventAddTag'], $data); // 调用自身的方法实现事件的添加
//        触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }
    /**
     * 添加标签的方法
     */
    public function _eventAddTag($event)
    {
//        保存标签
        $tag = new TagForm();
        $tag -> tags = $event->data['tag'];
        $tagids = $tag -> saveTags(); // 返回一个标签数组
//        删除原先的关联关系, 如果是对一个已有的文章更改其标签, 便需要将其原有的标签删除
        RelationPostTag::deleteAll(['post_id' => $event->data['id']]);
//        批量保存文章和标签的关联关系, 因为 post_id 和 tag_id 可能是多对多的关系
        if(!empty($tagids))
        {
            foreach ($tagids as $key => $id)
            {
                $row[$key]['post_id'] = $this->id;
                $row[$key]['tag_id'] = $id;
            }
//            批量插入
            $result = (new Query())->createCommand()
                ->batchInsert(RelationPostTag::tableName(), ['post_id', 'tag_id'], $row)
                ->execute();
//            插入结果
            if(!$result)
                throw new \Exception(Yii::t('common', '关联数组保存失败!'));
        }
    }
    /**
     * 格式化数据
     */
    public static function _formatList($data)
    {
        foreach ($data as &$list)
        {
            $list['tags'] = [];
            if(isset($list['relate']) && !empty($list['relate']))
            {
                foreach ($list['relate'] as $item) {
                    $list['tags'][] = $item['tag']['tag_name'];
                }
            }
            unset($list['relate']);
        }
        return $data;
    }
    /**
     * 通过 post_id 来获取视图的信息
     */
    public function getViewById($post_id)
    {
//        获取数据
        $data = Post::find()
            ->with('relate.tag', 'extend')
            ->where(['id' => $post_id])
            ->asArray()
            ->one(); // relate 用来访问和 post 关联的数据库 relation_post_tags, relate.tag 用来关联和 post 二重关联的数据库 tags
        if(!$data)
        {
            throw new NotFoundHttpException(Yii::t('common', '文章不存在!'));
        }
//        处理标签
        $data['tags'] = [];
        if(isset($data['relate']) && !empty($data['relate']))
        {
            foreach ($data['relate'] as $list)
            {
                $data['tags'][] = $list['tag']['tag_name'];
            }
        }
//        去除数组中无用的数据
        unset($data['relate']);
        return $data;
    }
    /**
     * 查询文章列表数据
     */
    public static function getList($condition, $curPage = 1, $pageSize = 5, $orderBy = ['id' => SORT_DESC])
    {
        $model = new Post();
        $select = [
            'id', 'title', 'summary', 'label_img', 'cat_id', 'user_id', 'user_name', 'is_valid', 'created_at', 'updated_at'
        ];
        $query = $model
            ->find()
            ->select($select)
            ->where($condition)
            ->with('relate.tag', 'extend')
            ->orderBy($orderBy);
//        获取分页数据
        $res = $model->getPages($query, $curPage, $pageSize);
//        格式化数据, 满足对数据的要求
        $res['data'] = self::_formatList($res['data']);
        return $res;
    }
}