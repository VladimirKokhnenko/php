<?php 
    require_once "month.php";

    class Year {
        const F_MON = 1;
        const L_MON = 12;

        public static function generateYear() : void{
            $curDate = new DateTime("NOW");
            $year = $curDate->format('Y');

            for($i = 1; $i <= 12; $i++) {
                $m = new Month($i, $year);    
                echo "<div id=\"grid-item-year\">";
                echo $m->getMonthForYear(); 
                echo "</div>";    
            }
        }
    }
?>