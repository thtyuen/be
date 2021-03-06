<?php

use aabc\helpers\Html;   
use aabc\grid\GridView;

//use aabc\bootstrap\Modal; /*Them*/
use aabc\helpers\Url; /*Them*/
use aabc\helpers\ArrayHelper; /*Them*/
use aabc\widgets\ActiveForm;
/*use app\models\Dskh; */


/* @var $this aabc\web\View */
// use backend\models\DanhmucSearch ;
// use backend\models\Danhmuc ;
/* @var $dataProvider aabc\data\ActiveDataProvider */

$this->title = 'Thông số sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="pj<?=Aabc::$app->_model->__danhmuc?>"    <?=Aabc::$app->d->i?>=<?= Aabc::$app->_model->__danhmuc?> class="pj">


<div class="<?= Aabc::$app->_model->__danhmuc?>-index">

    <style type="text/css">
        #modal2 .modal-header{
            height: 30px;
        }
        #modal2 .modal-header button{
            display: none;
        }
    </style>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<p>  
                

         <?php         
        $_Danhmuc = Aabc::$app->_model->Danhmuc;        
        $demthungrac = count($_Danhmuc::getAllRecycle1_5());

            echo '<button type="button"  '.Aabc::$app->d->m.'="3"  '.($demthungrac > 0 ? : 'disabled').'  id="mb'.Aabc::$app->_model->__danhmuc.'r" '.Aabc::$app->d->u.'="ir_tn" class="btn btn-danger mb" '.Aabc::$app->d->i.'="'.Aabc::$app->_model->__danhmuc.'"><span class="glyphicon glyphicon-trash mden"></span>'.Aabc::$app->MyConst->view_btn_thungrac.' ('.$demthungrac.')</button>';
        
        ?>
   

    </p>

  
    <?= $this->render('_gridview5', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]) ?>



  
<div style="clear: both"></div>
   
 <div class="form-group right">    
    <button type="button" class="btn btn-default rlts" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-ban-circle mdo"></span>Đóng</button>
</div>


<script type="text/javascript">        
    $('.rlts').click(function(){
        loadimg();
        $.ajax({
            cache: false,
            url: 'danhmuc/rts?ts=<?= empty($_GET['ts'])?'':$_GET['ts']?>&stt=<?= empty($_GET['stt'])?'':$_GET['stt']?>&sp=<?= empty($_GET['sp'])?'':$_GET['sp']?>',
            type: 'POST',               
            success: function (data) {
                $('#tssp<?= empty($_GET['ts'])?'':$_GET['ts']?>').html(data)
                unloadimg(); 
            },
            error: function () {
                poploi();                    
            }
        });

    });     
</script>

</div>
