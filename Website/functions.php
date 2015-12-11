<?php
    function convertToHMSs($inSeconds)
    {
        $secs = floor($inSeconds);
        $milli = (float) round(($inSeconds - $secs) * 1000);

        $hours = floor($secs / 3600);
        $minutes = floor(($secs / 60) % 60);
        $seconds = $secs % 60;

        $string = "$milli";
        $milli = $string[0];

            if($minutes < 10)
            {
                    $minutes = "0".$minutes;
            }

            if($seconds < 10)
            {
                    $seconds = "0".$seconds;
            }

            if($hours >= 1)
            {
                    $stageTime = "$hours:$minutes:$seconds.$milli";
            }
            else
            {
                    $stageTime = "$minutes:$seconds.$milli";
            }

         return $stageTime;
    }

    function convertTodiff($init)
    {
        $secs = floor($init);
        $milli = (float) round(($init - $secs) * 1000);

        $hours = floor($secs / 3600);
        $minutes = (($secs / 60) % 60);
        $seconds = $secs % 60;

        $string = "$milli";
        $milli = $string[0];

            if($minutes < 10)
            {
                    $minutes = "0".$minutes;
            }

            if($seconds < 10)
            {
                    $seconds = "0".$seconds;
            }


        if($init < 60)
        {
              $stageTime = "$seconds.$milli";
        }
        else
        {
            $stageTime = "$minutes:$seconds.$milli";
        }
              
        if($hours >= 1)
        {
            $stageTime = "$hours:$minutes:$seconds.$milli";
        }

        return $stageTime;
    }

    function penaltyTotal($numberOfStages, $info)
    {
        $x = str_replace('{', "", $info);
        $y = str_replace('}', "", $x);
        $lines = explode(PHP_EOL, $y);

        foreach ($lines as $line) {
            $array[] = str_getcsv($line);
        }
        $total = 0;
        $i = 0;
        while($i <= ($numberOfStages * 2))
        {
            if($i % 2 ==  1)
            {
                $total += $array[0][$i];
            }
            $i++;
        }
        return $total;
    }

    function getPositionPreviousStage($array, $carNumber)
    {
        $neededObjects = array_filter(
        $array,
            function ($e) use ($carNumber) {
                return $e->getNumber() == $carNumber;
            }
        );
        foreach ($neededObjects as $x) {
            return $x->getPosition();
        }
    }
    
    function setNumberToLetter($carNumber){
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
        return $carNumber;
    }
    
    function setNumberToNumber($carNumber){
        if (substr( $carNumber, 0, 1 ) === 'J') {
            if (strlen($carNumber) == 2) {
                $carNumber = str_replace("J", "30", $carNumber);
            }
            if (strlen($carNumber) == 3) {
                $carNumber = str_replace("J", "3", $carNumber);
            }
        }

        if (substr( $carNumber, 0, 1 ) === 'H') {
            if (strlen($carNumber) == 2) {
                $carNumber = str_replace("H", "20", $carNumber);
            }
            if (strlen($carNumber) == 3) {
                $carNumber = str_replace("H", "2", $carNumber);
            }
        }
        return $carNumber;
    }
?>
