<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class JsonRPCServer extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function _remap($method, $params = array()) {
        // checks if a JSON-RCP request has been received
        if (
                $_SERVER['REQUEST_METHOD'] != 'POST' ||
                empty($_SERVER['CONTENT_TYPE']) ||
                $_SERVER['CONTENT_TYPE'] != 'application/json'
        ) {
            // This is not a JSON-RPC request
            return false;
        }

        // reads the input data
        $request = json_decode(file_get_contents('php://input'), true);

        // executes the task on local object
        try {
            if ($result = @call_user_func_array(array($this, $request['method']), $request['params'])) {
                $response = array(
                    'id' => $request['id'],
                    'result' => $result,
                    'error' => NULL
                );
            } else {
                $response = array(
                    'id' => $request['id'],
                    'result' => NULL,
                    'error' => 'unknown method or incorrect parameters'
                );
            }
        } catch (Exception $e) {
            $response = array(
                'id' => $request['id'],
                'result' => NULL,
                'error' => $e->getMessage()
            );
        }

        // output the response
        if (!empty($request['id'])) { // notifications don't want response
            header('content-type: text/javascript');
            echo json_encode($response);
        }

        // finish
        return true;
    }

}

?>
