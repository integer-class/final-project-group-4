INSERT INTO [User] (FullName, RegistrationNumber, Username, Email, Password, Phone, Avatar)
VALUES ('Administrator', NULL, 'administrator', 'admin@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'default.png'),
       ('Lecturer 1', '0010057308', 'lecturer1', 'lecturer1@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'default.png'),
       ('Lecturer 2', '0010057309', 'lecturer2', 'lecturer2@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'default.png'),
       ('Student 1', '2241720000', 'student1', 'student1@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'default.png'),
       ('Student 2', '2241720001', 'student2', 'student2@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'default.png'),
       ('Student 3', '2241720002', 'student3', 'student3@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'default.png');

INSERT INTO [Role] (Name)
VALUES ('Administrator'),
       ('Lecturer'),
       ('Student');

INSERT INTO [User_Role] (UserId, RoleId)
VALUES (1, 1),
       (2, 2),
       (3, 2),
       (4, 3),
       (5, 3),
       (6, 3);

INSERT INTO [StudyPrograms] (Name)
VALUES ('Teknik Informatika'),
       ('Sistem Informasi Bisnis'),
       ('Pengembangan Piranti Lunak Situs');

INSERT INTO [User_StudyPrograms] (UserId, StudyProgramId)
VALUES (4, 1),
       (5, 2),
       (6, 3);

INSERT INTO [Room] (Code, Name, Floor, Capacity, Side, FloorPlanIndex)
VALUES ('RT01', 'Ruang Teori 1', 5, 60, 'west', 0),
       ('RT02', 'Ruang Teori 2', 5, 30, 'west', 0),
       ('RT03', 'Ruang Teori 3', 5, 60, 'west', 0),
       ('RT04', 'Ruang Teori 4', 5, 30, 'west', 0),
       ('RT05', 'Ruang Teori 5', 5, 60, 'west', 0),
       ('RT06', 'Ruang Teori 6', 5, 30, 'west', 0),
       ('RT07', 'Ruang Teori 7', 5, 60, 'west', 0),
       ('RT08', 'Ruang Teori 8', 5, 30, 'west', 0),
       ('RT09', 'Ruang Teori 9', 5, 60, 'west', 0),
       ('RT10', 'Ruang Teori 10', 8, 30, 'east', 0),
       ('RT11', 'Ruang Teori 11', 8, 30, 'east', 0),
       ('RT12', 'Ruang Teori 12', 8, 30, 'east', 0),
       ('RT13', 'Ruang Teori 13', 8, 30, 'east', 0),
       ('RT14', 'Ruang Teori 14', 8, 30, 'east', 0),
       ('LPY1', 'Laboratorium Proyek 1', 7, 30, 'west', 0),
       ('LPY2', 'Laboratorium Proyek 2', 7, 30, 'west', 0),
       ('LPY3', 'Laboratorium Proyek 3', 7, 30, 'west', 0),
       ('LPY4', 'Laboratorium Proyek 4', 7, 30, 'east', 0),
       ('LSI1', 'Laboratorium Sistem Informasi 1', 6, 30, 'east', 0),
       ('LSI2', 'Laboratorium Sistem Informasi 2', 6, 30, 'east', 0),
       ('LSI3', 'Laboratorium Sistem Informasi 3', 6, 30, 'east', 0),
       ('LKJ1', 'Laboratorium Komputer dan Jaringan 1', 7, 30, 'west', 0),
       ('LKJ2', 'Laboratorium Komputer dan Jaringan 2', 7, 30, 'east', 0),
       ('LKJ3', 'Laboratorium Komputer dan Jaringan 3', 7, 30, 'east', 0),
       ('LIG1', 'Laboratorium Visi Komputer 1', 7, 30, 'east', 0),
       ('LIG2', 'Laboratorium Visi Komputer 2', 7, 30, 'east', 0),
       ('LIG3', 'Laboratorium Visi Komputer 3', 7, 30, 'east', 0),
       ('RPL1', 'Laboratorium Pemrograman 1', 7, 30, 'west', 0),
       ('RPL2', 'Laboratorium Pemrograman 2', 7, 30, 'west', 0),
       ('RPL3', 'Laboratorium Pemrograman 3', 7, 30, 'west', 0),
       ('RPL4', 'Laboratorium Pemrograman 4', 7, 30, 'west', 0),
       ('RPL5', 'Laboratorium Pemrograman 5', 7, 30, 'west', 0),
       ('RPL6', 'Laboratorium Pemrograman 6', 7, 30, 'west', 0),
       ('RPL7', 'Laboratorium Pemrograman 7', 7, 30, 'west', 0),
       ('RPL8', 'Laboratorium Pemrograman 8', 7, 30, 'west', 0),
       ('LAI1', 'Laboratorium Sistem Cerdas 1', 7, 30, 'east', 0),
       ('LAI2', 'Laboratorium Sistem Cerdas 2', 7, 30, 'east', 0);