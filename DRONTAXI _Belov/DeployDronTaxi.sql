USE [master]
GO
/****** Object:  Database [DronTaxi]    Script Date: 31.07.2020 9:11:15 ******/
CREATE DATABASE [DronTaxi]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'DronTaxi', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\DronTaxi.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'DronTaxi_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\DronTaxi_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
ALTER DATABASE [DronTaxi] SET COMPATIBILITY_LEVEL = 140
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [DronTaxi].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [DronTaxi] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [DronTaxi] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [DronTaxi] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [DronTaxi] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [DronTaxi] SET ARITHABORT OFF 
GO
ALTER DATABASE [DronTaxi] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [DronTaxi] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [DronTaxi] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [DronTaxi] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [DronTaxi] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [DronTaxi] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [DronTaxi] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [DronTaxi] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [DronTaxi] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [DronTaxi] SET  DISABLE_BROKER 
GO
ALTER DATABASE [DronTaxi] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [DronTaxi] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [DronTaxi] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [DronTaxi] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [DronTaxi] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [DronTaxi] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [DronTaxi] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [DronTaxi] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [DronTaxi] SET  MULTI_USER 
GO
ALTER DATABASE [DronTaxi] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [DronTaxi] SET DB_CHAINING OFF 
GO
ALTER DATABASE [DronTaxi] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [DronTaxi] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [DronTaxi] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [DronTaxi] SET QUERY_STORE = OFF
GO
USE [DronTaxi]
GO
/****** Object:  Table [dbo].[Companies]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Companies](
	[ID] [int] NOT NULL,
	[Name] [varchar](50) NOT NULL,
 CONSTRAINT [PK_Companies] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Functions]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Functions](
	[ID] [int] NOT NULL,
	[Name] [varchar](100) NOT NULL,
	[Description] [text] NULL,
 CONSTRAINT [PK_Functions] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Orders]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Orders](
	[Number] [int] NOT NULL,
	[DateTime] [datetime] NULL,
	[CustUserID] [int] NULL,
	[UserID] [int] NULL,
	[StartPoint] [text] NULL,
	[EndPoint] [text] NULL,
	[StatusID] [tinyint] NULL,
	[TransportID] [int] NULL,
	[StartDateTime] [datetime] NULL,
	[EndDateTime] [datetime] NULL,
	[Distance] [decimal](3, 0) NULL,
	[WorkTimeSecond] [int] NULL,
 CONSTRAINT [PK_Orders] PRIMARY KEY CLUSTERED 
(
	[Number] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[OrderStatus]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[OrderStatus](
	[ID] [tinyint] NOT NULL,
	[Name] [varchar](50) NOT NULL,
 CONSTRAINT [PK_OrderStatus] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[RoleFunctions]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[RoleFunctions](
	[RoleID] [int] NOT NULL,
	[FunctionID] [int] NOT NULL,
 CONSTRAINT [PK_RoleFunctions] PRIMARY KEY CLUSTERED 
(
	[RoleID] ASC,
	[FunctionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Roles]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Roles](
	[ID] [int] NOT NULL,
	[Name] [varchar](100) NOT NULL,
	[Description] [text] NULL,
 CONSTRAINT [PK_Roles] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Sessions]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Sessions](
	[SessionID] [varchar](100) NOT NULL,
	[UserID] [int] NOT NULL,
	[TimeStamp] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TransportImages]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TransportImages](
	[TransportID] [int] NULL,
	[Image] [text] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Transports]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Transports](
	[ID] [int] NOT NULL,
	[CompanyID] [int] NULL,
	[Mark] [varchar](100) NULL,
	[Model] [varchar](100) NULL,
	[CreateDate] [date] NULL,
	[RegNumver] [varchar](50) NULL,
	[EndDate] [date] NOT NULL,
	[IsUsed] [bit] NOT NULL,
 CONSTRAINT [PK_Transports] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[UserRoles]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[UserRoles](
	[UserID] [int] NOT NULL,
	[RoleID] [int] NOT NULL,
	[StartPeriod] [datetime] NULL,
	[EndPeriod] [datetime] NULL,
 CONSTRAINT [PK_UserRoles] PRIMARY KEY CLUSTERED 
(
	[UserID] ASC,
	[RoleID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Users]    Script Date: 31.07.2020 9:11:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Users](
	[ID] [int] NOT NULL,
	[Login] [varchar](25) NOT NULL,
	[Password] [varchar](32) NOT NULL,
	[RegDate] [datetime] NULL,
	[SurName] [varchar](100) NULL,
	[FirstName] [varchar](100) NULL,
	[MidName] [varchar](100) NULL,
	[BirthDay] [date] NULL,
	[Sex] [tinyint] NULL,
	[EMail] [varchar](100) NULL,
	[Phone] [varchar](100) NULL,
	[Image] [text] NULL,
 CONSTRAINT [PK_Users] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
ALTER TABLE [dbo].[Orders]  WITH CHECK ADD  CONSTRAINT [FK_Orders_OrderStatus] FOREIGN KEY([StatusID])
REFERENCES [dbo].[OrderStatus] ([ID])
GO
ALTER TABLE [dbo].[Orders] CHECK CONSTRAINT [FK_Orders_OrderStatus]
GO
ALTER TABLE [dbo].[Orders]  WITH CHECK ADD  CONSTRAINT [FK_Orders_Transports] FOREIGN KEY([TransportID])
REFERENCES [dbo].[Transports] ([ID])
GO
ALTER TABLE [dbo].[Orders] CHECK CONSTRAINT [FK_Orders_Transports]
GO
ALTER TABLE [dbo].[Orders]  WITH CHECK ADD  CONSTRAINT [FK_Orders_Users] FOREIGN KEY([CustUserID])
REFERENCES [dbo].[Users] ([ID])
GO
ALTER TABLE [dbo].[Orders] CHECK CONSTRAINT [FK_Orders_Users]
GO
ALTER TABLE [dbo].[Orders]  WITH CHECK ADD  CONSTRAINT [FK_Orders_Users1] FOREIGN KEY([UserID])
REFERENCES [dbo].[Users] ([ID])
GO
ALTER TABLE [dbo].[Orders] CHECK CONSTRAINT [FK_Orders_Users1]
GO
ALTER TABLE [dbo].[RoleFunctions]  WITH CHECK ADD  CONSTRAINT [FK_RoleFunctions_Functions] FOREIGN KEY([FunctionID])
REFERENCES [dbo].[Functions] ([ID])
GO
ALTER TABLE [dbo].[RoleFunctions] CHECK CONSTRAINT [FK_RoleFunctions_Functions]
GO
ALTER TABLE [dbo].[RoleFunctions]  WITH CHECK ADD  CONSTRAINT [FK_RoleFunctions_Roles] FOREIGN KEY([RoleID])
REFERENCES [dbo].[Roles] ([ID])
GO
ALTER TABLE [dbo].[RoleFunctions] CHECK CONSTRAINT [FK_RoleFunctions_Roles]
GO
ALTER TABLE [dbo].[Sessions]  WITH CHECK ADD  CONSTRAINT [FK_Sessions_Users] FOREIGN KEY([UserID])
REFERENCES [dbo].[Users] ([ID])
GO
ALTER TABLE [dbo].[Sessions] CHECK CONSTRAINT [FK_Sessions_Users]
GO
ALTER TABLE [dbo].[TransportImages]  WITH CHECK ADD  CONSTRAINT [FK_TransportImages_Transports] FOREIGN KEY([TransportID])
REFERENCES [dbo].[Transports] ([ID])
GO
ALTER TABLE [dbo].[TransportImages] CHECK CONSTRAINT [FK_TransportImages_Transports]
GO
ALTER TABLE [dbo].[Transports]  WITH CHECK ADD  CONSTRAINT [FK_Transports_Companies] FOREIGN KEY([CompanyID])
REFERENCES [dbo].[Companies] ([ID])
GO
ALTER TABLE [dbo].[Transports] CHECK CONSTRAINT [FK_Transports_Companies]
GO
ALTER TABLE [dbo].[UserRoles]  WITH CHECK ADD  CONSTRAINT [FK_UserRoles_Roles] FOREIGN KEY([RoleID])
REFERENCES [dbo].[Roles] ([ID])
GO
ALTER TABLE [dbo].[UserRoles] CHECK CONSTRAINT [FK_UserRoles_Roles]
GO
ALTER TABLE [dbo].[UserRoles]  WITH CHECK ADD  CONSTRAINT [FK_UserRoles_Users] FOREIGN KEY([UserID])
REFERENCES [dbo].[Users] ([ID])
GO
ALTER TABLE [dbo].[UserRoles] CHECK CONSTRAINT [FK_UserRoles_Users]
GO
USE [master]
GO
ALTER DATABASE [DronTaxi] SET  READ_WRITE 
GO
