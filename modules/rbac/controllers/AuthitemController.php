<?php

namespace backend\modules\rbac\controllers;

use Aabc;
use backend\modules\rbac\models\Authitem;
use backend\modules\rbac\models\AuthitemSearch;
use aabc\web\Controller;
use aabc\web\NotFoundHttpException;
use aabc\filters\VerbFilter;


use aabc\db\Transaction;
use aabc\base\Exception;
use aabc\base\ErrorException;
use aabc\base\ErrorHandler;

use aabc\web\ForbiddenHttpException;
use aabc\filters\AccessControl;

use backend\modules\rbac\models\Authitemchild;

class AuthitemController extends Controller
{
    
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     //'only' => ['create'],
            //     'rules' => [
            //         [
            //             'allow' => true,
            //             //'actions' => ['index','create'],
            //             'roles' => ['@'],
            //             'matchCallback' => function ($rule, $action){
            //                 $control = Aabc::$app->controller->id;
            //                 $action = Aabc::$app->controller->action->id;
            //                 $role = $action . '-' . $control;
            //                 if(Aabc::$app->user->can($role)){
            //                     return true;
            //                 }
            //             }
            //         ],
            //     ],
            // ],


            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'deleteall' => ['POST'],
                    'create' => ['GET','POST'],
                    'update' => ['GET','POST'],
                    'updatedev' => ['GET','POST'],
                ],
            ],
        ];
    }

    
    public function actionIndex($t = 20)
    {
        
        //$searchModel = new Dskh2Search(
        //    ['tencongty' => 'thanh']
        //);

        $searchModel = new AuthitemSearch();
        $dataProvider = $searchModel->search(Aabc::$app->request->queryParams);

        $dataProvider->setSort([
            'defaultOrder' => ['type'=>SORT_ASC]        
        ]);

        $dataProvider->pagination->pageSize=$t;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {
        $model = new Authitem();
        if ($model->load(Aabc::$app->request->post())) {            
            /* Json */
            if($model->save()){                    
                $data = 'thanhcong';                    
            }else{
                $data = 'thatbai'; 
            }
            Aabc::$app->response->format = \aabc\web\Response::FORMAT_JSON;
            return $data; 
            /* Binh thuong */
            /*
            $model->save();
            return $this->redirect(['view', 'id' => $model->name]);
            */
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
        // return $this->renderAjax('create', [
        //         'model' => $model,
        //     ]);
        
        die;
    }

    
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);

        if ($model->load(Aabc::$app->request->post()) ) {
            
             /* Json */
            if($model->save()){                    
                $data = 'thanhcong';                    
            }else{
                $data = 'thatbai'; 
            }
            Aabc::$app->response->format = \aabc\web\Response::FORMAT_JSON;
            return $data;

        } 

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
        die;
    }


    public function actionUpdatedev($name,$parent)
    {   
        $model = Authitemchild::find()
                ->andWhere(['parent'=>$parent])
                ->andWhere(['child'=>$name])
                ->all();

        $datajson = ''; 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $transaction = \Aabc::$app->db->beginTransaction();
            try {   
                if(count($model) > 0){
                    $modeldelete = Authitemchild::find()
                                    ->andWhere(['parent'=>$parent])
                                    ->andWhere(['child'=>$name])
                                    ->one();
                   if($modeldelete->delete()){
                        $transaction->commit();
                        $datajson = 'thanhcong';
                    }else{
                        $transaction->rollback();
                        $datajson = 'thatbai';
                    }
                }else{
                    $modelsave = new Authitemchild();
                    $modelsave->parent = $parent;
                    $modelsave->child = $name;
                    if($modelsave->save()){
                        $transaction->commit();
                        $datajson = 'thanhcong';
                    }else{
                        $transaction->rollback();
                        $datajson = 'thatbai';
                    }                  
                } 
                
            } catch (Exception $e) {            
                $transaction->rollback();
                $datajson = 'thatbai';
            }

            Aabc::$app->response->format = \aabc\web\Response::FORMAT_JSON;
            return $datajson;
        } 
        die;
    }

    
    public function actionDelete($id)
    {
        $datajson = 'thatbai';

        $transaction = \Aabc::$app->db->beginTransaction();
        try {     
                $this->findModel($id)->delete();                
            $transaction->commit();
            $datajson = 'thanhcong';
        } catch (Exception $e) {            
            $transaction->rollback();
            $datajson = 'thatbai';
        }

        Aabc::$app->response->format = \aabc\web\Response::FORMAT_JSON;
        return $datajson;

        //$this->findModel($id)->delete();

        //return $this->redirect(['index']);
    }


    public function actionDeleteall()
    {
        $data = Aabc::$app->request->post('selects');
        $datajson = 'thatbai';

        $transaction = \Aabc::$app->db->beginTransaction();
        try {
                foreach ($data as $key => $value) {  
                    $this->findModel($value)->delete();                    
                } 
            $transaction->commit();
            $datajson = 'thanhcong';
        } catch (Exception $e) {            
            $transaction->rollback();
            $datajson = 'thatbai';
        }

        Aabc::$app->response->format = \aabc\web\Response::FORMAT_JSON;
        return $datajson;


    }

    
    protected function findModel($id)
    {
        if (($model = Authitem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
