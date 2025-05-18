CREATE TABLE `evaluation_request` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `evaluator_emp_id` varchar(255) NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `realiability_quality` int(11) NOT NULL,
  `responsiveness` int(11) NOT NULL,
  `outcome` int(11) NOT NULL,
  `assurance_integrity` int(11) NOT NULL,
  `access_facility` int(11) NOT NULL,
  `quality_remark` text DEFAULT NULL,
  `responsiveness_remark` text DEFAULT NULL,
  `integrity_remark` text DEFAULT NULL,
  `timeliness_remark` text DEFAULT NULL,
  `access_remark` text DEFAULT NULL,
  `evaluation_subject` varchar(255) DEFAULT NULL,
  `evaluation_body` text DEFAULT NULL,
  `overall_rating` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_request_request_id_foreign` (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `evaluation_request` (
    `evaluator_emp_id`,
    `request_id`,
    `realiability_quality`,
    `responsiveness`,
    `outcome`,
    `assurance_integrity`,
    `access_facility`,
    `quality_remark`,
    `responsiveness_remark`,
    `integrity_remark`,
    `timeliness_remark`,
    `access_remark`,
    `evaluation_subject`,
    `evaluation_body`,
    `overall_rating`  /* Add the overall rating here */
) VALUES (
    '23-0001',  -- evaluator employee ID
    53,         -- request ID
    5,          -- realiability_quality (1-5)
    4,          -- responsiveness (1-5)
    5,          -- outcome (1-5)
    4,          -- assurance_integrity (1-5)
    5,          -- access_facility (1-5)
    'Good quality service',
    'Very responsive',
    'Professional',
    'On time',
    'Easy access',
    'Great Service',
    'Excellent overall',
    92          -- overall_rating (computed as: sum of ratings * 20 / 5)
);

ALTER TABLE evaluation_request
ADD COLUMN overall_rating decimal(5,2)
AFTER evaluation_body;
