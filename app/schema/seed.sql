INSERT INTO [User] (FullName, RegistrationNumber, Username, Email, Password, Phone, Avatar, Role)
VALUES ('Administrator', NULL, 'administrator', 'admin@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'profile_default_1.png', 'ADMIN'),
       ('Rosa Andrie', '0010057308', 'rosa', 'rosa@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'profile_default_2.png', 'APPROVER'),
       ('Putra Prima', '0010057309', 'prima', 'prima@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'profile_default_3.png', 'APPROVER'),
       ('Dicha Arkana', '2241720000', 'dicha', 'dicha@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'profile_default_4.png', 'STUDENT'),
       ('Iemaduddin', '2241720001', 'iemaduddin', 'iemaduddin@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'profile_default_5.png', 'APPROVER'),
       ('Ilzam Mulkhaq', '2241720002', 'ilzam', 'ilzam@localhost.com',
        '$2a$12$rMd7.a71S0.tlVGi36cD9ODTEK52iANR2s5w5DgMOxD3LQPBOz5jG',
        '08123456789', 'profile_default_6.png', 'APPROVER');

INSERT INTO [StudyPrograms] (Name)
VALUES ('Teknik Informatika'),
       ('Sistem Informasi Bisnis'),
       ('Pengembangan Piranti Lunak Situs');

INSERT INTO [User_StudyPrograms] (UserId, StudyProgramId)
VALUES (4, 1),
       (5, 2),
       (6, 3);

INSERT INTO [Room] (Code, Name, Floor, Capacity, Side, Image)
VALUES ('RT01', 'Ruang Teori 1', 5, 60, 'west', 'rt1.jpg'),
       ('RT02', 'Ruang Teori 2', 5, 30, 'west', 'rt2.jpg'),
       ('RT03', 'Ruang Teori 3', 5, 60, 'west', 'rt3.jpg'),
       ('RT04', 'Ruang Teori 4', 5, 30, 'west', 'rt4.jpg'),
       ('RT05', 'Ruang Teori 5', 5, 60, 'west', 'rt5.jpg'),
       ('RT06', 'Ruang Teori 6', 5, 30, 'west', 'rt6.jpg'),
       ('RT07', 'Ruang Teori 7', 5, 60, 'west', 'rt7.jpg'),
       ('RT08', 'Ruang Teori 8', 5, 30, 'west', 'rt8.jpg'),
       ('RT09', 'Ruang Teori 9', 5, 60, 'west', 'rt9.jpg'),
       ('RT10', 'Ruang Teori 10', 8, 30, 'east', 'rt10.jpg'),
       ('RT11', 'Ruang Teori 11', 8, 30, 'east', 'rt11.jpg'),
       ('RT12', 'Ruang Teori 12', 8, 30, 'east', 'rt12.jpg'),
       ('RT13', 'Ruang Teori 13', 8, 30, 'east', 'rt13.jpg'),
       ('RT14', 'Ruang Teori 14', 8, 30, 'east', 'rt14.jpg'),
       ('LPY1', 'Laboratorium Proyek 1', 7, 30, 'west', 'lpy1.jpg'),
       ('LPY2', 'Laboratorium Proyek 2', 7, 30, 'west', 'lpy2.jpg'),
       ('LPY3', 'Laboratorium Proyek 3', 7, 30, 'west', 'lpy3.jpg'),
       ('LPY4', 'Laboratorium Proyek 4', 7, 30, 'east', 'lpy4.jpg'),
       ('LSI1', 'Laboratorium Sistem Informasi 1', 6, 30, 'east', 'lsi1.jpeg'),
       ('LSI2', 'Laboratorium Sistem Informasi 2', 6, 30, 'east', 'lsi2.jpeg'),
       ('LSI3', 'Laboratorium Sistem Informasi 3', 6, 30, 'east', 'lsi3.jpeg'),
       ('LKJ1', 'Laboratorium Komputer dan Jaringan 1', 7, 30, 'west', 'lkj1.jpg'),
       ('LKJ2', 'Laboratorium Komputer dan Jaringan 2', 7, 30, 'east', 'lkj2.jpg'),
       ('LKJ3', 'Laboratorium Komputer dan Jaringan 3', 7, 30, 'east', 'lkj3.jpg'),
       ('LIG1', 'Laboratorium Visi Komputer 1', 7, 30, 'east', 'lig1.jpg'),
       ('LIG2', 'Laboratorium Visi Komputer 2', 7, 30, 'east', 'lig2.jpg'),
       ('LIG3', 'Laboratorium Visi Komputer 3', 7, 30, 'east', 'lig3.jpg'),
       ('LPR1', 'Laboratorium Pemrograman 1', 7, 30, 'west', 'lpr1.jpg'),
       ('LPR2', 'Laboratorium Pemrograman 2', 7, 30, 'west', 'lpr2.jpg'),
       ('LPR3', 'Laboratorium Pemrograman 3', 7, 30, 'west', 'lpr3.jpg'),
       ('LPR4', 'Laboratorium Pemrograman 4', 7, 30, 'west', 'lpr4.jpg'),
       ('LPR5', 'Laboratorium Pemrograman 5', 7, 30, 'west', 'lpr5.jpg'),
       ('LPR6', 'Laboratorium Pemrograman 6', 7, 30, 'west', 'lpr6.jpg'),
       ('LPR7', 'Laboratorium Pemrograman 7', 7, 30, 'west', 'lpr7.jpg'),
       ('LPR8', 'Laboratorium Pemrograman 8', 7, 30, 'west', 'lpr8.jpg'),
       ('LAI1', 'Laboratorium Sistem Cerdas 1', 7, 30, 'east', 'lai1.jpg'),
       ('LAI2', 'Laboratorium Sistem Cerdas 2', 7, 30, 'east', 'lai2.jpg');

-- simulate room booking
INSERT INTO Event (RoomID, UserID, Title, Description, StartsAt, EndsAt)
VALUES (19, 4, 'Hacktoberfest Workshop Riset Informatika',
        'Acara dalam rangka merayakan Hacktoberfest Workshop Riset Informatiks', '20231218', '20231220');
INSERT INTO Event_Approver (EventID, UserID, BeforeUserID, AfterUserID, Status)
VALUES (1, 6, NULL, 5,'APPROVED'),
       (1, 5, 6, 3, 'APPROVED'),
       (1, 3, 5, 2, 'PENDING'),
       (1, 2, 3, NULL, 'PENDING');