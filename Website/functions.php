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
?>
