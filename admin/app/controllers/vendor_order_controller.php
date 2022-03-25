<?php
class VendorOrderController extends AppController
{
 public $name = 'VendorOrder';
 public $uses = array('VendorMst','ContactAddressTrnView');
 public $layout = 'edit_mode';
 public $components = array('Auth');
 public $helpers = array('common');

 /**
  * ベンダー予約フォーム作成画面表示
  */
 function index()
 {
 	//暫定で見積PDF帳票構成データを固定で検索
    //$this->set('data',$this->ReportMst->find('all',array('conditions'=>array('code'=>'RPT01'))));

 	$this->set("menu_customers","");
 	$this->set("menu_customer","disable");
 	$this->set("menu_fund","");

 	$this->set("sub_title","ベンダー予約フォーム作成");
 	$this->set("user",$this->Auth->user());
 }

 /**
  *
  * [AJAX]問い合わせ画面を表示し、また問い合わせデータを新規作成する
  */
 function mailForm()
 {
 	$this->layout = '';
 	if(!empty($this->data)){

	   $this->autoRender =false;
 	   configure::write('debug', 0);

 	   $ret = $this->Mail->sendMail($this->data,$this->Session->read('customer_id'),$this->Auth->user());
 	   if($ret != null){
 	   	  	 return json_encode(array('result'=>false,'message'=>"メール送信に失敗しました。",'reason'=>$ret));
 	   }
 	   return json_encode(array('result'=>true,'message'=>'メール送信しました。'));
 	}else{

 	  $this->set("user",$this->Auth->user());
 	  $this->set("vendor_list",$this->VendorMst->find("all",array("conditions"=>array("del_kbn"=>EXISTS))));
    }
 }

 /**
  *
  * [AJAX]連絡帳選択画面を表示する
  * @param $page
  */
 function addressListForm()
 {
 	//AJAX CALLのみ処理する
 	if (!$this->RequestHandler->isAjax()){ $this->cakeError("error404"); }

 	configure::write('debug', 0);
 	$this->layout = '';
 }

 /**
  *
  * [AJAX] 連絡先帳をJSONデータで取得する
  */
 function AddressList()
 {
 	if (!$this->RequestHandler->isAjax()){ die('Not found');}

 	$this->layout = '';
 	$this->autoRender =false;
 	configure::write('debug', 0);

 	$data =  $this->ContactAddressTrnView->find('all');

 	$comps = array();
 	for($i=0;$i < count($data);$i++){

 		array_push($comps, array("id" => $i, "cell" => array($data[$i]['ContactAddressTrnView']['name'] ,
 				$data[$i]['ContactAddressTrnView']['email'],
 				$data[$i]['ContactAddressTrnView']['master_kbn'])
 		)
 				);
 	}
 	return json_encode(array('rows' => $comps));
 }


}
?>