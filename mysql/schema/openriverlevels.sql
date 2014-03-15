/*
 * ea_* tables for OpenRiverLevels
 * 
 */
 
CREATE TABLE `ea_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` varchar(20) DEFAULT NULL,
  `level` decimal(10,3) DEFAULT NULL,
  `read_dt` datetime DEFAULT NULL,
  `insert_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ea_levels_siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=840224 DEFAULT CHARSET=latin1;


CREATE TABLE `ea_regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regionid` int(11) DEFAULT NULL,
  `regionname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


CREATE TABLE `ea_rloi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `telemetry_id` varchar(20) DEFAULT NULL,
  `wiski_id` varchar(20) DEFAULT NULL,
  `rloi_id` int(11) DEFAULT NULL,
  `type` char(1) DEFAULT NULL,
  `region` varchar(60) DEFAULT NULL,
  `area` varchar(60) DEFAULT NULL,
  `catchment` varchar(60) DEFAULT NULL,
  `display_region` varchar(60) DEFAULT NULL,
  `display_area` varchar(60) DEFAULT NULL,
  `display_catchment` varchar(60) DEFAULT NULL,
  `external_name` varchar(60) DEFAULT NULL,
  `location` varchar(60) DEFAULT NULL,
  `x_coord` int(11) DEFAULT NULL,
  `y_coord` int(11) DEFAULT NULL,
  `wiski_river_name` varchar(60) DEFAULT NULL,
  `stage_datum` decimal(10,3) DEFAULT NULL,
  `norm_level_min` decimal(10,3) DEFAULT NULL,
  `norm_level_max` decimal(10,3) DEFAULT NULL,
  `recorded_level_max` decimal(10,3) DEFAULT NULL,
  `recorded_level_max_dt` datetime DEFAULT NULL,
  `recorded_level_min` decimal(10,3) DEFAULT NULL,
  `recorded_level_min_dt` datetime DEFAULT NULL,
  `date_open_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ea_rloi_rloi_id` (`rloi_id`),
  KEY `idx_ea_rloi_telemetry_id` (`telemetry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1091 DEFAULT CHARSET=latin1;


CREATE TABLE `ea_sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` varchar(20) DEFAULT NULL,
  `sitename` varchar(60) DEFAULT NULL,
  `ngr` varchar(20) DEFAULT NULL,
  `watercourse` varchar(24) DEFAULT NULL,
  `norm_min` decimal(10,2) DEFAULT NULL,
  `norm_max` decimal(10,2) DEFAULT NULL,
  `sitedatum` varchar(24) DEFAULT NULL,
  `regionid` int(11) DEFAULT NULL,
  `lat` decimal(14,10) DEFAULT NULL,
  `lon` decimal(14,10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ea_sites_siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=1358 DEFAULT CHARSET=latin1;



/* 
 * Older tables - not used for OpenRiverLevels
 */

CREATE TABLE `levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` int(11) DEFAULT NULL,
  `level` decimal(10,2) DEFAULT NULL,
  `read_dt` datetime DEFAULT NULL,
  `insert_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_levels_siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=19083 DEFAULT CHARSET=latin1;

CREATE TABLE `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regionid` int(11) DEFAULT NULL,
  `regionname` varchar(50) DEFAULT NULL,
  `areaname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_regions_regionid` (`regionid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

CREATE TABLE `sites` (
  `siteid` int(11) NOT NULL DEFAULT '0',
  `sitename` varchar(50) DEFAULT NULL,
  `watercourse` varchar(24) DEFAULT NULL,
  `norm_min` decimal(10,2) DEFAULT NULL,
  `norm_max` decimal(10,2) DEFAULT NULL,
  `sitedatum` varchar(24) DEFAULT NULL,
  `regionid` int(11) DEFAULT NULL,
  PRIMARY KEY (`siteid`),
  KEY `idx_sites_siteid` (`siteid`),
  KEY `idx_sites_regionid` (`regionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
