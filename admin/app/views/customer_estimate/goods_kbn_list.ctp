<?php
 echo "<option value=''></option>";         
 for($i=0;$i < count($goods);$i++)
 {
   $atr = $goods[$i];
   echo "<option value='{$atr['GoodsKbnMst']['id']}'>".$atr['GoodsKbnMst']['goods_kbn_nm']."</option>";           
 }  
?>
