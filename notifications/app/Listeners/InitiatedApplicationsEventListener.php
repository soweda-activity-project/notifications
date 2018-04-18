<?php
    require_once __DIR__ . '\..\..\vendor\autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();
    $channel->queue_declare('INITIATED-APPLICATIONS-QUEUE', false, true, false, false);
    echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";


    $callback = function($msg) {


        $url = 'http://localhost:8081/api/message/receivedapplication';



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg->body );



        $result = curl_exec($ch);
        if( $result === FALSE){
            die('Curl request failed: '.curl_error($ch));
        }else{

            echo " [x] I received --------------------", $result, "\n";

        }


    };
    $channel->basic_consume('INITIATED-APPLICATIONS-QUEUE', '', false, true, false, false, $callback);
    while(count($channel->callbacks)) {
        $channel->wait();
    }
    $channel->close();
    $connection->close();
?>




