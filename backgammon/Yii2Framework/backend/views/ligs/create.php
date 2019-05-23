<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Ligs */

$this->title =Yii::t('app', 'Ligs').' / '. Yii::t('app', 'Create Ligs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ligs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create Ligs');
?>
<div class="ligs-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'ligs_type' => $ligs_type,
    ])
    ?>

</div>
