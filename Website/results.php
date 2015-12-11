<?php

include 'functions.php';

session_start();

if (isset($_GET["eventid"])) {
    $_SESSION["eventid"] = $_GET["eventid"];
} 
else 
{
    $_SESSION["eventid"] = 1;
}

if (isset($_GET["getcat"])) {
    $_SESSION["getcat"] = $_GET["getcat"];
} 

if (isset($_GET["getclass"])) {
    $_SESSION["getclass"] = $_GET["getclass"];
} 
else
{
    $_SESSION["getclass"] = '*';
}

require_once('connection.php');
require_once('event.php');
require_once('event_individual.php');
require_once('entrant.php');
require_once('custom_comparision.php');

$eventDAO = new EventImpl();
$entrantDAO = new EntrantImpl();
$event_IndividualDAO = new Event_IndividualImpl();

$eventStageStartTimes = $eventDAO->getStageStartTimeInformation($_SESSION["eventid"], $_SESSION["getcat"]);
$stageStartTimes = $eventStageStartTimes->getStageStartTimes();

$mostRecentStage = 0;
foreach($stageStartTimes as $key => $stageStartTime){
    if( strtotime($stageStartTime) < strtotime('now') && strtotime($stageStartTime) > strtotime($stageStartTimes[$mostRecentStage]) ){
        $mostRecentStage = $key;
    }
}

if (isset($_GET["getstage"])) 
{
    $_SESSION["getstage"] = $_GET["getstage"];
} 
else 
{
    $_SESSION["getstage"] = $mostRecentStage + 1;
}

$eventIndividualInformation = $event_IndividualDAO->getEventIndividualInformation($_SESSION["eventid"]);
$eventIndividualInformationJson = $eventIndividualInformation->getJson();
$jsonEventIndividualInformationObj = json_decode($eventIndividualInformationJson);
$event = $eventDAO->getEventInformation($_SESSION["eventid"], $_SESSION["getstage"], $_SESSION["getcat"]);
$classArray = $eventDAO->getClasses($_SESSION["eventid"], $_SESSION["getcat"]);
$categoriesDB = $eventDAO->getCategories($_SESSION["eventid"]);
$driverStageEvent = $entrantDAO->getStageInformation($_SESSION["eventid"], $_SESSION["getstage"], $_SESSION["getclass"], $_SESSION["getcat"]);
$driveOverAllrEvent = $entrantDAO->getOverallInformation($_SESSION["eventid"], $_SESSION["getstage"], $_SESSION["getclass"], $_SESSION["getcat"]);
$top3Array = $entrantDAO->getOverallInformationTop3($_SESSION["eventid"], $_SESSION["getstage"], $_SESSION["getclass"], $_SESSION["getcat"]);

if ($_SESSION["getstage"] > 1) {
    $driveoverallreventPreviousStage = $entrantDAO->getOverallInformation($_SESSION["eventid"], $_SESSION["getstage"] - 1, $_SESSION["getclass"], $_SESSION["getcat"]);
}

$classPositions = array();
$classPosition = 0;

