<?php
include_once ('config.php');

function connectlocal()
{
    $con = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_PORT);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    return $con;
}

function select_query($sql)
{
    $result = mysqli_query(connectlocal(), $sql);
    $rows = []; // initialize
    while ($r = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        $rows[] = $r;
    }
    return $rows;
}

// inserts or updates go through here
function query($sql)
{
    $con = connectlocal();

    if ( mysqli_query($con, $sql) ) { // check success of server 1
        $insertid = mysqli_insert_id($con);
        if (isset($insertid)) {
            return $insertid;
        } else {
            // id not found
            return false;
        }
    } else {
        // query failure
        return false;
    }

}