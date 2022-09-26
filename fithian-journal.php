<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Greenwich Tea Burning</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<h3>Sunday, December 18th</h3>
<p style="width: 400px; margin: 20px;">
Early last week a Quantity of Tea said to be shipped at Rotterdam was brought & privately stored at Dan Bowens in Greenwich
    - A pro Tempore Committee was Chosen to secure it till the County Committee be duly elected.
</p>
<h3>Fryday, December 23</h3>
<p style="width: 400px; margin: 20px;">
    Last night the Tea was, by a number of persons in disguise, taken out of the House & consumed with fire.
    Violent, & different are words about this uncommon Manoeuvre among the inhabitants - Some rave, some curse &
    condemn, some try to reason; many are glad the Tea is destroyed, but almost all disapprove the Manner of the destruction.
</p>
<a href="index.php">Home</a>
</body>
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
    $_SESSION['user_activity'] = '1774';
    include('connection.php');

    if ($connected)
    {

        $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES ({$counter}, '{$ip_address}', '{$mysqltime}', '', '', '1774');";
        if (!mysqli_query($mysql, $sql))
        {
            echo "New record creation failed";
        }
        mysqli_close($mysql);
    }
}
else
{
    $_SESSION['user_activity'] = "{$_SESSION['user_activity']}|1774";
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
</html>