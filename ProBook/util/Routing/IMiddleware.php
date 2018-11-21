<?php
    require_once 'Request.php';

    interface IMiddleware {
        function run($next, $nextRequest);
    }


?>