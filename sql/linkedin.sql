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
    `user_id`  varchar(255) NOT NULL,
    `email`    varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `role`     enum('jobseeker', 'company') NOT NULL,
    `nama`     varchar(255) NOT NULL,
    PRIMARY KEY (`user_id`)
);

CREATE TABLE `company_detail`
(
    `user_id` varchar(255) NOT NULL,
    `lokasi`  varchar(255) NOT NULL,
    `about`   text         NOT NULL,
    constraint fk_company_detail_user foreign key (user_id) references user (user_id)
);

CREATE TABLE `lowongan`
(
    `lowongan_id`     varchar(255) NOT NULL,
    `company_id`      varchar(255) NOT NULL,
    `posisi`          varchar(255) NOT NULL,
    `deskripsi`       text         NOT NULL,
    `jenis_pekerjaan` varchar(255) NOT NULL,
    `jenis_lokasi`    enum('on-site', 'hybrid', 'remote') NOT NULL,
    `is_open`         tinyint(1) NOT NULL,
    `created_at`      timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    constraint fk_lowongan_company foreign key (company_id) references user (user_id)
);

CREATE TABLE `attachment_lowongan`
(
    `attachment_id` int          NOT NULL AUTO_INCREMENT,
    `lowongan_id`   varchar(255) NOT NULL,
    `file_path`     varchar(255) NOT NULL,
    constraint fk_attachment_lowongan_lowongan foreign key (lowongan_id) references lowongan (lowongan_id)
);

CREATE TABLE `lamaran`
(
    `lamaran_id`    int          NOT NULL,
    `user_id`       int          NOT NULL,
    `lowongan_id`   int          NOT NULL,
    `cv_path`       varchar(255) NOT NULL,
    `video_path`    varchar(255) NOT NULL,
    `status`        enum('accepted', 'rejected', 'waiting') NOT NULL,
    `status_reason` text         NOT NULL,
    `created_at`    timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    constraint fk_lamaran_user foreign key (user_id) references user (user_id),
    constraint fk_lamaran_lowongan foreign key (lowongan_id) references lowongan (lowongan_id)
)


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;