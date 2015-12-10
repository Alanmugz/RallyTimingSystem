<?php

interface IEntrant{
	public function getStageInformation($eventId, $stageNumber, $classId, $catId);
	public function getOverallInformation($eventId, $stageNumber, $classId, $catId);
        public function getOverallInformationTop3($eventId, $stageNumber, $classId, $catId);
        public function getEntrantInformationById($eventId, $carNumber, $stage);
}

class EntrantDetails{
	private $id;
	private $number;
	private $driver;
	private $codriver;
	private $address;
	private $car;
	private $class;
	private $categry;
	private $stagetime;
	private $penaltytotal;
	private $penalties;
	private $total;
	private $position;
        private $isSuperRally;

	function setId($par){
            $this->id = $par;
	}

	function getId(){
            return $this->id;
	}

	function setNumber($carNumber){
            if ($carNumber > 300) {
                if (strpos($carNumber, '30') !== FALSE) {
                    $carNumber = str_replace("30", "J", $carNumber);
                }
                if ($carNumber > 309) {
                    if (strpos($carNumber, '3') !== FALSE) {
                        $carNumber = str_replace("3", "J", $carNumber);
                    }
                }
            }

            if ($carNumber > 200 && $carNumber < 300) {
                if (strpos($carNumber, '20') !== FALSE) {
                    $carNumber = str_replace("20", "H", $carNumber);
                }
            
                if ($carNumber > 209) {
                    if (strpos($carNumber, '2') !== FALSE) {
                        $carNumber = str_replace("2", "H", $carNumber);
                    }
                }
            }
            $this->number = $carNumber;
	}

	function getNumber(){
            return $this->number;
	}

	function setDriver($par){
            $this->driver = $par;
	}

	function getDriver(){
            return $this->driver;
	}

	function setCodriver($par){
            $this->codriver = $par;
	}

	function getCodriver(){
            return $this->codriver;
	}

	function setAddress($par){
            $this->address = $par;
	}

	function getAddress(){
            return $this->address;
	}

	function setCar($par){
            $this->car = $par;
	}

	function getCar(){
            return $this->car;
	}

	function setClass($par){
            $this->class = $par;
	}

	function getClass(){
            return $this->class;
	}

	function setCategory($par){
            $this->category = $par;
	}

	function getCategory(){
            return $this->category;
	}

	function getStageTime(){
            return $this->stagetime;
	}

	function setStageTime($par){
            $this->stagetime = $par;
	}

	function getPenaltyTotal(){
            return $this->penaltytotal;
	}

	function setPenaltyTotal($par){
            $this->penaltytotal = $par;
	}

	function getPenalties(){
            return $this->penalties;
	}

	function setPenalties($par){
            $this->penalties = $par;
	}

	function getTotal(){
            return $this->total;
	}

	function setTotal($par){
            $this->total = $par;
	}

	function getPosition(){
            return $this->position;
	}

	function setPosition($par){
            $this->position = $par;
	}
        
        function getIsSuperRally(){
            return $this->isSuperRally;
	}

	function setIsSuperRally($par){
            $this->isSuperRally = $par;
	}
}

class EntrantPosition{
	private $position;
        
        function getPosition(){
            return $this->position;
	}

	function setPosition($par){
            $this->position = $par;
	}
}

class EntrantClassAndCategory{
	private $classEntered;
        private $category;
        private $number;
        private $driver;
        private $codriver;
        private $car;

        
        function getClassEntered(){
            return $this->classEntered;
	}

	function setClassEntered($par){
            $this->classEntered = $par;
	}
        
        function getCategory(){
            return $this->category;
	}

	function setCategory($par){
            $this->category = $par;
	}
        
        function getNumber(){
            return $this->number;
	}

	function setNumber($par){
            $this->number = $par;
	}
        
        function getDriver(){
            return $this->driver;
	}

	function setDriver($par){
            $this->driver = $par;
	}
        
        function getCoDriver(){
            return $this->codriver;
	}

	function setCoDriver($par){
            $this->codriver = $par;
	}
        
        function getCar(){
            return $this->car;
	}

	function setCar($par){
            $this->car = $par;
	}
}

