-- drop all foreign keys
DROP INDEX IF EXISTS [dbo].[Event].[FK_Event_Room];
DROP INDEX IF EXISTS [dbo].[Event].[FK_Event_User];
DROP INDEX IF EXISTS [dbo].[Event_Approver].[FK_Event_Approver_Event];
DROP INDEX IF EXISTS [dbo].[Event_Approver].[FK_Event_Approver_User];
DROP INDEX IF EXISTS [dbo].[Event_Approver].[FK_Event_Approver_BeforeUser];
DROP INDEX IF EXISTS [dbo].[Event_Approver].[FK_Event_Approver_AfterUser];

-- drop all tables
DROP TABLE IF EXISTS [dbo].[Room];
DROP TABLE IF EXISTS [dbo].[User];
DROP TABLE IF EXISTS [dbo].[Event];
DROP TABLE IF EXISTS [dbo].[Event_Room];
DROP TABLE IF EXISTS [dbo].[Event_User];
DROP TABLE IF EXISTS [dbo].[Event_Approver];
DROP TABLE IF EXISTS [dbo].[Approver];
DROP TABLE IF EXISTS [dbo].[Approver_User];

