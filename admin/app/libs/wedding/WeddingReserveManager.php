<?php
/**
 * [WeddingReserveManager description]
 */
class WeddingReserveManager
{

	private $crawlers;

	/**
	 * [__construct description]
	 */
	public function __construct() {
		$this->crawlers  = WeddingSiteManager::getCrawlers() ;
	}

	/**
	 * [getReserveData description]
	 * @param  [type] $year  [description]
	 * @param  [type] $month [description]
	 * @return [type]        [description]
	 */
	public function getReserveData( $year, $month, $week ) {

		foreach( $this->crawlers as $crawler ) {
				// データをリセットする。
				$site = $crawler->getSite();
				$reserve = $crawler->getCalendar( $year, $month, $week );
				$this->deleteReserveData( $site['id'], $year, $month );
		}
	}

	public function createCalerndarHtml( $reserveData, $year, $month, $week ) {
			/**
			 *  1行目　スペース　曜日
			 *  2行目　スペース　日時
			 *  3行目	時間
			 */
			// 週の開始と終了を計算する。

			if( $week != 6 ) {
				$date = sprintf( "%04d-%02d-%02d", $year, $month, 1 + ($week-1) * 7);
				$w = date('w', strtotime( $date ) );

				$weekStartDay  = 1 + ( $week - 1 ) * 7 - $w;
				$weekEndDay    = $weekStartDay + 7;

				// マイナスの場合はプラスにする。
				// $weekStartDay = $weekStartDay >= 1 ? $weekStartDay : 1;

		  } else {
				// ６週目の場合
				$lastDay = date("t",
					strtotime(sprintf( "%04d-%02d-01", $year, $month))
					);
				$lastWeek = date("w",
					strtotime(sprintf( "%04d-%02d-01", $year, $month))
					);

				if( $lastWeek != 6 ) {
					$weekStartDay =
						date("j",
							strtotime('last Sunday',
								strtotime(sprintf( "%04d-%02d-%02d", $year, $month, $lastDay ))
							)
						);
				} else {
					$weekStartDay = $lastDay;
				}

				$weekEndDay = $weekStartDay + 7;
			}

			$firstDay = sprintf( "%04d-%02d-01", $year, $month );

			// 終了日が翌月に跨がらないようにする。
			$tmpEndDay = date("t",strtotime(sprintf( "%04d-%02d-01", $year, $month )));
			//$weekEndDay  = $weekEndDay > $tmpEndDay + 1? $tmpEndDay + 1: $weekEndDay;

			$dateName = array( "日","月","火","水","木","金","土");

			$header1st = array( "" );
			$header2nd = array( "" );
			//for( $i=1; $i<=date("t",strtotime($firstDay)); $i++ ) {

			for( $i=$weekStartDay; $i<$weekEndDay; $i++ ) {
				//$rowDay = sprintf( "%04d-%02d-%02d", $year, $month, $i );
				$rowDay = mktime(0, 0, 0, $month, $i, $year );
			 	//$header1st[] = $dateName[date("w",strtotime($rowDay))];
			 	$header1st[] = $dateName[date("w",($rowDay))];
				if( $i > $tmpEndDay ) {
					//$header2nd[] = " ";
					//continue;
				}
			 	//$header2nd[] = date("m-d",strtotime($rowDay));
			 	$header2nd[] = date("m-d",($rowDay));
			}

			 for($i=420; $i<1440; $i+=30 ) {
				 unset( $tmp );
				 $tmpTime = sprintf( "%02d:%02d", floor($i/60), $i%60 );
				 $tmp[-99] =  $tmpTime;

				 foreach( $reserveData as $oneReserve ) {
					 for( $j=$weekStartDay; $j<$weekEndDay; $j++ ) {

						if( $j == 0 ) {
							//continue;
						}

						if( !isset($tmp[$j]) ) {
							$tmp[$j] = "";
						}

				 		$rowDay = sprintf( "%04d-%02d-%02d", $year, $month, $j );
						 if( isset( $oneReserve['data'][$rowDay] ) ) {
							 	foreach( $oneReserve['data'][$rowDay] as $one => $status ) {
									if( $one == $tmpTime ) {
										$tmp[$j] .= sprintf("%s<font color='%s'>%s</font>",
											$tmp[$j] ? "<br/>" : "",
											$oneReserve['color'], $oneReserve['name'] );
									}
								}
						 }
				 	 }
				 }

				 $body[] = $tmp;
			 }

			 return array(
				 "header1st" => $header1st,
				 "header2nd" => $header2nd,
			   "body" => $body );
	}

}
