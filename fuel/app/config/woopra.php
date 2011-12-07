<?php

return array(
    /*
     * Memcache configs
     */
    'memcache' => array("host" => "127.0.0.1", "port" => "11211"),
    /*
     * Woopra configs
     */
    
    'woopra' => array(
        "url" => "http://api.woopra.com/rest/analytics",
        //"domain" => "eplazashuttle.com",
        //"api_key" => "6TCDPLC2OW",
        "domain" => "brr.com.au",
        "api_key" => "TM6Q8ZE7MI",
        "format" => "xml",
        "date_format" => "dd/MM/yyyy"
    )
);

?>
    