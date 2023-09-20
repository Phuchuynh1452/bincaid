<?php
    // Include the binCaid class
    require_once './app/binCaid.php';

    class api {
        function __construct(){
            // Initialize the binCaid instance
            $binCaidInstance = new binCaid();

            // get url rewrite to array https://localhost/index.php?route=bincaid/1 -> ["bincaid","1"] 
            $arr = $this->UrlProcess();
            

            // print_r($arr);
            // Handle API endpoints
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                
                if (isset($arr[0]) && $arr[0] === 'bincaid' && count($arr) == 1) {
                    // Handle GET /bincaid
                    // Retrieve and return all bincaid records
                    $bincaidRecords = $binCaidInstance->getRecords();
                    echo json_encode($bincaidRecords);
                } elseif ($arr[0] === 'bincaid' && is_numeric($arr[1]) && count($arr) == 2 ) {
                    // Handle GET /bincaid/{bincaid_id}
                    // Retrieve and return a specific bincaid record by ID
                    $bincaid_ID = $arr[1];
                    $bincaidRecord = $binCaidInstance->getRecordID($bincaid_ID);
                    echo json_encode($bincaidRecord);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($arr[0]) && $arr[0] === 'bincaid'  && count($arr) == 1) {
                    // Handle POST /bincaid
                    // Add a new bincaid record
                    $bin = $_POST["bin"];
                    $caid = $_POST["caid"];
                    $status = $_POST["status"];
                    $comment = $_POST["comment"];
                    $ruleset = $_POST["ruleset"];
                    $result = $binCaidInstance->add($bin, $caid, $status, $comment, $ruleset);
            
                    if($result){
                        echo json_encode(
                            [
                                "success"=>true,
                                "message"=>"Add bincaid successfull",
                                "result"=>""
                            ]
                        );
                    }else{
                        echo json_encode(
                            [
                                "success"=>false,
                                "message"=>"Add bincaid failure, bin & caid already exists in a record",
                                "result"=>""
                            ]
                        ); 
                    }
                } elseif ($arr[0] === 'bincaid' && is_numeric($arr[1]) && count($arr) == 2 ) {
                    // Handle POST /bincaid/{bincaid_id}
                    // Perform actions such as adding merchant or enabling based on the ID
                    $result = $binCaidInstance->merchantAdd($arr[1],$_POST["merchant_id"]);
                    
                    if($result){
                        echo json_encode(
                            [
                                "success"=>true,
                                "message"=>"Update merchant_id successfull",
                                "result"=>""
                            ]
                        );
                    }else{
                        echo json_encode(
                            [
                                "success"=>false,
                                "message"=>"Update merchant_id failure",
                                "result"=>""
                            ]
                        ); 
                    }

                }
            }else{
                // Do nothing
            }
    
            // Close the binCaid instance
            unset($binCaidInstance);
        }

        function UrlProcess(){
            //cut string and catch blanks + hide automatically
            if( isset($_GET['route']) ){
                return explode("/",filter_var(trim($_GET['route'], "/")));
            }
        }
    }
?>