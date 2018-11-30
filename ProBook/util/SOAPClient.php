<?php
    ini_set('soap.wsdl_cache_enabled', 0);
    ini_set('soap.wsdl_cache_ttl', 900);
    ini_set('default_socket_timeout', 15);

    class SOAPClientUtility {
        public function searchBook($query) {
            $options = array(
                'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
                'style'=>SOAP_RPC,
                'use'=>SOAP_ENCODED,
                'soap_version'=>SOAP_1_1,
                'cache_wsdl'=>WSDL_CACHE_NONE,
                'connection_timeout'=>15,
                'trace'=>true,
                'encoding'=>'UTF-8',
                'exceptions'=>true,
            );
            $params = array('arg0' => $query);
            $wsdl = "http://localhost:8888/ws/book/?wsdl";
            
            try {
                $soap = new SoapClient($wsdl, $options);
                $data = $soap->searchBook($params);
            } catch (Exception $e) {
                die($e->getMessage());
            }

            return $data->return;
        }

        public function recommendationBook($categories) {
            $options = array(
                'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
                'style'=>SOAP_RPC,
                'use'=>SOAP_ENCODED,
                'soap_version'=>SOAP_1_1,
                'cache_wsdl'=>WSDL_CACHE_NONE,
                'connection_timeout'=>15,
                'trace'=>true,
                'encoding'=>'UTF-8',
                'exceptions'=>true,
            );

            $params = array(
                'arg0' => $categories,
            );
            $wsdl = "http://localhost:8888/ws/book/?wsdl";

            try {
                $soap = new SoapClient($wsdl, $options);
                $data = $soap->recommendationBook($params);
            } catch (Exception $e) {
                die($e->getMessage());
            }

            return $data->return;
        }

        public function bookDetail($id) {
            $options = array(
                'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
                'style'=>SOAP_RPC,
                'use'=>SOAP_ENCODED,
                'soap_version'=>SOAP_1_1,
                'cache_wsdl'=>WSDL_CACHE_NONE,
                'connection_timeout'=>15,
                'trace'=>true,
                'encoding'=>'UTF-8',
                'exceptions'=>true,
            );

            $params = array(
                'arg0' => $id,
            );
            $wsdl = "http://localhost:8888/ws/book/?wsdl";

            try {
                $soap = new SoapClient($wsdl, $options);
                $data = $soap->getBookDetail($params);
            } catch (Exception $e) {
                die($e->getMessage());
            }

            return $data->return;
        }
        public function buyBook($id, $counts, $sender) {
            $options = array(
                'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
                'style'=>SOAP_RPC,
                'use'=>SOAP_ENCODED,
                'soap_version'=>SOAP_1_1,
                'cache_wsdl'=>WSDL_CACHE_NONE,
                'connection_timeout'=>15,
                'trace'=>true,
                'encoding'=>'UTF-8',
                'exceptions'=>true,
            );
            $params = array('arg0' => $id, $counts, $sender);
            $wsdl = "http://localhost:8888/ws/book/?wsdl";
            
            try {
                $soap = new SoapClient($wsdl, $options);
                $data = $soap->buyBook($params);
            } catch (Exception $e) {
                die($e->getMessage());
            }

            return $data->return;
        }
    }

?>