<?php
	$b = false;
	$is_gpu = false;
	$i = 0;
    $arr_gpu = array();
	
	while( !feof(STDIN) ){
	    $line = fgets(STDIN);
	    $line = str_replace(array("\r", "\n"), array('', ''), $line);
	    
	    if( $b && preg_match("/Adapter/i", $line) ){
	    	continue;
	    }
	    
	    if( preg_match("/amdgpu/i", $line) || preg_match("/coretemp/i", $line) ){
	        $is_gpu = preg_match("/amdgpu/i", $line);
	    	$b = true;
	    }else if( $b && $line=="" ){
	    	$b=false;
	    	if( !$is_gpu ) echo "-----------------------------\r\n";
	    	$is_gpu=false;
	    	$i++;
	    }
	    
	    if( $b ){
	    	//echo "\033[32mPHP:\033[0m $line\r\n";
	    	
	    	if( preg_match('/fan/', $line) ){
	    	    if( $is_gpu && preg_match('/([0-9]+)\sRPM/i', $line, $m) ){
	    	        $arr_gpu[$i]['fan']=$m[1];
	    	    }
	    		
	    		$line = preg_replace('/\s([0-9]+)\s/i', "\033[32m $1 \033[0m", $line);
	    	}elseif( preg_match('/temp/', $line) || preg_match('/Core/i', $line) || preg_match('/Physical/i', $line)){
                //"temp1:         "
	    	    if( $is_gpu && preg_match('/(\+[0-9,\.]+)/i', $line, $m) ){
	    	        $arr_gpu[$i]['temp']=$m[1];
	    	    }
	    	    
	    		$line = preg_replace('/(\+[0-9,\.]+)/i', "\033[91m $1 \033[0m", $line);
	    	}
	    	
	    	//echo "$line\r\n";
	    	//if( !preg_match("/N\/A/i", $line) ) echo "$line\r\n";
	    	if( !preg_match("/amdgpu/i", $line) && !preg_match("/N\/A/i", $line) && !$is_gpu ) echo "$line\r\n";
	    	
	    }else{
	    	//echo "\033[35mPHP:\033[0m $line\r\n";
	    }
	}
	
	$i=0;
	foreach( $arr_gpu as $val ){
	    $fan = isset( $val['fan'] ) ? $val['fan'] : "N/A";
	    echo "GPU$i \t temp: \033[91m" . $val['temp'] . "\033[0m" . "\t" . "fan: \033[32m" . $fan . "\033[0m" . "\r\n";
	    $i++;
	}
	
	//var_dump( $arr_gpu );
	
	echo "-----------------------------\r\n";
?>