foreach ($categoriesDB as $category) {
    $categories[] = new CategoryComparisionObj($category);
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <title>Rally Results</title>
</head>

<body>
    <?php include 'include/header.php'?>
    
    <div id="id_eventDetails" class="c_backgroundColorWhite">
        <span class="c_eventLocation"><?php echo "Results" ;?></span><br />
        <span class="c_eventLocation"><?php echo $jsonEventIndividualInformationObj->{'name'} ;?></span><br />
        <span class="c_info"><?php echo date("d-m-Y", strtotime($jsonEventIndividualInformationObj->{'startdate'}))." to ".date("d-m-Y", strtotime($jsonEventIndividualInformationObj->{'finishdate'})) ;?></span><br />
        <span class="c_info"><?php echo "Surface: ".$jsonEventIndividualInformationObj->{'surface'}." - No.Stages: ".$event->getNoOfStages()." - Total Distance: ".$event->getTotalStageKm()."km" ?></span><br />
        <span class="c_info"><?php echo "Stage Name: ".$event->getStageName()." - Stage Distance: ".$event->getStageDistance()."km - Stage Start Time: ".$event->getStageStartTime();?></span>
    </div>
    
    <?php include 'include/eventmenu.php'?>
    
    <div id="id_eventInfo" class="c_backgroundColorWhite">
        <?php
            $dayCount = 1;
        ?>
        <span class="c_stageAlignment">Day <?php echo $dayCount; ?>: </span>
        <?php
            $stage = 1;
            $stageCount = 1 + $event->getStageOffset();
            while($stageCount <= ($event->getNoOfStages() +  $event->getStageOffset()))
            {
                if($stage == $_SESSION["getstage"])
                {
                ?>
                    <a href="<?php echo "results.php?getcat=".$_SESSION["getcat"]."&getstage=".$stage."&getclass=".$_SESSION["getclass"]."&eventid=".$_SESSION["eventid"];?>"><div class="stageCircle stageSelected"><?php echo $stageCount;?></div></a>
                <?php
                }
                else
                {
                ?>
                    <a href="<?php echo "results.php?getcat=".$_SESSION["getcat"]."&getstage=".$stage."&getclass=".$_SESSION["getclass"]."&eventid=".$_SESSION["eventid"];?>"><div class="stageCircle stageUnSelected"><?php echo $stageCount;?></div></a>
                <?php
                }
                
                if (in_array(($stage  +  $event->getStageOffset()), $jsonEventIndividualInformationObj->{'service'})) 
                {
                ?>
                    <img id="id_service" src="images/service.png" alt="service"/>
                <?php
                }

                if (in_array($stage, $jsonEventIndividualInformationObj->{'endofday'})) 
                {
                    $dayCount++;
                ?>
                <br /><span class="c_stageAlignment">Day <?php echo $dayCount; ?>: </span>
                <?php
                }
              $stage++;
              $stageCount++;
            }
        ?>
    </div>
    
    <div class="id_section c_backgroundColorWhite">
        <span class="c_stageAlignment">Sort by Category:</span>
        <?php
        usort($categories, array("CategoryComparisionObj", "CustomCategoryComparision"));
        foreach ($categories as $category) {
            if($_SESSION["getcat"] == $category->name)
            {
            ?>
                <a href="<?php echo "results.php?getcat=".$category->name."&getclass=".'*'."&getstage=".$_SESSION["getstage"]."&eventid=".$_SESSION["eventid"];?>" style="color:red;" ><div class="id_sectionSelected c_sectionUniform"><?php echo $category->name;?></div></a>
            <?php
            }
            else
            {
            ?>
                <a href="<?php echo "results.php?getcat=".$category->name."&getclass=".'*'."&getstage=".$_SESSION["getstage"]."&eventid=".$_SESSION["eventid"];?>"><div class="id_sectionUnSelected c_sectionUniform"><?php echo $category->name;?></div></a>
            <?php
            }
        }
        ?>
    </div>
    
    <div class="id_section c_backgroundColorWhite">
        <span class="c_stageAlignment">Sort by Class:</span>
        <?php
        sort($classArray, SORT_NUMERIC);
        for ($k=0; $k < count($classArray); $k++)
        {
            if($_SESSION["getclass"] == $classArray[$k])
            {
            ?>
                <a href="<?php echo "results.php?getcat=".$_SESSION["getcat"]."&getclass=".$classArray[$k]."&getstage=".$_SESSION["getstage"]."&eventid=".$_SESSION["eventid"];?>"><div class="id_sectionSelected c_sectionUniform"><?php echo $classArray[$k];?></div></a><?php
            }
            else
            {
            ?>
                <a href="<?php echo "results.php?getcat=".$_SESSION["getcat"]."&getclass=".$classArray[$k]."&getstage=".$_SESSION["getstage"]."&eventid=".$_SESSION["eventid"];?>"><div class="id_sectionUnSelected c_sectionUniform"><?php echo $classArray[$k];?></div></a>
            <?php
            }
        }
        ?>
    </div>
    
    <div id="bodyMain">
        <div id="wrapper">
            <div id="bodyLeft">
                <div style="background-color: #EDF5F7;">
                    <div class="pos">#</div>
                    <div id="divercar">
                        <div id="driver">Driver - Co.Driver</div>
                        <div id="car">Car Make</div>
                    </div>
                    <div id="flag"></div>
                    <div class="catclass">
                        <div id="category">Cat</div>
                        <div id="class">Class</div>
                    </div>
                    <div id="stagetime">Stage Time</div>
                    <div id="diff">
                        <div id="stagediff">Diff</div>
                        <div id="stagediffpr">Diffpr</div>
                    </div>
                </div>
                <?php 
                $entrantStagePosition = 0;
                $previousStageTime = 0;
                foreach ($driverStageEvent as $entrant) 
                {
                    $entrantStageTime = $entrant->getStageTime();
                    if($entrantStagePosition == 0){ $leadingStageTime = $entrantStageTime; }
                    $differenceToStageLeader = $entrantStageTime - $leadingStageTime;
                    $diffprevious = $entrantStageTime - $previousStageTime;
                ?>
                <div class="<?php if($entrant->getIsSuperRally() == 't'){echo 'entrantStyleSuperRally';} else {echo 'entrantStyleNotSuperRally';} ?>">
                        <div class="pos"><?php if($diffprevious == 0.0){ echo "="; ++$entrantStagePosition; } else { echo ++$entrantStagePosition; } ?></div>
                        <div id="divercar">
                            <div id="driver"><a href="<?php echo "entrantinfo.php?eventid=".$_SESSION["eventid"]."&carnumberleft=".$entrant->getNumber();?>" target="_blank"><?php echo $entrant->getDriver().' - '. $entrant->getCodriver(); ?></a></div>
                            <div id="car"><?php echo '#'.$entrant->getNumber().' - '.$entrant->getCar() ; ?></div>
                        </div>
                        <div id="flag"><img src="<?php echo 'logos/'.strstr($entrant->getCar(), ' ', true).'.png'; ?>" alt="Flag" width="28" height="32"></div>
                        <div class="catclass">
                            <div id="category"><?php echo substr($entrant->getCategory(), 0, 1); ?></div>
                            <div id="class"><?php echo $entrant->getClass(); ?></div>
                        </div>
                        <div id="stagetime"><?php echo convertToHMSs($entrant->getStageTime()); ?></div>
                        <div id="diff" style="<?php if ($entrantStagePosition % 2 == 0) { echo "background-color: #EDF5F7;"; } ?>">
                            <div id="stagediff"><?php if ($entrantStagePosition != 1) { echo '+'.convertTodiff($differenceToStageLeader); } ?></div>
                            <div id="stagediffpr"><?php if ($entrantStagePosition != 1) { echo '+'.convertTodiff($diffprevious); } ?></div>
                        </div>
                    </div>
                <?php
                $previousStageTime = $entrantStageTime;
                }
                ?>
                <div class="noresults"><?php if(count($driverStageEvent) == 0) { echo 'No Results'; }?></div>
            </div>

            <div id="bodyRight">
                <div style="background-color: #EDF5F7;">
                    <div class="posoa">#</div>
                    <div class="posoa"></div>
                    <div id="divercar">
                        <div id="driver">Driver - Co.Driver</div>
                        <div id="car">Car Make</div>
                    </div>
                    <div id="flag"></div>
                    <div class="catclass">
                        <div id="category">Cat</div>
                        <div id="class">Class</div>
                    </div>
                    <div id="oastagetime">
                        <div id="time">Time</div>
                        <div id="oapenalty">Penalty</div>
                    </div>
                    <div id="diff">
                        <div id="stagediff">Diff</div>
                        <div id="stagediffpr">Diffpr</div>
                    </div>
                </div>
                <?php 
                $entrantOverAllPosition = 0;
                $previousOverAllTime = 0;
                foreach ($driveOverAllrEvent as $entrant) 
                {
                    $entrantOverAllEventTime = $entrant->getTotal();
                    if($entrantOverAllPosition == 0){ $leadingTimeOverall = $entrantOverAllEventTime; }
                    $differenceToOverAllLeader = $entrantOverAllEventTime - $leadingTimeOverall;
                    $differencePreviousOverAll = $entrantOverAllEventTime - $previousOverAllTime;

                    if ($entrantOverAllPosition > 2 && $_SESSION["getclass"] == "*") 
                    {
                        if (!array_key_exists($entrant->getClass(), $classPositions)) 
                        {
                          $classPositions[$entrant->getClass()] = 1 ;
                          $classPosition = 1;
                        }
                        else 
                        {
                          $positionByClass = $classPositions[$entrant->getClass()] ;
                          $classPosition = $positionByClass + 1;
                          $classPositions[$entrant->getClass()] = $classPosition ;
                        }
                    }
                    else 
                    {
                        if (!array_key_exists($entrant->getClass(), $classPositions)) 
                        {
                            $classPositions[$entrant->getClass()] = 1 ;
                            $classPosition = 1;
                        }
                        else 
                        {
                            $positionByClass = $classPositions[$entrant->getClass()] ;
                            $classPosition = $positionByClass + 1;
                            $classPositions[$entrant->getClass()] = $classPosition;
                        }
                    }
                ?>
                <!-- <div id="pos"><?php// if($diffprOverall == 0.0){ echo "="; ++$pos; } else { echo ++$pos."(".$classPos.")"; } ?></div> -->
                <div class="catclass">
                    <div id="category"><?php if($differencePreviousOverAll == 0.0){ echo "="; ++$entrantOverAllPosition; } else { echo ++$entrantOverAllPosition; } ?></div>
                    <div id="class">
                        <?php
                        if ($_SESSION["getclass"] == "*")
                        {
                            if ($entrantOverAllPosition <= 3)
                            {
                                echo "(O/A)";
                                $x = $classPositions[$entrant->getClass()];
                                $classPosition = $x - 1;
                                $classPositions[$entrant->getClass()] = $classPosition;
                            }
                            else
                            {
                                echo "(".$classPosition.")";
                            }
                        }
                        else
                        {
                            if (in_array($entrant->getNumber() ,$top3Array))
                            {
                                echo "(O/A)";
                                $positionByClass = $classPositions[$entrant->getClass()];
                                $classPosition = $positionByClass - 1;
                                $classPositions[$entrant->getClass()] = $classPosition;
                            }
                            else
                            {
                                echo "(".$classPosition.")";
                            }
                        } 
                        ?>
                    </div>
                </div>
                    <div id="icons"><img src="
                    <?php 
                    if ($_SESSION["getstage"] > 1) 
                    {
                        $position = getPositionPreviousStage($driveoverallreventPreviousStage, $entrant->getNumber());
                        if ($position == $entrantOverAllPosition) 
                        {
                            echo 'icons/Equals.png';
                        } 
                        else if ($position < $entrantOverAllPosition)
                        {
                            echo 'icons/Down.png';
                        } 
                        else 
                        {
                            echo 'icons/Up.png';
                        }
                    }
                    else 
                    {
                      echo 'icons/Equals.png';
                    }
                    ?>
                    " alt="Flag" width="20" height="20">
                    </div>
                    <div id="divercar">
                        <div id="driver"><?php echo $entrant->getDriver().' - '. $entrant->getCodriver(); ?></div>
                        <div id="car"><?php echo '#'.$entrant->getNumber().' - '. $entrant->getCar(); ?></div>
                    </div>
                    <div id="flag"><img src="<?php echo 'logos/'.strstr($entrant->getCar(), ' ', true).'.png'; ?>" alt="Flag" width="32" height="28"></div>
                    <div class="catclass">
                        <div id="category"><?php echo substr($entrant->getCategory(), 0, 1); ?></div>
                        <div id="class"><?php echo $entrant->getClass(); ?></div>
                    </div>
                    <div id="oastagetime">
                        <div id="time"><?php echo convertToHMSs($entrant->getTotal()); ?></div>
                        <div id="oapenalty"><?php if (penaltyTotal($_SESSION["getstage"], $entrant->getPenaltyTotal()) != 0) { echo convertToHMSs(penaltyTotal($_SESSION["getstage"], $entrant->getPenaltyTotal())); } ?></div>
                    </div>
                    <div id="diff" style="<?php if ($entrantOverAllPosition % 2 == 0) { echo "background-color: #EDF5F7;"; } ?>">
                        <div id="stagediff"><?php if ($entrantOverAllPosition != 1) { echo '+'.convertTodiff($differenceToOverAllLeader); } ?></div>
                        <div id="stagediffpr"><?php if ($entrantOverAllPosition != 1) { echo '+'.convertTodiff($differencePreviousOverAll); } ?></div>
                    </div>
                <?php
                    $previousOverAllTime = $entrantOverAllEventTime;
                }
                ?>
                <div class="noresults"><?php if(count($driverStageEvent) == 0) { echo 'No Results'; }?></div>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
    
    <?php include 'include/footer.php'?>
    
</body>
</html>
