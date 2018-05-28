<?php
namespace backend\models;
use Aabc;
use aabc\helpers\ArrayHelper;

class Chinhsach extends \aabc\db\ActiveRecord
{
    
    public static function tableName()
    {
        return Aabc::$app->_chinhsach->table;        
    }

    const TRONGTHUNGRAC = 1;
    const NGOAITHUNGRAC = 2;

    const ON = 1;
    const OFF = 2;

    const KHUYENMAI = 1;
    const BAOHANH = 2;
    const GIAOHANG = 3;

    const APDUNGTATCA = 1;
    const APDUNGDANHMUC = 2;


    public function rules()
    {
        return [
            [[Aabc::$app->_chinhsach->cs_type, Aabc::$app->_chinhsach->cs_typetyle, Aabc::$app->_chinhsach->cs_apdungcho, Aabc::$app->_chinhsach->cs_dieukien, Aabc::$app->_chinhsach->cs_status, Aabc::$app->_chinhsach->cs_recycle], 'string'],
            [[Aabc::$app->_chinhsach->cs_ten], 'required'],
            [[Aabc::$app->_chinhsach->cs_tylechietkhau, Aabc::$app->_chinhsach->cs_noidungdieukien], 'integer'],
            [[Aabc::$app->_chinhsach->cs_ngaytao, Aabc::$app->_chinhsach->cs_ngaybatdau, Aabc::$app->_chinhsach->cs_ngayketthuc], 'safe'],
            [[Aabc::$app->_chinhsach->cs_ten], 'string', 'max' => 80],
            [[Aabc::$app->_chinhsach->cs_code], 'string', 'max' => 20],
            [[Aabc::$app->_chinhsach->cs_ghichu], 'string', 'max' => 200],

            [[Aabc::$app->_chinhsach->cs_id_danhmuc, Aabc::$app->_chinhsach->cs_id_sp], 'safe'],
        ];
    }



    public function attributeLabels()
    {
        return [
                        
            Aabc::$app->_chinhsach->cs_id => Aabc::$app->_chinhsach->__cs_id ,                        
            Aabc::$app->_chinhsach->cs_type => Aabc::$app->_chinhsach->__cs_type ,                        
            Aabc::$app->_chinhsach->cs_ten => Aabc::$app->_chinhsach->__cs_ten ,                        
            Aabc::$app->_chinhsach->cs_code => Aabc::$app->_chinhsach->__cs_code ,                        
            Aabc::$app->_chinhsach->cs_ghichu => Aabc::$app->_chinhsach->__cs_ghichu ,                        
            Aabc::$app->_chinhsach->cs_typetyle => Aabc::$app->_chinhsach->__cs_typetyle ,                        
            Aabc::$app->_chinhsach->cs_tylechietkhau => Aabc::$app->_chinhsach->__cs_tylechietkhau ,                        
            Aabc::$app->_chinhsach->cs_apdungcho => Aabc::$app->_chinhsach->__cs_apdungcho ,                        
            Aabc::$app->_chinhsach->cs_dieukien => Aabc::$app->_chinhsach->__cs_dieukien ,                        
            Aabc::$app->_chinhsach->cs_noidungdieukien => Aabc::$app->_chinhsach->__cs_noidungdieukien ,                        
            Aabc::$app->_chinhsach->cs_status => Aabc::$app->_chinhsach->__cs_status ,                        
            Aabc::$app->_chinhsach->cs_recycle => Aabc::$app->_chinhsach->__cs_recycle ,                        
            Aabc::$app->_chinhsach->cs_ngaytao => Aabc::$app->_chinhsach->__cs_ngaytao ,                        
            Aabc::$app->_chinhsach->cs_ngaybatdau => Aabc::$app->_chinhsach->__cs_ngaybatdau ,                        
            Aabc::$app->_chinhsach->cs_ngayketthuc => Aabc::$app->_chinhsach->__cs_ngayketthuc ,        
            Aabc::$app->_chinhsach->cs_id_danhmuc => Aabc::$app->_chinhsach->__cs_id_danhmuc 
            ,
            Aabc::$app->_chinhsach->cs_id_sp => Aabc::$app->_chinhsach->__cs_id_sp 
            ,
            ];
    }

