<?php
class ContractManagementService extends AppModel {
	var $useTable = false;

	/**
	 * 約定一覧を取得する
	 * @param unknown $start_contract_dt
	 * @param unknown $end_contract_dt
	 * @return Ambigous <multitype:, NULL, boolean, mixed, number, unknown>
	 */
	function GetContractList($contract_dt){

		App::import("Model", "ContractTrnView");
  	    $contract = new ContractTrnView();

  	    App::import("Model", "EstimateService");
  	    $estimate = new EstimateService();

  	    $data = $contract->find("all",array("fields"=>array("customer_id","status_nm","first_contact_person_nm","contract_dt","wedding_dt","grmls_kj","grmfs_kj","brdls_kj","brdfs_kj"),
  	    		                            "conditions"=>array("SUBSTR(contract_dt,1,7)"=>$contract_dt,
  	    		                            		            "status_id"=>array(CS_CONTRACTED,CS_INVOICED)),
  	    		                            "order"=>array("contract_dt","wedding_dt")));

  	    for($i=0;$i < count($data);$i++){
  	    	$estimate_amount = $estimate->getCustomerEstimateSummary($data[$i]["ContractTrnView"]["customer_id"]);
  	    	$data[$i]["ContractTrnView"]["total"] = $estimate_amount["total"];
  	    	$data[$i]["ContractTrnView"]["cost"] = $estimate_amount["cost_total"];
  	    	$data[$i]["ContractTrnView"]["profit"] = $estimate_amount["profit"];
  	    	$data[$i]["ContractTrnView"]["profit_rate"] = $estimate_amount["profit_rate"];
  	    	$data[$i]["ContractTrnView"]["service_fee"] = $estimate_amount["service_fee"];
  	    	$data[$i]["ContractTrnView"]["discount_rate_fee"] = $estimate_amount["discount_rate_fee"];
  	    	$data[$i]["ContractTrnView"]["discount_fee"] = $estimate_amount["discount_fee"];
  	    	$data[$i]["ContractTrnView"]["tax"] = $estimate_amount["tax"];
  	    }
  	    return $data;
	}
}