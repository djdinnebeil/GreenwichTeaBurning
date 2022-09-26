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
        $_SESSION['user_activity'] = 'Visitors';
        include('connection.php');

        if ($connected)
        {

            $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES ({$counter}, '{$ip_address}', '{$mysqltime}', '', '', 'Visitors');";
            if (!mysqli_query($mysql, $sql))
            {
                echo "New record creation failed";
            }
            mysqli_close($mysql);
        }
    }

        $_SESSION['user_activity'] = "{$_SESSION['user_activity']}|Admin";

        include('connection.php');

        if ($connected)
        {
            $sql = "UPDATE Visitors SET user_activity='{$_SESSION['user_activity']}', user_name='admin' WHERE id={$_SESSION['id']};";
            if (!mysqli_query($mysql, $sql))
            {
                echo "Update failed";
            }
            $sql = "SELECT * FROM VISITORS;";
            $result = mysqli_query($mysql, $sql);
	
            if (mysqli_num_rows($result) > 0)
            {
                echo "<table><tr><th style='width: 20px;'>Visitor</th>";
                echo "<th style='width: 160px;'>Arrival Time</th>";
                echo "<th style='width: 120px;'>Quiz Score</th>";
                echo "<th style='width: 120px;'>User Name</th>";
                echo "<th>User Activity</th></tr>";
                while($row = mysqli_fetch_assoc($result))
                {
                    $arrival_time = $row['arrival_time'];
                    $row['quiz_score'] = ($row['quiz_score'] == '') ? "-" : $row['quiz_score'];
                    $row['user_name'] = ($row['user_name'] == '') ? "-" : $row['user_name'];
                    echo "<tr><td style='text-align: center;'>{$row['id']}</td>";
                    echo "<td style='text-align: center;'>{$arrival_time}</td>";
                    echo "<td style='text-align: center;'>{$row['quiz_score']}</td>";
                    echo "<td style='text-align: center;'>{$row['user_name']}";
                    echo "<td>{$row['user_activity']}</td></tr>";
                }
                echo "</table>";
            }
            mysqli_close($mysql);
        }

?>
<br>
<a href="index.php">Home</a>
