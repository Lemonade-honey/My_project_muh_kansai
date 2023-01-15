<?php
    
    // time default
    date_default_timezone_set("Asia/Jakarta");

    // ============== DEFINE DATE AND TIME ============== //

    // Time Local
    $time_local = date("H:i:s");

    // date range timeline, set to 1 week
    $range = date('Y-m-d', strtotime("+6 day", strtotime(date('Y-m-d'))));
    // $time_range = date("H:i:s", strtotime())

    function eventDisplay($time_end, $time_local, $date_event, $date_local){
        if($date_event == $date_local){
            $time_range = 3 * 60; // 3 hour
            if($time_local < date("H:i:s", strtotime($time_end) + $time_range * 60)){
                return true;
            }else{
                return false;
            }
        }
        elseif($date_event > $date_local){
            return true;
        }
        else{
            return false;
        }
    }

    function status($date_event, $start, $end, $time_local, $date_local){
        if($date_event >= $date_local){
            if($date_event == $date_local){
                if($time_local >= $start && $time_local <= $end){
                    echo "<p style= 'color:green'>On Air</p>";
                }elseif($time_local > $end){
                    echo "<p style= 'color:red'>Finish</p>";
                }
            }
        }else{
            echo 'expired';
        }
        
    }

    function eventStart($date_local, $date_event){
        if($date_local < $date_event){
            return false;
        }else{
            return true;
        }
    }

    function splitData($data, $indeks){
        $explode = explode("~|*", $data);
        echo $explode[$indeks];
    }

    // SQL syntax
    // $sql = "SELECT * FROM timeline WHERE tanggal BETWEEN ? AND ? ORDER BY tanggal, start ASC";
    $sql = "SELECT event_name, event_start, time_start, time_end, speaker, description, location, links
    FROM timeline WHERE event_start BETWEEN ? AND ? ORDER BY event_start, time_start ASC";
    if($stmt = mysqli_prepare($conn, $sql)){

        $param_date_now = date('Y-m-d');
        $param_week = $range;

        mysqli_stmt_bind_param($stmt, "ss", $param_date_now, $param_week);

        // data bind result
        mysqli_stmt_bind_result($stmt, $event_name, $event_start, $time_start, $time_end, $speaker, $desc, $location, $links);
        mysqli_stmt_execute($stmt);

        // banyak event
        mysqli_stmt_store_result($stmt);
        $many_event = mysqli_stmt_num_rows($stmt);

    }
    else{
        die("Config Error on timeline");
        exit;
    }

    // ================ RUN ====================== //

    // while(mysqli_stmt_fetch($stmt)){
    //     printf("status : " . $status_time . "<br>");
    //     printf() "id : " . $id. ", ";
    //     printf("tanggal : " . $tanggal . "<br>");
    //     printf( "start : " . $jam_start . "<br>");
    //     printf("end : " . $jam_end . "<br>");
    //     printf("nama : " . $nama. "<br>");
    //     status($tanggal, $jam_start, $jam_end, $time_local, $param_date_now);
    //     echo $jam_start . "+" . $jam_end;
    //     printf("<br><br>");
    // }
    
?>