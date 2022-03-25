<?php
set_time_limit(1300);
class ContractManagementController extends AppController
{

 public $name = 'ContractManagement';
 public $uses = array('CustomerMst','EnvMst','ContractManagementService','ContractTrnView');
 public $layout = 'fund_management_main_tab';
 public $components = array('Auth','RequestHandler');
 public $helpers = array('Html','common','Javascript');

 /**
  *
  *
  */
 function index()
 {
 	$contract_dt = null;

 	if (!empty($this->data)) {
 		/* フィルタ条件変更*/
 		$contract_dt = $this->data['GoodsMstView']['contract_dt'];
 		$this->Session->write("filter_contract_dt",$contract_dt);
 	}
 	/* デフォルト値 :処理年月にシステム日付が成約日の顧客を表示 */
 	else{
 		if($this->Session->read("filter_contract_dt") == null){
 			$this->Session->write("filter_contract_dt",date("Y-m"));
 			$contract_dt = date("Y-m");
 		}else{
 			$contract_dt = $this->Session->read("filter_contract_dt");
 		}
 	}

 	//約定一覧を取得
 	$data = $this->ContractManagementService->GetContractList($contract_dt);
 	$this->set('data',$data);

 	/* フィルタ条件をVIEWで保持する */
 	$this->set("contract_dt" ,$this->Session->read("filter_contract_dt"));

    $this->set("menu_customers","");
 	$this->set("menu_customer","disable");
 	$this->set("menu_fund","current");

 	$this->set("sub_menu_bank","");
 	$this->set("sub_menu_sales","");
 	$this->set("sub_menu_contract","current");
 	$this->set("sub_menu_fund","");
 	$this->set("sub_menu_remittance","");
 	$this->set("sub_menu_payment","");
 	$this->set("sub_menu_vendor_sales","");

 	$this->set("sub_title","約定一覧");
 	$this->set("user",$this->Auth->user());
 }

 /**
  *
  * 約定一覧表をEXCEL出力する
  */
 function export(){

 	$data = $this->ContractManagementService->GetContractList($this->Session->read("filter_contract_dt"));
 	$this->set('data',$data);

 	$temp_filename = "contract_template.xlsx";
 	$save_filename = mb_convert_encoding("約定", "SJIS", "AUTO").$this->Session->read("filter_contract_dt").".xlsx";

 	$this->layout = false;
 	$this->set( "sheet_name", $this->Session->read("filter_contract_dt"));
 	$this->set( "filename", $save_filename );
 	$this->set( "template_file", $temp_filename);
 	$this->render("excel");
 }
}
?>