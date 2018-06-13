<?php
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST') {
        header('Content-type: application/json');
        $request = json_decode(file_get_contents('php://input'), true);
        $response = array("Status" => "OK", "Result" => "");
        
        if(!array_key_exists("values", $request) || !array_key_exists("operation", $request) || !array_key_exists(0, $request["values"]) || !array_key_exists(1, $request["values"])) {
            $response["Status"] = "error";
        } else {
            switch($request["operation"]) {
                case "sum": 
                    $response["Result"] = $request["values"][0]+$request["values"][1];
                    break;
                
                case "subtraction":
                    $response["Result"] = $request["values"][0]-$request["values"][1];
                    break;
                
                case "division":
                    $response["Result"] = $request["values"][0]/$request["values"][1];
                    break;
                
                case "multiplication":
                    $response["Result"] = $request["values"][0]*$request["values"][1];
                    break;
                
                default:
                    $response["Status"] = "error";
            }
        }
        
        echo json_encode($response);
    }
?>