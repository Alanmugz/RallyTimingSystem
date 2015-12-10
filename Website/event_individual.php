<?php

interface IEvent_Individual{
    public function getEventIndividualInformation($eventId);
}

class Event_IndividualDetails{
    private $id;
    private $json;

    function setId($par){
        $this->id = $par;
    }

    function getId(){
        return $this->id;
    }

    function setJson($par){
        $this->json = $par;
    }

    function getJson(){
        return $this->json;
    }
}

class Event_IndividualImpl extends Connection implements IEvent_Individual{
    function getEventIndividualInformation($eventId){
        $event = new Event_IndividualDetails();
        try{
            $dbConnection = parent::open();
            $sql = getEventIndividualInformationByEventIdSql($eventId);
            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }

            while($row = pg_fetch_row($result)){
                $event->setId($row[0]);
                $event->setJson($row[1]);
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        parent::close();
        return $event;
    }
}

function getEventIndividualInformationByEventIdSql($eventId) {
    return <<<EOF
        SELECT *
        FROM "Event_Individual"
        WHERE "Id" = '$eventId';
EOF;
}

?>
