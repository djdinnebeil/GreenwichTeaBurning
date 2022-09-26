<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Greenwich Tea Burning</title>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
<h3>The Greenwich Tea Burning Quiz</h3>
<form method="post" action="results.php">
    <p>1. The Greenwich Tea Party occurred on<br>
        <label>
            <input type="radio" name="1" value="November 22, 1774">
            November 22, 1774
        </label><br>
        <label>
            <input type="radio" name="1" value="November 23, 1774">
            November 23, 1774
        </label><br>
        <label>
            <input type="radio" name="1" value="">
            December 22, 1774
        </label><br>
        <label>
            <input type="radio" name="1" value="December 23, 1774">
            December 23, 1774
        </label><br>
    </p>

    <p>2. How was the tea destroyed?<br>
        <label>
            <input type="radio" name="2" value="By dumping it into the water">
            By dumping it into the water
        </label><br>
        <label>
            <input type="radio" name="2" value="">
            By burning it
        </label><br>
        <label>
            <input type="radio" name="2" value="By both dumping it into the water and burning it">
            By both dumping it into the water and burning it
        </label><br>
        <label>
            <input type="radio" name="2" value="The tea was not destroyed">
            The tea was not destroyed
        </label><br>
    </p>
    <p>3. What disguises did the participants use?<br>
        <label>
            <input type="radio" name="3" value="Mohawk Indians">
            Mohawk Indians
        </label><br>
        <label>
            <input type="radio" name="3" value="Narragansett Indians">
            Narragansett Indians
        </label><br>
        <label>
            <input type="radio" name="3" value="Both Mohawk Indians and Narragansett Indians">
            Both Mohawk Indians and Narragansett Indians
        </label><br>
        <label>
            <input type="radio" name="3" value="">
            Cannot know for certain
        </label><br>
    </p>
    <p>4. Where was the tea stored before it was destroyed?<br>
        <label>
            <input type="radio" name="4" value="Dan Bowen's">
            At Dan Bowen's
        </label><br>
        <label>
            <input type="radio" name="4" value="David Sutton's">
            At David Sutton's
        </label><br>
        <label>
            <input type="radio" name="4" value="At both Dan Bowen's and David Sutton's">
            At both Dan Bowen's and David Sutton's
        </label><br>
        <label>
            <input type="radio" name="4" value="">
            There are conflicting accounts
        </label><br>
    </p>
    <p>5. What century was the Greenwich Tea Burning Monument erected?<br>
        <label>
            <input type="radio" name="5" value="18th">
            18th
        </label><br>
        <label>
            <input type="radio" name="5" value="19th">
            19th
        </label><br>
        <label>
            <input type="radio" name="5" value="">
            20th
        </label><br>
        <label>
            <input type="radio" name="5" value="21st">
            21st
        </label><br>
    </p>
    <br>
    <input type="submit" value="Submit">
</form>
<br>
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
    $_SESSION['user_activity'] = 'Quiz';
    include('connection.php');

    if ($connected)
    {

        $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES ({$counter}, '{$ip_address}', '{$mysqltime}', '', '', 'Quiz');";
        if (!mysqli_query($mysql, $sql))
        {
            echo "New record creation failed";
        }
        mysqli_close($mysql);
    }
}
else
{
    include('connection.php');
    $_SESSION['user_activity'] = "{$_SESSION['user_activity']}|Quiz";
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