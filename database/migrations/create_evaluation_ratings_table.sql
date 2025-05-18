CREATE TABLE `evaluation_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(10) UNSIGNED NOT NULL,
  `overall_rating` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_ratings_evaluation_id_foreign` (`evaluation_id`),
  CONSTRAINT `evaluation_ratings_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluation_request` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
