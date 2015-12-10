<?php

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
$entrantDAO = new EntrantImpl();
$event_IndividualDAO = new Event_IndividualImpl();

$event = $eventDAO->getEventInformation($_SESSION["eventid"], 1, "Main Field");
$categoriesDB = $eventDAO->getCategories($_SESSION["eventid"], "Main Field");
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
    <title>Entry List</title>
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
                            <div style="width: 98%; text-align: center; margin: 5px 0px 5px 0px; display: inline-block; "><h3><?php echo $category->name; ?></h3></div>
                            <div style="width: 98%; background-color: #EDF5F7; overflow: auto; padding: 5px">
                                <div style="width: 10%; float: left; padding-left: 1%">Number</div>
                                <div style="width: 24.5%; float: left;">Driver</div>
                                <div style="width: 24.5%; float: left; display: block">Co Driver</div>
                                <div style="width: 30%; float: left;">Car</div>
                                <div style="width: 10%; float: right;">Class</div>
                            </div>
                        <?php
                    }
                    $entryList = $entrantDAO->getEntryList($_SESSION["eventid"], $category->name);
                    foreach ($entryList as $entrant) {
                        ?>
                            <div style="width: 98%; padding: 5px">
                                <div style="width: 10%; float: left;padding-left: 1%"><?php echo $entrant->getNumber() ; ?></div>
                                <div style="width: 24.5%; float: left;"><?php echo $entrant->getDriver() ; ?></div>
                                <div style="width: 24.5%; float: left; display: block"><?php echo $entrant->getCoDriver() ; ?></div>
                                <div style="width: 30%; float: left;"><?php echo $entrant->getCar() ; ?></div>
                                <div style="width: 10%; float: right;"><?php echo $entrant->getClass() ; ?></div>
                            </div>
                        <?php
                    }
                }
            ?>
            <div style="clear:both;"></div>
        </div>
    </div>
    
    <?php include 'include/footer.php'?>
    
</body>
</html>
