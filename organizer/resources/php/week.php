<?php 
    require_once "day.php";

    class Week {
        const COUNT_DAYS = 7;
        
        public static function getWeek($week, $flagDayOrWeek) : string {
            $res = '';
            $dates = null;
            
            if($flagDayOrWeek == 'w') {
                $dates = self::convertDatesForWeek($week);
            }else if($flagDayOrWeek == 'd') {
                $dates = self::convertDatesForDay($week);
            }
            
            for($i = 0; $i < self::COUNT_DAYS; $i++) {
                $res .= "<div id=\"grid-item-week\">";
                $res .= Day::getDay($dates[$i], $flagDayOrWeek);
                $res .= "</div>";
            }

            return $res;
        }

        private static function convertDatesForDay($week) : array {
            $res = [];
            list($w, $d, $m, $y) = explode("/", $week);

            $firstDay = $d;
            $lastDay = $d + 6;
            $lastDayOfMonth = date('t', strtotime("$y-$m-$d"));
            if($lastDay > $lastDayOfMonth) {
                $lastDay = $lastDay - $lastDayOfMonth;
            }
            
            if($lastDay > $firstDay) {
                for($i = $firstDay, $j = 0; $i <= $lastDay; $i++, $j++) {
                    $w = date('W', strtotime("$y-$m-$i"));
                    $res[$j] = "$w/$i/$m/$y";
                }
            } else {
                $mNext = $m + 1;
                $yNext = $y;
                if($mNext > 12) {
                    $mNext = 1;
                    $yNext += 1; 
                }

                $start = $firstDay;
                $end = date('t', strtotime("$y-$m-$firstDay"));

                for($i = $start, $j = 0; $i <= $end + 1; $i++, $j++) {
                    if(($i) > $end) {
                        for($k = 1; $k <= $lastDay; $k++) {
                            $w = date('W', strtotime("$yNext-$mNext-$k"));
                            $res[$j++] = "$w/$k/$mNext/$yNext";        
                        }
                        break;
                    }
                    $res[$j] = "$w/$i/$m/$y";
                }    
            }
            return $res;
        }

        private static function convertDatesForWeek($week) : array {
            $res = [];
            list($w, $d, $m, $y) = explode("/", $week);
            $firstDay = date('j', strtotime("mon this week $y-$m-$d"));
            $lastDay = date('j', strtotime("sun this week $y-$m-$d"));

            if($lastDay > $firstDay) {
                for($i = $firstDay, $j = 0; $i <= $lastDay; $i++, $j++) {
                    $res[$j] = "$w/$i/$m/$y";
                }
            } else {
                $mPrev = $m - 1;
                $yPrev = $y;
                if($mPrev < 1) {
                    $yPrev -= 1; 
                }

                $start = $firstDay;
                $end = date('t', strtotime("$yPrev-$mPrev-$start"));

                for($i = $start, $j = 0; $i <= $end + 1; $i++, $j++) {
                    if(($i) > $end) {
                        for($k = 1; $k <= $lastDay; $k++) {
                            $res[$j++] = "$w/$k/$m/$y";        
                        }
                        break;
                    }
                    $res[$j] = "$w/$i/$mPrev/$yPrev";
                }
            }
            return $res;
        }
    }
?>