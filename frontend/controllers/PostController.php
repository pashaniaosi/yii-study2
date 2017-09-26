<?php
/**
 * Created by PhpStorm.
 * User: lukace
 * Date: 9/25/17
 * Time: 3:42 PM
 */

namespace frontend\controllers;


use frontend\controllers\base\BaseController;
use common\models\Cat;
use common\models\PostExtend;
use frontend\models\PostForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
class PostController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'upload', 'ueditor'],
                'rules' => [
                    [
//                        roles 没有参数, 表示不管登陆状态都可以访问
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'upload', 'ueditor', ],
                        'allow' => true,
//                        @ 表示登陆了才能访问
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    表示所有方法都可以使用 get 、post 两种方式收集数据
                    '*' => ['get', 'post'],
                ],
            ],
        ];
    }
    /**
     * 上传头像和富文本编辑器
     * @return array
     */
    public function actions()
    {
        return [
//            上传图片
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/images/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/images/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }
    /**
     * @return string
     * 文章列表
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * 创建文章
     */
    public function actionCreate()
    {
        $model = new PostForm();
//        创建场景
        $model->setScenario(PostForm::SCENARIO_CREATE);
        if($model->load(Yii::$app->request->post())&&$model->validate()&&$model->create())
        {
//            文章创建成功, 则显示创建成功后的视图
            return $this->redirect(['post/view', 'id' => $model->id]);
        } else {
//            文章创建失败, 则显示错误信息
            Yii::$app->session->setFlash('warning', $model->_lastError);
        }
//        获取所有分类
        $cat = Cat::getAllCats();
        return $this->render('createPost',['model' => $model, 'cat' => $cat]);
    }
    /**
     * 文章详情界面
     */
    public function actionView($id)
    {
        $model = new PostForm();
//        通过文章的 id 来获取数据
        $data = $model->getViewById($id);
//        统计文章的浏览量
        $model = new PostExtend();
        $model->upCounter(['post_id' => $id], 'browser', 1);
        return $this->render('view', ['data' => $data]);
    }
}