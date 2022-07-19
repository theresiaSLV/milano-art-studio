<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\cmenu\ContextMenu;
$this->title = 'Pilih Foto';
?>

<div id="loading" style="position: fixed;
  display: block;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  opacity: 0.7;
  background-color: #fff;
  z-index: 99;">
  <div style="z-index: 100;" class="h-100">
    <div class="d-flex justify-content-center align-items-center" style="height:100%">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
</div>
<div id="invalid-data" style="position: fixed;
  display: <?= $modelFoto ? 'none' : 'block'; ?>;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  opacity: 0.7;
  background-color: #fff;
  z-index: 99;">
  <div style="z-index: 100;" class="h-100">
    <div class="d-flex justify-content-center align-items-center" style="height:100%">
      <span id="error-message" style="font-weight:bold; font-size:18px;">
      <?php
        $err = '';
        if(is_null($lokasi_folder_start)) $err = 'LOKASI FOLDER FOTO NOT SPECIFIED';
        else if( $lokasi_folder_start == 'INVALID') $err = 'INVALID LOKASI FOLDER FOTO';
        echo $err;
      ?>
      </span>
    </div>
  </div>
</div>
<h1>Selamat Datang, <br/> di Milano Art Studio</h1>
<h2>Silahkan Pilih Foto Terbaik Kamu di Momen Ini!</h2>

<!-- STEP #1 -->
<?php ob_start(); ?>
<div class="row" style="margin:20px;">
  <div class="col-lg-12">
    <h3>Pilih Foto</h3>Lakukan Pemilihan Foto Terlebih Dahulu
  </div>
</div>
<div class="row" style="margin:20px;">
<?php if($modelFoto) { ?>
<?php foreach ($modelFoto as $key=>$value) { ?>
<?php if($value != "." && $value != "..") { ?>
  <div class="col-xs-4 col-sm-3 col-md-2 nopad text-center" style="padding:0px;">
    <a href="<?php echo $lokasi_folder_start . "/" . $value;?>" data-fancybox="gallery">
      <img class="img-responsive img-thumbnail kv-context context-menu" src="<?php echo  $lokasi_folder_start . "/" . $value;?>" data-id="<?=$key;?>" style="width:100%; height:150px; object-fit: cover" alt="image"/>
    </a>
  </div>
<?php } ?>
<?php } ?>
<?php } ?>
</div>
<?php $step1 = ob_get_clean(); ?>

<!-- STEP #2 -->
<?php ob_start(); ?>
<div class="row" style="margin:20px;">
  <div class="col-lg-12">
    <h3>Preview Foto</h3>
  </div>
</div>
<div class="row" style="margin:20px;">
  <div class="col-lg-12">
    <table class="table table-striped table-bordered">
      <tr>
        <th>Foto Utama</th>
        <th>Cetak</th>
        <th>Foto Tambahan</th>
      </tr>
      <tr>
        <td id="preview-foto-utama">
        </td>
        <td id="preview-cetak">
        </td>
        <td id="preview-tambah-foto">
        </td>
      </tr>
    </table>
  </div>
</div>
<div class="modal" id="preview-modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="font-size:20px; text-align:center">
    <div class="modal-content">
      <div class="modal-body">
        Masih ada <span id="preview-diff"></span> foto yang belum anda ambil.<br>
        Apakah mau dipilih juga?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        <button type="button" id="preview-back-button" class="btn btn-primary">Iya</button>
      </div>
    </div>
  </div>
</div>
<?php $step2 = ob_get_clean(); ?>

<!-- STEP #3 -->
<?php ob_start(); ?>
<div class="row" style="font-size:14px; margin:20px;">
  <div class="col-lg-12">
    <h3>Rekap</h3>Pastikan fotonya sudah sesuai harapan Kamu
  </div>
  <div class="col-sm-6 mt-4">
    <strong>No Invoice:</strong> <span class="no-invoice">1234</span><br>
    <strong>Tanggal:</strong> <span class="order-tanggal">12-12-2022</span><br>
  </div>
  <div class="col-sm-6 mt-4">
    <strong>Nama Kustomer:</strong> <span class="customer-name">Mr. X</span><br>
    <strong>Paket Foto:</strong> <span class="nama-paket">Paket Hemat Ramadhan</span><br>
  </div>
</div>
<div class="row" style="font-size:14px;">
  <div class="col-sm-6 ma-4">
    <div class="card mt-4 mx-4" style="min-height:100px;">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-6">
            <button class="btn btn-info btn-block btn-lg" data-toggle="modal" data-target="#frame-modal">
              <i class="fas fa-search"></i> Pilih Frame
            </button><br>
            <table class="table">
              <thead>
                <th>Nama Bingkai</th>
                <th>Ukuran</th>
                <th>Warna</th>
              </thead>
              <tbody>
                <tr>
                  <td><span id="nama-bingkai">-</span></td>
                  <td><span id="ukuran-bingkai">-</span></td>
                  <td><span id="warna-bingkai">-</span></td>
                </tr>
              </tbody>
            </table>
            <!-- <strong>Nama Bingkai:</strong> <span id="nama-bingkai">-</span><br>
            <strong>Ukuran:</strong> <span id="ukuran-bingkai">-</span><br>
            <strong>Warna:</strong> <span id="warna-bingkai">-</span> -->
          </div>
          <div class="col-sm-6" id="rekap-frame-img">
            <!-- <img src="https://via.placeholder.com/150"> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 ma-4" id="pilih_album_section">
    <div class="card mt-4 mx-4" style="min-height:100px; max-height:200px;">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-6">
            <button class="btn btn-dark btn-block btn-lg" data-toggle="modal" data-target="#album-modal">
              <i class="fas fa-search"></i> Pilih Album
            </button><br>
            <strong>Nama:</strong> <span id="nama-album">-</span><br>
            <strong>Warna:</strong> <span id="warna-album">-</span><br>
            <strong>Ukuran:</strong> <span id="ukuran-album">-</span><br>
          </div>
          <div class="col-sm-6" id="rekap-album-img">
            <!-- <img src="https://via.placeholder.com/150"> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br><br>
