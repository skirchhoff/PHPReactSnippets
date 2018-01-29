<?php

/**
 *  @description - handels urls and parameters of incomming requests
 */

 // regular expression to match url parameter
define('REGX_URL_PARAM_DESCRIPTOR','/\{([A-Za-z0-9\-_\$]+)\}/');

class ServerRouter extends EventHandler{

    private $endpoints = [];
    private $default;

    /**
     *  @description - calls the url trigger function when request url and router url
     *  matches. And calls 404 response header and page, when no match found.
     *  @param - {Psr\Http\Message\ServerRequestInterface}$request - request data
     */
    public function get_response ( $request ){
 
        if( $request->getUri()->getPath() != "/"){
            if($response = $this->get_match_from_template_stack( $request )){
                return $this->generate_response ( $response, $request);
            }else{
                return $this->get_404( $request );
            }
        } else {
            return $this->generate_response($this->endpoints['default']($request),$request);
        }
    }

    //  Matches request url and in the router stack registred urls.
    //  Extracts parameters from the url.

    private function get_match_from_template_stack( $request ) {

        $url = explode("/",$this->prepare_url($request->getUri()->getPath()));

        // if request method supported
        if($template_endpoint = @$this->endpoints[$request->getMethod()]){

            for ( $i = 0; $i<sizeof($template_endpoint); $i++ ){

                // 1st level match - when both urls have same number of elements
                if(sizeof($url)==sizeof($template_endpoint[$i]['params'])){

                    $match = true; $params = []; $response = "No content for request.";
                    for ($k = 0; $k<sizeof($url); $k++){
                        
                        // when url element is a parameter, ignore element for matching...
                        if($template_endpoint[$i]['params'][$k]['param']==true){

                            // ... and add element to parameter stack
                            $params[$template_endpoint[$i]['params'][$k]['name']] = $url[$k];

                        //  2nd level match - if one element doesn't match, 
                        //  the whole url can't match.
                        }else if($url[$k]!=$template_endpoint[$i]['params'][$k]['name']){
                            $match = false;
                            break;
                        }
                    }
    
                    // call url trigger function with found parameters
                    if($match == true){
                        return $template_endpoint[$i]['callback']($request,$params);
                    } 
                }
            }

        }else{

            //  if request method is not supported, the router sends
            //  a header with a 503 server code (bad gateway) and a list with
            //  possible methods to the client

            $this->get_503 ( $request );
            return false;
        }
        
        return false;
    }

    /**
     *  @description - adds endpoint template
     *  @param {string}endpoint - url of endpoint
     *  @param {string}method - method of endpoint
     *  @param {string}f - callback function of endpoint
     */
    public function add ( $endpoint, $method, $f ){
        if(!$this->endpoints[$method])
            $this->endpoints[$method] = [];
        $endpoint = $this->prepare_url($endpoint);
        array_push($this->endpoints[$method],HttpUrlParameter::get_template( $endpoint, $f ));
    }

    /**
     *  @description - adds default endpoint (index.html) template
     *  @param {string}f - callback function of endpoint
     */
    public function add_default( $f ){
        $this->endpoints['default'] = $f;
    }

    // response generator
    private function generate_response ( $response, $request) {
        return new React\Http\Response($response[0],$response[1],$response[2]);
    }

    /**
     *  @description - 'not found' header, when request uses not registred 
     *  endpoint.
     */
    public function get_404($request) {
        return new React\Http\Response(404,['Content-Type' => 'text/html'],'<h1>404</h1><br/><h3>No content found for request '.$request->getUri()->getPath().'.</h3>');
    }


    //  'bad gateway' header, when request uses unsopported transfair method
    private function get_503($request){
        return new React\Http\Response(501,[
            'Content-Type' => 'text/html',
            'Access-Control-Allow-Methods'=>'GET', 
            'Access-Control-Allow-Headers'=>'Content-Type'
        ],
        '<h1>503</h1><br/><h3>No service for method '.$request->getMethod().' available.</h3>');
    }

    private function prepare_url( $url ){
        return substr($url,0,1)=="/" ?  substr_replace($url,"",0,1) : $url;
    }    
}
?>