<?php

namespace backend\controllers;

use Yii;
use common\models\Article;
use common\models\ArticleSearch;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['token'] = [
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];
        return $behaviors;
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->with('type')->asArray();
        return [
            'code' => 0,
            'msg' => '获取成功',
            'result' => [
                'count' => $dataProvider->getTotalCount(),
                'data' => $dataProvider->getModels(),
                'page' => $dataProvider->getPagination()->page
            ]
        ];
    }

    public function actionUpload()
    {
        if (empty($_FILES['file']['tmp_name']) && strpos($_FILES['file']['type'], 'image') === -1) {
            return [
                'code' => 1,
                'msg' => '上传失败',
            ];
        }
        $ext = explode('.', $_FILES['file']['name']);
        $ext = $ext[count($ext)-1];
        $name = date('YmdHis').mt_rand(1000000,9999999).'.'.$ext;
        if (Yii::$app->upload->write($name, file_get_contents($_FILES['file']['tmp_name']))) {
            return [
                'code' => 0,
                'msg' => '上传成功!',
                'result' => Yii::$app->params['uploadDomain'].'/'.$name
            ];
        }
        return [
            'code' => 1,
            'msg' => '上传失败'
        ];
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return [
                'code' => 0,
                'msg' => '发布成功'
            ];
        }
        return [
            'code' => 1,
            'msg' => $model->getErrorOne()
        ];
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
