USE [WebSite]
GO
/****** Object:  Table [dbo].[Classic_Carrinho]    Script Date: 06/13/2013 07:09:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Classic_Carrinho](
	[item_id] [int] NOT NULL,
	[UserID] [varchar](20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[item_quantidade] [int] NOT NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF