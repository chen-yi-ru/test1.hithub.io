<?php
    require_once 'sql.php';
    
    date_default_timezone_set('Asia/Taipei');
    $current_date = date("Y-m-d");

    function getVehicleStatus($link, $vehicle, $current_date)
    {
        $sql = "SELECT `id`, `datetime`, `returned_datetime` FROM `users` WHERE `car` = '$vehicle';";
        $result = mysqli_query($link, $sql);

        $is_borrowed = false;
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $reservation_date = date("Y-m-d", strtotime($row['datetime']));
                $returned_date = date("Y-m-d", strtotime($row['returned_datetime']));

                if ($current_date >= $reservation_date && $current_date <= $returned_date) {
                    $is_borrowed = true;
                    break;
                }
            }
            mysqli_free_result($result);
        }

        return $is_borrowed;
    }
    ?>