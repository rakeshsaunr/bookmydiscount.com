<?php
session_start();
include('database.inc.php');

if (!isset($_SESSION['UID'])) {
    header('location:index.php');
    die();
}

$current_time = time();
$idle_time_threshold = 60; // Adjust this threshold as needed (in seconds)

$res = mysqli_query($con, "SELECT * FROM user WHERE last_activity > FROM_UNIXTIME($current_time - $idle_time_threshold)");

$i = 1;
$html = '';
while ($row = mysqli_fetch_assoc($res)) {
    $status = 'Offline';
    $class = "btn-danger";

    $last_activity = strtotime($row['last_activity']);
    $idle_time = $current_time - $last_activity;

    if ($idle_time < $idle_time_threshold) {
        $status = 'Online';
        $class = 'btn-success';
    }

    $last_seen = ($status === 'Online') ? date('H:i:s', $last_activity) : date('H:i:s', $last_activity);

    $html .= '<tr>
                <th scope="row">' . $i . '</th>
                <td>' . $row['name'] . '</td>
                <td><button type="button" class="btn ' . $class . '">' . $status . '</button></td>
                <td>' . $last_seen . '</td>
              </tr>';
    $i++;
}
echo $html;
?>
