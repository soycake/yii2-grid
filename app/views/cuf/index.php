<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\icons\Icon;
use kartik\grid\GridView;
use yii\widgets\Pjax;

Icon::map($this);

//use app\models\SplittedStripLocal;
//use app\models\MissionLocal;

$this->title = 'CUF';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo $this->render('_search-manual', ['model' => $searchModel]);   ?>
<div class="clearfix"></div>
<div class="grid-index " >
    <div class="scrollspy-board" data-spy="scroll" data-offset="0">
        <?php
        Pjax::begin([
            'id' => 'Pjax',
            'enablePushState' => false
        ]);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => '\yii\grid\SerialColumn'],
                //
                [
                    'attribute'=>'id',
                    'label'=>'XML Name',
                    'value'=>function($data){
                        switch($data->id){
                            case '30': $d='THA_SAKHONNAK_20140805_URG_FL'; break;
                            case '21': $d='THA_AMNATCHA_20140803_URG_FL'; break;
                            case '20': $d='THA_YASOTORN_20140802_URG_FL'; break;
                            case '17': $d='CEO_201407311432_565_PM_STD'; break;
                            default : $d='CEO_201407311437_566_PM_STD'; break;
                        }
                        return $d;
                    },
                ],
                [
                    'attribute'=>'id',
                    'label'=>'Request Name',
                    'value'=>function($data){
                        switch($data->id){
                            case '30': $d='ST01'; break;
                            case '21': $d='ST05'; break;
                            case '20': $d='ST08'; break;
                            case '17': $d='ST32'; break;
                            default : $d='ST09'; break;
                        }
                        return $d;
                    },
                ],
                [
                    'attribute'=>'id',
                    'label'=>'Strip',
                    'value'=>function($data){
                        switch($data->id){
                            case '30': $d='Strip #1'; break;
                            case '21': $d='Strip #3'; break;
                            case '20': $d='Strip #2'; break;
                            case '17': $d='Strip #1'; break;
                            default : $d='Strip #1'; break;
                        }
                        return $d;
                    },
                ],
                [
                    'attribute'=>'id',
                    'label'=>'Status',
                    'value'=>function($data){return null;},
                ],   
                [
                    'attribute'=>'id',
                    'label'=>'Begin Reception Date',
                    'value'=>function($data){return null;},
                ],  
                [
                    'attribute'=>'id',
                    'label'=>'Revolution',
                    'value'=>function($data){
                        switch($data->id){
                            case '30': $d=30217; break;
                            case '21': $d=30217; break;
                            case '20': $d=30217; break;
                            case '17': $d=30217; break;
                            default : $d=30217; break;
                        }
                        return $d;
                    },
                ],  
                [
                    'attribute'=>'id',
                    'label'=>'File Name',
                    'value'=>function($data){
                        switch($data->id){
                            case '30': $d=31; break;
                            case '21': $d=32; break;
                            case '20': $d=33; break;
                            case '17': $d=34; break;
                            default : $d=36; break;
                        }
                        return $d;
                    },
                ], 
                [
                    'attribute'=>'id',
                    'label'=>'Number of Scene',
                    'value'=>function($data){
                        switch($data->id){
                            case '30': $d=3; break;
                            case '21': $d=5; break;
                            case '20': $d=7; break;
                            case '17': $d=8; break;
                            default : $d=9; break;
                        }
                        return $d;
                    },
                ], 
                [
                    'attribute'=>'id',
                    'label'=>'Sun Elevation',
                    'value'=>function($data){
                        switch($data->id){
                            case '30': $d=28.70; break;
                            case '21': $d=29.10; break;
                            case '20': $d=29.77; break;
                            case '17': $d=28.57; break;
                            default : $d=27.55; break;
                        }
                        return $d;
                    },
                ], 
                [
                    'attribute'=>'id',
                    'label'=>'Sun Azimuth',
                    'value'=>function($data){
                        switch($data->id){
                            case '30': $d=37.01; break;
                            case '21': $d=37.08; break;
                            case '20': $d=36.70; break;
                            case '17': $d=36.47; break;
                            default : $d=36.20; break;
                        }
                        return $d;
                    },
                ],[
                    'attribute'=>'id',
                    'label'=>'Quick Look',
                    'format'=>'raw',
                    'value'=>function($data){
                        switch($data->id){
                            case '30': $d='11102654101001.JPG'; break;
                            case '21': $d='11102654101002.JPG'; break;
                            case '20': $d='11102654101003.JPG'; break;
                            case '17': $d='11102654101004.JPG'; break;
                            default : $d='11102654101005.JPG'; break;
                        }
                        return Html::img('http://mvos3.gistda.or.th/tpt/uploads/cuf/'.$d,[
                            'style'=>'width:30px;'
                        ]);
                    },
                ],
                [
                    'class'=>'prawee\grid\ActionColumn',
                    'template'=>'{import} {export}',
                    'options'=>['class'=>'width-action'],
                    'header'=>'Import | Export',
                    'buttons'=>[
                        'export' => function($data) {
                            $urlFile='http://mvos3.gistda.or.th/tpt/uploads/shape/THA_AMNATCHA_20140803_URG_FL-Strip_01.zip';
                            return Html::a(Icon::show('upload'),$urlFile,[
                                'data-pjax'=>'0',
                                'title'=>' Export ',
                                'class'=>'btn btn-xs btn-danger',
                            ]);
                        },
                        'import' => function($url,$model) {
                            $urlFile='http://mvos3.gistda.or.th/tpt/uploads/shape/THA_SAKHONNAK_20140805_URG_FL-01.xls';
                            return Html::a(Icon::show('download'),$urlFile,[
                                'data-pjax'=>'0',
                                'title'=>' Import ',
                                'class'=>'btn btn-xs btn-success',
                            ]);
                        }
                    ]
                ]
            ],
        ]);
        Pjax::end();
        ?>
    </div>
</div>