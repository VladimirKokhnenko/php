USE `vkorginizer_db`;
DROP procedure IF EXISTS `delete_task_by_id`;

USE `vkorginizer_db`;
DROP procedure IF EXISTS `vkorginizer_db`.`delete_task_by_id`;
;

DELIMITER $$
USE `vkorginizer_db`$$
CREATE DEFINER=`vkorginizer`@`%` PROCEDURE `delete_task_by_id`(t_in time, d_in int, w_in int, m_in int, y_in int)
BEGIN
set @id_task = (select t.id
			FROM years AS y
			JOIN months AS m ON m.year_fk = y.id
			JOIN weeks AS w ON w.month_fk = m.id
			JOIN days AS d ON d.week_fk = w.id
			JOIN tasks AS t ON t.days_Fk = d.id
			WHERE y.nameyear = y_in AND m.numbermonth = m_in AND w.nameweek = w_in AND d.dateday = d_in AND t.timeTask = t_in);
DELETE FROM TASKS
WHERE id = @id_task;

END$$

DELIMITER ;
;

USE `vkorginizer_db`;
DROP procedure IF EXISTS `create_task`;

USE `vkorginizer_db`;
DROP procedure IF EXISTS `vkorginizer_db`.`create_task`;
;

DELIMITER $$
USE `vkorginizer_db`$$
CREATE DEFINER=`vkorginizer`@`%` PROCEDURE `create_task`(nameTask_in varchar(100), description_Task text, t_in time, d_in int, w_in int, m_in int, y_in int)
begin
set @id_year = (select y.Id
		from years as y
		where y.NameYear = y_in);
if @id_year is null then
	insert into years (NameYear) values (y_In);
	
    set @id_year = (select y.Id
		from years as y
        where y.NameYear = y_in);
    
    insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'January', 1);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'February', 2);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'March', 3);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'April', 4);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'May', 5);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'June', 6);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'July', 7);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'August', 8);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'September', 9);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'October', 10);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'November', 11);
	insert into Months(Year_Fk, NameMonth, NumberMonth) values (@id_year, 'December', 12);
end if;

set @id_week = (select w.Id
	from years as y
    join months as m on m.Year_Fk = y.Id
    join weeks as w on w.Month_Fk = m.Id
    where y.NameYear = y_in and m.NumberMonth = m_in and w.NameWeek = w_in);  
if @id_week is null then 
	set @id_month = (select m.Id
				from years as y
                join months as m on m.Year_Fk = y.Id
				where y.NameYear = y_in and m.NumberMonth = m_in);

	insert into Weeks(Month_Fk, NameWeek) values (@id_month, w_in);
end if;

set @id_day = (select d.Id
	from years as y
    join months as m on m.Year_fk = y.Id
    join weeks as w on w.Month_Fk = m.Id
    join days as d on d.Week_Fk = w.Id
    where y.NameYear = y_in and m.NumberMonth = m_in and w.NameWeek = w_in and d.DateDay = d_in);
set @id_week = (select w.Id
	from years as y
    join months as m on m.Year_fk = y.Id
    join weeks as w on w.Month_Fk = m.Id
    where y.NameYear = y_in and m.NumberMonth = m_in and w.NameWeek = w_in);
if @id_day is null then
	insert into Days(Week_Fk, DateDay) values (@id_week, d_in);
end if;

set @id_time  = (select t.Id
	from years as y
    join months as m on m.Year_Fk = y.Id
    join weeks as w on w.Month_Fk = m.Id
    join days as d on d.Week_Fk = w.Id
    join tasks as t on t.Days_Fk = d.Id
    where y.NameYear = y_in and m.NumberMonth = m_in and w.NameWeek = w_in and d.DateDay = d_in and t.TimeTask = t_in);
if @id_time is null then
	set @id_day = (select d.Id
		from years as y
		join months as m on m.Year_Fk = y.Id
		join weeks as w on w.Month_Fk = m.Id
		join days as d on d.Week_Fk = w.Id
		where y.NameYear = y_in and m.NumberMonth = m_in and w.NameWeek = w_in and d.DateDay = d_in);
	
    insert into Tasks(Days_Fk, NameTask, TimeTask, DescriptionTask) values (@id_day, nameTask_in, t_in, description_Task);
end if;

end$$

DELIMITER ;
;