<div class="col-sm-12">
<h4 style="color:#476">Pilih Frame Terlebih Dahulu</h4>
</div>
<div class="row">
  <div class="col-sm-12 ma-4">
    <div class="card mt-4 mx-4">
      <div class="card-body">
        <div class="row" id="rekap-foto-list">
          <div class="col-sm-4 d-flex justify-content-center">
            <form>
              <img src="https://via.placeholder.com/150">
              <h1>Foto Utama</h1>
              <div class="form-group">
                <textarea class="rekap-foto-description form-control" placeholder="Tulis catatan untuk foto.."></textarea>
              </div>
              <div class="form-group">
                <select class="rekap-frame-selection form-control">
                  <option>--Pilih Frame--</option>
                </select>
              </div>
            </form>
          </div>
          <div class="col-sm-4 d-flex justify-content-center">
            <form>
              <img src="https://via.placeholder.com/150">
              <h1>Foto Utama</h1>
              <div class="form-group">
                <textarea class="rekap-foto-description form-control" placeholder="Tulis catatan untuk foto.."></textarea>
              </div>
              <div class="form-group">
                <select class="rekap-frame-selection form-control">
                  <option>--Pilih Frame--</option>
                </select>
              </div>
            </form>
          </div>
          <div class="col-sm-4 d-flex justify-content-center">
            <form>
              <img src="https://via.placeholder.com/150">
              <h1>Foto Utama</h1>
              <div class="form-group">
                <textarea class="rekap-foto-description form-control" placeholder="Tulis catatan untuk foto.."></textarea>
              </div>
              <div class="form-group">
                <select class="rekap-frame-selection form-control">
                  <option>--Pilih Frame--</option>
                </select>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="frame-modal" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-size:14px; overflow-y:auto;">
  <div class="modal-dialog  modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Bingkai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-list-frame">
        <table class="table table-striped table-bordered">
          <tr>
            <th>Nama Bingkai</th>
            <th>Gambar</th>
            <th>Cetak Utama</th>
            <th>Cetak Biasa</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
          <tr></tr>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="album-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-size:14px;">
  <div class="modal-dialog  modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Bingkai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered" id="modal-list-album">
          <tr>
            <th>Nama Bingkai</th>
            <th>Gambar</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
          <tr></tr>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $step3 = ob_get_clean(); ?>

<!-- STEP #4 -->
<?php ob_start(); ?>
<div class="row" style="font-size:14px; margin:20px;">
  <div class="col-lg-12">
    <h3>Finalisasi</h3>Foto akan di proses
  </div>
  <div class="col-sm-6 mt-4">
    <strong>No Invoice:</strong> <span class="no-invoice">1234</span><br>
    <strong>Tanggal:</strong> <span class="order-tanggal">12-12-2022</span><br>
  </div>
  <div class="col-sm-6 mt-4">
    <strong>Nama Kustomer:</strong> <span class="customer-name">Mr. X</span><br>
    <strong>Paket Foto:</strong> <span class="nama-paket">Paket Hemat Ramadhan</span><br>
  </div>
</div>
<div class="row mt-4" style="margin:20px;">
  <div class="col-sm-12">
    <table class="table table-striped table-bordered" id="list-main">
      <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Nama File</th>
        <th>Detail</th>
        <th>Produk Foto</th>
        <th>Deskripsi</th>
      </tr>
      <tr>
        <td>01</td>
        <td><img src="https://via.placeholder.com/150"></td>
        <td>file.png</td>
        <td>Foto Utama</td>
        <td>Frame block 20 x 20</td>
        <td>Dikasih filter</td>
      </tr>
    </table>
  </div>
  <div class="col-sm-12">
    <table class="table table-striped table-bordered" id="list-additional">
      <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Nama File</th>
        <th>Detail</th>
        <th>Produk Foto</th>
        <th>Deskripsi</th>
        <th>Harga</th>
      </tr>
      <tr>
        <td>01</td>
        <td><img src="https://via.placeholder.com/150"></td>
        <td>file.png</td>
        <td>Foto Tambahan</td>
        <td>Frame block 20 x 20</td>
        <td>Dikasih filter</td>
        <td>Rp 1.000.000</td>
      </tr>
    </table>
  </div>
</div>
<div class="modal" id="rekap-modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="font-size:20px; text-align:center">
    <div class="modal-content">
      <div class="modal-body">
        Masing-masing frame pada Foto Utama harus berbeda!
      </div>
      <div class="modal-footer">
        <button type="button" id="rekap-back-button" class="btn btn-primary">OK</button>
      </div>
    </div>
  </div>
</div>
<?php $step4 = ob_get_clean(); ?>

<!-- STEP #5 -->
<?php ob_start(); ?>
<div class="row" style="font-size:14px; margin:20px;">
  <div class="col-lg-12">
    <h3>Finalisasi</h3>
  </div>
  <div class="col-sm-6 mt-4">
    <strong>No Invoice:</strong> <span class="no-invoice">1234</span><br>
    <strong>Tanggal:</strong> <span class="order-tanggal">12-12-2022</span><br>
  </div>
  <div class="col-sm-6 mt-4">
    <strong>Nama Kustomer:</strong> <span class="customer-name">Mr. X</span><br>
    <strong>Paket Foto:</strong> <span class="nama-paket">Paket Hemat Ramadhan</span><br>
  </div>
