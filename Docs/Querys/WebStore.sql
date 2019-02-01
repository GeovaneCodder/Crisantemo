GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Classic_Shop](
 [ID] [int] IDENTITY(1,1) NOT NULL,
 [item_id] [int] NOT NULL,
 [item_nome] [nchar](20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
 [item_tipo] [int] NOT NULL,
 [item_sexo] [int] NOT NULL, 
 [item_level] [int] NOT NULL,
 [item_preco] [int] NOT NULL, 
 [item_peso] [int] NOT NULL,
 [item_damege] [int] NULL,
 [item_ap] [int] NULL,
 [item_hp] [int] NULL,
 [item_delay] [int] NULL,
 [item_magazine] [int] NULL,
 [item_maxbullet] [int] NULL,
 [item_maxweight] [int] NULL,
 [item_reload] [int] NULL,
 [item_fr] [int] NULL,
 [item_cr] [int] NULL,
 [item_pr] [int] NULL,
 [item_lr] [int] NULL,
 [item_desc] [nchar](20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
 [item_comprado] [int] NOT NULL CONSTRAINT [DF_Classic_Shop_item_comprad]  DEFAULT ((0)),
 [item_imagem] [nchar](20) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]