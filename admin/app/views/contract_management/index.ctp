<?php
$index_url = $html->url('index');

$this->addScript($javascript->codeBlock( <<<JSPROG
$(function(){

   $("#contract_date").mask("9999-99");

   $("#search_button").click(function(){

      $("#GoodsMstViewContractDt").val($("#contract_date").val());
      $("#CustomerMstIndexForm").submit();
   });
});
JSPROG
)) ?>

<ul class="operate">
  <li><a href="<?php echo $html->url('export') ?>">EXCEL出力</a></li>
</ul>

 <!-- フィルター用の条件を保持   -->
 <div style="display:none;">
   <?php echo $form->create(null);
         echo $form->text('GoodsMstView.contract_dt' ,array('value' => $contract_dt));
         echo $form->end(); ?>
 </div>

 <div class='notation'>
   <label>表示年月：</label>
   <input type="text" id="contract_date" name="contract_date" class="inputdate" value="<?php echo $contract_dt ?>" />
   <input id="search_button" type="image"  src="<?php echo $html->webroot("/images/search.png"); ?>"  style="margin-left:3px;" />
</div>

 <div style='position:relative;'>
    <table id="country_japan" class="list" cellspacing="0">
	<tr>
	    <tr>
	    <th>No</th>
	    <th>成約日</th>
	    <th>顧客名</th>
	    <th>挙式予定日</th>
	    <th>担当者</th>
	    <th style="text-align:right">見積金額<?php echo $html->image('yen.png')?></th>
	    <th style="text-align:right">見積原価<?php echo $html->image('yen.png')?></th>
	    <th style="text-align:right">利益額<?php echo $html->image('yen.png')?></th>
	    <th style="text-align:right">利益率<?php echo $html->image('yen.png')?></th>
	    <!--
	    <th id="hi_header_en" style="text-align:right">HI取り分<?php echo $html->image('yen.png')?></th>
  	    <th style="text-align:right">RW取り分<?php echo $html->image('yen.png')?></th>
	    -->
	    <th style="text-align:right">アレンジメントフィー<?php echo $html->image('yen.png')?></th>
	    <th style="text-align:right">割引額①<?php echo $html->image('yen.png')?></th>
	    <th style="text-align:right">割引額②<?php echo $html->image('yen.png')?></th>
	    <th style="text-align:right">税金<?php echo $html->image('yen.png')?></th>
	    <th style="text-align:center"">ステータス</th>
	</tr>

<?php
	$sum_total = 0;
    $sum_cost = 0;
    $sum_service_fee= 0;
	$sum_tax= 0;
	$sum_discount= 0;
    $sum_discount_rate_fee= 0;

    for($i=0;$i < count($data);$i++){

	  echo "<tr>".
	           "<td nowrap>".($i+1)."</td>".
	           "<td nowrap>{$common->evalForShortDate($data[$i]['ContractTrnView']['contract_dt'])}</td>".
	           "<td nowrap><a href='".$html->url('/customersList/goToCustomerInfo/'.$data[$i]['ContractTrnView']['customer_id'])."'>{$data[$i]['ContractTrnView']['grmls_kj']}{$data[$i]['ContractTrnView']['grmfs_kj']}</a></td>".
	           "<td nowrap>{$common->evalForShortDate($data[$i]['ContractTrnView']['wedding_dt'])}</td>".
               "<td nowrap>{$data[$i]['ContractTrnView']['first_contact_person_nm']}</td>".
               "<td class='yen'>".number_format($data[$i]['ContractTrnView']['total'])."</td>".
               "<td class='yen'>".number_format($data[$i]['ContractTrnView']['cost'])."</td>".
               "<td class='yen'>".number_format($data[$i]['ContractTrnView']['profit'])."</td>".
               "<td class='yen'>".number_format($data[$i]['ContractTrnView']['profit_rate'],2)."%</td>".
               "<td class='yen'>".number_format($data[$i]['ContractTrnView']['service_fee'])."</td>".
               "<td class='yen'>".number_format($data[$i]['ContractTrnView']['discount_fee'])."</td>".
               "<td class='yen'>".number_format($data[$i]['ContractTrnView']['discount_rate_fee'])."</td>".
               "<td class='yen'>".number_format($data[$i]['ContractTrnView']['tax'])."</td>".
               "<td nowrap>{$data[$i]['ContractTrnView']['status_nm']}</td>".
            "</tr>";
    $sum_total += $data[$i]['ContractTrnView']['total'];
    $sum_cost += $data[$i]['ContractTrnView']['cost'];
    $sum_service_fee += $data[$i]['ContractTrnView']['service_fee'];
    $sum_tax += $data[$i]['ContractTrnView']['tax'];
    $sum_discount += $data[$i]['ContractTrnView']['discount_fee'];
    $sum_discount_rate_fee += $data[$i]['ContractTrnView']['discount_rate_fee'];

    }
     echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>合計</td>".
          "<td class='yen'>".number_format($sum_total)."</td>".
          "<td class='yen'>".number_format($sum_cost)."</td>".
          "<td class='yen'>".number_format($sum_total - $sum_cost)."</td>".
          "<td class='yen'>".($sum_total== 0 ? 0 : number_format((($sum_total - $sum_cost)/$sum_total)*100,2))."%</td>".

          "<td class='yen'>".number_format($sum_service_fee)."</td>".
          "<td class='yen'>".number_format($sum_discount)."</td>".
          "<td class='yen'>".number_format($sum_discount_rate_fee)."</td>".
          "<td class='yen'>".number_format($sum_tax)."</td>".
	      "<td>&nbsp;</td>".
          "</tr>";

     $c = count($data);
     echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>平均</td>".
          "<td class='yen'>".($c==0 ? 0 : number_format($sum_total/$c))."</td>".
          "<td class='yen'>".($c==0 ? 0 : number_format($sum_cost/$c))."</td>".
          "<td class='yen'>".($c==0 ? 0 : number_format(($sum_total - $sum_cost)/$c))."</td>".
          "<td class='yen'>".($sum_total== 0 ? 0 : number_format((($sum_total - $sum_cost)/$sum_total)*100,2))."%</td>".
          "<td class='yen'>".($c==0 ? 0 : number_format($sum_service_fee/$c))."</td>".
          "<td class='yen'>".($c==0 ? 0 : number_format($sum_discount/$c))."</td>".
          "<td class='yen'>".($c==0 ? 0 : number_format($sum_discount_rate_fee/$c))."</td>".
          "<td class='yen'>".($c==0 ? 0 : number_format($sum_tax/$c))."</td>".
	      "<td>&nbsp;</td>".
          "</tr>";
?>
    </table>
 </div>