  public function getOption($type = NULL)
  {
    $_Chinhsach = Aabc::$app->_model->Chinhsach;
    $chinhsach =  $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_status => $_Chinhsach::ON])
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => $_Chinhsach::NGOAITHUNGRAC])
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => $type])
                           ->orderBy([Aabc::$app->_chinhsach->cs_apdungcho => SORT_ASC]) 
                           ->all();      
    if($chinhsach){
        foreach ($chinhsach as $keycs => $valuecs) {
            if($valuecs[Aabc::$app->_chinhsach->cs_apdungcho] == $_Chinhsach::APDUNGTATCA){
                $chinhsach[$keycs][Aabc::$app->_chinhsach->cs_ten] = '<i>Tất cả</i>'.$valuecs[Aabc::$app->_chinhsach->cs_ten] .'#$'.$valuecs[Aabc::$app->_chinhsach->cs_apdungcho];
            }
            if($valuecs[Aabc::$app->_chinhsach->cs_apdungcho] == $_Chinhsach::APDUNGDANHMUC){
                $chinhsach[$keycs][Aabc::$app->_chinhsach->cs_ten] = $valuecs[Aabc::$app->_chinhsach->cs_ten] .'#$'.$valuecs[Aabc::$app->_chinhsach->cs_apdungcho];
            }
      }
      return ArrayHelper::map($chinhsach,Aabc::$app->_chinhsach->cs_id,Aabc::$app->_chinhsach->cs_ten);
    }
    return [];
  }





    public function getAllRecycle1_1()
    {
        $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '1'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => '1'])
                           ->all();
    }
    public function getAllRecycle1_2()
    {
        $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '1'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => '2'])
                           ->all();
    }
    public function getAllRecycle1_3()
    {
        $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '1'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => '3'])
                           ->all();
    }







   public function getAllRecycle0_1()
   {
       $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '2'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => '1'])
                           ->all();
   }   
  


   public function getAllRecycle0_2()
   {
       $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '2'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => '2'])                         
                           ->all();
   }
   public function getAllRecycle0_3()
   {
       $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '2'])   
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => '3'])
                           ->all();
   }









    public function getAll1_1()
   {
       $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_status => '1'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '2'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => '1'])
                           ->orderBy([Aabc::$app->_chinhsach->cs_apdungcho => SORT_ASC]) 
                           ->all();
   }



    public function getAll1_2()
   {
       $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_status => '1'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '2'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => '2'])
                           ->orderBy([Aabc::$app->_chinhsach->cs_apdungcho => SORT_ASC]) 
                           ->all();
   }
    public function getAll1_3()
   {
       $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_status => '1'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '2'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_type => '3'])
                           ->orderBy([Aabc::$app->_chinhsach->cs_apdungcho => SORT_ASC]) 
                           ->all();
   }








    public function getAll2()
   {
       $_Chinhsach = Aabc::$app->_model->Chinhsach;
       return   $_Chinhsach::find()
                           ->andWhere([Aabc::$app->_chinhsach->cs_status => '2'])
                           ->andWhere([Aabc::$app->_chinhsach->cs_recycle => '2'])
                           ->all();
   }










 /**
     * @return \aabc\db\ActiveQuery
     */
    public function getChinhsachNgonngus()
    {
        $_ChinhsachNgonngu = Aabc::$app->_model->ChinhsachNgonngu;
return $this->hasMany($_ChinhsachNgonngu::className(), [Aabc::$app->_chinhsachngonngu->csnn_id_chinhsach => Aabc::$app->_chinhsach->cs_id]);
    }
    /**
     * @return \aabc\db\ActiveQuery
     */
    public function getCsnnIdNgonngus()
    {
        $_Ngonngu = Aabc::$app->_model->Ngonngu;
return $this->hasMany($_Ngonngu::className(), [Aabc::$app->_ngonngu->ngonngu_id => Aabc::$app->_chinhsachngonngu->csnn_id_ngonngu])->viaTable(Aabc::$app->_chinhsachngonngu->table, [Aabc::$app->_chinhsachngonngu->csnn_id_chinhsach => Aabc::$app->_chinhsach->cs_id]);
    }
    /**
     * @return \aabc\db\ActiveQuery
     */
    public function getDanhmucChinhsaches()
    {
        $_DanhmucChinhsach = Aabc::$app->_model->DanhmucChinhsach;
return $this->hasMany($_DanhmucChinhsach::className(), [Aabc::$app->_danhmucchinhsach->dmcs_id_chinhsach => Aabc::$app->_chinhsach->cs_id]);
    }
    /**
     * @return \aabc\db\ActiveQuery
     */
    public function getDmcsIdDanhmucs()
    {
        $_Danhmuc = Aabc::$app->_model->Danhmuc;
return $this->hasMany($_Danhmuc::className(), [Aabc::$app->_danhmuc->dm_id => Aabc::$app->_danhmucchinhsach->dmcs_id_danhmuc])->viaTable(Aabc::$app->_danhmucchinhsach->table, [Aabc::$app->_danhmucchinhsach->dmcs_id_chinhsach => Aabc::$app->_chinhsach->cs_id]);
    }
    /**
     * @return \aabc\db\ActiveQuery
     */
    public function getDonhangs()
    {
        $_Donhang = Aabc::$app->_model->Donhang;
return $this->hasMany($_Donhang::className(), [Aabc::$app->_donhang->ddh_idkhuyenmai => Aabc::$app->_chinhsach->cs_id]);
    }
    /**
     * @return \aabc\db\ActiveQuery
     */
    public function getSanphamChinhsaches()
    {
        $_SanphamChinhsach = Aabc::$app->_model->SanphamChinhsach;
return $this->hasMany($_SanphamChinhsach::className(), [Aabc::$app->_sanphamchinhsach->spcs_id_chinhsach => Aabc::$app->_chinhsach->cs_id]);
    }
    /**
     * @return \aabc\db\ActiveQuery
     */
    public function getSpcsIdSps()
    {
        $_Sanpham = Aabc::$app->_model->Sanpham;
return $this->hasMany($_Sanpham::className(), [Aabc::$app->_sanpham->sp_id => Aabc::$app->_sanphamchinhsach->spcs_id_sp])->viaTable(Aabc::$app->_sanphamchinhsach->table, [Aabc::$app->_sanphamchinhsach->spcs_id_chinhsach => Aabc::$app->_chinhsach->cs_id]);
    }





}