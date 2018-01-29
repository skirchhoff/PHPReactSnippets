<?php

/**
 *  @description - http server with router, based on 
 *  reactPHP library
 */
class HttpServer extends EventHandler{

    private $server;
    public $router;
    private $socket;
    private $port;

    function __construct () {

        $this->router = new ServerRouter();
        $this->server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) {
            return $this->router->get_response($request);
        });
    }

    /**
     *  @description - starts socket server with given port and hangs http server to
     *  the socket server loop
     *  @param {uint}$port - port to observe
     */
    public function start_server ( $port ) {
        $this->port = $port;
        $this->socket = new React\Socket\Server($port, React\EventLoop\Factory::get());
        $this->socket->on('error', function (Exception $e) {
            echo 'error: ' . $e->getMessage() . PHP_EOL;
            if ($e->getPrevious() !== null) {
                $previousException = $e->getPrevious();
                echo $previousException->getMessage() . PHP_EOL;
            }
        });
        $this->server->listen($this->socket);
        React\EventLoop\Factory::get()->run();
    }
}
?>