</div>
<div class="row mt-4">
  <div class="col-sm-12" style="font-size:14px;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="checkbox_tnc">
      <label class="form-check-label" for="checkbox_tnc" style="padding-left:20px;">
        I am agree with terms and conditions Studio
      </label>
    </div>
  </div>
  <div class="col-sm-12 mt-4" style="font-size:14px; margin:20px;">
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras imperdiet ante lorem, id interdum risus finibus eget. Donec consectetur nisl vitae quam mattis pulvinar. Morbi sed orci eu dolor consequat hendrerit vel in magna. Mauris aliquet erat a augue venenatis, ut consectetur diam posuere. Mauris justo ipsum, sagittis non massa vel, aliquam accumsan justo. Curabitur ac venenatis diam, id auctor eros. Mauris non lacus ante. Sed blandit tellus mollis, vehicula sem ut, maximus nibh. In varius lectus erat, nec cursus eros porta vitae. Nullam volutpat imperdiet purus sed blandit. Vivamus tempus, libero id viverra pulvinar, ipsum leo pretium mi, vel dignissim tellus lectus in felis. Integer vulputate scelerisque mi, ac porta ex porta ut. Morbi quis metus pharetra, viverra quam vitae, finibus diam. Fusce ultricies rhoncus eros ut dictum. Quisque et ornare est. Curabitur at velit eleifend, mattis dolor id, sollicitudin sapien.<br><br>
    Suspendisse odio magna, pharetra at feugiat tristique, ultrices non sapien. Nam auctor metus placerat eros lobortis, quis dictum dolor gravida. Ut rutrum eros et venenatis cursus. Nunc eu fringilla elit, sed pharetra dolor. Sed et lectus ut nisi accumsan aliquam. Vestibulum bibendum erat eu odio gravida pharetra. Ut pellentesque, dolor in gravida tempor, elit tortor vehicula nunc, vel commodo felis urna ut lectus. Aliquam dapibus, neque eu accumsan mollis, massa sem pharetra urna, ac rutrum odio dui sit amet velit. Curabitur sit amet nulla vitae tortor mattis porta. Nam vitae tellus quis lacus egestas tincidunt. Phasellus lacus felis, mattis ac quam ac, ultricies suscipit turpis.<br><br>
  </div>
</div>
<div class="row mt-4" id="signature-box" style="display:none; margin:20px;">
  <div class="col-sm-4">
    <span style="font-size:16px;">Disetujui Client (tanda tangan)</span><br>
    <canvas id="signature-pad" class="signature-pad" height=100 style="border: solid 1px;"></canvas><br>
    <button class="btn btn-default" id="clear-signature">Clear</button>
    <!-- <div style="height:100px;border:solid 1px;">
      <p style="text-align:center">Signature</p>
    </div> -->
  </div>
  <div class="col-sm-4">
    <span style="font-size:16px;">Deadline finish Photo</span><br>
    <div style="height:100px;border:solid 1px;" class="d-flex align-items-center justify-content-center">
      <!-- <p style="font-size:14px;" id="deadline-date">12-12-2022</p> -->
      <input type="text" name="deadline-date" id="deadline-date" />
    </div>
  </div>
  <div class="col-sm-4">
    <span style="font-size:16px;">Customer Service</span><br>
    <div style="height:100px;border:solid 1px;" class="d-flex align-items-center justify-content-center">
      <p style="font-size:14px;" id="cs-name">Fajar Hidayah</p>
    </div>
  </div>
</div>
<div class="modal" id="empty-signature" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="font-size:20px; text-align:center">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Anda belum melakukan tanda tangan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Anda belum melakukan tanda tangan. silahkan isi form tanda tangan untuk menyelesaikan form.
      </div>
    </div>
  </div>
</div>
<?php $step5 = ob_get_clean(); ?>

