INSERT INTO `menus` (`id`, `displayed_name`, `route_name`, `parent`, `icon`, `status`, `superadmin_access`, `admin_access`, `teacher_access`, `parent_access`, `student_access`, `accountant_access`, `librarian_access`, `sort_order`, `is_addon`, `unique_identifier`, `driver_access`, `donor_access`)
 VALUES (NULL, 'institutions', 'institution', '0', 'mdi mdi-office-building', '1', '1', '1', '0', '0', '0', '0', '0', '50', '0', 'institution', NULL, '1');
ALTER TABLE `donors` ADD `abbr` VARCHAR(50) NULL AFTER `user_id`, ADD `abbr_ar` VARCHAR(50) NULL AFTER `abbr`;
CREATE TABLE IF NOT EXISTS `ministries` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abbr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abbr_ar` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menus` (`displayed_name`, `route_name`, `parent`, `icon`, `status`, `superadmin_access`, `admin_access`, `sort_order`, `unique_identifier`, `donor_access`) 
VALUES ('Ministries', 'ministry', 0, 'mdi mdi-bank', 1, 1, 0, 70, 'ministry', 1);
INSERT INTO `menus` (
    `displayed_name`, 
    `route_name`, 
    `parent`, 
    `icon`, 
    `status`, 
    `superadmin_access`, 
    `admin_access`, 
    `sort_order`, 
    `unique_identifier`, 
    `donor_access`
) 
VALUES (
    'My Projects', 
    'my_projects', 
    0, 
    'mdi mdi-briefcase-check', 
    1, 
    0, -- superadmin (usually they see all projects elsewhere)
   0, -- admin_access
    2, -- sort_order (after Dashboard)
    'my_projects', 
    1  -- donor_access
);