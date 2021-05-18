<?php
    class WorkWithTask {

        public static function createTask($data) : string {
            list($w,$d,$m,$y,$flagDayOrWeek) = explode('/', $data);

            $res = "<table class=\"Create\">"
                . "<thead>"
                . "<tr><th>" . "$d.$m.$y" . "</th></tr>"
                . "</thead>"
                . "<tbody>"
                . "<tr><td>" . "<label for=\"idInputTime\">Time</label>" . "<input name=\"inputTime\" required id=\"idInputTime\" type=\"time\">" . "</tr></td>"
                . "<tr><td>" . "<label for=\"idInputNameOfTask\">Name</label>" . "<input name=\"inputName\" id=\"idInputNameOfTask\" type=\"text\">" . "</tr></td>"
                . "<tr><td>" . "<textarea name=\"inputDescription\" id=\"idDescriptionOfTask\" rows=\"10\"></textarea>" . "</tr></td>";
                
            if($flagDayOrWeek == 'w') {
                $res .= "<tr><td>" . "<button type=\"submit\" value=\"$w/$d/$m/$y\" name=\"week\" formmethod=\"POST\" formaction=\"show-week.php\">Cansel</button>"
                    . "<button type=\"submit\" value=\"$w/$d/$m/$y/$flagDayOrWeek\" name=\"okCreate\" formmethod=\"POST\" formaction=\"show-week.php\">OK</button>" . "</tr></td>";
            } else if($flagDayOrWeek == 'd') {
                $res .= "<tr><td>" . "<button type=\"submit\" value=\"$w/$d/$m/$y\" name=\"day\" formmethod=\"POST\" formaction=\"show-week.php\">Cansel</button>"
                    . "<button type=\"submit\" value=\"$w/$d/$m/$y/$flagDayOrWeek\" name=\"okCreate\" formmethod=\"POST\" formaction=\"show-week.php\">OK</button>" . "</tr></td>";
            }
                
            $res .= "</tr></td>"
                . "</tbody>"
                . "</table>";

            return $res;
        }

        public static function editTask($data) : string {
            list($w,$d,$m,$y,$flagDayOrWeek, $t) = explode('/', $data);
            $resArr = Task::getTaskForTime($w,$d,$m,$y,$t);
            $id = $resArr["Id"];
            $time = substr($resArr["TimeTask"], 0, 5);
            $nameTask = $resArr["NameTask"];
            $descriptionTask = $resArr["DescriptionTask"];

            $res = "<table class=\"Create\">"
                . "<thead>"
                . "<tr><th>" . "$d.$m.$y" . "</th></tr>"
                . "</thead>"
                . "<tbody>"
                . "<tr><td>" . "<label for=\"idInputTime\">Time</label>" . "<input name=\"inputTime\" required id=\"idInputTime\" type=\"time\" value=\"$time\">" . "</tr></td>"
                . "<tr><td>" . "<label for=\"idInputNameOfTask\">Name</label>" . "<input name=\"inputName\" id=\"idInputNameOfTask\" type=\"text\" value=$nameTask>" . "</tr></td>"
                . "<tr><td>" . "<textarea name=\"inputDescription\" id=\"idDescriptionOfTask\" rows=\"10\">$descriptionTask</textarea>" . "</tr></td>";
                
            if($flagDayOrWeek == 'w') {
                $res .= "<tr><td>" . "<button type=\"submit\" value=\"$w/$d/$m/$y\" name=\"week\" formmethod=\"POST\" formaction=\"show-week.php\">Cansel</button>"
                    . "<button type=\"submit\" value=\"$w/$d/$m/$y/$flagDayOrWeek/$id\" name=\"okEdit\" formmethod=\"POST\" formaction=\"show-week.php\">OK</button>" . "</tr></td>";
            } else if($flagDayOrWeek == 'd') {
                $res .= "<tr><td>" . "<button type=\"submit\" value=\"$w/$d/$m/$y\" name=\"day\" formmethod=\"POST\" formaction=\"show-week.php\">Cansel</button>"
                    . "<button type=\"submit\" value=\"$w/$d/$m/$y/$flagDayOrWeek/$id\" name=\"okEdit\" formmethod=\"POST\" formaction=\"show-week.php\">OK</button>" . "</tr></td>";
            }
                
            $res .= "</tr></td>"
                . "</tbody>"
                . "</table>";

            return $res;
        }
    }
?>