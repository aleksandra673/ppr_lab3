<?php
	$stdin = fopen( 'php://stdin', 'r' );

	function getService($name){
		$host 	= '127.0.0.1';
		$port 	= 9999;
		
		$req = xmlrpc_encode_request("getServicePorts", $name);

		$ctx = stream_context_create(
			array(
				'http' => array(
					'method' 	=> "POST",
					'header' 	=> array( "Content-Type: text/xml" ),
					'content' 	=> $req
				)
			)
		);
		
		$xml = file_get_contents( "http://$host:$port/RPC2", false, $ctx );
		
		$res = xmlrpc_decode( $xml ); 
		return $res;
	}
	
	function callService($port, $data){
		$host 	= '127.0.0.1';
		$req = xmlrpc_encode_request("processData", $data);

		$ctx = stream_context_create(
			array(
				'http' => array(
					'method' 	=> "POST",
					'header' 	=> array( "Content-Type: text/xml" ),
					'content' 	=> $req
				)
			)
		);
		$xml = file_get_contents( "http://$host:$port/RPC2", false, $ctx );
		
		$res = xmlrpc_decode( $xml ); 
		return $res;
	}
	
	while(true){
		
		print "\nPodaj nazwe uslugi do wywolania\n";
		$serviceName = fgets($stdin); 
		$serviceName = chop($serviceName); 
		
		$servicePort = getService($serviceName);
		if(is_array($servicePort)) {
			print "Nie ma takiej uslugi\n";
			continue;
		}

		print "Podaj dane do przetworzenia:\n";
		$data = fgets($stdin); 
		$data = chop($data);

		$resp = callService($servicePort, $data); 
		print "Odpowiedź to '$resp'\n\n"; 

		fgets($stdin); 
	}

?>

