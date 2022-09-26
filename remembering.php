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
    $_SESSION['user_activity'] = '2033';
    include('connection.php');

    if ($connected)
    {

        $sql = "INSERT INTO Visitors (id, ip_address, arrival_time, quiz_score, user_name, user_activity) VALUES ({$counter}, '{$ip_address}', '{$mysqltime}', '', '', '2022');";
        if (!mysqli_query($mysql, $sql))
        {
            echo "New record creation failed";
        }
        mysqli_close($mysql);
    }
}
else
{
    $_SESSION['user_activity'] = "{$_SESSION['user_activity']}|2022";
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
<h3 style="margin-left: 30%;">The Greenwich Tea Party: How it has been remembered</h3>
<p>
    The Boston Tea Party was not the only tea party to take place in Revolutionary America.
    According to Joseph Cummins in <em>Ten Tea Parties: Patriotic Protests That History Forgot</em>,
    there were ten tea parties in all. The last of these tea parties took place on December 22, 1774,
    in the small community of Greenwich, Cumberland County, New Jersey, but instead of dumping the tea into water,
    the participants burnt the tea. How the Greenwich Tea Party has been remembered in history is the focus
    of this article.
</p>
<p>
    There are only four primary sources about this event.
    The first record of the tea burning was made by Philip Vickers Fithian
    in an entry in his journal dated December 23. He wrote: “Last night the Tea was,
    by a number of persons in disguise, taken out of the house and consumed with fire.”
    The second record of the event was made in Dunlap’s Pennsylvania Packet; or, the General Advertiser,
    January 9, 1775. The packet described how a committee of local residents was formed to discuss how
    to respond to the arrival of tea in Greenwich, who were later informed of the tea’s destruction.
</p>
<p>
    The third and fourth sources of the tea burning are from a civil case docket and a criminal case docket.
    Grand Jury action was demanded by the tea merchants, and the tea party participants were hauled into court
    on charges of illegal trespass. Civil suits were also brought against them for destruction of property. But
    none of the raiders were ever found guilty of anything. By the time their cases came up, the courts were in
    the hands of judges and prosecutors sympathetic to the American cause, and all charges were eventually dismissed.
</p>
<p>
    These four sources are the direct factual evidence of the event.
    There are also two books on the histories of Salem and Cumberland Counties that describe the tea party,
    but these were written decades later, and both accounts got the date wrong. In all accounts of this event
    published previous to 1874, the date was given as Nov. 22, 1774, instead of Dec. 22 of that year. This is
    because Fithian only wrote the date as “Friday 23” in his journal, which followed several entries dated in
    November, so it was assumed that “Friday 23” referred to November 23, but November 23 was a Wednesday, not
    a Friday. And even as late as the 1970s, the wrong date was still given by some newspapers.
</p>
<p>
    Unlike the date, there are other details of the event that we cannot know for certain.
    For example, we do not know how the tea burners were dressed. What we know from Fithian’s
    journal is that the tea burners were “disguised,” but he does not say how. This detail has
    evolved over the years with some accounts claiming the participants were disguised like Mohawk
    Indians. Another detail that has conflicting accounts is where the tea was stored. In his journal,
    Fithian claims the tea was stored at Dan Bowen’s house. However, in a letter from 1930, Charles Ewing
    describes how his grandfather, Wm. B. Ewing, heard from his father, Thomas Ewing, one of the participants,
    that the tea was stored at David Sutton’s house.
</p>
<p>
    Despite the conflicting accounts, the patriotic pride of Greenwich would see to it that a monument gets
    erected in honor of the tea party participants. On September 30, 1908, over 8,000 people gathered to take
    part in the ceremony of the unveiling of the Greenwich Tea Burning Monument. And this patriotic fervor
    continues to this day with many local residents commemorating the event through plays, celebrations, newspaper
    articles, and even historical tours of the sites.
</p>
<a style="margin-left: 30%;" href="index.php">Home</a>
</body>
</html>