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

if (isset($_GET["carnumberleft"])) {
    $_SESSION["carnumberleft"] = setNumberToNumber($_GET["carnumberleft"]);
} 
else 
{
    $_SESSION["carnumberleft"] = 1;
}

if (isset($_GET["carnumberright"])) {
    $_SESSION["carnumberright"] = setNumberToNumber($_GET["carnumberright"]);
} 
else 
{
    $_SESSION["carnumberright"] = 1;
}

require_once('connection.php');
require_once('event.php');
require_once('event_individual.php');
require_once('entrant.php');

$eventDAO = new EventImpl();
$entrantDAO = new EntrantImpl();
$event_IndividualDAO = new Event_IndividualImpl();

$event = $eventDAO->getEventInformation($_SESSION["eventid"], 1, "Main Field");

$eventIndividualInformation = $event_IndividualDAO->getEventIndividualInformation($_SESSION["eventid"]);
$eventIndividualInformationJson = $eventIndividualInformation->getJson();
$jsonEventIndividualInformationObj = json_decode($eventIndividualInformationJson);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <title>Driver Information</title>
</head>

<body>
    <?php include 'include/header.php'?>
    
    <div id="id_eventDetails" class="c_backgroundColorWhite">
        <span class="c_eventLocation"><?php echo "Driver Information" ;?></span><br />
        <span class="c_eventLocation"><?php echo $jsonEventIndividualInformationObj->{'name'} ;?></span><br />
        <span class="c_info"><?php echo date("d-m-Y", strtotime($jsonEventIndividualInformationObj->{'startdate'}))." to ".date("d-m-Y", strtotime($jsonEventIndividualInformationObj->{'finishdate'})) ;?></span><br />
        <span class="c_info"><?php echo "Surface: ".$jsonEventIndividualInformationObj->{'surface'}." - No.Stages: ".$event->getNoOfStages()." - Total Distance: ".$event->getTotalStageKm()."km" ?></span><br />
    </div>
    
    <?php include 'include/eventmenu.php'?>
    
    <div id="bodyMain">
        <div id="wrapper">
            <form action="<?php echo "entrantinfo.php?eventid=".$_SESSION["eventid"]."&carnumberleft=".$_SESSION["carnumberleft"]."&carnumberright=".$_SESSION["carnumberright"];?>" method="get">
                <div>                 
                    <input type="submit" value="Compare" style="display: block; margin: 4px auto;">
                </div>
                <div>
                    <div id="bodyLeft" style="padding-bottom: 8px;" >
                        <div style="float: right;">
                            <INPUT TYPE = "Text" VALUE ="<?php echo setNumberToLetter($_SESSION["carnumberleft"]); ?>" NAME = "carnumberleft" size="5" style=" text-align: right;">
                        </div>
                        </div>
                    <div id="bodyRight" style="padding-bottom: 8px">
                        <INPUT TYPE = "Text" VALUE ="<?php echo setNumberToLetter($_SESSION["carnumberright"]); ?>" NAME = "carnumberright" size="5">
                    </div>
                </div>
            </form>
            <div id="bodyLeft">
                <?php
                    $entrantsClassAndCategoryLeft = $entrantDAO->getEntrantsClassAndCategory($_SESSION["eventid"], $_SESSION["carnumberleft"]);
                ?>
                <div style="width: 100%; height: 33px; background-color: #EDF5F7; margin-bottom: 5px;">
                    <div style="width: 5%; float: left;  padding-left: 3px; padding-bottom: 5px; line-height: 30px; font-weight: bold"><?php echo "#".$entrantsClassAndCategoryLeft->getNumber(); ?></div>
                    <div style="width: 43%; float: left; line-height: 30px; font-weight: bold"><?php echo $entrantsClassAndCategoryLeft->getDriver(). " - ".$entrantsClassAndCategoryLeft->getCoDriver(); ?></div>
                    <div style="width: 23%; float: left; text-align: center; display: block; line-height: 30px; font-weight: bold; white-space: nowrap;"><?php echo $entrantsClassAndCategoryLeft->getCar(); ?></div>
                    <div style="width: 7%; float: left;"><img src="<?php echo 'logos/'.strstr($entrantsClassAndCategoryLeft->getCar(), ' ', true).'.png'; ?>" alt='&nbsp' width="28" height="32"></div>
                    <div style="width: 12%; float: left; line-height: 30px; font-weight: bold"><?php echo $entrantsClassAndCategoryLeft->getCategory();; ?></div>
                    <div style="width: 6%; float: right; line-height: 30px; font-weight: bold"><?php echo $entrantsClassAndCategoryLeft->getClassEntered();; ?></div>                  
                </div>
                <div style="overflow: auto; background-color: #EDF5F7; padding: 4px 0px">
                    <div style="width: 9%; float: left;  padding-left: 3px">Stage</div>
                    <div style="width: 20%; float: left">Stage Name</div>
                    <div style="width: 15%; float: left; display: block; text-align: right; margin-right: 1%; font-weight: bold">
                        <div>Stage</div>
                        <div>Penalty</div>
                    </div>
                    <div style="width: 13%; float: left; text-align: center">Class<br />Position</div>
                    <div style="width: 6%; float: left"><?php echo '&nbsp'; ?></div>
                    <div style="width: 15%; float: left; text-align: right; font-weight: bold">Total</div>
                    <div style="width: 13%; float: left; text-align: center">Overall Position</div>
                    <div style="width: 7%; float: right; text-align: center"><?php echo '&nbsp'; ?></div>
                </div>
                <?php
                $prevousOAPosition = 0;
                $prevousClassPosition = 0;
                $stage = 1;
                $stageCount = 1 + $event->getStageOffset();
                while($stageCount <= ($event->getNoOfStages() +  $event->getStageOffset()))
                {
                    ?>
                    <div style="overflow: auto; padding: 4px 0px">
                        <?php 
                            $event = $eventDAO->getEventInformation($_SESSION["eventid"], $stage, $entrantsClassAndCategoryLeft->getCategory()); 
                            $entrant = $entrantDAO->getEntrantInformationById($_SESSION["eventid"], $_SESSION["carnumberleft"], $stage);
                            if($stage > 1)
                            {
                                $prevousOAPosition = $oaPosition->getPosition();
                                $prevousClassPosition = $classPosition->getPosition();
                            }
                            $oaPosition = $entrantDAO->getPostionOverAllByCarNumber($_SESSION["eventid"], $stage, $_SESSION["carnumberleft"], $entrantsClassAndCategoryLeft->getCategory());
                            $classPosition = $entrantDAO->getPostionClassByCarNumber($_SESSION["eventid"], $stage, $_SESSION["carnumberleft"], $entrantsClassAndCategoryLeft->getClassEntered());
                        ?>
                        <div style="width: 9%; float: left;  padding-left: 3px"><?php if($entrant->getStageTime() !== null){ echo $stage; } else { echo '&nbsp'; } ?></div>
                        <div style="width: 20%; float: left"><?php echo $event->getStageName(); ?></div>
                        <div style="width: 15%; float: left; display: block; text-align: right; font-weight: bold; margin-right: 1%">
                            <div style="font-weight: bold"><?php if($entrant->getStageTime() !== null) { echo convertToHMSs($entrant->getStageTime()); } else { echo '&nbsp';}?></div>
                            <div style="color: red; font-weight: bold"><?php 
                            if($entrant->getStageTime() !== null) 
                            {
                                if (penaltyTotal($stage, $entrant->getPenaltyTotal()) != 0) 
                                { 
                                    echo convertToHMSs(penaltyTotal($stage, $entrant->getPenaltyTotal())); 
                                } 
                                else 
                                { 
                                    echo '&nbsp';
                                }
                            } 
                            else 
                            {
                                echo '&nbsp';
                            }?>
                            </div>
                        </div>
                        <div style="width: 13%; float: left; text-align: center"><?php echo $classPosition->getPosition(); ?></div>
                        <div style="width: 6%; float: left"><img style="display: block; margin-left: auto; margin-right: auto;" src="
                        <?php  
                        if($entrant->getStageTime() !== null)
                        {
                            if ($stage > 1) 
                            {
                                if ($prevousClassPosition == $classPosition->getPosition()) 
                                {
                                    echo 'icons/Equals.png';
                                } 
                                else if ($prevousClassPosition < $classPosition->getPosition())
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
                        }
                        
                        ?>
                        " alt="&nbsp" width="20" height="20">
                            
                        </div>
                        <div style="width: 15%; float: left; text-align: right; font-weight: bold"><?php 
                        if($entrant->getStageTime() !== null)
                        {
                            echo convertToHMSs($entrant->getTotal());
                        }
                        else 
                        {
                            echo '&nbsp';
                        }?>
                        </div>
                        <div style="width: 13%; float: left; text-align: center"><?php echo $oaPosition->getPosition() ; ?></div>
                        <div style="width: 7%; float: right"><img style="display: block; margin-left: auto; margin-right: auto;" src="
                        <?php  
                        if($entrant->getStageTime() !== null)
                        {
                            if ($stage > 1) 
                            {
                                if ($prevousOAPosition == $oaPosition->getPosition()) 
                                {
                                    echo 'icons/Equals.png';
                                } 
                                else if ($prevousOAPosition < $oaPosition->getPosition())
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
                        }
                        ?>
                        " alt="&nbsp" width="20" height="20">                            
                        </div>
                    </div>
                    <?php
                    $stage++;
                    $stageCount++;
                }
                ?>
            </div>
            <div id="bodyRight">
                <?php
                    $entrantsClassAndCategoryRight = $entrantDAO->getEntrantsClassAndCategory($_SESSION["eventid"], $_SESSION["carnumberright"]);
                ?>
                <div style="width: 100%; height: 33px; background-color: #EDF5F7; margin-bottom: 5px;">
                    <div style="width: 5%; float: left;  padding-left: 3px; padding-bottom: 5px; line-height: 30px; font-weight: bold"><?php echo "#".$entrantsClassAndCategoryRight->getNumber(); ?></div>
                    <div style="width: 43%; float: left; line-height: 30px; font-weight: bold"><?php echo $entrantsClassAndCategoryRight->getDriver(). " - ".$entrantsClassAndCategoryRight->getCoDriver(); ?></div>
                    <div style="width: 23%; float: left; text-align: center; display: block; line-height: 30px; font-weight: bold; white-space: nowrap;"><?php echo $entrantsClassAndCategoryRight->getCar(); ?></div>
                    <div style="width: 7%; float: left;"><img src="<?php echo 'logos/'.strstr($entrantsClassAndCategoryRight->getCar(), ' ', true).'.png'; ?>" alt='&nbsp' width="28" height="32"></div>
                    <div style="width: 12%; float: left; line-height: 30px; font-weight: bold"><?php echo $entrantsClassAndCategoryRight->getCategory();; ?></div>
                    <div style="width: 6%; float: right; line-height: 30px; font-weight: bold"><?php echo $entrantsClassAndCategoryRight->getClassEntered();; ?></div>                  
                </div>
                <div style="overflow: auto; background-color: #EDF5F7; padding: 4px 0px">
                    <div style="width: 9%; float: left;  padding-left: 3px">Stage</div>
                    <div style="width: 20%; float: left">Stage Name</div>
                    <div style="width: 15%; float: left; display: block; text-align: right; margin-right: 1%; font-weight: bold">
                        <div>Stage</div>
                        <div>Penalty</div>
                    </div>
                    <div style="width: 13%; float: left; text-align: center">Class<br />Position</div>
                    <div style="width: 6%; float: left"><?php echo '&nbsp'; ?></div>
                    <div style="width: 15%; float: left; text-align: right; font-weight: bold">Total</div>
                    <div style="width: 13%; float: left; text-align: center">Overall Position</div>
                    <div style="width: 7%; float: right; text-align: center"><?php echo '&nbsp'; ?></div>
                </div>
                <?php
                $prevousOAPosition = 0;
                $prevousClassPosition = 0;
                $stage = 1;
                $stageCount = 1 + $event->getStageOffset();
                
                while($stageCount <= ($event->getNoOfStages() +  $event->getStageOffset()))
                {
                    ?>
                    <div style="overflow: auto; padding: 4px 0px">
                        <?php 
                            $event = $eventDAO->getEventInformation($_SESSION["eventid"], $stage, $entrantsClassAndCategoryRight->getCategory()); 
                            $entrant = $entrantDAO->getEntrantInformationById($_SESSION["eventid"], $_SESSION["carnumberright"], $stage);
                            if($stage > 1)
                            {
                                $prevousOAPosition = $oaPosition->getPosition();
                                $prevousClassPosition = $classPosition->getPosition();
                            }
                            $oaPosition = $entrantDAO->getPostionOverAllByCarNumber($_SESSION["eventid"], $stage, $_SESSION["carnumberright"], $entrantsClassAndCategoryRight->getCategory());
                            $classPosition = $entrantDAO->getPostionClassByCarNumber($_SESSION["eventid"], $stage, $_SESSION["carnumberright"], $entrantsClassAndCategoryRight->getClassEntered());
                        ?>
                        <div style="width: 9%; float: left;  padding-left: 3px"><?php if($entrant->getStageTime() !== null){ echo $stage; } else { echo '&nbsp'; } ?></div>
                        <div style="width: 20%; float: left"><?php echo $event->getStageName(); ?></div>
                        <div style="width: 15%; float: left; display: block; text-align: right; font-weight: bold; margin-right: 1%">
                            <div style="font-weight: bold"><?php if($entrant->getStageTime() !== null) { echo convertToHMSs($entrant->getStageTime()); } else { echo '&nbsp';}?></div>
                            <div style="color: red; font-weight: bold"><?php 
                            if($entrant->getStageTime() !== null) 
                            {
                                if (penaltyTotal($stage, $entrant->getPenaltyTotal()) != 0) 
                                { 
                                    echo convertToHMSs(penaltyTotal($stage, $entrant->getPenaltyTotal())); 
                                } 
                                else 
                                { 
                                    echo '&nbsp';
                                }
                            } 
                            else 
                            {
                                echo '&nbsp';
                            }?>
                            </div>
                        </div>
                        <div style="width: 13%; float: left; text-align: center"><?php echo $classPosition->getPosition(); ?></div>
                        <div style="width: 6%; float: left"><img style="display: block; margin-left: auto; margin-right: auto;" src="
                        <?php  
                        if($entrant->getStageTime() !== null)
                        {
                            if ($stage > 1) 
                            {
                                if ($prevousClassPosition == $classPosition->getPosition()) 
                                {
                                    echo 'icons/Equals.png';
                                } 
                                else if ($prevousClassPosition < $classPosition->getPosition())
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
                        }
                        
                        ?>
                        " alt="&nbsp" width="20" height="20">
                            
                        </div>
                        <div style="width: 15%; float: left; text-align: right; font-weight: bold"><?php 
                        if($entrant->getStageTime() !== null)
                        {
                            echo convertToHMSs($entrant->getTotal());
                        }
                        else 
                        {
                            echo '&nbsp';
                        }?>
                        </div>
                        <div style="width: 13%; float: left; text-align: center"><?php echo $oaPosition->getPosition() ; ?></div>
                        <div style="width: 7%; float: right"><img style="display: block; margin-left: auto; margin-right: auto;" src="
                        <?php  
                        if($entrant->getStageTime() !== null)
                        {
                            if ($stage > 1) 
                            {
                                if ($prevousOAPosition == $oaPosition->getPosition()) 
                                {
                                    echo 'icons/Equals.png';
                                } 
                                else if ($prevousOAPosition < $oaPosition->getPosition())
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
                        }
                        
                        ?>
                        " alt="&nbsp" width="20" height="20">                            
                        </div>
                    </div>
                    <?php
                    $stage++;
                    $stageCount++;
                }
                ?>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>        
    
    <?php include 'include/footer.php'?>
    
</body>
</html>