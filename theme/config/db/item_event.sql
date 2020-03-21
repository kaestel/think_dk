CREATE TABLE `SITE_DB`.`item_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,

  `name` varchar(255) NOT NULL,
  `classname` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `html` text NOT NULL DEFAULT '',

  `starting_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ending_at` timestamp NULL DEFAULT NULL,

  `event_status` int(11) NOT NULL DEFAULT 1,
  `event_attendance_mode` int(11) NOT NULL DEFAULT 1,
  `event_attendance_limit` int(11) DEFAULT NULL,
  `accept_signups` int(11) NOT NULL DEFAULT 1,

  `location` int(11) NULL DEFAULT NULL,

  `event_owner` int(11) NULL DEFAULT NULL,
  `backer_1` int(11) NULL DEFAULT NULL,
  `backer_2` int(11) NULL DEFAULT NULL,

  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `item_event_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `SITE_DB`.`items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_event_ibfk_3` FOREIGN KEY (`event_owner`) REFERENCES `SITE_DB`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_event_ibfk_4` FOREIGN KEY (`backer_1`) REFERENCES `SITE_DB`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_event_ibfk_5` FOREIGN KEY (`backer_2`) REFERENCES `SITE_DB`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
