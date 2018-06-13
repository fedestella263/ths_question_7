<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        header('Content-type: application/json');
        $request = json_decode(file_get_contents('php://input'), true);
        $response = array("Status" => "OK");
        
        if(json_last_error() != JSON_ERROR_NONE || !array_key_exists("values", $request) || !is_array($request["values"]) || !array_key_exists("operation", $request) || 
            !array_key_exists(0, $request["values"]) || !array_key_exists(1, $request["values"]) ||
            !is_numeric($request["values"][0]) || !is_numeric($request["values"][1])) {
            
            $response["Status"] = "error";
            $response["Message"] = "invalid request";
            
        } else if($request["values"][0] > PHP_INT_MAX || $request["values"][1] > PHP_INT_MAX) {
            
            $response["Status"] = "error";
            $response["Message"] = "values out of range";
            
        } else if($request["operation"] == "division" && $request["values"][1] == 0) {
            
            $response["Status"] = "error";
            $response["Message"] = "can't be divided by zero";
            
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
                    $response["Message"] = "unrecognized operation";
            }
        }
        
        echo json_encode($response);
    }
?>