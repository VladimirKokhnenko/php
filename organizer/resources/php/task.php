<?php 
    class Task {
        const HOST = "127.0.0.1";
        const USER_NAME = "vkorginizer";
        const PASSWORD = "vkorginizer111111";
        const DB_NAME = "vkorginizer_db";

        public static function getTaskForDay($w, $d, $m, $y, $flagDayOrWeek) : string {
            $link = new mysqli(self::HOST, self::USER_NAME, self::PASSWORD, self::DB_NAME);
            
            if (!$link) {
                echo "Ошибка: Не могу установить соединение с БД.<br>" . PHP_EOL;
                echo "Ошибка: " . $link->connect_error(). "<br>" . PHP_EOL;
                exit;
            }
            
            $w_i = (int)$w;
            $d_i = (int)$d;
            $m_i = (int)$m;
            $y_i = (int)$y;

            // Текст SQL-запроса
            $query = "SELECT t.id, t.NameTask, t.TimeTask, t.DescriptionTask".
            " FROM years AS y".
            " JOIN months AS m ON m.year_fk = y.id".
            " JOIN weeks AS w ON w.month_fk = m.id".
            " JOIN days AS d ON d.week_fk = w.id".
            " JOIN tasks AS t ON t.Days_Fk = d.id".
            " WHERE y.nameyear = $y_i AND m.numbermonth = $m_i AND w.nameweek = $w_i AND d.dateday = $d_i;";

            // Выполняем SQL-запрос и получаем результирующую выборку
            $res = '';

            if ($result = $link->query($query))
                {
                    while ($row = $result->fetch_assoc()) {
                        $t = $row["TimeTask"];

                        $res .= "<table class=\"IdGetTask\">" . "<thead>"
                            . "<tr><th>" . $row["TimeTask"] ."</th></th>"
                            . "</thead>"
                            . "<tbody>"
                                . "<tr><td>" . $row["NameTask"] . "</td></tr>"
                                . "<tr><td>" . $row["DescriptionTask"] . "</td></tr>"
                                . "<tr><td>"
                                    . "<button id=\"idEdit\" type=\"submit\" value=\"$w/$d/$m/$y/$flagDayOrWeek/$t\" name=\"edit\" formmethod=\"POST\" formaction=\"show-create.php\">Edit</button>"
                                    . "<button id=\"idDel\" type=\"submit\" value=\"$w/$d/$m/$y/$flagDayOrWeek/$t\" name=\"del\" formmethod=\"POST\" formaction=\"show-week.php\">Del</button>"
                                . "</td></tr>"
                                . "</tbody>" . "</table>";
                    }

                    $result->close();
                }
            
            $link->close();

            $res .= "<table class=\"Create\"><body>";
            $res .= "<tr><td>"
                . "<button class=\"Create\" type=\"submit\" value=\"$w/$d/$m/$y/$flagDayOrWeek\" name=\"create\" formmethod=\"POST\" formaction=\"show-create.php\">Create</button>"
                . "</td></tr>"
                . "</body></table>";

            return $res;
        }

        public static function createTask($date, $time, $nameTask, $descriptionTask) : void {
            list($w, $d, $m, $y, $flagDayOrWeek) = explode('/',$date);

            $link = new mysqli(self::HOST, self::USER_NAME, self::PASSWORD, self::DB_NAME);

            if (!$link) {
                echo "Ошибка: Не могу установить соединение с БД.<br>" . PHP_EOL;
                echo "Ошибка: " . $link->connect_error(). "<br>" . PHP_EOL;
                exit;
            }
            
            $query = "call create_task(\"$nameTask\", \"$descriptionTask\", \"$time\", $d, $w, $m, $y);";
            $link->query($query);
            $link->close();
        }        

        public static function editTask($time, $nameTask, $descriptionTask, $id) : void {

            $link = new mysqli(self::HOST, self::USER_NAME, self::PASSWORD, self::DB_NAME);

            if (!$link) {
                echo "Ошибка: Не могу установить соединение с БД.<br>" . PHP_EOL;
                echo "Ошибка: " . $link->connect_error(). "<br>" . PHP_EOL;
                exit;
            }
            

            
            $id = (int)$id;

            $query = "update tasks "
                . "set NameTask = \"$nameTask\", "
                . "TimeTask = \"$time\", "  
                . "DescriptionTask = \"$descriptionTask\" "
                . "where id = $id;";

            $link->query($query);
            $link->close();
        }

        public static function delTask($w, $d, $m, $y, $flagDayOrWeek, $t) : void {
            $link = new mysqli(self::HOST, self::USER_NAME, self::PASSWORD, self::DB_NAME);
            
            if (!$link) {
                echo "Ошибка: Не могу установить соединение с БД.<br>" . PHP_EOL;
                echo "Ошибка: " . $link->connect_error(). "<br>" . PHP_EOL;
                exit;
            }
            
            $w_i = (int)$w;
            $d_i = (int)$d;
            $m_i = (int)$m;
            $y_i = (int)$y;
            
            $query = "CALL delete_task_by_id(\"$t\", $d_i, $w_i, $m_i, $y_i)";

            $link->query($query);
            $link->close();
        }

        public static function getTaskForTime($w, $d, $m, $y, $t) {
            $link = new mysqli(self::HOST, self::USER_NAME, self::PASSWORD, self::DB_NAME);
            
            if (!$link) {
                echo "Ошибка: Не могу установить соединение с БД.<br>" . PHP_EOL;
                echo "Ошибка: " . $link->connect_error(). "<br>" . PHP_EOL;
                exit;
            }

            $w_i = (int)$w;
            $d_i = (int)$d;
            $m_i = (int)$m;
            $y_i = (int)$y;
            
            $query = "select t.Id, t.NameTask, t.TimeTask, t.DescriptionTask
            from years as y
            join months as m on m.year_fk = y.Id
            join weeks as w on w.month_fk = m.Id
            join days as d on d.week_fk = w.Id
            join tasks as t on t.days_Fk = d.Id
            where y.NameYear = $y_i AND m.NumberMonth = $m_i AND w.NameWeek = $w_i AND d.DateDay = $d_i AND t.TimeTask = \"$t\";";
            

            if (!$result = $link->query($query)) return null;

            $row = $result->fetch_assoc();
            $resArr["Id"] = $row["Id"];
            $resArr["NameTask"] = $row["NameTask"];
            $resArr["TimeTask"] = $row["TimeTask"];
            $resArr["DescriptionTask"] = $row["DescriptionTask"];
            $result->close();
                
            $link->close();
            return $resArr;
        }
    }
?>