<?php
    class Request {
        public $params = array();
        public $payload = array();
        public $header = array();
        public $queries = array();

        function __construct(array $params, $payload, $header, $queries = null){
            $this->params = $params;
            $this->payload = $payload;
            $this->header = $header;
            $this->queries = $queries;
        }
    }
    
?>