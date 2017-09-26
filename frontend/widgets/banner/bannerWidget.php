<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 10:23
 */
namespace frontend\widgets\banner;

use yii\bootstrap\Widget;

class bannerWidget extends Widget
{
    public $items = [];

    public function init()
    {
        if(empty($this->items)) {
//            给予轮播图一个初始图片
            $this->items = [
                [
                    'label' => 'demo',
                    'image_url' => '/statics/images/banner/b_0.jpg',
                    'url' => ['site/index'],
                    'html' => '',
                    'active' => 'active',
                ],
                [
                    'label' => 'demo',
                    'image_url' => '/statics/images/banner/b_1.jpg',
                    'url' => ['site/index'],
                    'html' => '',

                ],
                [
                    'label' => 'demo',
                    'image_url' => '/statics/images/banner/b_2.jpg',
                    'url' => ['site/index'],
                    'html' => '',

                ],
            ];
        }
    }

    public function run()
    {
        $data['items'] = $this->items;
        return $this->render('index', ['data' => $data]);
    }
}