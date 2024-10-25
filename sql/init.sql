/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `user`
(
    `user_id`  INT AUTO_INCREMENT NOT NULL,
    `email`    varchar(255) NOT NULL UNIQUE,
    `nama`     varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `role`     enum('jobseeker', 'company') NOT NULL,
    `image_path` varchar(255) DEFAULT 'linkedinbanner.webp',
    `banner_path` varchar(255) DEFAULT 'profile-img.webp',
    PRIMARY KEY (`user_id`)
);

CREATE TABLE `company_detail`
(
    `user_id` INT NOT NULL,
    `lokasi`  varchar(255) NOT NULL,
    `about`   text NOT NULL,
    PRIMARY KEY (`user_id`),
    CONSTRAINT fk_company_detail_user FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`)
);

CREATE TABLE `lowongan`
(
    `lowongan_id`     INT AUTO_INCREMENT NOT NULL,
    `company_id`      INT NOT NULL,
    `posisi`          varchar(255) NOT NULL,
    `deskripsi`       text NOT NULL,
    `jenis_pekerjaan` enum('part-time','internship','full-time') NOT NULL,
    `jenis_lokasi`    enum('on-site', 'hybrid', 'remote') NOT NULL,
    `is_open`         tinyint(1) NOT NULL,
    `created_at`      timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`lowongan_id`),
    CONSTRAINT fk_lowongan_company FOREIGN KEY (`company_id`) REFERENCES `user`(`user_id`)
);

CREATE TABLE `attachment_lowongan`
(
    `attachment_id` INT NOT NULL AUTO_INCREMENT,
    `lowongan_id`   INT NOT NULL,
    `file_path`     varchar(255) NOT NULL,
    PRIMARY KEY (`attachment_id`),
    CONSTRAINT fk_attachment_lowongan_lowongan FOREIGN KEY (`lowongan_id`) REFERENCES `lowongan`(`lowongan_id`)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
);

CREATE TABLE `lamaran`
(
    `lamaran_id`    INT NOT NULL AUTO_INCREMENT,
    `user_id`       INT NOT NULL,
    `lowongan_id`   INT NOT NULL,
    `cv_path`       varchar(255) NOT NULL,
    `video_path`    varchar(255),
    `status`        enum('accepted', 'rejected', 'waiting') NOT NULL,
    `status_reason` text NOT NULL,
    `created_at`    timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`lamaran_id`),
    CONSTRAINT fk_lamaran_user FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`),
    CONSTRAINT fk_lamaran_lowongan FOREIGN KEY (`lowongan_id`) REFERENCES `lowongan`(`lowongan_id`)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;