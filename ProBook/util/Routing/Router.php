<?php
    require_once 'Request.php';
    require_once 'IMiddleware.php';
    require_once 'Renderer.php';

    class Router {
        // Array of routes and its callback
        private $routes = array();  
        // Array of patterns for params matching
        private $paramPatterns = array();
        // Array of param keys to be searched
        private $paramKeys = array();

        private function __makeParamPattern($url){
            $url_components = explode("/", $url);
            $paramPattern = "^";
            foreach($url_components as $url_component){
                if ($url_component != ""){
                    if (preg_match('(:.*)',$url_component)){
                        preg_match('(:.*)',$url_component, $paramName);
                        $param = substr($paramName[0],1);
                        array_push($this->paramKeys, $param);
                        $paramPattern .= "\/(?P"."<$param>"."\d+)";
                    }
                    else {
                        $paramPattern .= "\/(".$url_component.")"; 
                    }
                }
            }
            $paramPattern.= "\/$";
            return $paramPattern;
        }

        private function __parseParams($url){
            $request_params = array();
            $param_matches = array();

            foreach($this->paramPatterns as $paramPattern){
                if (preg_match('('.$paramPattern.')', $url, $matches, PREG_OFFSET_CAPTURE)){
                    $param_matches = $matches;
                }
            }

            foreach($this->paramKeys as $param){
                if (array_key_exists($param, $param_matches)){
                    $request_params[$param] = $param_matches[$param][0];
                }
            }

            return $request_params;
        }
        private function __getRouteFromPattern($url, $method){
            foreach ($this->routes as $key=>$value){
                if (preg_match("($key)", $url) && array_key_exists($method, $value)){
                    return $value[$method];
                }
            }

            return null;
        }

        function add(string $url, string $method, $callback, IMiddleware $middleware = null, $args= null) {
            $urlPattern = $this->__makeParamPattern($url);
            $this->routes[$urlPattern][$method] = array("callback"=>$callback, "middleware"=>$middleware, "args" =>$args);
            array_push($this->paramPatterns, $urlPattern);
        }
        
        function route(string $requestUrl, string $method, $errorCallback = null) {
            $route = $this->__getRouteFromPattern($requestUrl, $method);
            
            if ($route!= null) {
                // get params
                $params = $this->__parseParams($requestUrl);
                
                // get payload
                // get header
                $headers = getallheaders();
                $queries = $_GET;

                if ($headers["Content-Type"] == "multipart/form-data"){
                    $payload = $_POST;
                } else {
                    parse_str(file_get_contents("php://input"), $payload);
                }

                if(array_key_exists("Content-Type",$headers) && ($headers["Content-Type"] == "application/json") && $payload){
                    $strPayload = file_get_contents('php://input');
                    $payload = json_decode($strPayload,TRUE);
                }

                $request = new Request($params, $payload, $headers, $queries);
                $args = null;
                if ($route["args"]){
                    $args = $route["args"];
                } else {
                    $args = $request;
                }

                if ($route["middleware"]){
                    $route["middleware"]->run($route["callback"], $args);
                } else {
                    $route["callback"]($args);
                }
            } else {
                if ($errorCallback){
                    $errorCallback();
                }
            }
        }
    }
?>