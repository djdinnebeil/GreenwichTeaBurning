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
    $_SESSION['user_activity'] = '1775';
    include('connection.php');

    if ($connected)
    {

        $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES ({$counter}, '{$ip_address}', '{$mysqltime}', '', '', '1775');";
        if (!mysqli_query($mysql, $sql))
        {
            echo "New record creation failed";
        }
        mysqli_close($mysql);
    }
}
else
{
    $_SESSION['user_activity'] = "{$_SESSION['user_activity']}|1775";
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
<body>
    <div id="display-article">
        <img src="pdfs/1775_article_header.jpg" alt="The top portion of a 1775 newspaper article">
        <img src="pdfs/1775_article_text.jpg" alt="A 1775 newspaper article about the tea burning">
        <a href="index.php">Home</a>
    </div>
</body>
</html>