<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    protected $clients;
    
    //array met laatste zoekstring van elke client
    private $searchStrings=[];

    //array met werknemers
    private $werknemers=array(
        'Jan De Laet',
        'Jos Op De Beeck',
        'Fons Vermeulen'
    );

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        
        $numRecv = count($this->clients) - 1;
        
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        //messages worden doorgestuurd als jsonobject en hier gedecodeerd
        $msg=json_decode($msg);

        //indien msg als action add heeft
        if($msg->action=='add'){
            //nieuwe werknemer toevoegen aan array
            array_push($this->werknemers,$msg->message);
            //gefilterde werknemers naar elke client sturen (incl verzender)
            foreach ($this->clients as $client) {
                $client->send(
                    json_encode(
                        //filtering gebeurt voor elke client op basis van zijn eigen zoekterm
                        $this->filterWerknemers($this->searchStrings[$client->resourceId])
                    )
                );
            }

        //indien msg als action filter heeft
        }elseif($msg->action=='filter'){
            //opslaan zoekterm in array
            $this->searchStrings[$from->resourceId] = $msg->message;
            //gefilterde werknemers naar verzender sturen
            $from->send(
                json_encode(
                    $this->filterWerknemers($this->searchStrings[$from->resourceId])
                )
            );    
        }
        
    }

    public function onClose(ConnectionInterface $conn) {
    // The connection is closed, remove it, as we can no longer send it messages
    $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    private function filterWerknemers($msg){
        
        $response=[];

        foreach ($this->werknemers as $werknemer) {
            if(strpos(strtolower($werknemer),strtolower($msg))!==false){
                array_push($response,$werknemer);
            }
        }

        return $response;


    }

}
