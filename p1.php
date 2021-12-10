<?php
	$stdin = fopen( 'php://stdin', 'r' );

	
	function getServices(){
		$host 	= '127.0.0.1';
		
		$port 	= 9999;
		
		
		$req = xmlrpc_encode_request("getServicePorts", "");

		
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

		
		if(array_key_exists('faultString', $res)){
			print $res['faultString'];
		} else {
			
			return $res;
		}
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
		$services = getServices();
		print "Dostepne uslugi:\n";
		printf("%7s %20s\n", "Port", "Nazwa uslugi");
		foreach($services as $port=>$name) { 
			printf("%7s %20s\n", $port, $name);
		}

		print "\nPodaj port uslugi do wywolania\n";
		$chosenPort = fgets($stdin); 
		$chosenPort = chop($chosenPort); 
		if(array_key_exists($chosenPort, $services)){ 
			
			print "\nWybrales ";
			print $services[$chosenPort] . "\n";
		} else {
			print "Bledny wybor";
		}

		print "Podaj dane do przetworzenia:\n";
		$data = fgets($stdin); 
		$data = chop($data);

		$resp = callService($chosenPort, $data); 
		print "Odpowiedź to '$resp'\n\n"; 

		fgets($stdin);
	}

?>

