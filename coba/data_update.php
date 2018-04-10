<?php
    include_once('db.php');
    if(isSet($_POST['current_count']))
    {
        $current_count = $_POST['current_count'] + 1;
        if($_POST['current_count']=='0' || $_POST['current_count']=='')
        {
            mysqli_query($con,"insert into user(count) values('".$current_count."')");
        }
        else
        {
            mysqli_query($con,"update user set count='".$current_count."'");
        }
        echo $current_count;
    }
    else if(isSet($_POST['reset_count']))
    {
        $reset_count = 0;
        mysqli_query($con,"update user set count='".$reset_count."'");
        echo $reset_count;

    }
    else
    {
        echo '0';
    }
?>