<!-- FORM WIZARD -->
<?php
$wizard_config = [
  'id' => 'stepwizard',
  'steps' => [
    1 => [
      'title' => 'Form Pilih Foto',
      'icon' => 'glyphicon glyphicon-cloud-download',
      'content' => $step1,
      'buttons' => [
        'next' => [
          'title' => 'Next', 
          'options' => [
            'id' => 'next-to-preview'
          ],
         ],
       ],
      // 'url' => ['/foto/step1'],
    ],
    2 => [
      'title' => 'Preview Foto',
      'icon' => 'glyphicon glyphicon-cloud-download',
      'content' => $step2,
      'buttons' => [
        'next' => [
          'title' => 'Next', 
          'options' => [
            'id' => 'next-to-rekap'
          ],
         ],
       ],
      // 'url' => ['/foto/step1'],
    ],
    3 => [
      'title' => 'Rekap',
      'icon' => 'glyphicon glyphicon-cloud-upload',
      'content' => $step3,
      'buttons' => [
        'next' => [
          'title' => 'Next', 
          'options' => [
            'id' => 'next-to-finalisasi-review'
          ],
         ],
       ],
    ],
    4 => [
      'title' => 'Finalisasi Review',
      'icon' => 'glyphicon glyphicon-transfer',
      'content' => $step4,
      'buttons' => [
        'next' => [
          'title' => 'Next', 
          'options' => [
            'id' => 'next-to-finalisasi'
          ],
         ],
       ],
    ],
    5 => [
      'title' => 'Finalisasi',
      'icon' => 'glyphicon glyphicon-transfer',
      'content' => $step5,
      'buttons' => [
        'save' => [
          'title' => 'Submit', 
          'options' => [
            'id' => 'next-to-done',
            "class" => "btn btn-primary"
          ],
         ],
       ],
    ],
  ],
  // 'complete_content' => '<h2>Terima Kasih Sudah Mengabadikan Momen Kamu di Studio Foto </h2><span style="font-size:14px;">Silahkan print bukti pemilihan foto: <a href="https://google.com"><i class="fas fa-print"></i> Print</a></span>', 
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>

<?php
$script = <<< JS
  $(document).ready(function(){
    $('#deadline-date').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 1901,
      maxYear: parseInt(moment().format('YYYY'),10),
      locale: {
        format: 'YYYY-MM-DD'
      }
    })

    // let backend = "https://localhost/fotostudio-be" //harus diganti
    let backend = "/babymilano/backend/web" //harus diganti
    let detcus_id = get_detcus_id()
    let _detail_customer, _customer, _foto, _paket, _karyawan, _album, _frame, _paket_upgrade, _frame_group, _cetak_foto, _lokasi_folder_start, _lokasi_folder_start_original, _foto_all, _frame_all, _cetak_all, _album_name, _album_ukuran
    let new_list_frame = []
    let all_list_frame = []
    let selected_frame = []
    let total_tambahan = 0
    get_data(detcus_id)

    if(_detail_customer.detcus_status_pilih_foto == 'SUDAH PILIH FOTO'){
      // window.location.href = "https://localhost/fotostudio-fe" //haru diganti
      window.location.href = "/babymilano/frontend/web" //haru diganti
    }

    renderFrameOption(_frame)
    if(_album) renderAlbumOption(_album)
    else $('#pilih_album_section').hide()

    Fancybox.bind("[data-fancybox]", {});
    let foto_utama = [],
        cetak = [],
        tambah_foto = [],
        limit_foto_utama = _paket.paket_jumlah_foto_utama,
        limit_cetak = _paket.paket_jumlah_cetak

    $.contextMenu({
        selector: '.context-menu', 
        build: function() {
          var options = {
            callback: function(key, options) {
                let id = $(this).data('id')
                if(key == 'foto_utama' && foto_utama.length <= limit_foto_utama){
                  if(foto_utama.includes(id)){
                    foto_utama.pop(id)
                    if(foto_utama.includes(id) || cetak.includes(id) || tambah_foto.includes(id)){
                      $(this).css("background-color", "#d6861e")
                    }else{
                      $(this).css("background-color", "white")
                    }
                  }else{
                    if(foto_utama.length < limit_foto_utama){
                      foto_utama.push(id)
                      $(this).css("background-color", "#d6861e")
                    }
                  }
                }else if(key == 'cetak' && cetak.length <= limit_cetak){
                  if(cetak.includes(id)){
                    cetak.pop(id)
                    if(foto_utama.includes(id) || cetak.includes(id) || tambah_foto.includes(id)){
                      $(this).css("background-color", "#d92121")
                    }else{
                      $(this).css("background-color", "white")
                    }
                  }else{
                    if(cetak.length < limit_cetak){
                      cetak.push(id)
                      $(this).css("background-color", "#d92121")
                    }
                  }
                }else if(key == 'tambah_foto'){
                  if(tambah_foto.includes(id)){
                    tambah_foto.pop(id)
                    if(foto_utama.includes(id) || cetak.includes(id) || tambah_foto.includes(id)){
                      $(this).css("background-color", "#1919d1")
                    }else{
                      $(this).css("background-color", "white")
                    }
                  }else{
                    tambah_foto.push(id)
                    $(this).css("background-color", "#1919d1")
                  }
                }
                return true
            },
            items: {
                "foto_utama": {name: 'Foto Utama ('+foto_utama.length+'/'+limit_foto_utama+')'},
                "cetak": {name: 'Cetak ('+cetak.length+'/'+limit_cetak+')'},
                "tambah_foto": {name: 'Tambah Foto ('+tambah_foto.length+')'},
            }
          }
          return options
        }
    });

    let signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
      backgroundColor: 'rgba(255, 255, 255, 0)',
      penColor: 'rgb(0, 0, 0)'
    });

    // window.onbeforeunload = function() {
    //   return "Data akan hilang jika Anda meninggalkan halaman. Apakah Anda yakin?";
    // };

    $('#next-to-preview').click(function(){
      console.log("NEXT TO PREVIEW")
      let diff_foto_utama = limit_foto_utama - foto_utama.length,
          diff_cetak = limit_cetak - cetak.length,
          diff_all = diff_foto_utama + diff_cetak


      if(diff_all > 0){
        $('#preview-diff').html(diff_all)
        $('#preview-modal').modal('show')
      }
      console.log("")

      let foto_utama_html = ''
      for(let item of foto_utama){
        let foto = _foto[item]
        let img_html = '<img class="img-responsive img-thumbnail kv-context" src="'+_lokasi_folder_start+"/"+foto+'" data-id="'+item+'" alt="image" style="height:150px;"/>'
        foto_utama_html += img_html
      }
      $('#preview-foto-utama').html(foto_utama_html)

      let cetak_html = ''
      for(let item of cetak){
        let foto = _foto[item]
        let img_html = '<img class="img-responsive img-thumbnail kv-context" src="'+_lokasi_folder_start+"/"+foto+'" data-id="'+item+'" alt="image" style="height:150px;"/>'
        cetak_html += img_html
      }
      $('#preview-cetak').html(cetak_html)

      let tambah_foto_html = ''
      for(let item of tambah_foto){
        let foto = _foto[item]
        let img_html = '<img class="img-responsive img-thumbnail kv-context" src="'+_lokasi_folder_start+"/"+foto+'" data-id="'+item+'" alt="image" style="height:150px;"/>'
        tambah_foto_html += img_html
      }
      $('#preview-tambah-foto').html(tambah_foto_html)

    })

    $('#preview-back-button').click(function(){
      $('#preview-modal').modal('toggle')
      var active = $('.wizard .nav-tabs li.active');
      $( active).prev().find('a[data-toggle="tab"]').click();
    })

    $('#rekap-back-button').click(function(){
      $('#rekap-modal').modal('toggle')
      var active = $('.wizard .nav-tabs li.active');
      $( active).prev().find('a[data-toggle="tab"]').click();
    })

    $('#next-to-rekap').click(function(){
      console.log("NEXT TO REKAP")

      let foto_utama_html = ''
      for(let item of foto_utama){
        let foto = _foto[item]
        let img_html = `
          <div class="col-sm-4 d-flex justify-content-center mt-4">
            <form>
              <img src="`+_lokasi_folder_start+"/"+foto+`" class="img-responsive img-thumbnail" style="height:150px;">
              <h1>Foto Utama</h1>
              <div class="form-group">
                <textarea id="textarea-`+item+`" class="rekap-foto-description form-control" placeholder="Tulis catatan untuk foto.."></textarea>
              </div>
              <div class="form-group">
                <select id="select-`+item+`" class="rekap-frame-selection form-control print-option">
                  <option>--Pilih Frame--</option>
                </select>
              </div>
            </form>
          </div>`
        foto_utama_html += img_html
      }

      let cetak_html = ''
      for(let item of cetak){
        let foto = _foto[item]
        let img_html = `
          <div class="col-sm-4 d-flex justify-content-center mt-4">
            <form>
              <img src="`+_lokasi_folder_start+"/"+foto+`" class="img-responsive img-thumbnail" style="height:150px;">
              <h1>Cetak</h1>
              <div class="form-group">
                <textarea id="textarea-`+item+`" class="rekap-foto-description form-control" placeholder="Tulis catatan untuk foto.."></textarea>
              </div>
              <div class="form-group">
                <select id="select-`+item+`" class="rekap-cetak-selection form-control print-option">
                  <option>--Pilih Frame--</option>
                </select>
              </div>
            </form>
          </div>`
        cetak_html += img_html
      }

      let tambah_foto_html = ''
      for(let item of tambah_foto){
        let foto = _foto[item]
        let img_html = `
          <div class="col-sm-4 d-flex justify-content-center mt-4">
            <form>
              <img src="`+_lokasi_folder_start+"/"+foto+`" class="img-responsive img-thumbnail" style="height:150px;">
              <h1>Foto Tambahan</h1>
              <div class="form-group">
                <textarea id="textarea-`+item+`" class="rekap-foto-description form-control" placeholder="Tulis catatan untuk foto.."></textarea>
              </div>
              <div class="form-group">
                <select id="select-`+item+`" class="rekap-cetak-selection form-control print-option">
                  <option>--Pilih Frame--</option>
                </select>
              </div>
            </form>
          </div>`
          tambah_foto_html += img_html
      }
      let rekap_foto_html = foto_utama_html + cetak_html + tambah_foto_html
      $('#rekap-foto-list').html(rekap_foto_html)
      renderCommonData(_customer, _detail_customer, _paket, _karyawan)

    })

    $('#next-to-finalisasi-review').click(function(){
      let ids = []
      for(let item of foto_utama){
        ids.push($(`#select-`+item).find('option').filter(':selected').val())
      }
      if(new Set(ids).size !== ids.length){
        $('#rekap-modal').modal('show')
      }else{
        let count_main = 1, count_additional = 1
        let foto_utama_html = ''
        for(let item of foto_utama){
          let foto = _foto[item]
          let img_html = `<img class="img-responsive img-thumbnail" src="`+_lokasi_folder_start+"/"+foto+`" data-id="`+item+`" alt="image" style="height:150px;"/>`
          let cetak_size = $(`#select-`+item).find('option').filter(':selected').text()
          let keterangan = $(`#textarea-`+item).val()

          let row_html = `<tr>
            <td>`+count_main+`</td>
            <td>`+img_html+`</td>
            <td>`+foto+`</td>
            <td>Foto Utama</td>
            <td>`+cetak_size+`</td>
            <td>`+keterangan+`</td>
          </tr>`

          foto_utama_html += row_html
          count_main++
        }

        let cetak_html = ''
        for(let item of cetak){
          let foto =  _foto[item]
          let img_html = `<img class="img-responsive img-thumbnail" src="`+_lokasi_folder_start+"/"+foto+`" data-id="`+item+`" alt="image" style="height:150px;"/>`
          let cetak_size = $(`#select-`+item).find('option').filter(':selected').text()
          let keterangan = $(`#textarea-`+item).val()

          let row_html = `<tr>
            <td>`+count_main+`</td>
            <td>`+img_html+`</td>
            <td>`+foto+`</td>
            <td>Cetak</td>
            <td>`+cetak_size+`</td>
            <td>`+keterangan+`</td>
          </tr>`

          cetak_html += row_html
          count_main++
        }

        let tambah_foto_html = ''
        let item_index = 0
        for(let item of tambah_foto){
          let foto =  _foto[item]
          let img_html = `<img class="img-responsive img-thumbnail" src="`+_lokasi_folder_start+"/"+foto+`" data-id="`+item+`" alt="image" style="height:150px;"/>`
          let cetak_size = $(`#select-`+item).find('option').filter(':selected').text()
          let keterangan = $(`#textarea-`+item).val()
          // let price = formatRupiah(_paket_upgrade.upg_harga.toString(), true) //dummy
          let price = formatRupiah("0", true) //dummy

          let frame_index = 0
          let select_frame_html = `
          <select id="select-tambahan-frame-`+item+`" data-id="`+item+`" class="rekap-tambahan-frame form-control print-option">
            <option value="">--Pilih Frame--</option>`
          for(let _frame_item of all_list_frame){
            let option_html = `<option value="`+frame_index+`">`+_frame_item.frame_name+` `+_frame_item.warna_frame+` `+_frame_item.ukuran_frame+``+`</option>`
            select_frame_html += option_html
            frame_index++
          }
          select_frame_html += "</select>"

          let cetak_index = 0
          let select_cetak_html = `
          <select id="select-tambahan-cetak-`+item+`"  data-id="`+item+`" class="rekap-tambahan-cetak form-control print-option">
            <option value="">--Pilih Cetak--</option>`
          for(let _cetak_item of _cetak_all){
            let option_html = `<option value="`+cetak_index+`">`+_cetak_item.cetak_nama+` (`+_cetak_item.cetak_size+`)`+`</option>`
            select_cetak_html += option_html
            cetak_index++
          }
          select_cetak_html += "</select>"


          let row_html = `<tr>
            <td>`+count_additional+`</td>
            <td>`+img_html+`</td>
            <td>`+foto+`</td>
            <td>Foto Tambahan</td>
            <td>
              <div class="row">
                <div class="col-lg-6">
                  `+select_frame_html+`
                </div>
                <div class="col-lg-6">
                  `+select_cetak_html+`
                </div>
              </div> 
            </td>
            <td><textarea id="textarea-tambahan-`+item+`">`+keterangan+`</textarea></td>
            <td id="harga-tambahan-`+item+`">`+price+`</td>
          </tr>`

          tambah_foto_html += row_html
          count_additional++
          item_index++
        }

        let main_head_html = `<tr>
          <th>No</th>
          <th>Foto</th>
          <th>Nama File</th>
          <th>Detail</th>
          <th>Produk Foto</th>
          <th>Deskripsi</th>
        </tr>`

        let additional_head_html = `<tr>
          <th>No</th>
          <th>Foto</th>
          <th>Nama File</th>
          <th>Detail</th>
          <th>Produk Foto</th>
          <th>Deskripsi</th>
          <th>Harga</th>
        </tr>`

        let additional_footer = `<tr>
          <td colspan="6" style="text-align:center;"><strong>TOTAL</strong></td>
          <td id="total_tambahan"><strong>`+formatRupiah(total_tambahan.toString(), true)+`</strong></td>
        </tr>`

        $('#list-main').html(main_head_html+foto_utama_html+cetak_html)
        $('#list-additional').html(additional_head_html+tambah_foto_html+additional_footer)
        console.log("TAMBAH FOTO: ", tambah_foto)
        if(tambah_foto.length < 1) $('#list-additional').css("display", "none")
      }
    })

    $('#next-to-finalisasi').click(function(){
      $('#next-to-done').css("display", "none")
      console.log("START: ", formatDate(new Date()))
      // let deadline_date = getDeadlineDate(new Date())
      // $('#deadline-date').html(deadline_date)
    })

    $('#checkbox_tnc').change(function(){
      if ($(this).prop('checked')==true){ 
        $('#signature-box').css("display", "block")
        $('#next-to-done').css("display", "block")
      }else{
        $('#signature-box').css("display", "none")
      }
    })

    $('#clear-signature').click(function(){
      signaturePad.clear()
    })

    $('#next-to-done').click(function(){
      if(signaturePad.isEmpty()){
        var active = $('.wizard .nav-tabs li.active');
        $( active).prev().find('a[data-toggle="tab"]').click();
        $('#empty-signature').modal('show')
      }else{
        $('#loading').show()

        let foto_item = []
        for(let item of foto_utama){
          let foto_temp = _foto[item]
          let foto = _foto_all.find(x => x.foto_nama_file == foto_temp || x.foto_image == foto_temp)

          let select_id = $(`#select-`+item).find('option').filter(':selected').val()
          let frame_temp = selected_frame[select_id]

          let obj = {
            type: 'Utama',
            foto_id: foto.foto_id,
            keterangan: $(`#textarea-`+item).val(),
            jenis_frame_id: frame_temp.jenis_frame_id,
            cetak_foto_id: '',
            harga: frame_temp.harga_frame,
            ref_frame_id: frame_temp.frame_id,
            ref_ukuran_frame_id: frame_temp.ukuran_frame_id,
            nama_file: foto_temp
          }
          foto_item.push(obj)
        }
        for(let item of cetak){
          let foto_temp = _foto[item]
          let foto = _foto_all.find(x => x.foto_nama_file == foto_temp || x.foto_image == foto_temp)
          let obj = {
            type: 'Cetak',
            foto_id: foto.foto_id,
            keterangan: $(`#textarea-`+item).val(),
            jenis_frame_id: '',
            cetak_foto_id: _cetak_foto.cetak_id,
            harga: _cetak_foto.cetak_harga,
            ref_frame_id: '',
            ref_ukuran_frame_id: '',
            nama_file: foto_temp
          }
          foto_item.push(obj)
        }

        let tambah_index = 0
        for(let item of tambah_foto){
          let foto_temp = _foto[item]
          let foto = _foto_all.find(x => x.foto_nama_file == foto_temp || x.foto_image == foto_temp)
          let frame_id = $(`#select-tambahan-frame-`+item).find(":selected").val()
          let frame = all_list_frame[frame_id]
          let cetak_id = $(`#select-tambahan-cetak-`+item).find(":selected").val()
          let cetak = _cetak_all[cetak_id]
          let deskripsi = $(`#textarea-tambahan-`+item).val()
          let obj = {
            type: 'Tambah',
            foto_id: foto.foto_id,
            keterangan: deskripsi,
            jenis_frame_id: frame ? frame.jenis_frame_id : '',
            cetak_foto_id: cetak ? cetak.cetak_id : '',
            harga: frame ? frame.harga_frame : cetak.cetak_harga,
            ref_frame_id: frame ? frame.frame_id : '',
            ref_ukuran_frame_id: frame ? frame.ukuran_frame_id : '',
            nama_file: foto_temp
          }
          foto_item.push(obj)
        }

        let base64 = signaturePad.toDataURL()

        let request_data = {
          detcus_id: detcus_id,
          foto: foto_item,
          deadline_date: $('#deadline-date').val(),
          root_folder: _lokasi_folder_start_original,
          total_tambahan: total_tambahan,
          karyawan_id: $(`#select-karyawan`).find(":selected").val()
        }

        let request_signature = {
          detcus_id: detcus_id,
          signature: base64
        }

        $.ajax({
          async: true,
          url: `index.php?r=foto/save-signature`,
          type: 'POST',
          data: request_signature,
          error: function(res) {
            console.log(res)
            // const response = JSON.parse(res.responseText)
          },
          success: function(res) {
            console.log(res)
            if(res.status == 'success'){
              request_data.signature_url  = res.data
              save_data(request_data)
            }
            // const hasil_foto_id = res.data.toString()
            // deleteFoto(hasil_foto_id)
          }
        });
      }
    })

    function save_data(request){
      console.log("REQUEST ", request)
      $.ajax({
          async: true,
          url: `index.php?r=foto/save-hasil-foto`,
          type: 'POST',
          data: request,
          error: function(res) {
            console.log(res)
          },
          success: function(res) {
            console.log(res)
            if(res.status == 'success'){
              const hasil_foto_id = res.data.toString()
              $('#loading').hide()
              let link = "index.php?r=foto/step-complete&hasil_foto_id="+hasil_foto_id
              window.location.href = link
            }
          }
        });
    }

    $('.add-frame-button').click(function(){
      let key = $(this).data("key")
      let sub = $(this).data("sub")
      let max_content = $(`#max-qty-`+key).html()
      let max = parseInt(max_content)
      if(max > 0){
        $(this).prop("disabled", true);
        max -= 1
        $(`#max-qty-`+key).html(max)
        selected_frame.push(new_list_frame[sub])
        renderFrameBox()
        renderFrameDropwon()
      }
    })

    $('.add-album-button').click(function(){
      let album_id = $(this).data("id")
      renderAlbumBox(album_id)
    })

    $("body").delegate(".rekap-tambahan-frame", "change", function(e) {
      let id = $(this).data("id")
      let tambahan_frame_id = $(`#select-tambahan-frame-`+id).find(":selected").val()
      console.log("CHANGE FRAME TAMBAHAN ID: ", id)
      if(id && tambahan_frame_id){
        let tc_temp = $(`#select-tambahan-cetak-`+id).find(":selected").val()
        if(tc_temp && tc_temp != ''){
          let tambahan_cetak = _cetak_all[tc_temp]
          let harga_cetak = tambahan_cetak.cetak_harga
          total_tambahan -= harga_cetak
        }

        let tambahan_frame = all_list_frame[tambahan_frame_id]
        let harga = tambahan_frame.harga_frame
        total_tambahan += harga

        $('#harga-tambahan-'+id).html(formatRupiah(harga.toString(), true))
        $(`#select-tambahan-cetak-`+id).val('').change();
        $('#total_tambahan').html(`<strong>`+formatRupiah(total_tambahan.toString()+`</strong>`, true))
      }
    })

    $("body").delegate(".rekap-tambahan-cetak", "change", function(e) {
      let id = $(this).data("id")
      let tambahan_cetak_id = $(`#select-tambahan-cetak-`+id).find(":selected").val()
      console.log("CHANGE CETAK TAMBAHAN ID: ", id)
      if(id && tambahan_cetak_id){
        let tf_temp = $(`#select-tambahan-frame-`+id).find(":selected").val()
        if(tf_temp && tf_temp != ''){
          let tambahan_frame = all_list_frame[tf_temp]
          let harga_frame = tambahan_frame.harga_frame
          total_tambahan -= harga_frame
        }

        let tambahan_cetak = _cetak_all[tambahan_cetak_id]
        let harga = tambahan_cetak.cetak_harga
        total_tambahan += harga

        $('#harga-tambahan-'+id).html(formatRupiah(harga.toString(), true))
        $(`#select-tambahan-frame-`+id).val('').change();
        $('#total_tambahan').html(`<strong>`+formatRupiah(total_tambahan.toString()+`</strong>`, true))
      }
    })

    function getDeadlineDate(date, limit=18, weekendDayBefore=null){
      let start = date
      let start_temp = new Date(start.getTime());
      let finish_timestamp = start_temp.setDate(start_temp.getDate() + limit);
      let finish = new Date(finish_timestamp)
      let dayMilliseconds = 1000 * 60 * 60 * 24;
      let weekendDays = 0;
      while (start <= finish) {
        let day = start.getDay()
        if (day == 0) {
          weekendDays++;
        }
        start = new Date(+start + dayMilliseconds);
      }
      if(weekendDayBefore){
        if(weekendDayBefore == weekendDays){
          console.log("FINISH: ", formatDate(finish))
          return formatDate(finish)
        }else{
          console.log("start: ", formatDate(start))
          console.log("limit: ", limit+weekendDays)
          console.log("weekend day: ", weekendDays)
          return getDeadlineDate(new Date(), limit+weekendDays, weekendDays)
        }
      }else{
        
        console.log("start: ", formatDate(start))
        console.log("limit: ", limit+weekendDays)
        console.log("weekend day: ", weekendDays)
        if(weekendDays > 0){
          return getDeadlineDate(new Date(), limit+weekendDays, weekendDays)          
        }else{
          return formatDate(finish)
        }
      }
    }

    function formatDate(dateObj){
      let today = dateObj;
      let dd = String(today.getDate()).padStart(2, '0');
      let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      let yyyy = today.getFullYear();

      today = dd + '/' + mm + '/' + yyyy;
      return today
    }

    function formatDate2(dateObj){
      let today = dateObj;
      let dd = String(today.getDate()).padStart(2, '0');
      let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      let yyyy = today.getFullYear();

      today = yyyy + "-" + mm + '-' + yy;
      return today
    }

    // function deleteFoto(hasil_foto_id){
    //   $.ajax({
    //     async: true,
    //     url: ``+backend+`/index.php?r=foto/delete-by-hasil-foto&hasil_foto_id=`+hasil_foto_id,
    //     type: 'GET',
    //     error: function(res) {
    //       const response = JSON.parse(res.responseText)
    //     },
    //     success: function(res) {
    //       console.log("DATA:", res)
    //       $('#loading').hide()
    //       let link = "index.php?r=foto/step-complete&hasil_foto_id="+hasil_foto_id
    //       window.location.href = link
    //     }
    //   });
      
    // }

    function get_detcus_id(){
      const urlSearchParams = new URLSearchParams(window.location.search);
      const params = Object.fromEntries(urlSearchParams.entries());
      return params.foto_detcus_id
    }

    function get_data(detcus_id){
      $.ajax({
        async: false,
        url: `index.php?r=foto/get-detail-foto&detcus_id=`+detcus_id,
        type: 'GET',
        error: function(res) {
          const response = JSON.parse(res.responseText)
        },
        success: function(res) {
          console.log("DATA:", res)
          _detail_customer = res.detail_customer
          _customer = res.customer
          _foto_all = res.foto_all
          _paket = res.paket_foto
          _karyawan = res.karyawan
          _frame = res.jenis_frame
          _paket_upgrade = res.paket_upgrade
          _cetak_foto = res.cetak_foto
          _lokasi_folder_start = res.lokasi_folder_start
          _lokasi_folder_start_original = res.lokasi_folder_start_original
          _foto = res.files_lokasi_folder_start
          _frame_all = res.frame_all
          _cetak_all = res.cetak_foto_all
          if(res.album){
            _album = res.album
            _album_name = res.album_nama
            _album_ukuran = res.album_ukuran
          }

          $('#loading').hide()
        }
      });

      // $.get('index.php?r=foto/get-detail-foto', { detcus_id : detcus_id }, function(data) {})
    }

    function renderCommonData(customer, customer_detail, paket_foto, karyawan){
      $('.no-invoice').html(customer_detail.detcus_no_invoice)
      $('.order-tanggal').html(customer_detail.detcus_tanggal)
      $('.customer-name').html(customer.cust_nama)
      $('.nama-paket').html(paket_foto.paket_nama)
      // $('#deadline-date').html(customer_detail.detcus_tgl_deadline)

      let karyawan_html = `<select id="select-karyawan" class="form-control">`
      for(let item of karyawan){
        let option_html = `<option value="`+item.kary_id+`">`+item.kary_nama+`</option>`
        karyawan_html += option_html
      }
      karyawan_html += `</select>`
      $('#cs-name').html(karyawan_html)

      // $('.rekap-frame-selection').html(size_cetak_html)
    }

    function formatFrame(frames){
      for(const frame of frames){
        let jenis_frame = frame.jenis_frame
        let ref_frame = frame.ref_frame
        let ref_ukuran_frame = frame.ref_ukuran_frame

        for(const item of jenis_frame){
          let img_html = item.frame_gambar && item.frame_gambar != "" ? `<img class="img-responsive well card card-body" src="`+backend+`/`+item.frame_gambar+`" data-id="`+item.frame_id+`" alt="image" style="width:100px;"/>` : ''
          let frame_name = ref_frame.nama
          let ukuran_frame = ref_ukuran_frame.nama_size
          let warna_frame = item.frame_warna

          all_list_frame.push({
            img: img_html,
            frame_name: frame_name,
            warna_frame: warna_frame,
            ukuran_frame: ukuran_frame,
            harga_frame: item.frame_harga,
            jenis_frame_id: item.frame_id,
            ukuran_frame_id: ref_ukuran_frame.idukuranframe,
            frame_id: ref_frame.idframe
          })
        }
      }
    }

    function renderFrameOption(frames){
      formatFrame(_frame_all)

      let index = 0
      let sub = 0
      let table_frame_html = ""
      for(const frame of frames){
        let jenis_frame = frame.jenis_frame
        let ref_frame = frame.ref_frame
        let ref_ukuran_frame = frame.ref_ukuran_frame
        let max_qty = frame.max_qty

        let frame_option_html = ''
        for(const item of jenis_frame){
          let img_html = item.frame_gambar && item.frame_gambar != "" ? `<img class="img-responsive well card card-body" src="`+backend+`/`+item.frame_gambar+`" data-id="`+item.frame_id+`" alt="image" style="width:100px;"/>` : ''
          let frame_name = ref_frame.nama
          let ukuran_frame = ref_ukuran_frame.nama_size
          let warna_frame = item.frame_warna
          let harga_frame = formatRupiah(item.frame_harga.toString(), true)

          new_list_frame.push({
            img: img_html,
            frame_name: frame_name,
            warna_frame: warna_frame,
            ukuran_frame: ukuran_frame,
            harga_frame: item.frame_harga,
            jenis_frame_id: item.frame_id,
            ukuran_frame_id: ref_ukuran_frame.idukuranframe,
            frame_id: ref_frame.idframe
          })

          let item_html = `
          <tr>
            <td>`+img_html+`</td>
            <td>`+frame_name+`</td>
            <td>`+ukuran_frame+`</td>
            <td>`+warna_frame+`</td>
            
            <td><button class="btn btn-success add-frame-button" data-key="`+index+`" data-sub="`+sub+`">Tambah</button></td>
          </tr>`
          frame_option_html += item_html
          sub++
        }
        let list_frame_head_html = `<br>
            Sisa Pilihan: <span id="max-qty-`+index+`">`+max_qty+`</span>
            <table class="table table-striped table-bordered">
              <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Ukuran</th>
                <th>Warna</th>
                <th>Aksi</th>
              </tr>
              `+frame_option_html+`
            </table>`

        table_frame_html += list_frame_head_html
        index++
      }
      
      $('#modal-list-frame').html(table_frame_html)
    }

    function renderFrameBox(){
      let frame_names = selected_frame.reduce(function (r, a) {
        if(!r.includes(a.frame_name)) r.push(a.frame_name)
        return r;
      }, []);

      let ukuran_frames = selected_frame.reduce(function (r, a) {
        if(!r.includes(a.ukuran_frame)) r.push(a.ukuran_frame)
        return r;
      }, []);

      let warna_frames = selected_frame.reduce(function (r, a) {
        if(!r.includes(a.warna_frame)) r.push(a.warna_frame)
        return r;
      }, []);

      let imgs = selected_frame.reduce(function (r, a) {
        if(!r.includes(a.img)) r.push(a.img)
        return r;
      }, []);

      $('#nama-bingkai').html(frame_names.join(", "))
      $('#ukuran-bingkai').html(ukuran_frames.join(", "))
      $('#warna-bingkai').html(warna_frames.join(", "))
      $('#rekap-frame-img').html(imgs.join("<br>"))
    }

    function renderFrameDropwon(){

      let index = 0
      let frame_option_html = ''
      for(let item of selected_frame){
        let frame_html =  `<option value="`+index+`">`+item.frame_name+` `+item.warna_frame+` (`+item.ukuran_frame+`)</option>`
        frame_option_html += frame_html
        index++
      }

      let cetak_html = `<option value="`+_cetak_foto.cetak_id+`">` + _cetak_foto.cetak_nama + " (" + _cetak_foto.cetak_size + ")" + `</option>`

      $('.rekap-frame-selection').html(frame_option_html)
      $('.rekap-cetak-selection').html(cetak_html)
    }

    function renderAlbumOption(album){
      let album_html = ''

      let img_html = `<img class="img-responsive well card card-body" src="`+backend+`/`+album.album_gambar+`" data-id="`+album.album_id+`" alt="image" style="width:100px;"/>`

      let item_html = `<tr>
          <td>`+_album_name.nama+`</td>
          <td>`+album.album_warna+`</td>
          <td>`+_album_ukuran.nama_size+`</td>
          <td>`+img_html+`</td>
          <td>`+formatRupiah(album.album_harga.toString(), true)+`</td>
          <td><button class="btn btn-success add-album-button" data-dismiss="modal" data-id="`+album.album_id+`">Pilih</button></td>
        </tr>`
        album_html += item_html

      let list_album_head_html = `
        <tr>
          <th>Nama</th>
          <th>Warna</th>
          <th>Ukuran</th>
          <th>Gambar</th>
          <th>Harga</th>
          <th>Aksi</th>
        </tr>`
      $('#modal-list-album').html(list_album_head_html+album_html)
    }

    function renderAlbumBox(album_id){
      // let album = _album.find(x => x.album_id == album_id)
      let album = _album
      let img_html = `<img class="img-responsive well card card-body" src="`+backend+`/`+album.album_gambar+`" data-id="`+album.album_id+`" alt="image" style="width:100px;"/>`

      $('#nama-album').html(_album_name.nama)
      $('#ukuran-album').html(_album_ukuran.nama_size)
      $('#warna-album').html(album.album_warna)
      $('#rekap-album-img').html(img_html)
    }

    function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

  });
 
JS;
$this->registerJs($script);
