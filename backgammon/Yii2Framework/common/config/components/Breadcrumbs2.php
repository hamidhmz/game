<?php
namespace common\config\components;
use Yii;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
class Breadcrumbs2 extends Breadcrumbs {
    public function run() {
        $links = [];
        $data = ['label' => Yii::t('base', 'Dashboard')];
        if (strpos(Yii::$app->request->url, 'dashboard') === false) {
            $data['url'] = ['/site/index'];
        }
        $links[] = $this->renderItem($data, isset($data['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag($this->tag, implode('', $links), $this->options);
    }
}