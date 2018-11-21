<?php
    function render($viewPath, $params=null){
        extract($params);
        include __VIEW__.'/'.$viewPath;
    }
?>