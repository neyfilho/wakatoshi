CREATE DATABASE IF NOT EXISTS `baseone`;

USE `baseone`;

DROP TABLE IF EXISTS `tableone`;
CREATE TABLE `baseone`.`tableone`(
    `id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tabletwo`;
CREATE TABLE `baseone`.`tabletwo`(
    `id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO
    `baseone`.`tableone`(`id`, `name`)
VALUES
    (1, 'nameone'),
    (2, 'nametwo'),
    (3, 'nametreee');

INSERT INTO
    `baseone`.`tabletwo`(`id`, `name`)
VALUES
    (4, 'namefour'),
    (5, 'namefive'),
    (6, 'namesix');