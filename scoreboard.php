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
    $_SESSION['user_activity'] = '';
    include('connection.php');

    if ($connected)
    {

        $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES ({$counter}, '{$ip_address}', '{$mysqltime}', '', 'User{$counter}', 'Scoreboard');";
        if (!mysqli_query($mysql, $sql))
        {
            echo "New record creation failed";
        }
        mysqli_close($mysql);
    }
}

    include('connection.php');
    $_SESSION['user_activity'] = "{$_SESSION['user_activity']}|Scoreboard";

    if ($connected)
    {
        include('connection.php');
        $sql = "UPDATE Visitors SET user_activity='{$_SESSION['user_activity']}' WHERE id={$_SESSION['id']};";
        if (!mysqli_query($mysql, $sql))
        {
            echo "Update failed";
        }


        $unfiltered_name = $_GET['name'];
        $name = "";

        for ($i = 0; $i <mb_strlen($unfiltered_name); $i++)
        {
            if (ctype_alnum($unfiltered_name[$i]) or $unfiltered_name[$i] == ' ')
            {
                $name = "{$name}{$unfiltered_name[$i]}";
            }
        }


        $sql = "UPDATE Visitors SET user_name='{$name}' WHERE id={$_SESSION['id']};";
        if (!mysqli_query($mysql, $sql))
        {
            echo "Update failed";
        }

        $sql = "SELECT * FROM VISITORS;";
        $result = mysqli_query($mysql, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            echo "<table><tr><th style='width: 50px;'>Name</th>";
            echo "<th style='width: 80px;'>Quiz Score</th></tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                if (($row['quiz_score'] or $row['quiz_score'] == '0') and ($row['user_name'] != 'admin'))
                {
                    echo "<tr><td style='text-align: center;'>{$row['user_name']}</td><td style='text-align: center;'>{$row['quiz_score']}</td></tr>";
                }
            }
             echo "</table>";
        }
        mysqli_close($mysql);
    }



?>
<br>
<a href="index.php">Home</a>
