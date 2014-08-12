<?php
/*
 * 20140724
 * prawee@hotmail.com
 */
namespace app\models;

use common\models\SplittedStripLocal as CSplittedStripLocal;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class SplittedStripLocal extends CSplittedStripLocal {
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT =>['created','modified'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'modified',
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    public static function insertBySceneId($sceneId) {
        $model = new self;
        $model->databasedata_id = (int) Databasedata::insertGetId();
        $model->strips_id = (int) Strips::insertGetId();
        $model->scene_id = $sceneId;
        $model->save(false);
    }
    public static function insertByLoop($data,$sceneId){
        foreach ($data as $key => $value){
            foreach($value as $request){ 
                foreach($request->STRIPS as $aaa=>$bbb){
                    $stname = 'ST' . sprintf('%02d', $bbb);
                    if($request->STRIPS->{$stname}['name']){
                        $model=new self;
                        $model->databasedata_id=(int)  Databasedata::insertGetId($request->STRIPS->{$stname}->DatabaseData);
                        $model->strips_id=(int)Strips::insertGetId($request->STRIPS->{$stname}->Definition);
                        $model->scene_id=(int)$sceneId;
                        $model->status=(int)$request->STRIPS->{$stname}['status'];
                        $model->type=(string)$request->STRIPS->{$stname}['type'];
                        $model->image=(string)$request->STRIPS->{$stname}['image'];
                        $model->name=(string)$request->STRIPS->{$stname}['name'];
                        $model->save(false);
                        StripAccessLocal::insertBySplitted($request->STRIPS->{$stname}->Passes, $model->id);
                    }
                }
            }
        }
    }
    public static function updateBySceneId($data,$sceneId){
        $model = self::find()->where(['scene_id'=>$sceneId])->one();
        //echo '<pre>'.print_r($model->attributes,true).'</pre>';
        foreach ($data as $key => $value){
            foreach($value as $request){ 
                //echo '<pre>'.print_r($request->STRIPS->ST01,true).'</pre>';

                foreach($request->STRIPS as $aaa=>$bbb){
                    $stname = 'ST' . sprintf('%02d', $bbb);
                    if($request->STRIPS->{$stname}['name']){
                        //echo $request->STRIPS->{$stname}['name'];
                        //echo '<pre>'.print_r($request->STRIPS->{$stname}->DatabaseData,true).'</pre>';
                        Databasedata::updateXML($request->STRIPS->{$stname}->DatabaseData,$model->databasedata_id);
                        Strips::updateXML($request->STRIPS->{$stname}->Definition,$model->strips_id);
                        
                        //echo '<pre>'.print_r($request->STRIPS->{$stname}->Passes,true).'</pre>';
                        StripAccessLocal::insertBySplitted($request->STRIPS->{$stname}->Passes, $model->id);
                    }
                }
            }
        }
    }
    
    public static function insertGetId($data){
        //echo '<pre>'.print_r($data,true).'</pre>';
        if(is_object($data)){
            $model=new self;
            $model->name=(string)$data['name'];
            $model->image=(string)$data['image'];
            $model->type=(string)$data['type'];
            $model->status=(string)$data['status'];
            if($data->DatabaseData){
                $model->databasedata_id=(int) Databasedata::insertGetId($data->DatabaseData);
            }
            if($data->Definition){
                $model->strips_id=(int)  Strips::insertGetId($data->Definition);
            }
            $model->save();
            
            if($data->Passes){
                StripAccessLocal::insertBySplitted($data->Passes, $model->id);
            }
            if($data->Trials){
                TrialLocal::insertGetId($data->Trials);
            }
        }
        return null;
    }
    public static function insertGetId2($xml,$data,$missionId){
        echo '<pre>'.print_r($xml,true).'</pre>';
        echo '<pre>'.print_r($data->attributes,true).'</pre>';
        echo $missionId;
        if(is_object($xml)){
            $model=new self;
            
            $model->scene_id=$data->scene_id;
            
            echo '<pre>'.print_r($model->attributes,true).'</pre>';
        }
        exit;
    }

}
