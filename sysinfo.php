<?php


	function getSystemMemInfo(){
	    $data = explode("\n", file_get_contents("/proc/meminfo"));
	    $meminfo = array();
	    foreach ($data as $line) {
	    	$arr = explode(":", $line);
	    	if( count($arr) >= 2  ){
	    		list($key, $val) = $arr;
	        	$meminfo[$key] = trim($val);
	    	}
	        
	    }
	    return $meminfo;
	}

	function getMb($str_mem){
		if( preg_match("/([0-9]+\s(.*))/", $str_mem, $m) ){
			if( $m[2]=='kB' ){
				return round($m[1] / 1024, 2) . " MB";
			}
		}
		return '';
	}
	
	$mem_arr = getSystemMemInfo();
	echo 
		"Free: " . getMb( $mem_arr['MemFree'] ) . ' / ' . getMb( $mem_arr['MemTotal'] ) . "\t" . 
		"Available: " . getMb( $mem_arr['MemAvailable'] ) . ' / ' . getMb( $mem_arr['MemTotal'] ) . "\t" .
		"\r\n";
	
	echo "-----------------------------\r\n";
	//var_dump($mem_arr);
	//echo disk_free_space("/");
?>