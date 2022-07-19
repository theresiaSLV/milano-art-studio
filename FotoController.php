<?php

namespace frontend\controllers;

use Yii;
use common\models\Customer;
use common\models\DetailCustomer;
use common\models\Foto;
use common\models\FotoSearch;
use common\models\OrderDetailPaketFoto;
use common\models\PaketFoto;
use common\models\PaketFrameDetail;
use common\models\JenisFrame;
use common\models\Album;
use common\models\HasilFoto;
use common\models\HasilFotoItem;
use common\models\DetailServiceSpk;
use common\models\HeaderSpk;
use common\models\Karyawan;
use common\models\PaketUpgrade;
use common\models\CetakFoto;
use common\models\RefFrameDetail;
use common\models\RefFrame;
use common\models\RefUkuranFrame;
use common\models\RefAlbumDetail;
use common\models\RefNamaAlbum;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FotoController implements the CRUD actions for Foto model.
 */
class FotoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Foto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FotoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetInvoice($invoice){
        $customer_detail = DetailCustomer::find()->where(['detcus_no_invoice' => $invoice])->one();
        if(!$customer_detail){
            $data = array("status" => "failed", "message" => "Nomor Invoice tidak valid");
            return $this->asJson($data);
        }
        // $foto = Foto::find()->where(['foto_detcus_id' => $customer_detail->detcus_id])->all();
        // if(!$foto || sizeof($foto) < 1){
        //     $data = array("status" => "failed", "message" => "Foto belum diinput oleh admin");
        //     return $this->asJson($data);
        // }
        return $this->asJson(array("status" => "success", "data" => $customer_detail));
    }

    /**
     * Displays a single Foto model.
     * @param int $foto_id Foto ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($foto_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($foto_id),
        ]);
    }

    /**
     * Creates a new Foto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Foto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'foto_id' => $model->foto_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Foto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $foto_id Foto ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($foto_id)
    {
        $model = $this->findModel($foto_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'foto_id' => $model->foto_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Foto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $foto_id Foto ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($foto_id)
    {
        $this->findModel($foto_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Foto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $foto_id Foto ID
     * @return Foto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($foto_id)
    {
        if (($model = Foto::findOne(['foto_id' => $foto_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStepper($foto_detcus_id = null)
    {
        $modelFoto = null;
        $detail_customer = null;
        $lokasi_folder_start = null;

        if($foto_detcus_id){
            $detail_customer = DetailCustomer::find()->where(['detcus_id' => $foto_detcus_id])->one();
            if($detail_customer){
                if($detail_customer->lokasi_folder_start){
                    $root = "../../backend/web/images/uploads/customer/";
                    if (file_exists($root.$detail_customer->lokasi_folder_start)) {
                        $files = scandir($root.$detail_customer->lokasi_folder_start);
                        $lokasi_folder_start = $root . implode('/', array_map('urlencode', explode('/', $detail_customer->lokasi_folder_start)));
                        $modelFoto = $files;
                    }else{
                        $lokasi_folder_start = "INVALID";
                    }
                }
            }
        }

        return $this->render('stepper', [
            'modelFoto' => $modelFoto,
            'detail_customer' => $detail_customer,
            'lokasi_folder_start' => $lokasi_folder_start
        ]);
    }

    public function actionStepComplete($hasil_foto_id)
    {
        return $this->render('stepComplete', [
            'hasil_foto_id' => $hasil_foto_id,
        ]);
    }

    public function actionPrint($hasil_foto_id)
    {
        $hasil_foto = HasilFoto::find()->where(['hf_id' => $hasil_foto_id])->one();
        $hasil_foto_item = HasilFotoItem::find()->where(['hasil_foto_id' => $hasil_foto_id])->all();
        
        $detail_customer = DetailCustomer::findOne($hasil_foto->hf_detcus_id);
        $customer = Customer::findOne($detail_customer->detcus_cust_id);

        $foto = Foto::find()->where(['foto_detcus_id' => $hasil_foto->hf_detcus_id])->all();

        $order_detail_paket_foto = OrderDetailPaketFoto::find()->where(['odpf_detcus_id' => $hasil_foto->hf_detcus_id])->one();

        $paket_foto = PaketFoto::find()->where(['paket_id' => $order_detail_paket_foto->odpf_paket_id])->one();

        $list_foto = [];
        foreach($foto as $item){
            foreach($hasil_foto_item as $hasil_item){
                if($hasil_item->foto_id == $item->foto_id){
                    array_push($list_foto, $item);
                }
            }
        }

        return $this->render('print', [
            'customer' => $customer,
            'detail_customer' => $detail_customer,
            'paket_foto' => $paket_foto,
            'list_foto' => $list_foto
        ]);
    }

    public function actionGetDetailFoto($detcus_id)
    {
        $data['detail_customer'] = DetailCustomer::findOne($detcus_id);

        if(is_null($data['detail_customer']->lokasi_folder_start)){
            $data['lokasi_folder_start'] = null;
        }else{
            $root = "../../backend/web/images/uploads/customer/";
            if (file_exists($root.$data['detail_customer']->lokasi_folder_start)) {
                $files = scandir($root.$data['detail_customer']->lokasi_folder_start);
                $data['lokasi_folder_start'] = $root . implode('/', array_map('urlencode', explode('/', $data['detail_customer']->lokasi_folder_start)));
                $data['lokasi_folder_start_original'] = $root . $data['detail_customer']->lokasi_folder_start;
                $data['files_lokasi_folder_start'] = $files;
            }else{
                $data['lokasi_folder_start'] = "INVALID";
            }
        }

        $data['customer'] = Customer::findOne($data['detail_customer']->detcus_cust_id);
        // $data['header_spk'] = HeaderSpk::find()->where(['spk_detcus_id' => $detcus_id])->orderBy(['spk_id' => SORT_DESC])->one();
        // $data['detail_service_spk'] = DetailServiceSpk::find()->where(['serv_spk_id' => $data['header_spk']->spk_id])->one();
        $data['karyawan'] = Karyawan::find()->where(['kary_status_id' => 2])->all();
        $data['paket_upgrade'] = PaketUpgrade::find()->where(['upg_nama' => 'Foto Tambahan'])->one();
        $data['foto_all'] = Foto::find()->where(['foto_detcus_id' => $detcus_id])->all();

        $data['order_detail_paket_foto'] = OrderDetailPaketFoto::find()->where(['odpf_detcus_id' => $detcus_id])->one();
        $data['paket_foto'] = PaketFoto::find()->where(['paket_id' => $data['order_detail_paket_foto']->odpf_paket_id])->one();

        $paket_frame_detail = PaketFrameDetail::find()->where(['fd_paket_id' => $data['order_detail_paket_foto']->odpf_paket_id])->all();
        $ref_frame_details = array();
        foreach($paket_frame_detail as $item){
            $ref_frame_item = RefFrameDetail::find()->where(['rfd_id' => $item->fd_rfd_id])->one();
            array_push($ref_frame_details, array(
                    "ref_frame_detail" => $ref_frame_item,
                    "max_qty" => $item->fd_qty
                )
            );
        }
        $arr = array();
        foreach($ref_frame_details as $item){
            $ref_frame_detail = $item['ref_frame_detail'];
            $ref_frame = RefFrame::find()->where(['idframe' => $ref_frame_detail->rfd_idframe])->one();
            $jenis_frame = JenisFrame::find()->where(['frame_rfd_id' => $ref_frame_detail->rfd_id])->all();
            $ref_ukuran_frame = RefUkuranFrame::find()->where(['idukuranframe' => $ref_frame_detail->rfd_idukuranframe])->one();
            $max_qty = $item['max_qty'];
            array_push($arr, array(
                    "ref_frame" => $ref_frame, 
                    "jenis_frame" => $jenis_frame, 
                    "ref_ukuran_frame" => $ref_ukuran_frame, 
                    'max_qty' => $max_qty
                )
            );
        }

        $data['jenis_frame'] = $arr;
        $data['paket_frame'] = $paket_frame_detail;
        $album = Album::find()->where(['album_id' => $data['paket_foto']->paket_album_id])->one();
        if($album){
            $data['album'] = $album;
            $ref = RefAlbumDetail::find()->where(['id' => $data['album']->id_ref_album_detail])->one();
            $data['album_nama'] = RefNamaAlbum::find()->where(['id' => $ref->id_ref_nama_album])->one();
            $data['album_ukuran'] = RefUkuranFrame::find()->where(['idukuranframe' => $ref->idukuranframe])->one();
        }
        $data['cetak_foto'] = CetakFoto::find()->where(['cetak_id' => $data['paket_foto']->paket_cetak_id])->one();
        $data['cetak_foto_all'] = CetakFoto::find()->all();

        $ref_frame_detail_all = RefFrameDetail::find()->all();
        $ref_frame_all = array();
        foreach($ref_frame_detail_all as &$item){
            $ref_frame = RefFrame::find()->where(['idframe' => $item->rfd_idframe])->one();
            $jenis_frame = JenisFrame::find()->where(['frame_rfd_id' => $item->rfd_id])->all();
            $ref_ukuran_frame = RefUkuranFrame::find()->where(['idukuranframe' => $item->rfd_idukuranframe])->one();
            array_push($ref_frame_all, array("ref_frame" => $ref_frame, "jenis_frame" => $jenis_frame, "ref_ukuran_frame" => $ref_ukuran_frame));
        }
        $data['frame_all'] = $ref_frame_all;

        return $this->asJson($data);
    }

    public function actionSaveHasilFoto()
    {
        $request = Yii::$app->request;
        $req = $request->post();
        $detcus_id = $req['detcus_id'];
        $foto = $req['foto'];
        $deadline_date = $req['deadline_date'];
        $url =$req['signature_url'];
        $root_folder =$req['root_folder'];
        $karyawan_id =$req['karyawan_id'];
        $total_tambahan =$req['total_tambahan'];
        $current_month = date("F");
        $current_year = date("Y");
        $current_date = date("Y-m-d");
        $root_destination = "../../backend/web/images/editing/";
        $full_root_destionation = $root_destination . '/' . $current_year . '/' . $current_month;

        $detail_customer = DetailCustomer::find()->where(['detcus_id' => $detcus_id])->one();
        $customer = Customer::findOne($detail_customer->detcus_cust_id);
        $removetag = str_replace('#','',$detail_customer->detcus_no_invoice);//pakein rumus ini
        $removespace = str_replace(' ','_',$customer->cust_nama);
        $fullname_new_folder = $current_date . " - " . $removetag . " - " . $removespace;
        $full_destionation = $full_root_destionation . '/' . $fullname_new_folder;
        $finish_destination = $current_year . '/' . $current_month . '/' . $fullname_new_folder;

        $detail_customer->detcus_status_pilih_foto = 'SUDAH PILIH FOTO';
        $detail_customer->detcus_tgl_deadline = $deadline_date;
        $detail_customer->detcus_ttd_customer = $url;
        $detail_customer->lokasi_folder_finish = $finish_destination;
        $detail_customer->nama_cs = $karyawan_id;
        $detail_customer->total_bayar_pilih_foto = $total_tambahan;
        if($detail_customer->save(false)){
        }else{
            return $this->asJson(array('status' => 'failed', 'message' => 'gagal mengubah data detail customer'));
        }

        $hasil_foto = new HasilFoto();
        $hasil_foto->hf_detcus_id = $detcus_id;
        if($hasil_foto->save()){
        }else{
            return $this->asJson(array('status' => 'failed', 'message' => 'gagal membuat data hasil foto'));
        }

        if (!file_exists($root_destination)) {
            mkdir($root_destination);
        }

        if (!file_exists($root_destination . '/' . $current_year)) {
            mkdir($root_destination . '/' . $current_year);
        }

        if (!file_exists($root_destination . '/' . $current_year . '/' . $current_month)) {
            mkdir($root_destination . '/' . $current_year . '/' . $current_month);
        }

        if (!file_exists($full_destionation)) {
            mkdir($full_destionation);
        }

        foreach($foto as $item){
            $hasil_foto_item = new HasilFotoItem();
            $hasil_foto_item->hasil_foto_id = $hasil_foto->hf_id;
            $hasil_foto_item->type = $item['type'];
            $hasil_foto_item->foto_id = $item['foto_id'];
            $hasil_foto_item->keterangan = $item['keterangan'];
            $hasil_foto_item->jenis_frame_id = $item['jenis_frame_id'];
            $hasil_foto_item->cetak_foto_id = $item['cetak_foto_id'];
            $hasil_foto_item->harga_foto = $item['harga'];
            $hasil_foto_item->ref_frame_id = $item['ref_frame_id'];
            $hasil_foto_item->ref_ukuran_frame_id = $item['ref_ukuran_frame_id'];
            $hasil_foto_item->save(false);

            $nama_file = $item[' '];
            if (file_exists($root_folder . '/' . $nama_file)) {
                $full_root_folder = $root_folder . '/' . $nama_file;
                copy($full_root_folder, $full_destionation.'/'.$nama_file);
            }
        }

        return $this->asJson(array('status' => 'success', 'data' => $hasil_foto->hf_id));
    }

    public function actionSaveSignature(){
        $request = Yii::$app->request;
        $req = $request->post();

        $signature = $req['signature'];
        $detcus_id = $req['detcus_id'];
        $t=time();
        $url = "uploads/SIGN-$t-$detcus_id.png";

        list($type, $signature) = explode(';', $signature);
        list(, $signature)      = explode(',', $signature);
        $signature = base64_decode($signature);

        file_put_contents(Yii::getAlias("@backend") . "/web/$url", $signature);
        return $this->asJson(array('status' => 'success', 'data' => $url));

    }
}
