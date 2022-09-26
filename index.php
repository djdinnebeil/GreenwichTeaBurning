<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Greenwich Tea Burning</title>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="styles/styles.css">
</head>
<?php

session_start();



if (!isset($_SESSION['id']))
{
    $counter_file = fopen("counter.txt", "r");
    $counter = intval(fgets($counter_file));
    fclose($counter_file);
    $counter_file = fopen("counter.txt", "w");
    fwrite($counter_file, $counter + 1);
    fclose($counter_file);
    $_SESSION['id'] = $counter;
    $mysqltime = date ('Y-m-d H:i:s', time());
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_activity'] = 'Index';
    include('connection.php');

    if ($connected)
    {

        $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES ({$counter}, '{$ip_address}', '{$mysqltime}', '', '', 'Index');";
        if (!mysqli_query($mysql, $sql))
        {
            echo "New record creation failed";
        }
        mysqli_close($mysql);
    }
}
else
{
    $_SESSION['user_activity'] = "{$_SESSION['user_activity']}|Index";
    include('connection.php');

    if ($connected)
    {
        $sql = "UPDATE Visitors SET user_activity='{$_SESSION['user_activity']}' WHERE id={$_SESSION['id']};";
        if (!mysqli_query($mysql, $sql))
        {
            echo "Update failed";
        }
        mysqli_close($mysql);

    }
}


?>
<body>
    <div id="container">
        <h2>The Greenwich Tea Burning</h2>
        <img id="start-image" src="images/Indian_photo.jpg" alt="A depiction of the tea burning">
        <div id="welcome-message">
            <br>
            The Greenwich Tea Burning was a tea party that took place in December 1774 at Greenwich, NJ.
                Instead of dumping the tea into water, the participants burnt the tea.

            <br><br>
                Learn more about the Greenwich Tea Burning by reading newspaper articles,
                excerpts from journals, and other textual sources. After studying, test
                your knowledge by taking a quiz.
            <br><br>

        </div>
        <h4>Explore more by clicking the links below</h4>
        <div id="links">
            <div id="read-fithian-journal">
                <a href="fithian-journal.php">Philip Vickers Fithian Journal (1774)</a>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div id="read-1775">
                <a href="display.php">Pennsylvania Dunlap Packet (1775)</a>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div id="read-sojourn">
                <a href="remembering.php">Remembering the Greenwich Tea Party (2022)</a>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div id="quiz">
                <a href="quiz.php">Take the Quiz!</a>
            </div>
        </div>
        <div style="cursor: pointer; width: 300px; text-align: center; color: blue;"
                  onmouseover='this.style.backgroundColor="blue"; this.style.color="white";'
                  onmouseout='this.style.backgroundColor="white"; this.style.color="blue";'
                  id="get-name">
                  Admin Login<br>
                  Enter 'admin' for access
        </div>
    </div>
</body>
<script>
    let get_name_element = document.getElementById("get-name");
    function get_name()
    {
        let user_name = window.prompt("Please enter admin credentials: ");
        if (user_name === "admin")
        {
            window.location.href = "visitors.php";
        }
    }
    get_name_element.onclick = get_name;
</script>
</html>