<?php
// Excel出力用ライブラリ
App::import( 'Vendor', 'PHPExcel', array('file'=>'phpexcel' . DS . 'PHPExcel.php') );
//App::import( 'Vendor', 'PHPExcel_IOFactory', array('file'=>'phpexcel' . DS . 'PHPExcel' . DS . 'IOFactory.php') );
//App::import( 'Vendor', 'PHPExcel_Cell_AdvancedValueBinder', array('file'=>'phpexcel' . DS . 'PHPExcel' . DS . 'Cell' . DS . 'AdvancedValueBinder.php') );

// Excel95用ライブラリ
App::import( 'Vendor', 'PHPExcel_Writer_Excel2007', array('file'=>'phpexcel' . DS . 'PHPExcel' . DS . 'Writer' . DS . 'Excel2007.php') );
App::import( 'Vendor', 'PHPExcel_Reader_Excel2007', array('file'=>'phpexcel' . DS . 'PHPExcel' . DS . 'Reader' . DS . 'Excel2007.php') );

$cols = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
              "AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");

    $reader = new PHPExcel_Reader_Excel2007();
    $objPHPExcel = $reader->load(realpath( TMP ).DS . 'excels' . DS . $template_file);
    $sheet = $objPHPExcel->getActiveSheet();

    // Rename sheet
    // シート名をつける
    $sheet->setTitle( $sheet_name);
    // デフォルトのフォント
    $sheet->getDefaultStyle()->getFont()->setName('ＭＳ Ｐゴシック');
    // デフォルトのフォントサイズ
    $sheet->getDefaultStyle()->getFont()->setSize(11);
    // 列番
    $row_cnt = 5;

    for($i=0;$i < count($data);$i++){

    	$sheet->setCellValue("B".$row_cnt, $i+1);
        $sheet->setCellValue("C".$row_cnt, date("Y-m-d",strtotime($data[$i]['ContractTrnView']['contract_dt'])));
        $sheet->setCellValue("D".$row_cnt, $data[$i]['ContractTrnView']['grmls_kj'].$data[$i]['ContractTrnView']['grmfs_kj']);
        $sheet->setCellValue("E".$row_cnt, date("Y-m-d",strtotime($data[$i]['ContractTrnView']['wedding_dt'])));
        $sheet->setCellValue("F".$row_cnt, $data[$i]['ContractTrnView']['first_contact_person_nm']);
        $sheet->setCellValue("G".$row_cnt, $data[$i]['ContractTrnView']['total']);
        $sheet->setCellValue("H".$row_cnt, $data[$i]['ContractTrnView']['cost']);
        $sheet->setCellValue("I".$row_cnt, $data[$i]['ContractTrnView']['profit']);
        $sheet->setCellValue("J".$row_cnt, $data[$i]['ContractTrnView']['profit_rate']/100);
        $sheet->setCellValue("K".$row_cnt, $data[$i]['ContractTrnView']['service_fee']);
        $sheet->setCellValue("L".$row_cnt, $data[$i]['ContractTrnView']['discount_fee']);
        $sheet->setCellValue("M".$row_cnt, $data[$i]['ContractTrnView']['discount_rate_fee']);
        $sheet->setCellValue("N".$row_cnt, $data[$i]['ContractTrnView']['tax']);
        $sheet->setCellValue("O".$row_cnt, $data[$i]['ContractTrnView']['status_nm']);

    	$sheet->getStyle("G".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    	$sheet->getStyle("H".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    	$sheet->getStyle("I".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    	$sheet->getStyle("J".$row_cnt)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
    	$sheet->getStyle("K".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    	$sheet->getStyle("L".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    	$sheet->getStyle("M".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    	$sheet->getStyle("N".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');

    	$row_cnt++;
    	$sheet->insertNewRowBefore( $row_cnt, 1 );
    }

    $sheet->removeRow($row_cnt);
    $sheet->removeRow($row_cnt);

    //合計行
    $sheet->setCellValue("G".$row_cnt, "=SUM(G5:G".($row_cnt-1).")");
    $sheet->setCellValue("H".$row_cnt, "=SUM(H5:H".($row_cnt-1).")");
    $sheet->setCellValue("I".$row_cnt, "=SUM(I5:I".($row_cnt-1).")");
    $sheet->setCellValue("J".$row_cnt, "=I".$row_cnt."/G".$row_cnt);
    $sheet->setCellValue("K".$row_cnt, "=SUM(K5:K".($row_cnt-1).")");
    $sheet->setCellValue("L".$row_cnt, "=SUM(L5:L".($row_cnt-1).")");
    $sheet->setCellValue("M".$row_cnt, "=SUM(M5:M".($row_cnt-1).")");
    $sheet->setCellValue("N".$row_cnt, "=SUM(N5:N".($row_cnt-1).")");

    $sheet->getStyle("G".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("H".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("I".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("J".$row_cnt)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
    $sheet->getStyle("K".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("L".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("M".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("N".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');

    //平均行
    $row_cnt++;
    $sheet->setCellValue("G".$row_cnt, "=AVERAGE(G5:G".($row_cnt-2).")");
    $sheet->setCellValue("H".$row_cnt, "=AVERAGE(H5:H".($row_cnt-2).")");
    $sheet->setCellValue("I".$row_cnt, "=AVERAGE(I5:I".($row_cnt-2).")");
    $sheet->setCellValue("J".$row_cnt, "=I".$row_cnt."/G".$row_cnt);
    $sheet->setCellValue("K".$row_cnt, "=AVERAGE(K5:K".($row_cnt-2).")");
    $sheet->setCellValue("L".$row_cnt, "=AVERAGE(L5:L".($row_cnt-2).")");
    $sheet->setCellValue("M".$row_cnt, "=AVERAGE(M5:M".($row_cnt-2).")");
    $sheet->setCellValue("N".$row_cnt, "=AVERAGE(N5:N".($row_cnt-2).")");

    $sheet->getStyle("G".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("H".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("I".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("J".$row_cnt)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
    $sheet->getStyle("K".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("L".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');
    $sheet->getStyle("M".$row_cnt)->getNumberFormat()->setFormatCode('"\"#,##0');

    // PHPの日時出力
    $time = time();                 // 現在日時(Unix Timestamp)
    $sheet->setCellValue("O2", '出力日：'.date('Y/m/d'));
    $sheet->setCellValue("C2", $sheet_name."分約定一覧");

// Excelファイルの保存
// 保存ファイルフルパス
$uploadDir = realpath( TMP );
$uploadDir .= DS . 'excels' . DS;
$path = $uploadDir . $filename;

$objWriter = new PHPExcel_Writer_Excel2007( $objPHPExcel );
$objWriter->save( $path );

// Excelファイルをクライアントに出力
Configure::write('debug', 0);       // debugコードを非表示
header("Content-disposition: attachment; filename={$filename}");
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name={$filename}");

$result = file_get_contents( $path );   // ダウンロードするデータの取得
print( $result );                       // 出力


?>