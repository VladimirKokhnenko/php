<?php
    class Month {
        const ALL_DAYS_MON = 36;
        const C_WEEKS = 6;
        
        private $date;
        private $year;
        private $nameMonth;
        private $numMonth;
        private $lastDateOfMonths;
        private $firstDay;

        public function __construct($m, $y) {
            $this->year = $y;
            $this->numMonth = $m;
            $this->date = new DateTime("$y/$m/01");
            $this->nameMonth = $this->date->format('F');
            $this->lastDateOfMonths = $this->date->format('t');
            $this->firstDay = self::getFirstDay($this->date);
        }

        public function getMonthForYear() : string {
            $resStr = "<button type=\"submit\" value=\"$this->numMonth/$this->year\" name=\"month\" formmethod=\"POST\" formaction=\"show-month.php\"><h3>$this->nameMonth</h3></button>";
            $resStr .= "<table class=\"show-year\">";
            $resStr .= self::getHead();
            $resStr .= "<tbody>";
            
            $countDate = 1;

            for($i = 0; $i < self::C_WEEKS; $i++) {
                $resStr .= "<tr class=\"week-hov\">";
                $w = $this->getWeek($countDate);
                $resStr .= "<td><button type=\"submit\" value=\"$w/$countDate/$this->numMonth/$this->year\" name=\"week\" formmethod=\"POST\" formaction=\"show-week.php\">$w</button></td>";
                for($j = 0; $j < 7; $j++) {
                    $ordinalNumber = $i * 7 + $j;
                    if($ordinalNumber >= $this->firstDay && $ordinalNumber < $this->lastDateOfMonths + $this->firstDay) {
                        $resStr .= "<td><button type=\"submit\" value=\"$w/$countDate/$this->numMonth/$this->year\" name=\"day\" formmethod=\"POST\" formaction=\"show-week.php\">$countDate</button></td>";
                        $countDate++;
                    } else {
                        $resStr .= "<td> </td>";
                    }
                }
                if($countDate == $this->lastDateOfMonths + 1) {
                    break;
                }
                $resStr .= "</tr>";
            }
            $resStr .= "</tbody>";
            $resStr .= "</table>";
            return $resStr;
        }
        
        public static function generateMonth($inputDate) : string{
            list($m, $y) = explode("/", $inputDate);
            $curDate = new DateTime("$y/$m/01");
            $nameMonth = $curDate->format('F');
            $firstDay = self::getFirstDay($curDate);
            $lastDateOfMonths = $curDate->format('t');

            $resStr = "<h3>$nameMonth $y</h3>";
            $resStr .= "<table class=\"show-year\">";
            $resStr .= self::getHead();
            $resStr .= "<tbody>";
            
            $countDate = 1;

            for($i = 0; $i < self::C_WEEKS; $i++) {
                $resStr .= "<tr class=\"week-hov\">";
                $w = self::getWeekStatic($countDate, $inputDate);
                $resStr .= "<td><button type=\"submit\" value=\"$w/$countDate/$m/$y\" name=\"week\" formmethod=\"POST\" formaction=\"show-week.php\">$w</button></td>";
                for($j = 0; $j < 7; $j++) {
                    $ordinalNumber = $i * 7 + $j;
                    if($ordinalNumber >= $firstDay && $ordinalNumber < $lastDateOfMonths + $firstDay) {
                        $resStr .= "<td><button type=\"submit\" value=\"$w/$countDate/$m/$y\" name=\"day\" formmethod=\"POST\" formaction=\"show-week.php\">$countDate</button></td>";
                        $countDate++;
                    } else {
                        $resStr .= "<td> </td>";
                    }
                }
                if($countDate == $lastDateOfMonths + 1) {
                    break;
                }
                $resStr .= "</tr>";
            }
            $resStr .= "</tbody>";
            $resStr .= "</table>";
            return $resStr;
        }

        public static function createButtonPrevMonth($curDate) : string {
            $date = self::giveOffsetMonth($curDate, '-1');
            $m = $date['m'];
            $y = $date['y'];

            $res = "<button class=\"row\" type=\"submit\" value=\"$m/$y\" name=\"month\" formmethod=\"POST\" formaction=\"show-month.php\"><</button>";
            return $res;
        }

        public static function createButtonNextMonth($curDate) : string {
            $date = self::giveOffsetMonth($curDate, '1');
            $m = $date['m'];
            $y = $date['y'];

            $res = "<button class=\"row\" type=\"submit\" value=\"$m/$y\" name=\"month\" formmethod=\"POST\" formaction=\"show-month.php\">></button>";
            return $res;
        }

        private static function getFirstDay($curDate) : string {
            $firstDay = $curDate->format('w') - 1;
            if($firstDay == -1) {
                $firstDay = 6;
            }
            return $firstDay;
        }

        private function getWeek($d) : string {
            $m = $this->numMonth;
            $time = strtotime("$d.$m.$this->year"); // порядковый номер недели
            $week = date("W", $time);
            
            return $week;
        }

        private static function getWeekStatic($day, $date) : string {
            list($m, $y) = explode("/", $date);
            $time = strtotime("$day.$m.$y"); // порядковый номер недели
            $week = date("W", $time);
            return $week;
        }

        private static function giveOffsetMonth($curDate, $offset) : array {
            $res = [];
            list($m, $y) = explode("/", $curDate);

            $m += $offset;
            
            if($m > 12) {
                $m = 1;
                $y += 1;
            } else if($m < 1) {
                $m = 12;
                $y -= 1;
            }

            $res['m'] = $m;
            $res['y'] = $y;
            return $res;
        }

        private static function getHead() : string {
            $resStr = "<thead>";
            $resStr .= "<tr>";
            $resStr .= "<th>Week</th>";
            $resStr .= "<th>Mon</th>";
            $resStr .= "<th>Tue</th>";
            $resStr .= "<th>Wed</th>";
            $resStr .= "<th>Thu</th>";
            $resStr .= "<th>Fri</th>";
            $resStr .= "<th>Sat</th>";
            $resStr .= "<th>Sun</th>";
            $resStr .= "</tr>";
            $resStr .= "</thead>";
            return $resStr;
        }
    }
?>