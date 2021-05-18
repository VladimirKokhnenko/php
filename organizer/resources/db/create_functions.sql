USE `vkorginizer_db`;
DROP function IF EXISTS `getIdAtDate`;

USE `vkorginizer_db`;
DROP function IF EXISTS `vkorginizer_db`.`getIdAtDate`;
;

DELIMITER $$
USE `vkorginizer_db`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getIdAtDate`(in_w INT, in_d INT, in_m INT, in_y INT) RETURNS int(11)
BEGIN
    RETURN (select d.id
	FROM years AS y
	JOIN months AS m ON m.year_fk = y.id
	JOIN weeks AS w ON w.month_fk = m.id
	JOIN days AS d ON d.week_fk = w.id
	WHERE y.nameyear = in_y AND m.numbermonth = in_m AND w.nameweek = in_w AND d.dateday = in_d);
END$$

DELIMITER ;
;

