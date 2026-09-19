-- ============================================================
-- REDFLOW — database.sql
-- Matches database/migrations exactly (10 tables). Import this
-- directly in phpMyAdmin (XAMPP) if you'd rather not run
-- `php artisan migrate`. Don't run both on the same database —
-- pick one.
-- ============================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

CREATE DATABASE IF NOT EXISTS `redflow_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `redflow_db`;

-- ---------------------------------------------------------
-- sessions (SESSION_DRIVER=database)
-- ---------------------------------------------------------
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- users (Admin + Staff, uuid used as the frontend-facing id)
-- ---------------------------------------------------------
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `ext_name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `role` enum('Admin','Staff') NOT NULL DEFAULT 'Staff',
  `status` enum('Pending','Approved') NOT NULL DEFAULT 'Pending',
  `id_front_path` varchar(255) DEFAULT NULL,
  `id_back_path` varchar(255) DEFAULT NULL,
  `face_doc_path` varchar(255) DEFAULT NULL,
  `action_taken` varchar(255) NOT NULL DEFAULT 'Registered',
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `failed_login_attempts` tinyint unsigned NOT NULL DEFAULT 0,
  `locked_until` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_uuid_unique` (`uuid`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_approved_by_foreign` (`approved_by`),
  CONSTRAINT `users_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Demo Admin account (adminredflow402@gmail.com / RhuRflow204@) is NOT
-- inserted here with a hand-typed bcrypt hash — a wrong one would silently
-- break login. Instead, after importing this file, run:
--
--   php artisan db:seed --class=AdminSeeder
--
-- which calls Hash::make('RhuRflow204@') for you, correctly, every time.

-- ---------------------------------------------------------
-- donors
-- ---------------------------------------------------------
CREATE TABLE `donors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `donor_uid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ext_name` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `extra` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `donors_donor_uid_unique` (`donor_uid`),
  KEY `donors_name_index` (`name`),
  KEY `donors_blood_type_index` (`blood_type`),
  KEY `donors_brgy_index` (`brgy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- monitoring_records (the Record / History Record nav)
-- ---------------------------------------------------------
CREATE TABLE `monitoring_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `record_uid` varchar(255) NOT NULL,
  `donor_id` bigint unsigned DEFAULT NULL,
  `donation_date` date NOT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `times_donated` int unsigned NOT NULL DEFAULT 1,
  `extra` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `monitoring_records_record_uid_unique` (`record_uid`),
  KEY `monitoring_records_donor_id_foreign` (`donor_id`),
  KEY `monitoring_records_donation_date_index` (`donation_date`),
  CONSTRAINT `monitoring_records_donor_id_foreign` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- monitoring_transactions (the Last Donation Transaction list)
-- ---------------------------------------------------------
CREATE TABLE `monitoring_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_uid` varchar(255) NOT NULL,
  `donor_id` bigint unsigned NOT NULL,
  `monitoring_record_id` bigint unsigned DEFAULT NULL,
  `donation_date` date NOT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `extra` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `monitoring_transactions_transaction_uid_unique` (`transaction_uid`),
  KEY `monitoring_transactions_donor_id_foreign` (`donor_id`),
  KEY `monitoring_transactions_monitoring_record_id_foreign` (`monitoring_record_id`),
  CONSTRAINT `monitoring_transactions_donor_id_foreign` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `monitoring_transactions_monitoring_record_id_foreign` FOREIGN KEY (`monitoring_record_id`) REFERENCES `monitoring_records` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- staff_profiles
-- ---------------------------------------------------------
CREATE TABLE `staff_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `extra` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_profiles_user_id_unique` (`user_id`),
  CONSTRAINT `staff_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- app_notifications
-- ---------------------------------------------------------
CREATE TABLE `app_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `app_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- audit_log
-- ---------------------------------------------------------
CREATE TABLE `audit_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_role` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `action_label` varchar(255) DEFAULT NULL,
  `donor_id` bigint unsigned DEFAULT NULL,
  `donor_name` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `logged_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `audit_log_user_id_foreign` (`user_id`),
  KEY `audit_log_logged_at_index` (`logged_at`),
  CONSTRAINT `audit_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- user_logs
-- ---------------------------------------------------------
CREATE TABLE `user_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `event` varchar(255) NOT NULL,
  `occurred_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_logs_user_id_foreign` (`user_id`),
  KEY `user_logs_occurred_at_index` (`occurred_at`),
  CONSTRAINT `user_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- password_reset_otps
-- ---------------------------------------------------------
CREATE TABLE `password_reset_otps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `code_hash` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `consumed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_reset_otps_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- cache tables (CACHE_STORE=database)
-- ---------------------------------------------------------
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
