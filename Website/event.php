<?php

interface IEvent{
    public function getEventInformation($eventId, $stageNumber, $category);
    public function getStageStartTimeInformation($eventId, $category); 
    public function getClasses($eventId, $catId);
}

class EventDetails{
    private $id;
    private $location;
    private $startDate;
    private $finishDate;
    private $surface;
    private $noOfStages;
    private $stageName;
    private $stageDistance;
    private $stageStartTime;
    private $totalStageKm;
    private $stageOffset;

    function setId($par){
        $this->id = $par;
    }

    function getId(){
        return $this->id;
    }

    function setLocation($par){
        $this->location = $par;
    }

    function getLocation(){
        return $this->location;
    }

    function setStartDate($par){
        $this->startDate = $par;
    }

    function getStartDate(){
        return date("d-m-Y", strtotime($this->startDate));
    }

    function setFinishDate($par){
        $this->finishDate = $par;
    }

    function getFinishDate(){
        return date("d-m-Y", strtotime($this->finishDate));
    }

    function setSurface($par){
        $this->surface = $par;
    }

    function getSurface(){
        return $this->surface;
    }

    function setNoOfStages($par){
        $this->noOfStages = $par;
    }

    function getNoOfStages(){
        return $this->noOfStages;
    }

    function setStageName($par){
        $this->stageName = $par;
    }

    function getStageName(){
        return $this->stageName;
    }

    function setStageDistance($par){
        $this->stageDistance = $par;
    }

    function getStageDistance(){
        return $this->stageDistance;
    }

    function setStageStartTime($par){
        $this->stageStartTime = $par;
    }

    function getStageStartTime(){
        return date("H:i",strtotime($this->stageStartTime));
    }

    function setTotalStageKm($par){
        $this->totalStageKm = $par;
    }

    function getTotalStageKm(){
        return $this->totalStageKm;
    }

    function setStageOffset($par){
        $this->stageOffset = $par;
    }

    function getStageOffset(){
        return $this->stageOffset;
    }

    function getDayOfStage(){
        return date("Y-m-d",strtotime($this->stageStartTime));
    }
}

class StageTimeEventDetails{

    public $stageStartTimes = array();

    function setStageStartTimes($par){
        array_push($this->stageStartTimes, $par);
    }

    function getStageStartTimes() {
        return $this->stageStartTimes;
    }
}

class EventImpl extends Connection implements IEvent{
    function getStageStartTimeInformation($eventId, $category){
        $event = new StageTimeEventDetails();
        try{
            $dbConnection = parent::open();
            $sql =<<<EOF
            SELECT array_length("Stage_information", 1) AS NumberOfStages
            FROM "Event_Category"
            WHERE "Id" = '$eventId'
            AND "CategoryType" = '$category';
EOF;
            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }
            while($row = pg_fetch_row($result)){
                $stageCount = $row[0];
            }

            for ($stageNumber = 1; $stageNumber <= $stageCount; $stageNumber++) {
                $sql =<<<EOF
                SELECT "Stage_information"['$stageNumber'].Stage_Start_Time AS Stage_Start_Time
                FROM "Event_Category"
                WHERE "Id" = '$eventId'
                AND "CategoryType" = '$category';
EOF;

                $result = pg_query($dbConnection, $sql);
                if(!$result){
                    echo pg_last_error($dbConnection);
                    exit;
                }
                while($row = pg_fetch_row($result)){
                    $event->setStageStartTimes($row[0]);
                }
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        parent::close();
        return $event;
    }

    function getEventInformation($eventId, $stageNumber, $category){
        $event = new EventDetails();
        try{
            $dbConnection = parent::open();
            $sql =<<<EOF
            SELECT "Id" AS Event_Id,
            "Stage_information"['$stageNumber'].Stage_Name AS Stage_Name, "Stage_information"['$stageNumber'].Stage_Distance AS Stage_Distance,
            "Stage_information"['$stageNumber'].Stage_Start_Time AS Stage_Start_Time, array_length("Stage_information", 1) AS NumberOfStages,
            "Total_stage_km" AS Total_Stage_Km, "CategoryType", "Offset"
            FROM "Event_Category"
            WHERE "Id" = '$eventId'
            AND "CategoryType" = '$category';
EOF;
            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }
            while($row = pg_fetch_row($result)){
                $event->setId($row[0]);
                $event->setStageName($row[1]);
                $event->setStageDistance($row[2]);
                $event->setStageStartTime($row[3]);
                $event->setNoOfStages($row[4]);
                $event->setTotalStageKm($row[5]);
                $event->setStageOffset($row[7]);
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        parent::close();
        return $event;
    }

    function getClasses($eventId, $catId){
        $classArray = array();
        try{
            $dbConnection = parent::open();
            $sql =<<<EOF
            SELECT DISTINCT ("Class")
            FROM "Entrant"
            WHERE "Id" = '$eventId'
            AND "Category" = '$catId';
EOF;

            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }
            while($row = pg_fetch_row($result)){
                array_push($classArray, $row[0]);
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        parent::close();
        return $classArray;
    }

    function getCategories($eventId){
        $classArray = array();
        try{
            $dbConnection = parent::open();
            $sql =<<<EOF
            SELECT DISTINCT ("Category")
            FROM "Entrant"
            WHERE "Id" = '$eventId';
EOF;

            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }
            while($row = pg_fetch_row($result)){
                array_push($classArray, $row[0]);
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        parent::close();
        return $classArray;
    }
}

?>
