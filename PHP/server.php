<?php

/**
 *  PHP based http server using ReactPHP library
 *  @description - http server based on the ReactPHP library.
 *  Provides html and rest servics. The original React\EventLoop\Factory
 *  singleton is extended with a get method to make the core loop 
 *  application wide accessable (vendor/react/event-loop/Factory.php).
 *  @param {uint} -p - port to observe by the server.
 */

/**
 *  @description - autoload to complements reactPHP autoload.
 */
spl_autoload_register(function ($class_name) {
    $_sar_dir = array(
                    'src/utils/'.$class_name.'.php',
                    'src/'.$class_name.'.php'
                );
    
    array_map(function($d){
        
        if(file_exists($d)){
            include $d ;
        }   
    },$_sar_dir);
});

/**
 *  @description - ReactPHP autoloader.
 */
include 'vendor/autoload.php';

// initialize http server
$srv = new HttpServer();
$dev = new DeviceProvider();

//  makes DeviceProvider accessable in router 
//  callback functions
DataProxy::on("devices",$dev);


/**
 *  @description - router endpoint template with parameter 'file'
 *  to load assets in to the frontend.
 */
$srv->router->add("asset/{file}","GET",function($request,$parameter){
    
    $type = explode(".",$parameter['file'])[1];
    $file = ""; $mime = ""; $failed = array(404,['Content-Type' => "text/html"],"File not found");

    switch ($type) {
        case 'css':
            $mime = 'text/css';
            if($file = file_get_contents("client/assets/css/".$parameter['file'])){
                return array(200,['Content-Type' => $mime],$file);
            }else{
                return $failed;
            };
            break;

        case 'js':
            $mime = 'text/javascript';
            if($file = file_get_contents("client/assets/js/".$parameter['file'])){
                return array(200,['Content-Type' => $mime],$file);
            }else{
                return $failed;
            };
            break;

        case 'png':
            $mime = 'image/png';
            if($file = file_get_contents("client/assets/img/".$parameter['file'])){
                return array(200,['Content-Type' => $mime],$file);
            }else{
                return $failed;
            };
            break;

        case 'ico':
            $mime = 'image/x-icon';
            if($file = file_get_contents("client/assets/img/".$parameter['file'])){
                return array(200,['Content-Type' => $mime],$file);
            }else{
                return $failed;
            };
            break;

        case 'jpg':
            $mime = 'image/jpeg';
            if($file = file_get_contents("client/assets/img/".$parameter['file'])){
                return array(200,['Content-Type' => $mime],$file);
            }else{
                return $failed;
            };
            break; 

        case 'gif':
            $mime = 'image/gif';
            if($file = file_get_contents("client/assets/img/".$parameter['file'])){
                return array(200,['Content-Type' => $mime],$file);
            }else{
                return $failed;
            };
            break; 

        default:
            return $failed;
    }
});
/**
 *  @description - router endpoint template for mac-address overview
 */
$srv->router->add("/mac-addresses","GET",function($request){

    $html = file_get_contents("client/assets/html/index.html");
    return array(200,['Content-Type' => 'text/html'],$html);
});
/**
 *  @description - router endpoint template for index
 */
$srv->router->add_default(function($request){

    $html = file_get_contents("client/assets/html/index.html");
    return array(200,['Content-Type' => 'text/html'],$html);
});
/**
 *  @description - router rest endpoint template for devices data
 */
$srv->router->add("/data/devices","GET",function($request){

    $json = json_encode(DataProxy::call_data("devices")->get_devices());
    return array(200,['Content-Type' => 'text/json'],$json);
});

/**
 *  @description- starts device scanner every 30 seconds
 */
React\EventLoop\Factory::get()->addPeriodicTimer(30, function () {
    DataProxy::call_data("devices")->get_active_devices(true);
});
// start server at port 8080 if parameter -p is not set.
$srv->start_server(8080);

?>