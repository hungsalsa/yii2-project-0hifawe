<?php

namespace backend\modules\quantri\controllers;

use Yii;
use backend\modules\quantri\models\Categories;
use backend\modules\quantri\models\Group;
use backend\modules\quantri\models\CategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categories model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categories();

        $group = new Group();
        $dataGroups = ArrayHelper::map($group->getAllGroups(),'id','groupsName');


// $categories = ArrayHelper::map(Categories::find()
//                 ->where(['groupId'=>3])
//                 ->all(),'id','cateName');
// foreach ($categories as $value) {
//     ech
// }
        // $data2 = $this->actionLists(3);
        // echo '<pre>'; print_r($categories);die;

        $datacat = $model->getCategoryParent();
        if (empty($datacat)) {
            $datacat=array();
        }

        $model->created_at=time();
        $model->updated_at=time();
        $model->userAdd = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'dataGroups' => $dataGroups,
            'datacat' => $datacat,
        ]);
    }

     public function actionLists($id)
    {
        $countCategory = Categories::find()
                ->where(['groupId'=>$id])
                ->count();

        $categories = Categories::find()
                ->where(['groupId'=>$id])
                ->orderBy(['cateName'=>SORT_ASC])
                ->all();

        if ($countCategory > 0 ) {
            foreach ($categories as $result) {
                echo "<option value='".$result->id."'>".$result->cateName."</option>";
            }
        }else {
            echo '<option value="0">-- Danh mục root -- </option>';
        } 
    }


     

    /**
     * Updates an existing Categories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $group = new Group();
        $dataGroups = ArrayHelper::map($group->getAllGroups(),'id','groupsName');

         $datacat = $model->getCategoryParent();
        if (empty($datacat)) {
            $datacat=array();
        }

        $model->updated_at=time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'dataGroups' => $dataGroups,
            'datacat' => $datacat,
        ]);
    }

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

   
    
}
