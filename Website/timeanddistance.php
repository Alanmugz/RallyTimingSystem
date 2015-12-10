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

require_once('connection.php');
require_once('event.php');
require_once('event_individual.php');
require_once('entrant.php');
require_once('custom_comparision.php');

$eventDAO = new EventImpl();
$event_IndividualDAO = new Event_IndividualImpl();

$event = $eventDAO->getEventInformation($_SESSION["eventid"], 1, $_SESSION["getcat"]);
$categoriesDB = $eventDAO->getCategories($_SESSION["eventid"], $_SESSION["getcat"]);
$eventIndividualInformation = $event_IndividualDAO->getEventIndividualInformation($_SESSION["eventid"]);
$eventIndividualInformationJson = $eventIndividualInformation->getJson();
$jsonEventIndividualInformationObj = json_decode($eventIndividualInformationJson);

foreach ($categoriesDB as $category) {
    $categories[] = new CategoryComparisionObj($category);
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <title>Stage Information</title>
</head>

<body style="min-width: 1200px;">
    
    <?php include 'include/header.php'?>
    
    <div id="id_eventDetails" class="c_backgroundColorWhite">
        <span class="c_eventLocation"><?php echo "Time & Distance" ;?></span><br />
        <span class="c_eventLocation"><?php echo $jsonEventIndividualInformationObj->{'name'} ;?></span><br />
        <span class="c_info"><?php echo date("d-m-Y", strtotime($jsonEventIndividualInformationObj->{'startdate'}))." to ".date("d-m-Y", strtotime($jsonEventIndividualInformationObj->{'finishdate'})) ;?></span><br />
        <span class="c_info"><?php echo "Surface: ".$jsonEventIndividualInformationObj->{'surface'}." - No.Stages: ".$event->getNoOfStages()." - Total Distance: ".$event->getTotalStageKm()."km" ?></span><br />
    </div>
    
    <?php include 'include/eventmenu.php'?>
    
    <div id="bodyMain">
        <div style="width: 75%; margin-left: auto; margin-right: auto; height: auto; padding: 8px">
            <?php
                $stage = 1 ;
                $totalDistance = 0;
                usort($categories, array("CategoryComparisionObj", "CustomCategoryComparision"));
                $_SESSION["getcat"] = $categories[0]->name;
                foreach ($categories as $category) {
                    if($stage == 1)
                    {
                        ?>
                        <div style="width: 98%; text-align: center; padding: 5px"><h3><?php echo $category->name; ?></h3></div>
                        <div style="width: 98%; background-color: #EDF5F7; overflow:auto; padding: 5px 0px">
                            <div style="float: left; width: 33%"><div style="margin-left: auto; margin-right: auto; width: 50%">Stage Name</div></div>
                            <div style="float: left; display: block; width: 34%; text-align: center">F.C.D</div>
                            <div style="float: right; width: 33%; text-align: center">Distance</div>
                        </div>
                        <?php
                    }
                                        
                    $event = $eventDAO->getEventInformation($_SESSION["eventid"], $stage, $category->name);
                    $stage = 1;
                    $day = 1;
                    $stageCount = 1 + $event->getStageOffset();
                    while($stageCount <= ($event->getNoOfStages() +  $event->getStageOffset())) {
                        $event = $eventDAO->getEventInformation($_SESSION["eventid"], $stage, $category->name);
                        ?>
                        <div style="width: 98%; overflow:auto; padding: 5px 0px">
                            <div style="float: left; width: 33%"><div style="margin-left: auto; margin-right: auto; width: 50%"><?php echo $stageCount."  ".$event->getStageName(); ?></div></div>
                            <div style="float: left; display: block; width: 34%; text-align: center"><?php echo $event->getStageStartTime(); ?></div>
                            <div style="float: right; width: 33%; text-align: center"><?php echo $event->getStageDistance(); ?></div>
                        </div>
                        <?php
                            if (in_array(($stage +  $event->getStageOffset()), $jsonEventIndividualInformationObj->{'service'})) 
                            {
                                ?>
                                <div style="width: 98%; overflow:auto; padding: 5px 0px">
                                    <div style="float: left; width: 33%; text-align: center;">&nbsp;</div>
                                    <div style="float: left; display: block; width: 34%; text-align: center"><?php echo "Service"; ?></div>
                                    <div style="float: right; width: 33%; text-align: center">&nbsp;</div>
                                </div>
                                <?php
                            }

                            if (in_array($stage, $jsonEventIndividualInformationObj->{'endofday'})) 
                            {
                                ?>
                                <div style="width: 98%; overflow:auto; padding: 5px 0px">
                                    <div style="float: left; width: 33%; text-align: center;">&nbsp;</div>
                                    <div style="float: left; display: block; width: 34%; text-align: center"><?php echo 'Day'.++$day; ?></div>
                                    <div style="float: right; width: 33%; text-align: center"><strong>&nbsp;</strong></div>
                                </div>
                                <?php
                            }
                                $totalDistance += $event->getStageDistance();
                                $stageCount++;
                                $stage++;
                    }
                    ?>
                    <div style="width: 98%; overflow:auto; padding: 5px 0px">
                        <div style="float: left; width: 33%; text-align: center;">&nbsp;</div>
                        <div style="float: left; display: block; width: 34%; text-align: center">&nbsp;</div>
                        <div style="float: right; width: 33%; text-align: center"><strong><?php echo $totalDistance."KM"; ?></strong></div>
                    </div>
                    <?php
                    $stage = 1;
                    $totalDistance = 0;
                }
            ?>
            <div style="clear:both;"></div>
        </div>
    </div>
    
    <?php include 'include/footer.php'?>
    
</body>
</html>
