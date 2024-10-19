-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS linkedin;

-- Use the database
USE linkedin;

-- Create user table
CREATE TABLE IF NOT EXISTS `user`
(
    `user_id`  VARCHAR(255) PRIMARY KEY,
    `email`    VARCHAR(255)                  NOT NULL UNIQUE,
    `password` VARCHAR(255)                  NOT NULL,
    `role`     ENUM ('jobseeker', 'company') NOT NULL,
    `nama`     VARCHAR(255)                  NOT NULL
);

-- Create company_detail table
CREATE TABLE IF NOT EXISTS `company_detail`
(
    `user_id` VARCHAR(255) PRIMARY KEY,
    `lokasi`  VARCHAR(255) NOT NULL,
    `about`   TEXT         NOT NULL,
    CONSTRAINT fk_company_detail_user FOREIGN KEY (user_id) REFERENCES `user` (user_id)
);

-- Create lowongan table
CREATE TABLE IF NOT EXISTS `lowongan`
(
    `lowongan_id`     VARCHAR(255) PRIMARY KEY,
    `company_id`      VARCHAR(255)                         NOT NULL,
    `posisi`          VARCHAR(255)                         NOT NULL,
    `deskripsi`       TEXT                                 NOT NULL,
    `jenis_pekerjaan` VARCHAR(255)                         NOT NULL,
    `jenis_lokasi`    ENUM ('on-site', 'hybrid', 'remote') NOT NULL,
    `is_open`         BOOLEAN                              NOT NULL,
    `created_at`      TIMESTAMP                            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      TIMESTAMP                            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_lowongan_company FOREIGN KEY (company_id) REFERENCES `user` (user_id)
);

-- Create attachment_lowongan table
CREATE TABLE IF NOT EXISTS `attachment_lowongan`
(
    `attachment_id` INT AUTO_INCREMENT PRIMARY KEY,
    `lowongan_id`   VARCHAR(255) NOT NULL,
    `file_path`     VARCHAR(255) NOT NULL,
    CONSTRAINT fk_attachment_lowongan_lowongan FOREIGN KEY (lowongan_id) REFERENCES `lowongan` (lowongan_id)
);

-- Create lamaran table
CREATE TABLE IF NOT EXISTS `lamaran`
(
    `lamaran_id`    INT AUTO_INCREMENT PRIMARY KEY,
    `user_id`       VARCHAR(255)                             NOT NULL,
    `lowongan_id`   VARCHAR(255)                             NOT NULL,
    `cv_path`       VARCHAR(255)                             NOT NULL,
    `video_path`    VARCHAR(255)                             NOT NULL,
    `status`        ENUM ('accepted', 'rejected', 'waiting') NOT NULL,
    `status_reason` TEXT                                     NOT NULL,
    `created_at`    TIMESTAMP                                NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_lamaran_user FOREIGN KEY (user_id) REFERENCES `user` (user_id),
    CONSTRAINT fk_lamaran_lowongan FOREIGN KEY (lowongan_id) REFERENCES `lowongan` (lowongan_id)
);
