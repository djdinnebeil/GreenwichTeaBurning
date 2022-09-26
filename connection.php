<?php
    $host = "sql212.epizy.com";
    $user = "epiz_32537539";
    $password = "GL7kIy9Rf92brk";
    $db = "epiz_32537539_Activity";
    $mysql = @new mysqli($host, $user, $password);
    $connected = False;

    if (!$mysql)
    {
        echo "Connection failed - check if MySQL is running" ;
    }
    elseif (!is_null(mysqli_connect_error()))
    {
        echo "Connection error - check username={$user} and password={$password} ";
    }
    elseif (!mysqli_select_db($mysql, $db))
    {
        $sql = "CREATE DATABASE IF NOT EXISTS {$db};";

        if (!mysqli_query($mysql, $sql))
        {
            echo "Database creation failed ";
        }
        else
        {
            mysqli_select_db($mysql, $db);
            $sql = "CREATE TABLE Visitors (
                     id int(11) NOT NULL,
                     ip_address varchar(50) NOT NULL,
                     arrival_time datetime NOT NULL,
                     quiz_score varchar(1) NOT NULL,
                     user_name varchar(50) NOT NULL,
                     user_activity varchar(1000) NOT NULL,
                     PRIMARY KEY (id)
                    );";
            if (!mysqli_query($mysql, $sql))
            {
                echo "Table creation failed ";

            }
            else
            {
                $mysqltime = date ('Y-m-d H:i:s', time());
                $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES (-6, '::1', '{$mysqltime}', '5', 'DJ', 'Index|Quiz|Results|Scoreboard');";
                if (!mysqli_query($mysql, $sql))
                {
                    echo "Initial record creation failed ";
                }

                for ($i = -5; $i < 0; $i++)
                {
                    $name = $i * -1;
                    $score = $name % 5;
                    $mysqltime = date ('Y-m-d H:i:s', time());

                    $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES ({$i}, '::1', '{$mysqltime}', '{$score}', 'User{$name}', 'Index|Quiz|Results|Scoreboard');";
                    if (!mysqli_query($mysql, $sql))
                    {
                        echo "Initial record creation failed ";
                        break;
                    }
                }
                $mysqltime = date ('Y-m-d H:i:s', time());
                $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES (0, '0', '{$mysqltime}', '5', 'Jose', 'Index|Quiz|Results|Scoreboard');";
                if (!mysqli_query($mysql, $sql))
                {
                    echo "Initial record creation failed ";
                }

            }


            $connected = True;


        }
    }
    else
    {
        $connected = True;
    }


?>