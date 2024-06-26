/****** Object:  Database [HaarlemFestivalDatabase]    Script Date: 4/8/2024 10:40:55 PM ******/
CREATE DATABASE [HaarlemFestivalDatabase]  (EDITION = 'Basic', SERVICE_OBJECTIVE = 'Basic', MAXSIZE = 2 GB) WITH CATALOG_COLLATION = SQL_Latin1_General_CP1_CI_AS, LEDGER = OFF;
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET COMPATIBILITY_LEVEL = 150
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET ARITHABORT OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET ALLOW_SNAPSHOT_ISOLATION ON 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET READ_COMMITTED_SNAPSHOT ON 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET  MULTI_USER 
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET ENCRYPTION ON
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET QUERY_STORE = ON
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET QUERY_STORE (OPERATION_MODE = READ_WRITE, CLEANUP_POLICY = (STALE_QUERY_THRESHOLD_DAYS = 7), DATA_FLUSH_INTERVAL_SECONDS = 900, INTERVAL_LENGTH_MINUTES = 60, MAX_STORAGE_SIZE_MB = 10, QUERY_CAPTURE_MODE = AUTO, SIZE_BASED_CLEANUP_MODE = AUTO, MAX_PLANS_PER_QUERY = 200, WAIT_STATS_CAPTURE_MODE = ON)
GO
/*** The scripts of database scoped configurations in Azure should be executed inside the target database connection. ***/
GO
-- ALTER DATABASE SCOPED CONFIGURATION SET MAXDOP = 8;
GO
/****** Object:  Table [dbo].[CarouselItems]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CarouselItems](
	[itemId] [int] NOT NULL,
	[sectionId] [int] NULL,
	[title] [varchar](100) NULL,
	[subtitle] [varchar](100) NULL,
	[linkText] [varchar](50) NULL,
	[imageId] [int] NULL,
	[linkPath] [varchar](50) NULL,
 CONSTRAINT [PK_CarouselItems] PRIMARY KEY CLUSTERED 
(
	[itemId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[HistoryDetails]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[HistoryDetails](
	[time] [varchar](50) NULL,
	[date] [varchar](50) NULL,
	[languageIndicator] [varchar](255) NULL,
	[guideId] [int] NULL,
	[sectionId] [int] NULL,
	[historyId] [int] IDENTITY(1,1) NOT NULL,
	[startTime] [time](7) NULL,
	[endTime] [time](7) NULL,
 CONSTRAINT [PK_HistoryDetails_1] PRIMARY KEY CLUSTERED 
(
	[historyId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[HistoryGuide]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[HistoryGuide](
	[guideId] [int] NOT NULL,
	[guideName] [varchar](255) NULL,
 CONSTRAINT [PK_FlagImage] PRIMARY KEY CLUSTERED 
(
	[guideId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[HistoryLocations]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[HistoryLocations](
	[locationPicture] [varchar](50) NULL,
	[location] [varchar](50) NULL,
	[description] [varchar](max) NULL,
	[locationId] [int] NOT NULL,
	[sectionId] [int] NULL,
	[button] [varchar](50) NULL,
	[icon] [varchar](50) NULL,
 CONSTRAINT [PK_HistoryEvent] PRIMARY KEY CLUSTERED 
(
	[locationId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Images]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Images](
	[imageId] [int] IDENTITY(1,1) NOT NULL,
	[sectionId] [int] NOT NULL,
	[imageName] [varchar](255) NULL,
	[imagePath] [varchar](255) NOT NULL,
 CONSTRAINT [PK_Images] PRIMARY KEY CLUSTERED 
(
	[imageId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[OpeningTime]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[OpeningTime](
	[OpeningTimeId] [int] NOT NULL,
	[restaurantSectionId] [int] NOT NULL,
	[openingTime] [varchar](100) NOT NULL,
 CONSTRAINT [PK_OpeningTime] PRIMARY KEY CLUSTERED 
(
	[OpeningTimeId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Order]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Order](
	[orderId] [int] IDENTITY(1,1) NOT NULL,
	[dateOfOrder] [datetime] NULL,
	[totalPrice] [float] NULL,
	[vatAmount] [float] NULL,
	[customerId] [int] NULL,
	[invoiceNr] [varchar](50) NULL,
	[orderStatus] [varchar](100) NULL,
 CONSTRAINT [PK_Order] PRIMARY KEY CLUSTERED 
(
	[orderId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[orderItem]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[orderItem](
	[orderItemId] [int] IDENTITY(1,1) NOT NULL,
	[historyId] [int] NULL,
	[restaurantSectionId] [int] NULL,
	[date] [varchar](200) NULL,
	[startTime] [time](7) NULL,
	[endTime] [time](7) NULL,
	[numberOfTickets] [int] NULL,
	[price] [float] NULL,
	[status] [varchar](100) NULL,
	[userId] [int] NOT NULL,
	[specialRequest] [varchar](max) NULL,
	[sessionId] [int] NULL,
	[orderId] [int] NULL,
	[qrHash] [varchar](255) NULL,
	[eventName] [varchar](255) NULL,
	[vatPercentage] [decimal](18, 0) NULL,
 CONSTRAINT [PK_orderItem] PRIMARY KEY CLUSTERED 
(
	[orderItemId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Pages]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Pages](
	[pageId] [int] IDENTITY(1,1) NOT NULL,
	[pageTitle] [varchar](50) NULL,
	[pageLink] [varchar](100) NULL,
 CONSTRAINT [PK_Pages] PRIMARY KEY CLUSTERED 
(
	[pageId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Paragraph]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Paragraph](
	[paragraphId] [int] IDENTITY(1,1) NOT NULL,
	[sectionId] [int] NOT NULL,
	[text] [varchar](max) NOT NULL,
 CONSTRAINT [PK_Paragraph] PRIMARY KEY CLUSTERED 
(
	[paragraphId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[payment]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[payment](
	[paymentId] [int] IDENTITY(1,1) NOT NULL,
	[userId] [int] NULL,
	[orderId] [int] NULL,
	[paymentStatus] [varchar](50) NULL,
	[paymentCode] [nvarchar](50) NULL,
	[webhookURL] [varchar](255) NULL,
	[paymentDate] [datetime] NULL,
 CONSTRAINT [PK_payment] PRIMARY KEY CLUSTERED 
(
	[paymentId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Restaurant]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Restaurant](
	[restaurantName] [varchar](50) NOT NULL,
	[restaurantId] [int] NOT NULL,
	[location] [nchar](50) NOT NULL,
	[numberOfSeats] [int] NOT NULL,
	[restaurantPicture] [varchar](50) NOT NULL,
	[foodOfferings] [varchar](100) NOT NULL,
	[description] [varchar](max) NOT NULL,
	[sessions] [varchar](max) NULL,
	[service] [varchar](50) NOT NULL,
 CONSTRAINT [PK_Restaurant] PRIMARY KEY CLUSTERED 
(
	[restaurantId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[RestaurantSection]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[RestaurantSection](
	[restaurantId] [int] NOT NULL,
	[restaurantSectionId] [int] NOT NULL,
	[location] [nchar](100) NULL,
	[email] [nchar](300) NULL,
	[phonenumber] [int] NULL,
	[kidPrice] [nchar](100) NULL,
	[adultPrice] [nchar](100) NULL,
	[type] [nchar](10) NULL,
	[restaurantName] [varchar](100) NULL,
	[numberOfSeats] [int] NULL,
 CONSTRAINT [PK_RestaurantSection] PRIMARY KEY CLUSTERED 
(
	[restaurantSectionId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Sections]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Sections](
	[pageId] [int] NOT NULL,
	[sectionId] [int] IDENTITY(1,1) NOT NULL,
	[type] [varchar](50) NOT NULL,
	[heading] [varchar](100) NULL,
	[subTitle] [varchar](100) NULL,
	[list] [varchar](max) NULL,
	[linkText] [varchar](50) NULL,
 CONSTRAINT [PK_Sections] PRIMARY KEY CLUSTERED 
(
	[sectionId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Session]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Session](
	[sessionId] [int] IDENTITY(1,1) NOT NULL,
	[restaurantSectionId] [int] NOT NULL,
	[startTime] [time](7) NOT NULL,
	[endTime] [time](7) NOT NULL,
	[numberOfSeats] [int] NULL,
 CONSTRAINT [PK_Session] PRIMARY KEY CLUSTERED 
(
	[sessionId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[sessions]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sessions](
	[sessionId] [int] NOT NULL,
	[restaurantId] [int] NOT NULL,
	[startTime] [datetime] NOT NULL,
	[endTime] [datetime] NOT NULL,
	[bookedSeats] [int] NOT NULL,
 CONSTRAINT [PK_sessions] PRIMARY KEY CLUSTERED 
(
	[sessionId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[User]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[User](
	[username] [varchar](50) NOT NULL,
	[email] [varchar](50) NOT NULL,
	[address] [varchar](50) NULL,
	[phonenumber] [int] NOT NULL,
	[password] [varchar](255) NOT NULL,
	[reset_token_hash] [varchar](65) NULL,
	[reset_token_expires_at] [datetime] NULL,
	[picture] [varchar](50) NULL,
	[role] [varchar](50) NULL,
	[registered_at] [datetime2](7) NULL,
	[id] [int] IDENTITY(1,1) NOT NULL,
	[firstName] [varchar](50) NULL,
	[lastName] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[YummyImage]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[YummyImage](
	[YummyImageId] [int] NOT NULL,
	[restaurantSectionId] [int] NOT NULL,
	[imagePath] [varchar](255) NOT NULL,
	[imageName] [varchar](255) NULL,
 CONSTRAINT [PK_YummyImage] PRIMARY KEY CLUSTERED 
(
	[YummyImageId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[YummyLocation]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[YummyLocation](
	[YummyLocationId] [int] NOT NULL,
	[restaurantSectionId] [int] NULL,
	[restaurantId] [int] NOT NULL,
	[Location] [varchar](255) NULL,
	[Long] [decimal](9, 6) NULL,
	[Lati] [decimal](8, 6) NULL,
 CONSTRAINT [PK_YummyLocation] PRIMARY KEY CLUSTERED 
(
	[YummyLocationId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[YummyParagraph]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[YummyParagraph](
	[YummyParagraphId] [int] NOT NULL,
	[restaurantSectionId] [int] NOT NULL,
	[text] [nvarchar](max) NOT NULL,
 CONSTRAINT [PK_YummyParagraph] PRIMARY KEY CLUSTERED 
(
	[YummyParagraphId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Yummyyy]    Script Date: 4/8/2024 10:40:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Yummyyy](
	[restaurantId] [int] IDENTITY(1,1) NOT NULL,
	[sectionId] [int] NULL,
	[restaurantName] [nvarchar](255) NULL,
	[location] [nvarchar](255) NULL,
	[numberOfSeats] [int] NULL,
	[restaurantPicture] [nvarchar](max) NULL,
	[foodOfferings] [nvarchar](max) NULL,
	[description] [nvarchar](max) NULL,
	[sessions] [nvarchar](max) NULL,
	[service] [nvarchar](255) NULL,
	[kidPrice] [decimal](10, 2) NULL,
	[adultPrice] [decimal](10, 2) NULL,
	[phonenumber] [nvarchar](50) NULL,
	[email] [nvarchar](255) NULL,
PRIMARY KEY CLUSTERED 
(
	[restaurantId] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
INSERT [dbo].[CarouselItems] ([itemId], [sectionId], [title], [subtitle], [linkText], [imageId], [linkPath]) VALUES (1, 11, N'<h1>A food event in Haarlem</h1>', N'<h4>Yummy event</h4>', N'Discover', 9, N'/restaurant/yummyHome')
INSERT [dbo].[CarouselItems] ([itemId], [sectionId], [title], [subtitle], [linkText], [imageId], [linkPath]) VALUES (2, 11, N'<h1>Haarlem''s historic landmarks</h1>', N'<h4>A stroll through history</h4>', N'Discover', 10, N'/history')
INSERT [dbo].[CarouselItems] ([itemId], [sectionId], [title], [subtitle], [linkText], [imageId], [linkPath]) VALUES (3, 23, N'<h1>Discover Haarlem''s Festival Events and Kids Events</h1>', NULL, NULL, NULL, N'/festival')
GO
SET IDENTITY_INSERT [dbo].[HistoryDetails] ON 

INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'12:00-12:02', N'14 July', N'../img/dutch.jpg', 2, 22, 3, CAST(N'12:00:00' AS Time), CAST(N'12:02:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'10:00-13:00', N'28 July', N'../img/english.jpg, ../img/dutch.jpg, ../img/chinese.jpg', 4, 22, 4, CAST(N'10:00:00' AS Time), CAST(N'13:00:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'13:00-16:00', N'26 July', N'../img/english.jpg, ../img/dutch.jpg, ../img/chinese.jpg', 2, 22, 5, CAST(N'13:00:00' AS Time), CAST(N'16:00:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'13:00-16:00', N'27 July', N'../img/english.jpg, ../img/dutch.jpg, ../img/chinese.jpg', 3, 22, 6, CAST(N'13:00:00' AS Time), CAST(N'16:00:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'13:00-16:00', N'25 July', N'../img/english.jpg, ../img/dutch.jpg', 1, 22, 7, CAST(N'13:00:00' AS Time), CAST(N'16:00:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'16:00-19:00', N'27 July', N'../img/english.jpg, ../img/dutch.jpg, ../img/chinese.jpg', 3, 22, 8, CAST(N'16:00:00' AS Time), CAST(N'19:00:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'13:00-16:00', N'28 July', N'../img/english.jpg, ../img/dutch.jpg, ../img/chinese.jpg', 4, 22, 9, CAST(N'13:00:00' AS Time), CAST(N'16:00:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'16:00-19:00', N'25 July', N'../img/english.jpg, ../img/dutch.jpg', 1, 22, 10, CAST(N'16:00:00' AS Time), CAST(N'19:00:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'16:00-19:00', N'26 July', N'../img/english.jpg, ../img/dutch.jpg', 2, 22, 11, CAST(N'16:00:00' AS Time), CAST(N'19:00:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'16:00-19:00', N'28 July', N'../img/english.jpg, ../img/dutch.jpg', 4, 22, 12, CAST(N'16:00:00' AS Time), CAST(N'19:00:00' AS Time))
INSERT [dbo].[HistoryDetails] ([time], [date], [languageIndicator], [guideId], [sectionId], [historyId], [startTime], [endTime]) VALUES (N'11:24-13:24', N'19 July', N'../img/dutch.jpg, ../img/english.jpg', 2, 22, 17, CAST(N'11:24:00' AS Time), CAST(N'13:24:00' AS Time))
SET IDENTITY_INSERT [dbo].[HistoryDetails] OFF
GO
INSERT [dbo].[HistoryGuide] ([guideId], [guideName]) VALUES (1, N'Jan-Willem(Dutch),Frederic(English)')
INSERT [dbo].[HistoryGuide] ([guideId], [guideName]) VALUES (2, N'Annet(Dutch), Williams(English), 
Kim(Chinese)')
INSERT [dbo].[HistoryGuide] ([guideId], [guideName]) VALUES (3, N'Annet + Jan-Willem(Dutch), Frederic+
William(English), Kim(Chinese)')
INSERT [dbo].[HistoryGuide] ([guideId], [guideName]) VALUES (4, N'Lisa+Annet+Jan-Willem(Dutch), 
Deirdre+Frederic+William(English),
Kim+Susan(Chinese)')
GO
INSERT [dbo].[HistoryLocations] ([locationPicture], [location], [description], [locationId], [sectionId], [button], [icon]) VALUES (N'../img/1.jpg', N'St.Bavo Church', N'Nestled in the heart of Haarlem, the Church of St. Bavo stands as a testament to centuries of history and architectural grandeur. Its Gothic splendor, with a spire that reaches towards the heavens, captivates the eyes and hearts of all who visit. Step inside to discover the famous Muller organ, whose melodious notes echo through the hallowed halls, adding a symphony to the rich tapestry of this sacred space. Discover a place where the past seamlessly intertwines with the present, and where every stone and note tells a story.', 1, 21, N'A', N'../img/start.png')
INSERT [dbo].[HistoryLocations] ([locationPicture], [location], [description], [locationId], [sectionId], [button], [icon]) VALUES (N'../img/2.jpg', N'Grote Markt', N'The Grote Markt in Haarlem stands as a historic gem at the heart of the city. Surrounded by a captivating mix of architectural wonders, including the iconic St. Bavo Church and the distinguished Town Hall, the square exudes a timeless charm. The St. Bavo Church, with its soaring Gothic spire, is a testament to the city''s rich medieval history. As the vibrant epicenter of Haarlem, the Grote Markt invites visitors to soak in the atmosphere, explore nearby attractions, and embrace the cultural tapestry woven into the very fabric of this picturesque Dutch city.', 2, 21, N'B', NULL)
INSERT [dbo].[HistoryLocations] ([locationPicture], [location], [description], [locationId], [sectionId], [button], [icon]) VALUES (N'../img/windmill.png', N'De Hallen', N'De Hallen Museum in Haarlem is a dynamic cultural institution that showcases a diverse range of contemporary art. With a focus on modern and experimental art forms, De Hallen features thought-provoking exhibitions, fostering a dialogue between artists and the public. This innovative museum contributes to Haarlem''s rich cultural tapestry, inviting patrons to explore the cutting edge of artistic expression.', 3, 21, N'C', NULL)
INSERT [dbo].[HistoryLocations] ([locationPicture], [location], [description], [locationId], [sectionId], [button], [icon]) VALUES (NULL, N'Proveniershof', N'Dating back to the 17th century, Proveniershof is a hidden gem surrounded by well-preserved almshouses with colorful facades and lush gardens. This serene oasis offers visitors a glimpse into the city''s rich history and architectural heritage, providing a peaceful escape from the bustling urban environment. The courtyard remains a testament to Haarlem''s commitment to preserving its cultural legacy and offers a delightful retreat for those seeking a quiet and scenic experience.', 4, 21, N'D', NULL)
INSERT [dbo].[HistoryLocations] ([locationPicture], [location], [description], [locationId], [sectionId], [button], [icon]) VALUES (NULL, N'Jopenkerk', N'Jopenkerk is a unique and historic brewery, housed in a former church. Renowned for its innovative approach to brewing, Jopenkerk seamlessly blends tradition with modern craftsmanship. Visitors can enjoy a distinctive atmosphere as they savor a variety of craft beers brewed on-site, surrounded by the impressive architecture of the converted church. With a rich history and a commitment to quality, Jopenkerk offers a memorable and authentic experience for beer enthusiasts and those seeking a one-of-a-kind setting in Haarlem.', 5, 21, N'E', N'../img/cheers.png')
INSERT [dbo].[HistoryLocations] ([locationPicture], [location], [description], [locationId], [sectionId], [button], [icon]) VALUES (NULL, N'Waalse Kerk', NULL, 6, 21, N'F', NULL)
INSERT [dbo].[HistoryLocations] ([locationPicture], [location], [description], [locationId], [sectionId], [button], [icon]) VALUES (NULL, N'Molen De Adriaan', N'Molen de Adriaan, nestled along the picturesque Spaarne River in Haarlem, is a historic windmill that stands as an enduring symbol of the city''s heritage. Originally built in 1779, the mill has played a vital role in Haarlem''s history, serving various functions over the years. Unfortunately, it faced significant challenges and was destroyed by fire in 1932. However, through dedicated restoration efforts, Molen de Adriaan has been resurrected, blending its original charm with modern significance.', 7, 21, N'G', NULL)
INSERT [dbo].[HistoryLocations] ([locationPicture], [location], [description], [locationId], [sectionId], [button], [icon]) VALUES (NULL, N'Amsterdamse Poort', NULL, 8, 21, N'H', NULL)
INSERT [dbo].[HistoryLocations] ([locationPicture], [location], [description], [locationId], [sectionId], [button], [icon]) VALUES (NULL, N'Hof van Bakenes', N'Nestled in the heart of Haarlem, the Hof van St. Bakens stands as a testament to centuries of history and architectural grandeur. Its Gothic splendor, with a spire that reaches towards the heavens, captivates the eyes and hearts of all who visit. Step inside to discover the famous Muller organ, whose melodious notes echo through the hallowed halls, adding a symphony to the rich tapestry of this sacred space. Discover a place where the past seamlessly intertwines with the present, and where every stone and note tells a story.', 9, 21, N'I', N'../img/finish.png')
GO
SET IDENTITY_INSERT [dbo].[Images] ON 

INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (1, 2, N'HomeHeader1', N'/img/HomeHeader1.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (2, 2, N'HomeHeader2', N'/img/HomeHeader2.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (3, 2, N'HomeHeader3', N'/img/HomeHeader3.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (4, 3, N'SpeakerIcon', N'/img/SpeakerIcon.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (5, 10, N'TeylerPhoto', N'../img/TeylerPhoto.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (6, 10, N'YummyPhoto', N'../img/YummyPhoto.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (7, 10, N'HistoryPhoto', N'../img/HistoryPhoto.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (8, 10, N'DancePhoto', N'../img/DancePhoto.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (9, 11, N'YummyNavigation', N'../img/YummyNavigation.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (10, 11, N'HistoryNavigationPhoto', N'../img/HistoryNavigation.svg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (11, 15, N'HistoryHome', N'../img/historyhome.jpg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (12, 1, N'HIstoryWalk', N'../img/walk.png')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (13, 17, N'HistoryMarkting.', N'../img/HistoryMarkting.png')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (14, 12, N'yummyHomeHeader', N'../img/yummyHomeHeaderrr.png')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (15, 23, N'yummyMarketing', N'../img/food.jpg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (16, 22, N'EnglishLanguage', N'../img/english.jpg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (17, 22, N'Chinese', N'../img/chinese.jpg')
INSERT [dbo].[Images] ([imageId], [sectionId], [imageName], [imagePath]) VALUES (18, 22, N'Dutch', N'../img/dutch.jpg')
SET IDENTITY_INSERT [dbo].[Images] OFF
GO
INSERT [dbo].[OpeningTime] ([OpeningTimeId], [restaurantSectionId], [openingTime]) VALUES (1, 1, N'17.00 PM - 18:30 PM')
INSERT [dbo].[OpeningTime] ([OpeningTimeId], [restaurantSectionId], [openingTime]) VALUES (2, 1, N'18:30 PM - 20:00 PM')
INSERT [dbo].[OpeningTime] ([OpeningTimeId], [restaurantSectionId], [openingTime]) VALUES (3, 1, N'20:00 PM - 21:30 PM')
INSERT [dbo].[OpeningTime] ([OpeningTimeId], [restaurantSectionId], [openingTime]) VALUES (4, 2, N'18.00 PM - 19:00 PM ')
INSERT [dbo].[OpeningTime] ([OpeningTimeId], [restaurantSectionId], [openingTime]) VALUES (5, 2, N'20:00 PM - 21:00 PM')
INSERT [dbo].[OpeningTime] ([OpeningTimeId], [restaurantSectionId], [openingTime]) VALUES (6, 2, N'22:00 PM - 23:00 PM')
GO
SET IDENTITY_INSERT [dbo].[Order] ON 

INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (1, CAST(N'2024-03-19T16:07:59.000' AS DateTime), 17.5, 3, 2, N'1', NULL)
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (2, CAST(N'2024-03-24T00:00:00.000' AS DateTime), NULL, NULL, 17, N'2', NULL)
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (3, NULL, NULL, NULL, 18, N'3', NULL)
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (7, NULL, NULL, NULL, 19, N'4', NULL)
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (11, NULL, 95, NULL, 20, N'6', NULL)
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (12, NULL, 95, NULL, 21, NULL, NULL)
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (13, NULL, 113, NULL, 22, NULL, NULL)
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (14, NULL, 95, NULL, 23, NULL, NULL)
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (67, CAST(N'2024-03-24T00:00:00.000' AS DateTime), 113, NULL, 1, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (284, NULL, 113, NULL, 1, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (286, NULL, 113, NULL, 1, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (287, NULL, 113, NULL, 1, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (288, NULL, 113, NULL, 1, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (289, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (290, NULL, 113, NULL, 1, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (291, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (292, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (293, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (294, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (295, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (296, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (297, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (298, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (299, NULL, NULL, NULL, 1, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (300, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (301, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (302, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (303, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (304, CAST(N'2024-04-07T15:57:50.000' AS DateTime), 17.5, 5.4, 2, N'INV-20240407-304', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (305, CAST(N'2024-04-08T11:15:14.000' AS DateTime), 17.5, 1.575, 2, N'INV-20240408-305', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (306, NULL, 17.5, NULL, 2, NULL, N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (307, CAST(N'2024-04-08T11:32:33.000' AS DateTime), 17.5, 4.725, 2, N'INV-20240408-307', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (308, CAST(N'2024-04-08T11:40:52.000' AS DateTime), 17.5, 5.4, 2, N'INV-20240408-308', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (309, CAST(N'2024-04-08T11:46:35.000' AS DateTime), 17.5, 3.15, 2, N'INV-20240408-309', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (310, CAST(N'2024-04-08T12:22:43.000' AS DateTime), 17.5, 9.45, 2, N'INV-20240408-310', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (312, CAST(N'2024-04-08T12:43:41.000' AS DateTime), 17.5, 5.4, 2, N'INV-20240408-312', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (319, NULL, 17.5, NULL, 2, NULL, N'open')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (320, CAST(N'2024-04-08T14:25:25.000' AS DateTime), 17.5, 1.575, 2, N'INV-20240408-320', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (321, NULL, 17.5, NULL, 2, NULL, N'open')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (322, CAST(N'2024-04-08T14:47:58.000' AS DateTime), 55, 4.95, NULL, N'INV-20240408-322', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (323, CAST(N'2024-04-08T15:05:07.000' AS DateTime), 37.5, 3.375, 2, N'INV-20240408-323', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (324, CAST(N'2024-04-08T15:06:39.000' AS DateTime), 107.5, 9.675, 2, N'INV-20240408-324', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (325, CAST(N'2024-04-08T15:41:56.000' AS DateTime), 27.5, 2.475, 2, N'INV-20240408-325', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (326, CAST(N'2024-04-08T16:52:50.000' AS DateTime), 60, 5.4, 2, N'INV-20240408-326', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (327, CAST(N'2024-04-08T17:38:16.000' AS DateTime), 37.5, 3.375, 4, N'INV-20240408-327', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (328, NULL, 82.5, NULL, 4, NULL, N'open')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (329, NULL, 20, NULL, 4, NULL, N'open')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (330, CAST(N'2024-04-08T20:09:45.000' AS DateTime), 17.5, 1.575, 2, N'INV-20240408-330', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (331, CAST(N'2024-04-08T20:11:39.000' AS DateTime), 20, 1.8, 2, N'INV-20240408-331', N'paid')
INSERT [dbo].[Order] ([orderId], [dateOfOrder], [totalPrice], [vatAmount], [customerId], [invoiceNr], [orderStatus]) VALUES (332, NULL, 17.5, NULL, 4, NULL, N'open')
SET IDENTITY_INSERT [dbo].[Order] OFF
GO
SET IDENTITY_INSERT [dbo].[orderItem] ON 

INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (29, NULL, 3, N'2024-03-23', CAST(N'19:00:00' AS Time), CAST(N'21:00:00' AS Time), 4, 40, N'deactivated', 4, N'ssd', 9, NULL, NULL, N'', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (30, NULL, 4, N'2024-03-19', CAST(N'20:30:00' AS Time), CAST(N'22:00:00' AS Time), 2, 40, N'Pending', 4, N'noting', 13, NULL, NULL, N'yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (31, NULL, 6, N'2024-03-19', CAST(N'19:30:00' AS Time), CAST(N'21:00:00' AS Time), 4, 40, N'unpaid', 4, N'dd', 19, NULL, NULL, NULL, CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (103, NULL, NULL, N'25 July', CAST(N'13:00:00' AS Time), CAST(N'16:00:00' AS Time), 4, NULL, N'unpaid', 19, NULL, NULL, NULL, NULL, N'History Tour Event', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (148, NULL, 3, N'2024-03-27', CAST(N'19:00:00' AS Time), CAST(N'21:00:00' AS Time), 2, 20, N'deactivated', 4, N'idk', 9, NULL, NULL, NULL, CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (149, NULL, 7, N'2024-03-27', CAST(N'17:30:00' AS Time), CAST(N'19:00:00' AS Time), 4, 40, N'deactivated', 4, N'www', 20, NULL, NULL, NULL, CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (150, NULL, 7, N'2024-03-27', CAST(N'17:30:00' AS Time), CAST(N'19:00:00' AS Time), 2, 20, N'unpaid', 4, N'qqq', 20, NULL, NULL, N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (179, NULL, 2, N'2024-03-23', CAST(N'11:11:00' AS Time), CAST(N'11:01:00' AS Time), 3, 30, N'Confirmed', 4, N'noting', NULL, NULL, NULL, N'yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (180, NULL, 3, N'2024-03-31', CAST(N'12:21:00' AS Time), CAST(N'21:11:00' AS Time), 4, 40, N'Confirmed', 4, N'noting', NULL, NULL, NULL, N'History lala Tour Event', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (181, NULL, 1, N'2024-03-10', CAST(N'11:11:00' AS Time), CAST(N'22:22:00' AS Time), 22, 220, N'Cancelled', 4, N'noting', NULL, NULL, NULL, N'saasd', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (182, NULL, 3, N'2024-03-31', CAST(N'11:11:00' AS Time), CAST(N'22:11:00' AS Time), 3, 30, N'deactivated', 4, N'noting', NULL, NULL, NULL, N'yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (183, NULL, 2, N'2024-03-31', CAST(N'12:21:00' AS Time), CAST(N'11:12:00' AS Time), 3, 30, N'deactivated', 4, N'noting', NULL, NULL, NULL, N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (184, NULL, 3, N'2024-04-07', CAST(N'05:55:00' AS Time), CAST(N'06:59:00' AS Time), 5, 50, N'deactivated', 4, N'ssd', NULL, NULL, NULL, N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (218, NULL, NULL, N'25 July', CAST(N'13:00:00' AS Time), CAST(N'16:00:00' AS Time), 5, 87.5, N'paid', 1, NULL, NULL, 290, NULL, N'History Tour Event', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (232, NULL, NULL, N'25 July', CAST(N'16:00:00' AS Time), CAST(N'19:00:00' AS Time), 4, 60, N'paid', 1, NULL, NULL, 290, NULL, N'History Tour Event', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (240, NULL, 4, N'2024-04-21', CAST(N'17:30:00' AS Time), CAST(N'19:00:00' AS Time), 4, 40, N'unpaid', 4, N'ss', 11, NULL, NULL, N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (241, NULL, 4, N'2024-04-21', CAST(N'17:30:00' AS Time), CAST(N'19:00:00' AS Time), 4, 40, N'unpaid', 4, N'ss', 11, NULL, NULL, N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (325, NULL, NULL, N'19 July', CAST(N'11:24:00' AS Time), CAST(N'13:24:00' AS Time), 1, 17.5, N'paid', 2, NULL, NULL, 325, N'564922d9114feac4425af3228302d170bbaf2f531667a21286bc4006bcce21b7', N'History Tour Event', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (326, NULL, 5, N'2024-04-18', CAST(N'17:00:00' AS Time), CAST(N'19:00:00' AS Time), 2, 10, N'', 2, N'', 14, 325, N'090bf53f807e387df238f03d13a256f4bbdf8d203fe8cfa17d4fa8373b507e6a', N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (327, NULL, NULL, N'19 July', CAST(N'11:24:00' AS Time), CAST(N'13:24:00' AS Time), 4, 60, N'paid', 2, NULL, NULL, 326, N'c712419bbfe9e92a4f9dcbe736d29d0cfea01bc73db0521fe72fdae7e8087877', N'History Tour Event', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (330, NULL, 4, N'2024-04-18', CAST(N'14:03:00' AS Time), CAST(N'15:33:00' AS Time), 2, 20, N'Confirmed', 4, N'noting', NULL, NULL, NULL, N'saasd', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (331, NULL, 4, N'2024-04-26', CAST(N'22:22:00' AS Time), CAST(N'23:22:00' AS Time), 1, 10, N'Pending', 4, N'sajkbhfh', NULL, NULL, NULL, N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (332, NULL, 4, N'2024-04-26', CAST(N'22:22:00' AS Time), CAST(N'23:22:00' AS Time), 1, 10, N'Pending', 4, N'sajkbhfh', NULL, NULL, NULL, N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (333, NULL, 3, N'2024-04-11', CAST(N'17:00:00' AS Time), CAST(N'19:00:00' AS Time), 2, 20, N'scanned', 4, N'fre', 8, 327, N'2795700588a0ead9d388c02efd51089182e32c3a4190433f7902274bf6329c68', N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (334, NULL, NULL, N'19 July', CAST(N'11:24:00' AS Time), CAST(N'13:24:00' AS Time), 1, 17.5, N'paid', 4, NULL, NULL, 327, N'3d2a29a5fa2018453f7eb4199ae6056f196f87c1870b3741ec11b63143775dbf', N'History Tour Event', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (335, NULL, 4, N'2024-04-19', CAST(N'19:00:00' AS Time), CAST(N'20:30:00' AS Time), 3, 40, N'unpaid', 4, N'rerace', 12, 328, NULL, N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (336, NULL, NULL, N'19 July', CAST(N'11:24:00' AS Time), CAST(N'13:24:00' AS Time), 3, 42.5, N'unpaid', 4, NULL, NULL, 328, NULL, N'History Tour Event', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (337, NULL, 4, N'2024-04-25', CAST(N'19:00:00' AS Time), CAST(N'20:30:00' AS Time), 2, 20, N'unpaid', 4, N'sad', 12, 329, NULL, N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (339, NULL, NULL, N'25 July', CAST(N'16:00:00' AS Time), CAST(N'19:00:00' AS Time), 1, 17.5, N'paid', 2, NULL, NULL, 330, N'6f7e2ea0b555e8264ec6f46dd94d4458f5e8b1e2106b6ea3d5e22d64f4fed0e8', N'History Tour Event', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (340, NULL, 6, N'2024-04-09', CAST(N'16:30:00' AS Time), CAST(N'18:00:00' AS Time), 2, 20, N'paid', 2, N'', 17, 331, N'df4033497047e8dbe43511dd2bb875a671eca2ceb488aebb40f8febc0b73f76c', N'Yummy', CAST(9 AS Decimal(18, 0)))
INSERT [dbo].[orderItem] ([orderItemId], [historyId], [restaurantSectionId], [date], [startTime], [endTime], [numberOfTickets], [price], [status], [userId], [specialRequest], [sessionId], [orderId], [qrHash], [eventName], [vatPercentage]) VALUES (341, NULL, NULL, N'19 July', CAST(N'11:24:00' AS Time), CAST(N'13:24:00' AS Time), 1, 17.5, N'unpaid', 4, NULL, NULL, 332, NULL, N'History Tour Event', CAST(9 AS Decimal(18, 0)))
SET IDENTITY_INSERT [dbo].[orderItem] OFF
GO
SET IDENTITY_INSERT [dbo].[Pages] ON 

INSERT [dbo].[Pages] ([pageId], [pageTitle], [pageLink]) VALUES (1, N'Home', N'/home/index')
INSERT [dbo].[Pages] ([pageId], [pageTitle], [pageLink]) VALUES (2, N'History', N'/history')
INSERT [dbo].[Pages] ([pageId], [pageTitle], [pageLink]) VALUES (3, N'Yummy', N'/restaurant/yummyHome')
INSERT [dbo].[Pages] ([pageId], [pageTitle], [pageLink]) VALUES (4, N'YummyDetail', NULL)
SET IDENTITY_INSERT [dbo].[Pages] OFF
GO
SET IDENTITY_INSERT [dbo].[Paragraph] ON 

INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (4, 4, N'<p>The Festival is opened from 15:00(3pm) to 23:00(11pm). This means you’ll be able to visit the festival at your own leisure between those times.
 
Do you want to get away from the summer weather and be a part of a fun activity? You can! Everything is possible!
 By reserving your spot and good planning your time you can be apart of multiple events. Between 15:00 and 23:00 there will be things to do in the entire Haarlem city.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (5, 5, N'<p>Kick off the festivities with a wondrous adventure for the family. ''The Secret of Professor Teyler'' invites kids and adults alike to solve intriguing science puzzles at the Teylers Museum. It''s a quest that sparks imagination and unveils the mysteries of our world!</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (6, 6, N'<p>As the evening sets in, prepare to dance the night away with DANCE! World-class DJs will turn up the beats, offering a soundtrack for everyone to groove to under the vibrant Haarlem sky. And we have some Top DJ''s.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (7, 7, N'<p>Food enthusiasts, get ready to indulge in ''Yummy!'', a delectable tour of Haarlem''s gastronomic delights. Sample exquisite dishes and explore an array of local and international cuisines.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (8, 8, N'<p>Take a step back in time with a historical stroll through Haarlem''s landmarks. Learn about our rich heritage and experience the city''s beauty up close.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (9, 9, N'<p>Curious yet? The Festival is a celebration for all—perfect for making summer memories. Tell your friends, bring your family, and don''t miss out on Haarlem''s biggest event of the year. We''re excited to welcome you to this unforgettable celebration. Your journey through discovery, taste, and excitement starts here!</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (10, 12, N'<p>Welcome to Yummy Festival in Haarlem! Get ready for a flavor adventure in our charming city. We''re bringing tastes from around the world the beautiful city of Haarlem from Thursday, 25 July to Sunday, 28 July 2024! With a variety of dishes to explore, you''re sure to find your new favorite. It''s a celebration of food, fun, and community. So come join us, and let''s make some delicious memories together!</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (11, 13, N'<p>1. Choose a Restaurant: Look through our exciting lineup and pick your favorites. 2. Make a Reservation: Book your spot online. There''s a €10 reservation fee, which will be taken off your final restaurant bill. 3. Special Requests: If you have specific food needs or other requests, simply let the restaurant know when booking. 4. Enjoy the Experience: Show up at your chosen time, and enjoy the great food and atmosphere. We''re here to help you have a great time at the Yummy Festival. See you there!</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (12, 1, N'<p>In this event, we''ll take a fun tour of some really old places in Haarlem. We''ll start at the Church of St. Bavo and finish at the Hof van Bakenes.
 Oh, and there''s a cool break in the middle at the Jopenkerk! You can grab a tasty local beer there and maybe meet some new friends who also love history. It''s going to be a great time exploring and learning about Haarlem''s past!</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (13, 17, N'<p>Discover Haarlem’s Festival Events And Kids Events</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (14, 18, N'<p>Step into Specktakel, a culinary gem in the heart of Haarlem, celebrated for bringing global tastes to your table. As part of the Yummy event, our chefs showcase a menu bursting with international dishes, right in the city''s historic center. It''s a place where every meal is a journey, and every flavor tells a story. Join us to experience the world through our kitchen during this special festival.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (15, 20, N'<p>The tour is given in 3 languages, English, Dutch and Chinese.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (16, 20, N'<p>Groups will consist of 12 participants and 1 tour guide.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (17, 20, N'<p>A giant flag will mark the starting location.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (18, 20, N'<p>Every participant can enjoy one drink with the ticket.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (19, 20, N'<p>Due to the nature of the walk, participants must be a minimum of 12 years old and no strollers are allowed.</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (21, 23, N'<p>Discover Haarlem''s Festival Events And Kids Events</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (46, 3, N'<p>Discover the heart and soul of Haarlem this summer at <strong>The Haarlem Festival</strong>. Over four exhilarating days, from <strong>Thursday, 25 July to Sunday, 28 July 2024</strong>! We invite you to immerse yourself in a vibrant tapestry of culture, music, gastronomy, and history. Experience dance to the tunes of world-class DJs, enjoy yummy foods, take a historical stroll through our city&rsquo;s landmarks, and unlock the wonders of science with your kids at ''The Secret of Professor Teyler!</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (47, 3, N'<p>Are you curious? Then this Festival is meant for you! Everyone is welcome! Take someone with you or tell others about this event. We would love to see you on this summer!</p>')
INSERT [dbo].[Paragraph] ([paragraphId], [sectionId], [text]) VALUES (48, 3, N'<p>The greatest events, all packed into one unforgettable celebration from June 27 to June 30 2024. Your journey starts here!</p>')
SET IDENTITY_INSERT [dbo].[Paragraph] OFF
GO
SET IDENTITY_INSERT [dbo].[payment] ON 

INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (1, 20, 11, N'open', N'tr_eWRXPrKv6B', N'https://www.mollie.com/checkout/select-issuer/ideal/eWRXPrKv6B', CAST(N'2024-03-26T21:58:56.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (5, 22, 13, N'Paid', N'tr_E4q2mzh8Bn', N'https://www.mollie.com/checkout/select-issuer/ideal/E4q2mzh8Bn', CAST(N'2024-03-27T14:54:50.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (6, 23, 14, N'Paid', N'tr_FYkLFmEHLb', N'https://www.mollie.com/checkout/select-issuer/ideal/FYkLFmEHLb', CAST(N'2024-03-27T15:27:55.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (16, 1, 67, N'paid', N'tr_jVP3BtWRQM', N'https://www.mollie.com/checkout/select-issuer/ideal/jVP3BtWRQM', CAST(N'2024-04-06T12:13:29.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (17, 1, 67, N'paid', N'tr_VqBk69hDCm', N'https://www.mollie.com/checkout/select-issuer/ideal/VqBk69hDCm', CAST(N'2024-04-07T09:19:08.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (19, 1, 67, N'open', N'tr_vNeyFnHGZ7', N'https://www.mollie.com/checkout/select-issuer/ideal/vNeyFnHGZ7', CAST(N'2024-04-07T09:30:44.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (20, 1, 286, N'paid', N'tr_w9asdH4zxR', N'https://www.mollie.com/checkout/select-issuer/ideal/w9asdH4zxR', CAST(N'2024-04-07T09:39:40.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (21, 1, 287, N'paid', N'tr_68r8D78NyV', N'https://www.mollie.com/checkout/select-issuer/ideal/68r8D78NyV', CAST(N'2024-04-07T09:40:26.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (22, 1, 288, N'paid', N'tr_qxeWKJqsMf', N'https://www.mollie.com/checkout/select-issuer/ideal/qxeWKJqsMf', CAST(N'2024-04-07T14:53:44.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (23, 2, 289, N'paid', N'tr_23ufSXZFEV', N'https://www.mollie.com/checkout/select-issuer/ideal/23ufSXZFEV', CAST(N'2024-04-07T15:01:10.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (24, 1, 290, N'paid', N'tr_E3y9MB5LFh', N'https://www.mollie.com/checkout/select-issuer/ideal/E3y9MB5LFh', CAST(N'2024-04-07T15:18:29.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (25, 2, 291, N'paid', N'tr_HqSb7hJfXB', N'https://www.mollie.com/checkout/select-issuer/ideal/HqSb7hJfXB', CAST(N'2024-04-07T15:48:18.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (26, 2, 292, N'paid', N'tr_aE6E8DQgtm', N'https://www.mollie.com/checkout/select-issuer/ideal/aE6E8DQgtm', CAST(N'2024-04-07T15:56:22.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (27, 2, 293, N'paid', N'tr_wSUkhpVGUA', N'https://www.mollie.com/checkout/select-issuer/ideal/wSUkhpVGUA', CAST(N'2024-04-07T16:01:05.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (28, 2, 294, N'paid', N'tr_ouUbiZWpTV', N'https://www.mollie.com/checkout/select-issuer/ideal/ouUbiZWpTV', CAST(N'2024-04-07T16:04:42.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (29, 2, 295, N'paid', N'tr_7RWiR8TwDk', N'https://www.mollie.com/checkout/select-issuer/ideal/7RWiR8TwDk', CAST(N'2024-04-07T16:07:31.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (30, 2, 296, N'paid', N'tr_sV8kX9Vi7R', N'https://www.mollie.com/checkout/select-issuer/ideal/sV8kX9Vi7R', CAST(N'2024-04-07T16:18:19.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (31, 2, 297, N'paid', N'tr_hksdujxa4w', N'https://www.mollie.com/checkout/select-issuer/ideal/hksdujxa4w', CAST(N'2024-04-07T16:32:49.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (32, 2, 298, N'paid', N'tr_JTtTnuGX7t', N'https://www.mollie.com/checkout/select-issuer/ideal/JTtTnuGX7t', CAST(N'2024-04-07T16:39:25.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (33, 1, 299, N'paid', N'tr_b9CfT3i7y6', N'https://www.mollie.com/checkout/select-issuer/ideal/b9CfT3i7y6', CAST(N'2024-04-07T17:05:54.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (34, 2, 300, N'paid', N'tr_D3B34XWJM2', N'https://www.mollie.com/checkout/select-issuer/ideal/D3B34XWJM2', CAST(N'2024-04-07T17:11:24.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (35, 2, 301, N'paid', N'tr_mohwdkCcs6', N'https://www.mollie.com/checkout/select-issuer/ideal/mohwdkCcs6', CAST(N'2024-04-07T17:20:13.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (36, 2, 302, N'paid', N'tr_SnAfuKBjpg', N'https://www.mollie.com/checkout/select-issuer/ideal/SnAfuKBjpg', CAST(N'2024-04-07T17:24:05.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (37, 2, 303, N'paid', N'tr_9d6yizSuSJ', N'https://www.mollie.com/checkout/select-issuer/ideal/9d6yizSuSJ', CAST(N'2024-04-07T17:47:58.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (38, 2, 304, N'paid', N'tr_Do3MbwSh7Z', N'https://www.mollie.com/checkout/select-issuer/ideal/Do3MbwSh7Z', CAST(N'2024-04-07T17:56:35.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (39, 2, 305, N'paid', N'tr_MSM3ZjXGzW', N'https://www.mollie.com/checkout/select-issuer/ideal/MSM3ZjXGzW', CAST(N'2024-04-08T13:14:48.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (40, 2, 306, N'paid', N'tr_jZnrkqHVkq', N'https://www.mollie.com/checkout/select-issuer/ideal/jZnrkqHVkq', CAST(N'2024-04-08T13:21:15.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (41, 2, 307, N'paid', N'tr_95BaFTFNSS', N'https://www.mollie.com/checkout/select-issuer/ideal/95BaFTFNSS', CAST(N'2024-04-08T13:32:24.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (42, 2, 308, N'paid', N'tr_Uc2CNiHav7', N'https://www.mollie.com/checkout/select-issuer/ideal/Uc2CNiHav7', CAST(N'2024-04-08T13:40:44.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (43, 2, 309, N'paid', N'tr_zp7UrumAp3', N'https://www.mollie.com/checkout/select-issuer/ideal/zp7UrumAp3', CAST(N'2024-04-08T13:43:34.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (47, 2, 312, N'paid', N'tr_iLAg4TcWJR', N'https://www.mollie.com/checkout/select-issuer/ideal/iLAg4TcWJR', CAST(N'2024-04-08T14:43:34.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (48, 2, 320, N'paid', N'tr_hM3FpXnAjm', N'https://www.mollie.com/checkout/select-issuer/ideal/hM3FpXnAjm', CAST(N'2024-04-08T16:25:19.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (49, 2, 322, N'paid', N'tr_pjE3wPuPr3', N'https://www.mollie.com/checkout/select-issuer/ideal/pjE3wPuPr3', CAST(N'2024-04-08T16:47:52.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (50, 2, 323, N'paid', N'tr_RQcmeBzjXe', N'https://www.mollie.com/checkout/select-issuer/ideal/RQcmeBzjXe', CAST(N'2024-04-08T17:04:23.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (51, 2, 324, N'paid', N'tr_PUqNJk73Pg', N'https://www.mollie.com/checkout/select-issuer/ideal/PUqNJk73Pg', CAST(N'2024-04-08T17:06:31.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (52, 2, 325, N'paid', N'tr_cS5FrrgpyQ', N'https://www.mollie.com/checkout/select-issuer/ideal/cS5FrrgpyQ', CAST(N'2024-04-08T17:41:49.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (53, 2, 326, N'paid', N'tr_x4yknQGFiT', N'https://www.mollie.com/checkout/select-issuer/ideal/x4yknQGFiT', CAST(N'2024-04-08T18:51:22.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (54, 4, 327, N'paid', N'tr_8p9JsuFMcY', N'https://www.mollie.com/checkout/select-issuer/ideal/8p9JsuFMcY', CAST(N'2024-04-08T19:38:08.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (55, 2, 330, N'paid', N'tr_ZrxVnSwkAw', N'https://www.mollie.com/checkout/select-issuer/ideal/ZrxVnSwkAw', CAST(N'2024-04-08T22:09:35.000' AS DateTime))
INSERT [dbo].[payment] ([paymentId], [userId], [orderId], [paymentStatus], [paymentCode], [webhookURL], [paymentDate]) VALUES (56, 2, 331, N'paid', N'tr_xUiYKpbAWz', N'https://www.mollie.com/checkout/select-issuer/ideal/xUiYKpbAWz', CAST(N'2024-04-08T22:11:28.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[payment] OFF
GO
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (2, 1, N'Spaarne 96, 2011 CL Haarlem                                                                         ', N'info@ratatouillefoodandwine.nl                                                                                                                                                                                                                                                                              ', NULL, N'2250                                                                                                ', N'4500                                                                                                ', N'headerrrrr', N'Ratatouille    ', 50)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (3, 2, N'Spekstraatt 4, 2011 HM Haarlem                                                                      ', N'info@specktakel.nl                                                                                                                                                                                                                                                                                          ', NULL, N'17.4                                                                                                ', N'36                                                                                                  ', N'headerrrrr', N'Specktakel', 36)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (4, 3, N'Klokhuisplein 9, 2011 HK Haarlem                                                                    ', N'info@MLfoodand.nl                                                                                                                                                                                                                                                                                           ', NULL, N'22.5                                                                                                ', N'45                                                                                                  ', N'headerrrrr', N'Restaurant Ml', 60)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (5, 4, N'Klokhuisplein 9, 2011 HK Haarlem                                                                    ', N'info@MLfoodand.nl                                                                                                                                                                                                                                                                                           ', NULL, N'21                                                                                                  ', N'22                                                                                                  ', N'headerrrrr', N'Restaurant ML                                                                                       ', 60)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (6, 5, N'Botermarkt 17, 2011 XL Haarlem                                                                      ', N'info@Roemerfoodandwine.nl                                                                                                                                                                                                                                                                                   ', NULL, N'17.5                                                                                                ', N'35                                                                                                  ', N'headerrrrr', N'Caf&eacute; de Roemer', 35)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (7, 6, N'Grote Markt 13, 2011 RC Haarlem                                                                     ', N'info@GrandCafeBrinkmanfoodandwine.nl                                                                                                                                                                                                                                                                        ', NULL, N'17.5                                                                                                ', N'35                                                                                                  ', N'headerrrrr', N'Grand Cafe Brinkman                                                                                 ', 100)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (7, 7, N'Grote Markt 13, 2011 RC Haarlem                                                                     ', N'info@GrandCafeBrinkmanfoodandwine.nl                                                                                                                                                                                                                                                                        ', NULL, N'17.5                                                                                                ', N'35                                                                                                  ', N'headerrrrr', N'Grand Cafe Brinkman                                                                                 ', 100)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (2, 8, NULL, NULL, NULL, NULL, NULL, N'introductt', NULL, NULL)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (2, 9, NULL, NULL, NULL, N'Adult: €35.00                                                                                       ', N'Kids(-12): €17.50                                                                                   ', N'discriptio', N'Seating Capacity and Menu Highlights ', NULL)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (2, 10, NULL, NULL, NULL, NULL, NULL, N'yummyimage', N'Restaurant Gallery', NULL)
INSERT [dbo].[RestaurantSection] ([restaurantId], [restaurantSectionId], [location], [email], [phonenumber], [kidPrice], [adultPrice], [type], [restaurantName], [numberOfSeats]) VALUES (2, 11, N'Spaarne 96, 2011 CL Haarlem                                                                         ', N'info@ratatouillefoodandwine.nl                                                                                                                                                                                                                                                                              ', 235427270, NULL, NULL, N'contactInf', N'Connect With Us', NULL)
GO
SET IDENTITY_INSERT [dbo].[Sections] ON 

INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (2, 1, N'introduction', NULL, NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 2, N'header', N'', N'', NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 3, N'introduction', N'<h1>The Festival</h1>', N'', NULL, N'Read more')
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 4, N'subsection', N'<h2>Program</h2>', NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 5, N'subsection', N'<h2>The Secret of Professor Teyler</h2>', NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 6, N'subsection', N'<h2>DANCE!</h2>', NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 7, N'subsection', N'<h2>Yummy!</h2>', NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 8, N'subsection', N'<h2>Historic Haarlem</h2>', NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 9, N'subsection', NULL, NULL, NULL, N'Read less')
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 10, N'photosection', NULL, NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (1, 11, N'crossnavigation', N'<h1>Which route is right for you?</h1>', N'<h2>During the Festival, three routes have been mapped out for you.</h2>', NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (3, 12, N'header', N'<h1>Yummy 
Festival Haarlem</h1> ', N'<h2>25 July - 28 July</h2>', NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (3, 13, N'introduction', N'<h2>Joining the feast is easy!</h2>', N'<h4>Haarlem Festival > Yummy</h4>', NULL, N'Reserve now')
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (3, 14, N'card', N'<h2>Summer 2024 Yummy Event: The Restaurant Line-Up</h2>', NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (2, 15, N'header', N'<h1>Strolling Through History</h1>', N'<h2>25 - 28 July</h2>', NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (3, 17, N'marketing', N'<h2>Stroll through history!</h2>', NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (4, 18, N'header', NULL, NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (4, 19, N'header', NULL, NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (2, 20, N'list', NULL, NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (2, 21, N'card', N'<h2>Locations List</h2>', N'<h3>Yummy Locations</h3>', NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (2, 22, N'timetable', NULL, NULL, NULL, NULL)
INSERT [dbo].[Sections] ([pageId], [sectionId], [type], [heading], [subTitle], [list], [linkText]) VALUES (2, 23, N'marketing', N'<h2>YUMMY!</h2>', NULL, NULL, NULL)
SET IDENTITY_INSERT [dbo].[Sections] OFF
GO
SET IDENTITY_INSERT [dbo].[Session] ON 

INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (2, 1, CAST(N'18:00:00' AS Time), CAST(N'19:30:00' AS Time), 35)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (3, 1, CAST(N'19:30:00' AS Time), CAST(N'21:00:00' AS Time), 35)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (4, 1, CAST(N'21:00:00' AS Time), CAST(N'22:30:00' AS Time), 35)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (5, 2, CAST(N'17:00:00' AS Time), CAST(N'19:00:00' AS Time), 52)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (6, 2, CAST(N'19:00:00' AS Time), CAST(N'21:00:00' AS Time), 52)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (7, 2, CAST(N'21:00:00' AS Time), CAST(N'23:00:00' AS Time), 52)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (8, 3, CAST(N'17:00:00' AS Time), CAST(N'19:00:00' AS Time), 48)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (9, 3, CAST(N'19:00:00' AS Time), CAST(N'21:00:00' AS Time), 40)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (10, 3, CAST(N'21:00:00' AS Time), CAST(N'23:00:00' AS Time), 49)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (11, 4, CAST(N'17:30:00' AS Time), CAST(N'19:00:00' AS Time), 25)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (12, 4, CAST(N'19:00:00' AS Time), CAST(N'20:30:00' AS Time), 11)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (13, 4, CAST(N'20:30:00' AS Time), CAST(N'22:00:00' AS Time), 41)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (14, 5, CAST(N'17:00:00' AS Time), CAST(N'19:00:00' AS Time), 16)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (15, 5, CAST(N'19:00:00' AS Time), CAST(N'21:00:00' AS Time), 19)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (16, 5, CAST(N'21:00:00' AS Time), CAST(N'23:00:00' AS Time), 96)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (17, 6, CAST(N'16:30:00' AS Time), CAST(N'18:00:00' AS Time), 96)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (18, 6, CAST(N'18:00:00' AS Time), CAST(N'19:30:00' AS Time), 98)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (19, 6, CAST(N'19:30:00' AS Time), CAST(N'21:00:00' AS Time), 92)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (20, 7, CAST(N'17:30:00' AS Time), CAST(N'19:00:00' AS Time), 36)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (21, 7, CAST(N'19:00:00' AS Time), CAST(N'20:30:00' AS Time), 26)
INSERT [dbo].[Session] ([sessionId], [restaurantSectionId], [startTime], [endTime], [numberOfSeats]) VALUES (22, 7, CAST(N'20:30:00' AS Time), CAST(N'22:00:00' AS Time), 46)
SET IDENTITY_INSERT [dbo].[Session] OFF
GO
SET IDENTITY_INSERT [dbo].[User] ON 

INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'dipika', N'bdipika076@gmail.com', N'Haarlemm', 1234567891, N'$2y$10$g32qJPMrvKpnUoLX69rOSu7kl3Rgy49Dkcvu7jSeVxd7tdEZox/fK', NULL, NULL, N'../img/769c004d8343628087a50fe5953f6eca.png', N'Administrator', NULL, 1, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'maike', N'maikepierick98@gmail.com', N'Rockplein 23, 2033KK Haarlem', 123456789, N'$2y$10$X9C/zRM0y7kXjOMgBWFJQuCNjngq5FDL9lAyD1aZoUQikAwYyHWoa', N'$2y$10$QEVoA6lp1.Poze0LVrro1ePIAvPaDllmVs2ut/JGs719LSI6.JUUa', CAST(N'2024-04-08T10:53:32.000' AS DateTime), NULL, N'Administrator', NULL, 2, N'Maike', N'Pierick')
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'testt', N'haarlemm.festival24@gmail.com', N'Test', 123456789, N'$2y$10$pLHCNV93ZygKphJX9rorleHNoEsyjYsoiGSxtT9NqFxWVi919dS7m', NULL, NULL, N'blankPerson.png', N'Customer', NULL, 3, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'ador', N'adordawit4@gmail.com', N'Leiden', 12345678, N'$2y$10$pDaPFm5.3OF7afholn/IJOJQz6iUnO7o4Bx9Pauf7zF8VogRBSjhG', NULL, NULL, N'../img/296fc2ceedbb03cbee8badff3e0399b8.png', N'Administrator', CAST(N'2024-03-07T20:43:56.0000000' AS DateTime2), 4, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'testing', N'not@gmail.com', N'amsterdam', 1234567890, N'$2y$10$rMxSvMkOORLfTZhi6KE9cuY7DSJIwZdXmfk/NxrwHBOnmKiGpQ3ku', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-04T20:46:53.2800000' AS DateTime2), 6, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'hihi', N'bdipika076@gmail.com', N'amsterdam', 12345678, N'$2y$10$dv1CQr/MaH4oQHj9828EbOVM8OFDcXS9EoFEDi1WJvJorHFdxzVh2', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-21T16:28:24.5633333' AS DateTime2), 14, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'hihi', N'bdipika076@gmail.com', N'amsterdam', 12345678, N'$2y$10$sJWiROODfn4iFatRAawdFOBH9/h2x45KVVfV4BpfY9cUkw6vNcEV2', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-21T16:28:49.1766667' AS DateTime2), 15, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'hi', N'bdipika076@gmail.com', N'amsterdam', 12345678, N'$2y$10$iVcANA9eWWsHw7XmYuVDxug6iKIwFnhDmnoD.SHAaWq0eR0eu9frG', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-23T11:05:09.6600000' AS DateTime2), 16, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'dipsika', N'dipsika@gmail.com', N'amsterdam', 12345678, N'$2y$10$qhKurDXqKtmwjdY8DACr3egWgAi5O3Ef5DFwn6yExCPFLwdKYpD0m', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-23T15:54:23.0566667' AS DateTime2), 17, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'heh', N'dil@gmail.com', N'amsterdam', 12345678, N'$2y$10$NrOKxz46qEcJTk1d906m4./PFn3549lHfY.rRyZJI1LUWvSQcO00a', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-23T16:14:45.0466667' AS DateTime2), 18, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'heh', N'dil@gmail.com', N'amsterdam', 12345678, N'$2y$10$Vzk124iimTSNTPxuI9mf/O.ZCovLtJ2budFAYgRZjePcmRcrbdaUi', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-23T16:52:48.2066667' AS DateTime2), 19, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'heh', N'dil@gmail.com', N'amsterdam', 12345678, N'$2y$10$vIClJJoO4eS7h0.0lAzcwu7XaUhXkRdv8Q1ZADlyMdEgaCkI6O5LS', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-23T17:31:51.6900000' AS DateTime2), 20, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'tester', N'not@gmail.com', N'amsterdam', 1234567890, N'$2y$10$UcDNN7iqlH/W2ihLkv24hu.UnMFZkHHK/Yy2a9DcuR9SEIJM3QnmK', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-27T11:12:38.7500000' AS DateTime2), 21, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'test1', N'not@gmail.com', N'amsterdam', 1234567890, N'$2y$10$9/QGks/gq4okrEUi7.SrSeCbL0WjDHIhD0ryE8S8FofmWrYNNsJrq', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-27T13:28:04.4100000' AS DateTime2), 22, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'dawood', N'not@gmail.com', N'amsterdam', 1234567890, N'$2y$10$AI6LntlhK9LPq1vR9rG.8OgnGGNJAC3pqjfTWxWNWGdKExtkARQg6', NULL, NULL, N'blankPerson.png', N'Customer', CAST(N'2024-03-27T14:26:51.8600000' AS DateTime2), 23, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'nati', N'adorf@gmail.com', N'Leiden', 1234567899, N'$2y$10$iZNvtFlajIbCrVHiojhsyenU0WLIUeM73VymK7IGCktZYqEH31imS', NULL, NULL, NULL, N'user', CAST(N'2024-04-08T17:13:52.0000000' AS DateTime2), 27, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'nati', N'adorf@gmail.com', N'Leiden', 1234567899, N'$2y$10$MNu91zxobMfRVThLexuYqefFLPYyH.7ULEqKcBC7.0wk1mkM/PASa', NULL, NULL, NULL, N'user', CAST(N'2024-04-08T17:13:55.0000000' AS DateTime2), 28, NULL, NULL)
INSERT [dbo].[User] ([username], [email], [address], [phonenumber], [password], [reset_token_hash], [reset_token_expires_at], [picture], [role], [registered_at], [id], [firstName], [lastName]) VALUES (N'testadmin', N'haarlem.festival24@gmail.com', N'Testaddress', 123456789, N'$2y$10$xfes3U843Qch3X6rkHL2FumJYKpD0pSpxqMnJ1AUQgk/rvh9AKSOq', NULL, NULL, NULL, N'Administrator', CAST(N'2024-04-08T20:19:59.0000000' AS DateTime2), 29, NULL, NULL)
SET IDENTITY_INSERT [dbo].[User] OFF
GO
INSERT [dbo].[YummyImage] ([YummyImageId], [restaurantSectionId], [imagePath], [imageName]) VALUES (1, 10, N'/img/yummyImages/img.png', N'image1')
INSERT [dbo].[YummyImage] ([YummyImageId], [restaurantSectionId], [imagePath], [imageName]) VALUES (2, 10, N'/img/yummyImages/img_1.png', N'image2')
INSERT [dbo].[YummyImage] ([YummyImageId], [restaurantSectionId], [imagePath], [imageName]) VALUES (3, 10, N'/img/yummyImages/img_2.png', N'image3')
INSERT [dbo].[YummyImage] ([YummyImageId], [restaurantSectionId], [imagePath], [imageName]) VALUES (4, 10, N'/img/yummyImages/img_3.png', N'image4')
INSERT [dbo].[YummyImage] ([YummyImageId], [restaurantSectionId], [imagePath], [imageName]) VALUES (5, 1, N'/img/yummyImages/img_6.png', N'image6')
GO
INSERT [dbo].[YummyLocation] ([YummyLocationId], [restaurantSectionId], [restaurantId], [Location], [Long], [Lati]) VALUES (1, 1, 1, N'Teds, Spaarne 94, 2011 CL Haarlem, Netherlands', CAST(4.637591 AS Decimal(9, 6)), CAST(52.378751 AS Decimal(8, 6)))
INSERT [dbo].[YummyLocation] ([YummyLocationId], [restaurantSectionId], [restaurantId], [Location], [Long], [Lati]) VALUES (2, 2, 2, N'Specktakel, Spekstraat 4, 2011 HM Haarlem, Netherlands', CAST(4.636115 AS Decimal(9, 6)), CAST(52.380780 AS Decimal(8, 6)))
INSERT [dbo].[YummyLocation] ([YummyLocationId], [restaurantSectionId], [restaurantId], [Location], [Long], [Lati]) VALUES (3, 3, 3, N'Klokhuisplein 9, 2011 HK Haarlem', CAST(4.636830 AS Decimal(9, 6)), CAST(52.380840 AS Decimal(8, 6)))
INSERT [dbo].[YummyLocation] ([YummyLocationId], [restaurantSectionId], [restaurantId], [Location], [Long], [Lati]) VALUES (4, 4, 4, N'Fris, Twijnderslaan 7, 2012 BG Haarlem, Netherlands', CAST(4.634163 AS Decimal(9, 6)), CAST(52.372253 AS Decimal(8, 6)))
INSERT [dbo].[YummyLocation] ([YummyLocationId], [restaurantSectionId], [restaurantId], [Location], [Long], [Lati]) VALUES (5, 5, 5, N'Botermarkt 17, 2011 XL Haarlem', CAST(4.643560 AS Decimal(9, 6)), CAST(52.383706 AS Decimal(8, 6)))
INSERT [dbo].[YummyLocation] ([YummyLocationId], [restaurantSectionId], [restaurantId], [Location], [Long], [Lati]) VALUES (6, 6, 6, N'Grand Cafe Brinkmann, Grote Markt 13, 2011 RC Haarlem, Netherlands', CAST(4.636151 AS Decimal(9, 6)), CAST(52.381650 AS Decimal(8, 6)))
INSERT [dbo].[YummyLocation] ([YummyLocationId], [restaurantSectionId], [restaurantId], [Location], [Long], [Lati]) VALUES (7, 7, 7, N'Oude Groenmarkt, 2011 HL Haarlem, Netherlands', CAST(4.637305 AS Decimal(9, 6)), CAST(52.380775 AS Decimal(8, 6)))
GO
INSERT [dbo].[YummyParagraph] ([YummyParagraphId], [restaurantSectionId], [text]) VALUES (1, 1, N'Welcome to Ratatouille in Haarlem, where good food and cozy dining come together. Our chef, Jozua Jaring, has brought his dream to life with a restaurant that blends French cooking with a modern touch. Since we opened in 2013, we''ve made a name for ourselves with delicious meals that won''t break the bank. In 2015, we moved to our current spot by the beautiful Spaarne river. It''s a special place with history in every corner. Come visit us for a taste of France right here in Haarlem, where every bite is a mix of classic and new!')
INSERT [dbo].[YummyParagraph] ([YummyParagraphId], [restaurantSectionId], [text]) VALUES (2, 2, N'Step into Specktakel, a culinary gem in the heart of Haarlem, celebrated for bringing global tastes to your table. As part of the Yummy event, our chefs showcase a menu bursting with international dishes, right in the city''s historic center. It''s a place where every meal is a journey, and every flavor tells a story. Join us to experience the world through our kitchen during this special festival.')
INSERT [dbo].[YummyParagraph] ([YummyParagraphId], [restaurantSectionId], [text]) VALUES (3, 8, N'Ready to experience the magic of Specktakel? Reserve your table now and secure a spot at one of Haarlem''s culinary gems. A €10 reservation fee applies, which will be deducted from your bill. Don’t miss out on this gastronomic delight!"')
INSERT [dbo].[YummyParagraph] ([YummyParagraphId], [restaurantSectionId], [text]) VALUES (4, 9, N'Savor the ambience at Specktakel, where we accommodate 36 guests in our globally-inspired haven. Our menu is a mosaic of tastes, presenting an eclectic mix of European, International, and Asian dishes that promise a gastronomic adventure.')
INSERT [dbo].[YummyParagraph] ([YummyParagraphId], [restaurantSectionId], [text]) VALUES (5, 11, N'Got a question or just want to say hello?')
GO
SET IDENTITY_INSERT [dbo].[Yummyyy] ON 

INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (2, 14, N'Ratatouilleee     ', N'Spaarne 96, 2011 CL Haarlem                                                                         ', 52, N'../img/Specktakel.png', N'Wine                    Cocktails                  Coffee                          Healthy options        Plates Spirits Wine                                                                                                                                                                              ', N'Types of food offered:
🍽️ French, fish and seafood, European

💫 Exclusive Experience: Enjoy an exceptional evening at Ratatouille, where indulgence meets elegance. Join as for exclusive experience at Yummy event!', NULL, N'Wheelchair-accessible seating                                                                                                                                                                                                                                  ', CAST(2250.00 AS Decimal(10, 2)), CAST(4500.00 AS Decimal(10, 2)), NULL, N'info@ratatouillefoodandwine.nl')
INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (3, 14, N'Specktakel                                                                                          ', N'Spekstraat 4, 2011 HM Haarlem                                                                       ', 36, N'../img/Specktakel.png', N'Wine                    Cocktails               Coffee                  Healthy options                                                                                                                                                                                                                     ', N'Types of food offered:
🍽️ Europees, Internationaal,Aziatisch

🍷 Wine & Dine Delight:  Enjoy a harmonious blend of world-class wines paired with our spice-infused culinary creations, offering a universally appealing taste experience for all!', NULL, N'Reservation only                                                                                                                                                                                                                                               ', CAST(17.50 AS Decimal(10, 2)), CAST(17.50 AS Decimal(10, 2)), NULL, N'info@specktakel.nl                                                                                                                                                                                                                                             ')
INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (4, 14, N'Restaurant ML                                                                                       ', N'Klokhuisplein 9, 2011 HK Haarlem ', 60, N'../img/RestaurantML.png', N'Wine                    Cocktails               Coffee           Healthy options                                                                                                                                                                                                                            ', N'Types of food offered:
🍽️ Dutch, fish and seafood, European

💫 Exclusive Experience: Enjoy an exceptional evening at ML Restaurant.
ML has been providing a place for delicious dining, drinks, parties, meetings and accommodations since 2018.', NULL, N'
Dine-In                                                                                                                                                                                                                                                       ', CAST(22.00 AS Decimal(10, 2)), CAST(22.00 AS Decimal(10, 2)), NULL, N'info@MLfoodand.nl                                                                                                                                                                                                                                              ')
INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (5, 14, N'Restaurant Fris ', N'Twijnderslaan 7, 2012 BG Haarlem ', 45, N'../img/RestaurantFris.png', N'Wine                    Cocktails               Coffee           Healthy options                                                                                                                                                                                                                            ', N'Types of food offered:
🍽️ Dutch, French, European

💫  Memorable Moments: Fris invites you to a superb dining experience, worth every moment and penny. Anticipate a return trip, as each visit leaves an imprint of culinary excellence.', NULL, N'Wheelchair-accessible entrance                                                                                                                                                                                                                                 ', CAST(22.50 AS Decimal(10, 2)), CAST(45.00 AS Decimal(10, 2)), NULL, N'info@Frisfoodandwine.nl                                                                                                                                                                                                                                        ')
INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (6, 14, N'Café de Roemer                                                                                      ', N'Botermarkt 17, 2011 XL Haarlem                                                                      ', 35, N'../img/CafédeRoemer.png', N'Alcohol  Beer             Cocktails               Coffee           Late-night food, Small                                                                                                                                                                                                                   ', N'Types of food offered:
🍽️ Dutch, fish and seafood, European

☀️ Event Special: Join us at Café de Roemer to enjoy these delectable bites and bask in the warm embrace of the sun. An ideal choice for food lovers seeking a delightful ambiance at Yummy event.', NULL, N'Outdoor seating                                                                                                                                                                                                                                                ', CAST(17.50 AS Decimal(10, 2)), CAST(45.00 AS Decimal(10, 2)), NULL, N'info@Roemerfoodandwine.nl                                                                                                                                                                                                                                      ')
INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (7, 14, N'Grand Cafe Brinkman                                                                                 ', N'Grote Markt 13, 2011 RC Haarlem                                                                     ', 100, N'../img/GrandCafeBrinkman.png', N'Wine                    Cocktails               Coffee           Healthy options                                                                                                                                                                                                                            ', N'Types of food offered:
🍽️Dutch, European, Modern. Join us at Grand Cafe Brinkmann for delightful tastes and a welcoming atmosphere, right in the heart of Yummy 2024''s culinary celebration.', NULL, N'Wheelchair-accessible entrance                                                                                                                                                                                                                                 ', CAST(17.50 AS Decimal(10, 2)), CAST(35.00 AS Decimal(10, 2)), NULL, N'info@GrandCafeBrinkmanfoodandwine.nl                                                                                                                                                                                                                           ')
INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (8, 14, N'Bistro Toujours                                                                                     ', N'Oude Groenmarkt 10-12, 2011 HL Haarlem                                                              ', 50, N'../img/Urban.png', N'Wine                    Cocktails               Coffee           Healthy options                                                                                                                                                                                                                            ', N'Types of food offered:
🍽️Dutch, fish and seafood, European. 🌟 Service Excellence: From the moment you arrive, experience service that''s as outstanding as our cuisine, ensuring a memorable visit during the Yummy event.', NULL, N'Dogs allowed                                                                                                                                                                                                                                                   ', CAST(17.50 AS Decimal(10, 2)), CAST(35.00 AS Decimal(10, 2)), NULL, N'info@Toujoursfoodandwine.nl                                                                                                                                                                                                                                    ')
INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (20, 14, N'Restaurant Ml', N'dsaf', 22, N'../img/Specktakel.png', N'sfddd', N'sdf', NULL, NULL, CAST(2.00 AS Decimal(10, 2)), CAST(3.00 AS Decimal(10, 2)), NULL, N'adorf@gmail.com')
INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (21, 14, N'aass', N'fdevswgda', 22, N'../img/Specktakel.png', N'wafwafhyyyyyty', N'sdadaph', NULL, NULL, CAST(22.00 AS Decimal(10, 2)), CAST(22.00 AS Decimal(10, 2)), NULL, N'adorf@gmail.com')
INSERT [dbo].[Yummyyy] ([restaurantId], [sectionId], [restaurantName], [location], [numberOfSeats], [restaurantPicture], [foodOfferings], [description], [sessions], [service], [kidPrice], [adultPrice], [phonenumber], [email]) VALUES (22, 14, N'sdfddd', N'sdd', 1, NULL, N'wafffffjikk', N'fwd', NULL, NULL, CAST(1.00 AS Decimal(10, 2)), CAST(0.00 AS Decimal(10, 2)), NULL, N'adori@gmail.com')
SET IDENTITY_INSERT [dbo].[Yummyyy] OFF
GO
ALTER TABLE [dbo].[orderItem] ADD  CONSTRAINT [DF_orderItem_vatPercentage]  DEFAULT ((9)) FOR [vatPercentage]
GO
ALTER TABLE [dbo].[User] ADD  DEFAULT (getdate()) FOR [registered_at]
GO
ALTER TABLE [dbo].[CarouselItems]  WITH CHECK ADD  CONSTRAINT [FK_CarouselItems_Images] FOREIGN KEY([imageId])
REFERENCES [dbo].[Images] ([imageId])
GO
ALTER TABLE [dbo].[CarouselItems] CHECK CONSTRAINT [FK_CarouselItems_Images]
GO
ALTER TABLE [dbo].[CarouselItems]  WITH CHECK ADD  CONSTRAINT [FK_CarouselItems_Sections] FOREIGN KEY([sectionId])
REFERENCES [dbo].[Sections] ([sectionId])
GO
ALTER TABLE [dbo].[CarouselItems] CHECK CONSTRAINT [FK_CarouselItems_Sections]
GO
ALTER TABLE [dbo].[HistoryDetails]  WITH CHECK ADD  CONSTRAINT [FK_HistoryDetails_HistoryGuide] FOREIGN KEY([guideId])
REFERENCES [dbo].[HistoryGuide] ([guideId])
GO
ALTER TABLE [dbo].[HistoryDetails] CHECK CONSTRAINT [FK_HistoryDetails_HistoryGuide]
GO
ALTER TABLE [dbo].[HistoryDetails]  WITH CHECK ADD  CONSTRAINT [FK_HistoryDetails_Sections] FOREIGN KEY([sectionId])
REFERENCES [dbo].[Sections] ([sectionId])
GO
ALTER TABLE [dbo].[HistoryDetails] CHECK CONSTRAINT [FK_HistoryDetails_Sections]
GO
ALTER TABLE [dbo].[HistoryLocations]  WITH CHECK ADD  CONSTRAINT [FK_HistoryEvent_Sections] FOREIGN KEY([sectionId])
REFERENCES [dbo].[Sections] ([sectionId])
GO
ALTER TABLE [dbo].[HistoryLocations] CHECK CONSTRAINT [FK_HistoryEvent_Sections]
GO
ALTER TABLE [dbo].[Images]  WITH CHECK ADD  CONSTRAINT [FK_Images_Sections] FOREIGN KEY([sectionId])
REFERENCES [dbo].[Sections] ([sectionId])
GO
ALTER TABLE [dbo].[Images] CHECK CONSTRAINT [FK_Images_Sections]
GO
ALTER TABLE [dbo].[OpeningTime]  WITH CHECK ADD  CONSTRAINT [FK_OpeningTime_RestaurantSection] FOREIGN KEY([restaurantSectionId])
REFERENCES [dbo].[RestaurantSection] ([restaurantSectionId])
GO
ALTER TABLE [dbo].[OpeningTime] CHECK CONSTRAINT [FK_OpeningTime_RestaurantSection]
GO
ALTER TABLE [dbo].[orderItem]  WITH CHECK ADD  CONSTRAINT [FK_orderItem_HistoryDetails] FOREIGN KEY([historyId])
REFERENCES [dbo].[HistoryDetails] ([historyId])
GO
ALTER TABLE [dbo].[orderItem] CHECK CONSTRAINT [FK_orderItem_HistoryDetails]
GO
ALTER TABLE [dbo].[orderItem]  WITH CHECK ADD  CONSTRAINT [FK_orderItem_Order] FOREIGN KEY([orderId])
REFERENCES [dbo].[Order] ([orderId])
GO
ALTER TABLE [dbo].[orderItem] CHECK CONSTRAINT [FK_orderItem_Order]
GO
ALTER TABLE [dbo].[orderItem]  WITH CHECK ADD  CONSTRAINT [FK_orderItem_RestaurantSection] FOREIGN KEY([restaurantSectionId])
REFERENCES [dbo].[RestaurantSection] ([restaurantSectionId])
GO
ALTER TABLE [dbo].[orderItem] CHECK CONSTRAINT [FK_orderItem_RestaurantSection]
GO
ALTER TABLE [dbo].[orderItem]  WITH CHECK ADD  CONSTRAINT [FK_orderItem_User] FOREIGN KEY([userId])
REFERENCES [dbo].[User] ([id])
GO
ALTER TABLE [dbo].[orderItem] CHECK CONSTRAINT [FK_orderItem_User]
GO
ALTER TABLE [dbo].[Paragraph]  WITH CHECK ADD  CONSTRAINT [FK_Paragraph_Sections] FOREIGN KEY([sectionId])
REFERENCES [dbo].[Sections] ([sectionId])
GO
ALTER TABLE [dbo].[Paragraph] CHECK CONSTRAINT [FK_Paragraph_Sections]
GO
ALTER TABLE [dbo].[payment]  WITH CHECK ADD  CONSTRAINT [FK_payment_Order] FOREIGN KEY([orderId])
REFERENCES [dbo].[Order] ([orderId])
GO
ALTER TABLE [dbo].[payment] CHECK CONSTRAINT [FK_payment_Order]
GO
ALTER TABLE [dbo].[payment]  WITH CHECK ADD  CONSTRAINT [FK_payment_User] FOREIGN KEY([userId])
REFERENCES [dbo].[User] ([id])
GO
ALTER TABLE [dbo].[payment] CHECK CONSTRAINT [FK_payment_User]
GO
ALTER TABLE [dbo].[RestaurantSection]  WITH CHECK ADD  CONSTRAINT [FK_RestaurantSection_Yummyyy] FOREIGN KEY([restaurantId])
REFERENCES [dbo].[Yummyyy] ([restaurantId])
GO
ALTER TABLE [dbo].[RestaurantSection] CHECK CONSTRAINT [FK_RestaurantSection_Yummyyy]
GO
ALTER TABLE [dbo].[Sections]  WITH CHECK ADD  CONSTRAINT [FK_Sections_Pages] FOREIGN KEY([pageId])
REFERENCES [dbo].[Pages] ([pageId])
GO
ALTER TABLE [dbo].[Sections] CHECK CONSTRAINT [FK_Sections_Pages]
GO
ALTER TABLE [dbo].[Session]  WITH CHECK ADD  CONSTRAINT [FK_Session_RestaurantSection] FOREIGN KEY([restaurantSectionId])
REFERENCES [dbo].[RestaurantSection] ([restaurantSectionId])
GO
ALTER TABLE [dbo].[Session] CHECK CONSTRAINT [FK_Session_RestaurantSection]
GO
ALTER TABLE [dbo].[YummyImage]  WITH CHECK ADD  CONSTRAINT [FK_YummyImage_RestaurantSection] FOREIGN KEY([restaurantSectionId])
REFERENCES [dbo].[RestaurantSection] ([restaurantSectionId])
GO
ALTER TABLE [dbo].[YummyImage] CHECK CONSTRAINT [FK_YummyImage_RestaurantSection]
GO
ALTER TABLE [dbo].[YummyLocation]  WITH CHECK ADD  CONSTRAINT [FK_YummyLocation_RestaurantSection] FOREIGN KEY([restaurantSectionId])
REFERENCES [dbo].[RestaurantSection] ([restaurantSectionId])
GO
ALTER TABLE [dbo].[YummyLocation] CHECK CONSTRAINT [FK_YummyLocation_RestaurantSection]
GO
ALTER TABLE [dbo].[YummyParagraph]  WITH CHECK ADD  CONSTRAINT [FK_YummyParagraph_RestaurantSection] FOREIGN KEY([restaurantSectionId])
REFERENCES [dbo].[RestaurantSection] ([restaurantSectionId])
GO
ALTER TABLE [dbo].[YummyParagraph] CHECK CONSTRAINT [FK_YummyParagraph_RestaurantSection]
GO
ALTER TABLE [dbo].[Yummyyy]  WITH CHECK ADD  CONSTRAINT [FK_Yummyyy_Sections] FOREIGN KEY([sectionId])
REFERENCES [dbo].[Sections] ([sectionId])
GO
ALTER TABLE [dbo].[Yummyyy] CHECK CONSTRAINT [FK_Yummyyy_Sections]
GO
ALTER DATABASE [HaarlemFestivalDatabase] SET  READ_WRITE 
GO
