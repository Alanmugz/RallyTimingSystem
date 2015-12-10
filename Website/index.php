<?php
// Start the session
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <title>Home</title>
</head>

<body>
    <?php include 'include/header.php'?>
    
    <div id="id_results" class="c_backgroundColorWhite">
        <a href ="results.php?getcat=Main Field&eventid=<?php echo "1"; ?>">Westlodge Hotel Fastnet Rally 2015</a><br />
        <a href ="results.php?getcat=Main Field&eventid=<?php echo "2"; ?>">Kerry Mini Stages 2015</a><br />
        <a href ="results.php?getcat=Historics&eventid=<?php echo "3"; ?>">Killarney Historics Stage Rally 2015</a><br />
    </div>
    
    <?php include 'include/footer.php'?>
</body>
</html>
