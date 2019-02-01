GO

/****** Object:  Table [dbo].[Classic_Noticias]    Script Date: 05/11/2013 15:14:03 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[Classic_Noticias](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Data] [varchar](25) NOT NULL,
	[Titulo] [varchar](200) NOT NULL,
	[Noticia] [varchar](max) NOT NULL,
	[Autor] [varchar](12) NULL
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

INSERT INTO Classic_Noticias 
	( Data, Titulo, Noticia, Autor ) VALUES
	( '00/00/2013', 'Bem Vindo', 'Web Site desenvolvido por Geovane Souza Aka. AvadaKedavra<br />( Criminal Team Web Develope`s )', 'GeovaneSouza' );
