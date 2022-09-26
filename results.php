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
<h3>The Greenwich Tea Burning Quiz Results</h3>
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
    $_SESSION['user_activity'] = 'Results';
    include('connection.php');

    if ($connected)
    {

        $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES ({$counter}, '{$ip_address}', '{$mysqltime}', '', '', 'Results');";
        if (!mysqli_query($mysql, $sql))
        {
            echo "New record creation failed";
        }
        mysqli_close($mysql);
    }
}

    $one = isset($_POST['1']) ? $_POST['1'] : " ";
    $two = isset($_POST['2']) ? $_POST['2'] : " ";
    $three = isset($_POST['3']) ? $_POST['3'] : " ";
    $four= isset($_POST['4']) ? $_POST['4'] : " ";
    $five= isset($_POST['5']) ? $_POST['5'] : " ";

    $answers_array = array($one, $two, $three, $four, $five);
    $n_correct = 0;
    $n_questions = count($answers_array);
    foreach ($answers_array as $incorrect)
    {
        if (!$incorrect)
        {
            $n_correct += 1;
        }
    }
    echo "{$n_correct} out of {$n_questions} correct<br><br>";
?>
<div style="border: 2px solid blue; cursor: pointer; width: 100px;"
          onmouseover='this.style.backgroundColor="blue"; this.style.color="white";'
          onmouseout='this.style.backgroundColor="white"; this.style.color="black";'
          id="get-name">
              Click Here
              <br>
              To Add Name
              <br>
              To Scoreboard
</div>
<br>
<?php
    if (!$answers_array[0])
    {
        echo "<p style='color: green;'>1. Correct.<br>";
    }
    else
    {
       $one = ($one == ' ') ? '' : " - {$one}";

        echo "<p style='color: red;'>1. Incorrect{$one}.<br>";
    }
    echo "<font color='black'>The Greenwich Tea Party occurred on December 22, 1774</font></p>";

    if (!$answers_array[1])
    {
        echo "<p style='color: green;'>2. Correct.<br>";
    }
    else
    {
       $two = ($two == ' ') ? '' : " - {$two}";

        echo "<p style='color: red;'>2. Incorrect{$two}.<br>";
    }
    echo "<font color='black'>The tea was 'consumed with fire.'</font></p>";

    if (!$answers_array[2])
    {
        echo "<p style='color: green;'>3. Correct.<br>";
    }
    else
    {
        $three = ($three == ' ') ? '' : " - {$three};";
        echo "<p style='color: red;'>3. Incorrect{$three}.<br>";
    }
    echo "<font color='black'>Fithian's journal only says 'persons in disguise', but does not say how.</font></p>";

    if (!$answers_array[3])
    {
        echo "<p style='color: green;'>4. Correct.<br>";
    }
    else
    {
       $four = ($four == ' ') ? '' : " - {$four}";

        echo "<p style='color: red;'>4. Incorrect{$four}.<br>";
    }
    echo "<font color='black'>There are conflicting accounts as to where the tea was stored.";
    echo "<br>Fithian's journal states Dan Bowen's whereas a 1930 letter claims David Sutton's.</font></p>";

    if (!$answers_array[4])
    {
        echo "<p style='color: green;'>5. Correct.<br>";
    }
    else
    {
       $five = ($five == ' ') ? '' : " - {$five}";

        echo "<p style='color: red;'>5. Incorrect{$five}.<br>";
    }
    echo "<font color='black'>The Greenwich Tea Burning Monument was unveiled on September 30, 1908.</font></p>";


    if (isset($_SESSION['id']))
    {
        include('connection.php');

    $_SESSION['user_activity'] = "{$_SESSION['user_activity']}|Results";

        if ($connected)
        {
            $sql = "UPDATE Visitors SET quiz_score='{$n_correct}', user_name='User{$_SESSION['id']}', user_activity='{$_SESSION['user_activity']}' WHERE id={$_SESSION['id']};";
            if (!mysqli_query($mysql, $sql))
            {
                echo "Update failed";
            }
            mysqli_close($mysql);
        }

    }

?>
<a href="index.php">Home</a>
</body>
<script>
    let get_name_element = document.getElementById("get-name");
    function get_name()
    {
        let user_name = window.prompt("Please enter your name: ");
        user_name = user_name.trim();
        if (user_name == null || user_name == "")
        {
            user_name = "NoName";
        }
        window.location.href = "scoreboard.php?name=" + user_name;
    }
    get_name_element.onclick = get_name;
</script>
</html>