class EntrantImpl extends Connection implements IEntrant{
    function getStageInformation($eventId, $stageNumber, $classId, $catId){
	$entrantArray = array();
	if($classId == '*'){
            try{
		$dbConnection = parent::open();
		$sql = getStageInformationByCategorySql($stageNumber, $eventId, $catId);
		$result = pg_query($dbConnection, $sql);
		if(!$result){
                    echo pg_last_error($dbConnection);
                    exit;
		}
		while($row = pg_fetch_row($result)){
                    $driverEvent = new EntrantDetails();
		    $driverEvent->setId($row[0]);
		    $driverEvent->setNumber($row[1]);
		    $driverEvent->setDriver($row[2]);
		    $driverEvent->setCodriver($row[3]);
		    $driverEvent->setAddress($row[4]);
		    $driverEvent->setCar($row[5]);
		    $driverEvent->setClass($row[6]);
                    $driverEvent->setCategory($row[7]);
                    $driverEvent->setPenaltyTotal($row[8]);
                    $driverEvent->setStageTime($row[10]);
                    $driverEvent->setPenalties($row[11]);
                    $driverEvent->setTotal($row[12]);
                    $driverEvent->setIsSuperRally($row[9]);

                    array_push($entrantArray, $driverEvent);
                }
            }
	    catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
	}
	else
	{
            try{
                $dbConnection = parent::open();
                $sql = getStageInformationByCategoryAndClassSql($stageNumber, $eventId, $catId, $classId);                   
                $result = pg_query($dbConnection, $sql);
                if(!$result){
                    echo pg_last_error($dbConnection);
                    exit;
                }
                while($row = pg_fetch_row($result)){
                    $driverEvent = new EntrantDetails();
                    $driverEvent->setId($row[0]);
                    $driverEvent->setNumber($row[1]);
                    $driverEvent->setDriver($row[2]);
                    $driverEvent->setCodriver($row[3]);
                    $driverEvent->setAddress($row[4]);
                    $driverEvent->setCar($row[5]);
                    $driverEvent->setClass($row[6]);
                    $driverEvent->setCategory($row[7]);
                    $driverEvent->setPenaltyTotal($row[8]);
                    $driverEvent->setStageTime($row[10]);
                    $driverEvent->setPenalties($row[11]);
                    $driverEvent->setTotal($row[12]);

                    array_push($entrantArray, $driverEvent);
                }
            }
            catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        parent::close();
        return $entrantArray;
    }

    function getOverallInformation($eventId, $stageNumber, $classId, $catId){
        $entrantArray = array();
        If($classId == '*')
        {
            try{
                $dbConnection = parent::open();
                $sql = getOverallInformationByCategorySql($stageNumber, $eventId, $catId);
                $result = pg_query($dbConnection, $sql);
                if(!$result){
                    echo pg_last_error($dbConnection);
                    exit;
                }
                $position = 0;
                while($row = pg_fetch_row($result)){
                    $driverEvent = new EntrantDetails();
                    $driverEvent->setId($row[0]);
                    $driverEvent->setNumber($row[1]);
                    $driverEvent->setDriver($row[2]);
                    $driverEvent->setCodriver($row[3]);
                    $driverEvent->setAddress($row[4]);
                    $driverEvent->setCar($row[5]);
                    $driverEvent->setClass($row[6]);
                    $driverEvent->setCategory($row[7]);
                    $driverEvent->setPenaltyTotal($row[8]);
                    $driverEvent->setStageTime($row[10]);
                    $driverEvent->setPenalties($row[11]);
                    $driverEvent->setTotal($row[12]);
                    $driverEvent->setPosition(++$position);

                    array_push($entrantArray, $driverEvent);
                }
            }
            catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        else
        {
            try{
                $dbConnection = parent::open();
                $sql = getOverallInformationByCategoryAndClassSql($stageNumber, $eventId, $catId, $classId);
                $result = pg_query($dbConnection, $sql);
                if(!$result){
                    echo pg_last_error($dbConnection);
                    exit;
                }
                $position = 0;
                while($row = pg_fetch_row($result)){
                    $driverEvent = new EntrantDetails();
                    $driverEvent->setId($row[0]);
                    $driverEvent->setNumber($row[1]);
                    $driverEvent->setDriver($row[2]);
                    $driverEvent->setCodriver($row[3]);
                    $driverEvent->setAddress($row[4]);
                    $driverEvent->setCar($row[5]);
                    $driverEvent->setClass($row[6]);
                    $driverEvent->setCategory($row[7]);
                    $driverEvent->setPenaltyTotal($row[8]);
                    $driverEvent->setStageTime($row[10]);
                    $driverEvent->setPenalties($row[11]);
                    $driverEvent->setTotal($row[12]);
                    $driverEvent->setPosition(++$position);

                    array_push($entrantArray, $driverEvent);
                }
            }
            catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        parent::close();
        return $entrantArray;
    }

    function getOverallInformationTop3($eventId, $stageNumber, $classId, $catId){
        $top3Array = array();
            try{
                $dbConnection = parent::open();
                $sql = getOverallInformationTop3ByCategoryAndClassSql($stageNumber, $eventId, $catId, $classId);                
                $result = pg_query($dbConnection, $sql);
                if(!$result){
                    echo pg_last_error($dbConnection);
                    exit;
                }

                while($row = pg_fetch_row($result)){
                    $driverEvent = new EntrantDetails();
                    $driverEvent->setNumber($row[1]);

                    array_push($top3Array, $driverEvent->getNumber());
                }
            }
            catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        parent::close();
        return $top3Array;
    }
    
    function getEntryList($eventId, $catId){
	$entrantArray = array();

        try{
            $dbConnection = parent::open();
            $sql = getEntryListByCategorySql($eventId, $catId);
            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }
            while($row = pg_fetch_row($result)){
                $driverEvent = new EntrantDetails();
                //$driverEvent->setId($row[0]);
                $driverEvent->setNumber($row[1]);
                $driverEvent->setDriver($row[2]);
                $driverEvent->setCodriver($row[3]);
                $driverEvent->setAddress($row[4]);
                $driverEvent->setCar($row[5]);
                $driverEvent->setClass($row[6]);
                $driverEvent->setCategory($row[7]);

                array_push($entrantArray, $driverEvent);
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        parent::close();
        return $entrantArray;
    }

    public function getEntrantInformationById($eventId, $carNumber, $stage){

        try{
            $dbConnection = parent::open();
            $sql = getEntrantInformationByIdSql($eventId, $carNumber, $stage);
            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }
            $driverEvent = new EntrantDetails();
            while($row = pg_fetch_row($result)){
                $driverEvent->setPenalties($row[1]);
                $driverEvent->setStageTime($row[0]);
                $driverEvent->setTotal($row[2]);
                $driverEvent->setPenaltyTotal($row[3]);
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        parent::close();
        if($driverEvent === null)
        {
            return null;
        }
        else
        {
            return $driverEvent;
        }
    }
    
    public function getPostionOverAllByCarNumber($eventId, $stageNumber, $carNumber, $cat){

        try{
            $dbConnection = parent::open();
            $sql = getPostionOverAllSql($eventId, $stageNumber, $carNumber, $cat);
            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }
            $driverPosition = new EntrantPosition();
            while($row = pg_fetch_row($result)){
                $driverPosition->setPosition($row[0]);
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        parent::close();
        if($driverPosition === null)
        {
            return null;
        }
        else
        {
            return $driverPosition;
        }
    }

    public function getPostionClassByCarNumber($eventId, $stageNumber, $carNumber, $class){

        try{
            $dbConnection = parent::open();
            $sql = getClassPostionSql($eventId, $stageNumber, $carNumber, $class);
            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }
            $driverPosition = new EntrantPosition();
            while($row = pg_fetch_row($result)){
                $driverPosition->setPosition($row[0]);
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        parent::close();
        if($driverPosition === null)
        {
            return null;
        }
        else
        {
            return $driverPosition;
        }
    }
    
    public function getEntrantsClassAndCategory($eventId, $carNumber){

        try{
            $dbConnection = parent::open();
            $sql = getEntrantsClassAndCategorySql($eventId, $carNumber);
            $result = pg_query($dbConnection, $sql);
            if(!$result){
                echo pg_last_error($dbConnection);
                exit;
            }
            $driverClassAndCategory = new EntrantClassAndCategory();
            while($row = pg_fetch_row($result)){
                $driverClassAndCategory->setClassEntered($row[0]);
                $driverClassAndCategory->setCategory($row[1]);
                $driverClassAndCategory->setNumber($row[2]);
                $driverClassAndCategory->setDriver($row[3]);
                $driverClassAndCategory->setCoDriver($row[4]);
                $driverClassAndCategory->setCar($row[5]);
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        parent::close();
        
        return $driverClassAndCategory;

    }
}

function getStageInformationByCategorySql($stageNumber, $eventId, $catId) {
    return <<<EOF
        SELECT *, "StageData"['$stageNumber'][1] AS Stage_Time, "StageData"['$stageNumber'][2] AS Penalties, (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s) AS Total
        FROM "Entrant"
        WHERE "Id" = '$eventId'
        AND "StageData"['$stageNumber'][1] is not null
        AND "Category" = '$catId'
        ORDER BY Stage_Time;
EOF;
}

function getStageInformationByCategoryAndClassSql($stageNumber, $eventId, $catId, $classId) {
    return <<<EOF
        SELECT *, "StageData"['$stageNumber'][1] AS Stage_Time, "StageData"['$stageNumber'][2] AS Penalties, (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s) AS Total
        FROM "Entrant"
        WHERE "Id" = '$eventId'
        AND "StageData"['$stageNumber'][1] is not null
        AND "Class" = '$classId'
        AND "Category" = '$catId'
        ORDER BY Stage_Time;
EOF;
}

function getOverallInformationByCategorySql($stageNumber, $eventId, $catId) {
    return <<<EOF
        SELECT *, "StageData"['$stageNumber'][1] AS Stage_Time, "StageData"['$stageNumber'][2] AS Penalties, (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s) AS Total
        FROM "Entrant"
        WHERE "Id" = '$eventId'
        AND "StageData"['$stageNumber'][1] is not null
        AND "Category" = '$catId'
        ORDER BY total;
EOF;
}

function getOverallInformationByCategoryAndClassSql($stageNumber, $eventId, $catId, $classId) {
    return <<<EOF
        SELECT *, "StageData"['$stageNumber'][1] AS Stage_Time, "StageData"['$stageNumber'][2] AS Penalties, (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s) AS Total
        FROM "Entrant"
        WHERE "Id" = '$eventId'
        AND "StageData"['$stageNumber'][1] is not null
        AND "Class" = '$classId'
        AND "Category" = '$catId'
        ORDER BY total;
EOF;
}

function getOverallInformationTop3ByCategoryAndClassSql($stageNumber, $eventId, $catId, $classId) {
    return <<<EOF
        SELECT *, "StageData"['$stageNumber'][1] AS Stage_Time, "StageData"['$stageNumber'][2] AS Penalties, (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s) AS Total
        FROM "Entrant"
        WHERE "Id" = '$eventId'
        AND "StageData"['$stageNumber'][1] is not null
        AND "Category" = '$catId'
        ORDER BY total
        LIMIT 3;
EOF;
}

function getEntryListByCategorySql($eventId, $catId) {
    return <<<EOF
        SELECT *
        FROM "Entrant"
        WHERE "Id" = '$eventId'
        AND "Category" = '$catId'
        ORDER BY "Number"
EOF;
}

function getEntrantInformationByIdSql($eventId, $carNumber, $stageNumber) {
    return <<<EOF
        SELECT "StageData"['$stageNumber'][1] AS Stage_Time, "StageData"['$stageNumber'][2] AS Penalties, (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s) AS Total, "StageData"
        FROM "Entrant"
        WHERE "Id" = '$eventId'
        AND "Number" = '$carNumber'
        AND "StageData"['$stageNumber'][1] is not null
EOF;
}

function getPostionOverAllSql($eventId, $stageNumber, $carNumber, $cat) {
    return <<<EOF
        SELECT result.pos
        FROM (SELECT row_number() over (order by (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s)) as pos, "Number", (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s) AS Total
              FROM "Entrant"
              WHERE "Id" = '$eventId'
              AND "Category" = '$cat'
              AND "StageData"['$stageNumber'][1] is not null
              ORDER BY Total) as result
        WHERE "Number" = '$carNumber'
EOF;
}

function getClassPostionSql($eventId, $stageNumber, $carNumber, $class) {
    return <<<EOF
        SELECT result.pos
        FROM (SELECT row_number() over (order by (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s)) as pos, "Number", (SELECT SUM(s) FROM UNNEST("StageData"[1:'$stageNumber']) s) AS Total
              FROM "Entrant"
              WHERE "Id" = '$eventId'
              AND "Class" = '$class'  
              AND "StageData"['$stageNumber'][1] is not null
              ORDER BY Total) as result
        WHERE "Number" = '$carNumber'
EOF;
}

function getEntrantsClassAndCategorySql($eventId, $carNumber) {
    return <<<EOF
        SELECT "Class", "Category", "Number", "Driver", "CoDriver", "Car" FROM "Entrant"
        WHERE "Id" = '$eventId'
        AND "Number" = '$carNumber'
EOF;
}

?>
