<?php
    require_once "task.php";

    class Day {
        const COUNT_HOURS = 24;

        public static function getDay($date, $flagDayOrWeek) : string {
            list($w, $d, $m, $y) = explode('/', $date);

            $res = "<div>$d.$m.$y";
            $res .= Task::getTaskForDay($w, $d, $m, $y, $flagDayOrWeek);
            $res .= "</div>";
            return $res;
        }
    }

?>