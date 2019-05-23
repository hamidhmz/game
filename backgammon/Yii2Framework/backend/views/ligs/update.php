<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Ligs */

$this->title = Yii::t('app', 'Ligs').' / '. $model->title .' / '. Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ligs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] =  Yii::t('app', 'Update');
?>
<div class="ligs-update">
    <?=
    $this->render('_form', [
        'model' => $model,
        'ligs_type' => $ligs_type,
    ])
    ?>

</div>
