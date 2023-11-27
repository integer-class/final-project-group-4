CREATE TABLE
    [dbo].[User]
(
    [ID]        INT          NOT NULL IDENTITY (1, 1),
    [FullName]  VARCHAR(255) NOT NULL,
    [Username]  VARCHAR(255) NOT NULL,
    [Password]  VARCHAR(255) NOT NULL,
    [Email]     VARCHAR(255) NOT NULL,
    [Phone]     VARCHAR(255) NOT NULL,
    [Avatar]    VARCHAR(255) NOT NULL,
    [CreatedAt] DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt] DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt] DATETIME     NULL,
    CONSTRAINT [PK_User] PRIMARY KEY ([ID])
);

CREATE TABLE
    [dbo].[StudyPrograms]
(
    [ID]        INT          NOT NULL IDENTITY (1, 1),
    [Name]      VARCHAR(255) NOT NULL,
    [CreatedAt] DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt] DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt] DATETIME     NULL,
    CONSTRAINT [PK_StudyPrograms ] PRIMARY KEY ([ID])
);

CREATE TABLE
    [dbo].[User_StudyPrograms]
(
    [ID]             INT      NOT NULL IDENTITY (1, 1),
    [UserID]         INT      NOT NULL,
    [StudyProgramID] INT      NOT NULL,
    [CreatedAt]      DATETIME NOT NULL DEFAULT GETDATE(),
    [UpdatedAt]      DATETIME NOT NULL DEFAULT GETDATE(),
    [DeletedAt]      DATETIME NULL,
    CONSTRAINT [PK_User_StudyPrograms] PRIMARY KEY ([ID])
);

CREATE TABLE
    [dbo].[Role]
(
    [ID]        INT          NOT NULL IDENTITY (1, 1),
    [Name]      VARCHAR(255) NOT NULL,
    [CreatedAt] DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt] DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt] DATETIME     NULL,
    CONSTRAINT [PK_Role] PRIMARY KEY ([ID])
);

CREATE TABLE
    [dbo].[User_Role]
(
    [ID]        INT      NOT NULL IDENTITY (1, 1),
    [UserID]    INT      NOT NULL,
    [RoleID]    INT      NOT NULL,
    [CreatedAt] DATETIME NOT NULL DEFAULT GETDATE(),
    [UpdatedAt] DATETIME NOT NULL DEFAULT GETDATE(),
    [DeletedAt] DATETIME NULL,
    CONSTRAINT [PK_User_Role] PRIMARY KEY ([ID])
);

CREATE TABLE
    [dbo].[Room]
(
    [ID]             INT          NOT NULL IDENTITY (1, 1),
    [Code]           CHAR(4)      NOT NULL,
    [Name]           VARCHAR(255) NOT NULL,
    [Floor]          INT          NOT NULL,
    [FloorPlanIndex] INT          NOT NULL,
    -- should be east and west
    [Side]           VARCHAR(255) NOT NULL,
    [Capacity]       INT          NOT NULL,
    [CreatedAt]      DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt]      DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt]      DATETIME     NULL,
    CONSTRAINT [PK_Room] PRIMARY KEY ([ID])
);

-- REQUESTED means the event is requested by the user and is forwarded to the admin for checking
-- PENDING means the event is approved by the admin and is waiting for the other approvers to approve
--         according to the standard operational procedure, there needs to be approval from several different people and it has to be in order
--         hence why we need the admin to check and then add the proper approver for the request
-- APPROVED means the event is approved by all approvers
-- REJECTED means the event is rejected by one of the approverss
CREATE TABLE
    [dbo].[Event]
(
    [ID]          INT          NOT NULL IDENTITY (1, 1),
    [RoomID]      INT          NOT NULL,
    [UserID]      INT          NOT NULL,
    [Title]       VARCHAR(255) NOT NULL,
    [Description] VARCHAR(MAX) NOT NULL,
    [StartsAt]    DATETIME     NOT NULL,
    [EndsAt]      DATETIME     NOT NULL,
    [CreatedAt]   DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt]   DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt]   DATETIME     NULL,
    CONSTRAINT [PK_Room_User] PRIMARY KEY ([ID])
);

CREATE TABLE
    [dbo].[Event_Approver]
(
    [ID]           INT      NOT NULL IDENTITY (1, 1),
    [EventID]      INT      NOT NULL,
    -- we use this to track who comes before and after this user in the approval process
    -- if it's null, it means this is the first or last approver
    [UserID]       INT      NOT NULL,
    [BeforeUserID] INT      NULL,
    [AfterUserID]  INT      NULL,
    -- PENDING, APPROVED, REJECTED
    [Status]       VARCHAR  NOT NULL,
    [CreatedAt]    DATETIME NOT NULL DEFAULT GETDATE(),
    [UpdatedAt]    DATETIME NOT NULL DEFAULT GETDATE(),
    [DeletedAt]    DATETIME NULL,
    CONSTRAINT [PK_Event_Approver] PRIMARY KEY ([ID])
);

ALTER TABLE
    [dbo].[User_StudyPrograms]
    ADD CONSTRAINT [FK_User_StudyPrograms_User]
        FOREIGN KEY ([UserID]) REFERENCES [dbo].[User] ([ID]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    [dbo].[User_StudyPrograms]
    ADD CONSTRAINT [FK_User_StudyPrograms_StudyPrograms]
        FOREIGN KEY ([StudyProgramID]) REFERENCES [dbo].[StudyPrograms] ([ID]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    [dbo].[User_Role]
    ADD CONSTRAINT [FK_User_Role_User]
        FOREIGN KEY ([UserID]) REFERENCES [dbo].[User] ([ID]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    [dbo].[User_Role]
    ADD CONSTRAINT [FK_User_Role_Role]
        FOREIGN KEY ([RoleID]) REFERENCES [dbo].[Role] ([ID]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    [dbo].[Event]
    ADD CONSTRAINT [FK_Event_Room]
        FOREIGN KEY ([RoomID]) REFERENCES [dbo].[Room] ([ID]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    [dbo].[Event]
    ADD CONSTRAINT [FK_Event_User]
        FOREIGN KEY ([UserID]) REFERENCES [dbo].[User] ([ID]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    [dbo].[Event_Approver]
    ADD CONSTRAINT [FK_Event_Approver_Event]
        FOREIGN KEY ([EventID]) REFERENCES [dbo].[Event] ([ID]) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE
    [dbo].[Event_Approver]
    ADD CONSTRAINT [FK_Event_Approver_User]
        FOREIGN KEY ([UserID]) REFERENCES [dbo].[User] ([ID]) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE
    [dbo].[Event_Approver]
    ADD CONSTRAINT [FK_Event_Approver_BeforeUser]
        FOREIGN KEY ([BeforeUserID]) REFERENCES [dbo].[User] ([ID]) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE
    [dbo].[Event_Approver]
    ADD CONSTRAINT [FK_Event_Approver_AfterUser]
        FOREIGN KEY ([AfterUserID]) REFERENCES [dbo].[User] ([ID]) ON DELETE NO ACTION ON UPDATE NO ACTION;