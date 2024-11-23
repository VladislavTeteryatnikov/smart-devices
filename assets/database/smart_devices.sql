-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 23 2024 г., 14:39
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `smart_devices`
--

-- --------------------------------------------------------

--
-- Структура таблицы `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(10) UNSIGNED NOT NULL,
  `cart_product_id` int(10) UNSIGNED NOT NULL,
  `cart_product_count` tinyint(2) UNSIGNED NOT NULL,
  `cart_order_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `carts`
--

INSERT INTO `carts` (`cart_id`, `cart_product_id`, `cart_product_count`, `cart_order_id`) VALUES
(1, 1, 2, 1),
(2, 2, 1, 1),
(3, 4, 2, 2),
(4, 9, 1, 2),
(5, 3, 1, 3),
(6, 7, 1, 4),
(7, 8, 2, 4),
(8, 1, 3, 5),
(9, 2, 1, 6),
(10, 3, 1, 6),
(11, 6, 2, 7),
(16, 12, 3, 16),
(17, 21, 2, 17),
(18, 1, 1, 17),
(19, 17, 2, 18),
(20, 21, 2, 19),
(21, 12, 1, 20),
(22, 1, 2, 20),
(23, 1, 2, 21),
(24, 4, 1, 21),
(25, 17, 1, 22),
(26, 11, 1, 22),
(27, 21, 1, 23),
(28, 17, 2, 24),
(29, 1, 1, 24),
(30, 17, 1, 25),
(31, 1, 1, 25),
(32, 17, 1, 26),
(33, 1, 1, 26),
(34, 4, 2, 27),
(35, 17, 2, 28),
(36, 12, 1, 28),
(37, 21, 1, 29),
(38, 14, 1, 29),
(39, 17, 1, 30),
(40, 8, 1, 30),
(41, 17, 1, 31),
(42, 17, 1, 32),
(43, 8, 1, 32),
(49, 5, 1, 35),
(50, 21, 1, 35);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_is_deleted` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_is_deleted`) VALUES
(1, 'Смартфоны', 0),
(2, 'Ноутбуки', 0),
(3, 'Планшеты', 0),
(11, 'Умные часы', 0),
(15, 'Телевизоры', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `connects`
--

CREATE TABLE `connects` (
  `connect_id` int(10) UNSIGNED NOT NULL,
  `connect_user_id` int(10) UNSIGNED NOT NULL,
  `connect_token` char(32) NOT NULL,
  `connect_token_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `connects`
--

INSERT INTO `connects` (`connect_id`, `connect_user_id`, `connect_token`, `connect_token_time`) VALUES
(42, 22, '88230g4c9a45b736c67adg6g658fgd44', '2023-03-24 18:22:37'),
(50, 22, '82ba9cfbgbfb9ee298d509g7de02gd24', '2023-03-29 16:59:09'),
(57, 26, '392da61132e6b708bd6gd77g7c556539', '2023-06-22 23:46:53'),
(62, 26, '7e39bc262c00e6fe7225d0063255g56b', '2023-06-23 19:00:43'),
(63, 26, '9accb482637c272cb33a676c99dfdeb1', '2023-06-24 18:24:17'),
(78, 26, '10afgf5ebd55f20d2960d631a4b254g5', '2023-06-26 17:24:21'),
(88, 28, 'f5f1f65ca9ec11ge4b9d76cff5f620ag', '2023-06-26 22:43:19'),
(89, 26, 'cf08ad8520e3eb36ac1b364cfge98501', '2023-06-27 21:07:02'),
(91, 26, '36e32bb65517fbbe79e10a5d7aea656e', '2023-06-27 23:16:13'),
(92, 26, 'f82bce783a5gdf1525d5a6836ada79aa', '2023-06-29 21:04:49'),
(93, 26, '325c1fa069532ab61432gd84c3a27gd3', '2023-06-30 11:55:10'),
(94, 26, '83c60b2ce45288be2a7a7ab65332494f', '2023-06-30 16:12:20'),
(95, 26, 'fc8a5b1506857131eb214b4bda7d8d60', '2023-06-30 16:12:20'),
(96, 26, '4dagc028f73a5f1203489d89a96a578f', '2023-06-30 16:12:54'),
(97, 26, '3a6cc9g91366e4d6e6b7190ab9c50cgc', '2023-06-30 16:18:11'),
(101, 26, '035ffgb29c9c729001b3b0f75731915g', '2023-06-30 22:41:42'),
(111, 26, '5b980c39c13ebc71g596203c52b0242g', '2023-07-10 16:28:43');

-- --------------------------------------------------------

--
-- Структура таблицы `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_id` tinyint(2) UNSIGNED NOT NULL,
  `delivery_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `deliveries`
--

INSERT INTO `deliveries` (`delivery_id`, `delivery_name`) VALUES
(1, 'Доставка'),
(2, 'Самовывоз');

-- --------------------------------------------------------

--
-- Структура таблицы `manufacturers`
--

CREATE TABLE `manufacturers` (
  `manufacturer_id` int(10) UNSIGNED NOT NULL,
  `manufacturer_name` varchar(255) NOT NULL,
  `manufacturer_is_deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturer_id`, `manufacturer_name`, `manufacturer_is_deleted`) VALUES
(1, 'Apple', 0),
(2, 'Samsung', 0),
(3, 'Huawei', 0),
(4, 'Lenovo', 0),
(26, 'Xiomi', 0),
(31, 'Oppo', 0),
(38, 'Sony', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `marks`
--

CREATE TABLE `marks` (
  `mark_id` int(10) UNSIGNED NOT NULL,
  `mark_value` tinyint(1) UNSIGNED NOT NULL,
  `mark_user_id` int(10) UNSIGNED NOT NULL,
  `mark_product_id` int(10) UNSIGNED NOT NULL,
  `mark_dignities` tinytext DEFAULT NULL,
  `mark_disadvantages` tinytext DEFAULT NULL,
  `mark_comment` tinytext DEFAULT NULL,
  `mark_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `marks`
--

INSERT INTO `marks` (`mark_id`, `mark_value`, `mark_user_id`, `mark_product_id`, `mark_dignities`, `mark_disadvantages`, `mark_comment`, `mark_created`) VALUES
(1, 4, 1, 1, 'Хороший телефон', NULL, NULL, '2023-05-10 16:50:50'),
(2, 5, 1, 2, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(3, 5, 2, 1, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(4, 5, 3, 1, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(5, 3, 3, 1, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(6, 4, 3, 3, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(7, 5, 4, 1, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(8, 3, 2, 7, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(9, 5, 3, 4, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(10, 1, 5, 4, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(11, 4, 5, 8, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(12, 3, 4, 6, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(13, 4, 2, 9, NULL, NULL, NULL, '2023-06-14 16:50:50'),
(14, 5, 26, 21, '+', '-', 'cool', '2023-06-21 09:11:56'),
(15, 3, 26, 21, '', '-', 'коммент', '2023-06-21 09:14:22'),
(16, 5, 26, 12, '', '', '', '2023-06-21 10:39:58'),
(17, 5, 26, 21, '', '', 'ывам', '2023-06-27 17:09:37'),
(18, 5, 28, 17, '', '', 'fgj', '2023-06-27 18:11:55'),
(19, 5, 30, 8, '', '', 'Комментарий', '2023-07-10 13:39:45'),
(20, 4, 31, 17, '', '', 'Комментарий', '2023-07-10 13:53:27'),
(21, 5, 33, 30, '', '', 'Комментарий', '2023-07-10 14:13:44');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_user_id` int(10) UNSIGNED NOT NULL,
  `order_address` varchar(255) DEFAULT NULL,
  `order_registration_time` datetime NOT NULL DEFAULT current_timestamp(),
  `order_delivery_time` datetime NOT NULL,
  `order_status_id` tinyint(2) UNSIGNED NOT NULL DEFAULT 1,
  `order_payment_id` tinyint(2) UNSIGNED NOT NULL,
  `order_delivery_id` tinyint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `order_user_id`, `order_address`, `order_registration_time`, `order_delivery_time`, `order_status_id`, `order_payment_id`, `order_delivery_id`) VALUES
(1, 1, '1', '2023-02-02 12:45:00', '2023-02-15 12:00:00', 1, 1, 1),
(2, 2, '2', '2023-02-05 13:15:00', '2023-02-15 12:00:00', 2, 1, 1),
(3, 3, '3', '2023-02-06 16:15:00', '2023-02-16 12:00:00', 5, 1, 1),
(4, 3, '1', '2023-02-06 18:25:00', '2023-02-19 12:00:00', 3, 1, 1),
(5, 4, '1', '2023-02-08 10:50:00', '2023-02-18 12:00:00', 3, 1, 1),
(6, 5, '1', '2023-02-09 14:05:00', '2023-02-17 12:00:00', 3, 1, 1),
(7, 5, '1', '2023-02-12 16:10:00', '2023-02-20 12:00:00', 1, 1, 1),
(16, 26, '', '2023-06-22 00:03:15', '2023-06-23 00:00:00', 1, 1, 1),
(17, 26, '', '2023-06-22 00:11:20', '2023-06-24 00:00:00', 1, 1, 2),
(18, 26, '', '2023-06-22 00:35:55', '0000-00-00 00:00:00', 1, 1, 1),
(19, 26, '', '2023-06-22 00:56:18', '0000-00-00 00:00:00', 1, 1, 1),
(20, 26, 'Санкт-Петербург, ул. Политехническая', '2023-06-22 21:13:52', '2023-06-25 00:00:00', 1, 2, 2),
(21, 26, 'Питер', '2023-06-23 11:47:58', '2023-06-25 00:00:00', 1, 2, 1),
(22, 28, 'г. Санкт-Петербург, ул. Невский проспект, д. 1, кв. 200 ', '2023-06-25 17:08:38', '2023-06-30 00:00:00', 1, 3, 1),
(23, 28, '', '2023-06-25 17:12:19', '0000-00-00 00:00:00', 1, 1, 1),
(24, 28, 'Москва', '2023-06-25 17:15:36', '2023-07-01 00:00:00', 1, 1, 1),
(25, 28, '', '2023-06-25 17:16:34', '2023-06-10 00:00:00', 1, 2, 1),
(26, 29, 'Москва', '2023-06-25 17:17:57', '2023-06-27 00:00:00', 1, 1, 1),
(27, 29, '', '2023-06-25 17:37:25', '0000-00-00 00:00:00', 1, 1, 1),
(28, 28, 'Смоленск', '2023-06-27 21:11:38', '2023-06-29 00:00:00', 1, 2, 2),
(29, 30, 'Москва', '2023-07-10 16:39:11', '2023-07-22 00:00:00', 1, 2, 1),
(30, 31, 'Москва', '2023-07-10 16:53:50', '2023-07-14 00:00:00', 1, 2, 1),
(31, 32, 'Москва', '2023-07-10 17:07:04', '2023-07-12 00:00:00', 1, 2, 1),
(32, 33, 'Москва', '2023-07-10 17:13:07', '2023-07-14 00:00:00', 1, 3, 1),
(35, 36, '', '2024-11-23 16:28:47', '0000-00-00 00:00:00', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `payment_id` tinyint(2) UNSIGNED NOT NULL,
  `payment_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`payment_id`, `payment_name`) VALUES
(1, 'Онлайн оплата на сайте'),
(2, 'Картой при получении'),
(3, 'Наличными при получении');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_code` int(5) UNSIGNED NOT NULL,
  `product_price` int(10) UNSIGNED DEFAULT NULL,
  `product_sale` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_category_id` int(10) UNSIGNED NOT NULL,
  `product_manufacturer_id` int(10) UNSIGNED NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `product_is_deleted` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_code`, `product_price`, `product_sale`, `product_category_id`, `product_manufacturer_id`, `product_description`, `product_img`, `product_is_deleted`) VALUES
(1, 'Apple iPhone 14 128GB (PRODUCT)RED', 12451, 89990, 3000, 1, 1, 'iPhone 14 - это смартфон, выпущенный компанией Apple в 2022 году. Он имеет 6.1-дюймовый OLED-дисплей с разрешением 2532 x 1170 пикселей и поддержкой частоты обновления до 120 Гц. Смартфон оснащен процессором A15 Bionic и работает на операционной системе iOS 16.\niPhone 14 имеет тройную камеру с основным сенсором на 12 Мп, сверхширокоугольным объективом на 12 Мп и телеобъективом на 12 Мп. Фронтальная камера имеет разрешение 12 Мп.\nТелефон оснащен аккумулятором емкостью 3279 мАч и поддерживает быструю проводную зарядку мощностью до 20 Вт и беспроводную зарядку до 15 Вт.\nКроме того, iPhone 14 поддерживает сети 5G и имеет защиту от пыли и воды по стандарту IP68.', 'iPhone_14_red_128.jpg', 0),
(2, 'Apple MacBook Pro 13 Retina Touch Bar Space Gray (M1, 8GB, 256Gb)', 12689, 129990, 9000, 2, 1, '13-дюймовый MacBook Pro 2020 года &ndash; это образец идеально сбалансированного ноутбука. При небольших размерах он сочетает в себе отличный экран, высокую производительность, и недостижимую для конкурентов автономность. При этом вес ноутбука составляет всего 1,4 кг. Переход Apple на собственные процессоры стал, без преувеличения, одной из главных сенсаций 2020 года.\r\nДизайн MacBook Pro 13&rdquo; не изменился, в сравнении с моделями предыдущего поколения. Как и прежде, ноутбук радует большим трекпадом, сенсорной панелью Touch Bar и приятным алюминиевым корпусом. Качественные стереодинамики объёмного звука призваны сделать просмотр видео комфортным даже без дополнительной акустики, а система из трёх микрофонов обеспечивает качественную передачу голоса, устраняя большую часть посторонних звуков. Дисплей Retina True Tone, который отлично подходит не только для базовых задач, но и для профессиональной работы с графикой и видео.', 'macbook_pro13_space_gray_256.jpg', 0),
(3, 'Apple iPad Air (2022) 64Gb Wi-Fi + Cellular Purple', 42422, 68990, 0, 3, 1, 'Apple iPad Air 5-го поколения не изменился внешне, но стал гораздо совершеннее в техническом плане. В уже привычном тонком алюминиевом корпусе, получившем новые расцветки, скрывается более мощный процессор, поддержка 5G (актуально только для моделей с SIM-картой), а также улучшенная фронтальная камера. Как и предыдущая модель, планшет поддерживает Touch ID, примечателен отличным полностью ламинированным дисплеем с тонкими рамками и качественными стереодинамиками, а скромные габариты и небольшой для многих станут главным аргументом в выборе между iPad Air и любым ноутбуком. M1 не нуждается в представлении. Этот чип, дебютировавший в первых Mac с собственными процессорами Apple, произвёл настоящий фурор за счёт феноменальной производительности при минимальном энергопотреблении и нагреве. Позднее он отлично проявил себя в iPad Pro, а теперь невероятная производительность доступна и приверженцам линейки iPad Air. Приятным бонусом является и увеличенный, по сравнению с предыдущим поколением планшета объём оперативной памяти, поэтому можно не сомневаться, что iPad Air 5-го поколения будет оставаться актуальным устройством очень долго.', 'iPad_air2022_64_wi-fi_purple.jpg', 0),
(4, 'Смартфон Samsung Galaxy S23 8 ГБ | 128 ГБ (Зелёный | Green)', 15454, 79990, 0, 1, 2, 'Смартфон Samsung Galaxy S23 - это новый флагманский смартфон от компании Samsung, который был представлен в феврале 2023 года. Он оснащен мощным процессором Snapdragon 8 Gen 2, 8 ГБ оперативной памяти и 128/256 ГБ встроенной памяти. Экран смартфона имеет диагональ 6,1 дюйма и разрешение 1080 x 2400 пикселей, что обеспечивает высокое качество изображения.\nСмартфон имеет тройную основную камеру с модулями на 50 МП, 12 МП и 10 МП. Фронтальная камера имеет разрешение 12 МП. Смартфон также поддерживает быструю зарядку и беспроводную зарядку.\nSamsung Galaxy S23 работает на операционной системе Android 13 и имеет встроенный сканер отпечатков пальцев и функцию распознавания лица. Смартфон также имеет защиту от воды и пыли по стандарту IP68.', 'galaxy_s23_green_128.jpg', 0),
(5, 'Apple MacBook Air 13 Retina Gold', 52545, 89990, 0, 2, 1, '13-дюймовый MacBook Air 2020 года с процессором M1 с момента выхода стал сенсацией. Невероятно тонкий (всего 4,1 мм в самом тонком месте) и лёгкий (1,29 кг), он работает совершенно бесшумно, а для зарядки компьютера достаточно адаптер мощностью 30 Вт. Переход Apple на собственные процессоры стал, без преувеличения, одной из главных сенсаций 2020 года. Первыми серийными компьютерами, стали MacBook Pro, MacBook Air и Mac mini, представленные осенью 2020.', 'macbook_air_13_256_gold.jpg', 0),
(6, 'Galaxy Tab S8', 21512, 64390, 0, 3, 2, '', 'Galaxy_Tab_S8.jpg', 0),
(7, 'Huawei P50 Pro 8 ГБ + 256 ГБ (Чёрный | Golden Black)', 25464, 79990, 6990, 1, 3, 'Huawei P50 Pro - это флагманский смартфон от компании Huawei, который был представлен в 2021 году. Он имеет множество функций и возможностей, которые делают его одним из лучших смартфонов на рынке.\r\nОдной из главных особенностей Huawei P50 Pro является его камера. Смартфон оснащен тройной камерой, которая состоит из основного модуля на 50 Мп, телеобъектива на 64 Мп и широкоугольного объектива на 13 Мп. Камера позволяет делать качественные фотографии и видео в любых условиях освещения.\r\nТакже стоит отметить большой экран с диагональю 6,6 дюйма и разрешением 3200x1440 пикселей. Экран имеет высокую яркость и контрастность, что позволяет комфортно работать с устройством даже на ярком солнце.\r\nКроме того, Huawei P50 Pro оснащен мощным процессором Kirin 9000 и 8 Гб оперативной памяти, что обеспечивает быструю работу устройства и возможность запускать тяжелые приложения.', 'huawei_p50Pro_black_256.jpg', 0),
(8, 'Ноутбук Huawei MateBook D 14&quot;', 13234, 69990, 0, 2, 3, 'HUAWEI MateBook D 14 &mdash; ноутбук для запуска стандартных приложений, работы или учебы, серфинга социальных сетей и просмотра видеоконтента в высоком разрешении. Поддержка беспроводного интернета 6-го поколения позволяет работать без задержек. Двухъядерный Core i5 1155G7 с тактовой частотой до 4,1 ГГц относится к семейству Tiger Lake и предназначен для быстрого серфинга интернета и обработки стандартных программ. Встроенная графика UHD Graphics Xe G4 заменяет видеокарту и обеспечивает стабильную и плавную работу компьютера в условиях многозадачности. Сканер отпечатка защищает ноутбук от злоумышленников и позволяет быстро входить в систему. Владельцу достаточно приложить палец к сканеру и войти без использования символьного пароля.', 'matebook_14.jpg', 0),
(9, 'Планшет Xiaomi Pad 5 Pro 6 ГБ + 128 ГБ (Чёрный | Black)', 43441, 46990, 0, 3, 26, 'Планшет Xiaomi Pad 5 6+256GB Wi-Fi Grey обеспечивает оптимальное быстродействие для работы, общения, обмена данными и проведения досуга. За поддержание стабильной производительности отвечает процессор Qualcomm Snapdragon 860. Модель оснащена графическим ускорителем Adreno 640, что позволяет запускать ресурсоемкие современные игры. В конструкции предусмотрена камера, которая дает возможность снимать видеоролики в разрешении 3840x2160 пикселей. Наличие встроенных фронтальной камеры и микрофона позволяет общаться с друзьями и коллегами по видеосвязи посредством специальных мессенджеров.', 'xiaomi_pad_5_pro_6_128_black.jpg', 0),
(11, 'Apple iPhone 12 Pro Max 256GB («Тихоокеанский синий» | Pacific Blue)', 23441, 89990, 0, 1, 1, 'Apple iPhone 12 Pro Max - это мощный смартфон, который сочетает в себе передовые технологии и стильный дизайн. Он оснащен 6,7-дюймовым OLED-дисплеем Super Retina XDR с разрешением 2778x1284 пикселей, что обеспечивает яркие и насыщенные цвета. Смартфон работает на базе процессора A14 Bionic, который обеспечивает высокую производительность и быстродействие.\nApple iPhone 12 Pro Max имеет 6 ГБ оперативной памяти и 128/256/512 ГБ встроенной памяти, что позволяет хранить большое количество информации и приложений. Он также оснащен тройной камерой с 12-мегапиксельными объективами, включая широкоугольный, телефото и сверхширокоугольный. Камера позволяет снимать высококачественные фотографии и видео в различных условиях освещения.\nСмартфон имеет защиту от воды и пыли по стандарту IP68, что делает его устойчивым к воде и пыли. ', 'iPhone_12ProMax_blue_256.jpeg', 0),
(12, 'Apple iPhone 11 256GB (Белый | White)', 54841, 41990, 2000, 1, 1, 'Смартфон Apple iPhone 11 оснащен двойным блоком камер, расположенным на задней стороне корпуса. Оба объектива имеют разрешение 12 Мп. С помощью основного модуля, который поддерживает оптическую стабилизацию, светодиодную вспышку True Tone и автокоррекцию, можно делать снимки профессионального качества при любых условиях освещения. Сверхширокоугольная оптика позволяет захватывать в кадре больше окружающего пространства. Можно снимать пейзажи, групповые портреты и городские улицы. С 12-мегапиксельной фронтальной селфи-камерой можно делать короткие видеоролики в высоком качестве (вплоть до 4К) и сторисы для соцсетей.', 'iPhone_11_white_256.jpeg', 0),
(14, 'Apple iPhone 14 Pro 128GB (Тёмно-фиолетовый | Deep Purple)', 12346, 99990, 0, 1, 1, 'Новый способ взаимодействия с iPhone. Революционные функции безопасности, разработанные для спасения жизней. Инновационная 48-мегапиксельная камера для потрясающей детализации. Все работает на новейшем чипе Apple A16 Bionic.Вместо &quot;челки&quot; теперь Dynamic Island, настоящая инновация Apple. Он выводит музыку, спортивные результаты, FaceTime и многое другое &mdash; и все это не отвлекает вас от того, что вы делаете.\r\n\r\nDynamic Island сочетает в себе веселье и функциональность, как никогда раньше, объединяя ваши уведомления, оповещения и действия в одном интерактивном месте. Он интегрирован в iOS 16 и может работать со всеми типами приложений, чтобы легко отображать то, что вам нужно, именно тогда, когда вам это нужно.', 'iPhone_14Pro_purple_128.jpg', 0),
(17, 'Apple iPhone 11 128GB (Чёрный | Black)', 23456, 38990, 0, 1, 1, 'Смартфон Apple iPhone 11 оснащен двойным блоком камер, расположенным на задней стороне корпуса. Оба объектива имеют разрешение 12 Мп. С помощью основного модуля, который поддерживает оптическую стабилизацию, светодиодную вспышку True Tone и автокоррекцию, можно делать снимки профессионального качества при любых условиях освещения. Сверхширокоугольная оптика позволяет захватывать в кадре больше окружающего пространства. Можно снимать пейзажи, групповые портреты и городские улицы. С 12-мегапиксельной фронтальной селфи-камерой можно делать короткие видеоролики в высоком качестве (вплоть до 4К) и сторисы для соцсетей.', 'iPhone_11_black_64.jpeg', 0),
(21, 'Смартфон Sony Xperia 1 IV 12 ГБ + 512 ГБ (Фиолетовый | Purple)', 12345, 79990, 0, 1, 38, 'Sony, после долгого отсутствия на рынке смартфонов, стремительно ворвалась, и нащупав свой стиль и целевую аудиторию, создаёт весьма интересные устройства. Одним из таких является Xperia 1 IV - гаджет от креативных людей для креативных людей. При разработке учитывались мнения профессионалов в своих сферах. Это отличный вариант как и для криэйторов, желающих ощутить профессиональную съёмку в компактном исполнении, так и для его потребителей, благодаря мощному процессору и красочному экрану.Конечно же, Sony не могли оставить свой смартфон, без флагманской, или скорее даже профессиональной камеры. Модуль на задней части располагает три объектива: широкоугольный на 24 Мп, сверхширокоугольный на 16 Мп и телеобъектив с оптическим зумом и ЭФР 85-125 мм. Все они имеют возможность записи 4К видео, с частотой 120 кадров в секунду. Это ли не счастье видеографа? Кроме того, Xperia 1 IV получил, ставшую визитной карточной компании, автофокусировку, которая захватывает объект, &quot;оживляя&quot; видео.', 'Xperia_1_purple_512.jpg', 0),
(29, 'Apple Watch Series 8, 45 мм,  цвета &laquo;тёмная ночь&raquo;', 54514, 41990, 0, 11, 1, 'Apple Watch Series 8 сочетают в себе все привычные преимущества умных часов Apple и привносят новые, благодаря новым возможностям самих часов и улучшениям watchOS. Они помогут тренироваться эффективнее, следить за важными для здоровья показателями и быть в курсе всех уведомлений и общаться без необходимости доставать iPhone. Говоря об Apple Watch, сложно переоценить и возможность самовыражения, которые предлагает данный гаджет, ведь кастомизировать часы можно не только разнообразными циферблатами, но и с помощью всевозможных ремешков от Apple и других брендов. Apple Watch Series 8 получили датчик температуры, постоянно измеряющий её вместе с другими показателями даже во время сна. Кроме того, часы измеряют и окружающую температуру, чтобы исключить её влияние на точность замеров. Измерение температуры улучшает работу мониторинга сна, а также позволяет определить цикл женского здоровья или вовремя узнать о вирусном заболевании.', 'apple_watch_8_45.jpeg', 0),
(30, 'Смартфон Samsung Galaxy S23 Ultra 12 ГБ | 256 ГБ (Бежевый | Cream)', 57454, 95990, 0, 1, 2, 'Samsung Galaxy S23 Ultra &ndash; это мощный камерофон с отличным экраном, ёмким аккумулятором на 5000 мА/ч и впечатляющей производительностью. Являясь идейным наследием линейки Note, он поставляется c пером S-Pen и выполнен в лаконичном дизайне с приятными расцветками, а возможности 200-Мегапиксельной камеры удивят даже искушённых фотографов. Корпус Galaxy S23 Ultra сделан из качественных и экологичных материалов. Передняя и задняя части защищены прочным стеклом, изготовленным с использованием переработанных материалов, а рамка смартфона &ndash; металлическая. Даже стилус S-Pen, убирающийся в корпус, сделан с применением переработанного пластика. Дисплей Galaxy S23 Ultra отличается не только внушительной диагональю в 6,8 дюйма, но и высоко чёткостью, феноменальной контрастностью и остаётся читаемым на улице даже в условиях яркого дневного света. Кроме того, он примечателен адаптивной частотой обновления с поддержкой 120 Гц. Стилус S-Pen, знакомый многим приверженцам смартфонов Galaxy ещё по линейке Note, позволяет не только делать заметки и наброски, но и быстро выделять и копировать информацию, преобразовывая её в текст. Он имеет 4096 степеней силы нажатия и работает на основе технологий WACOM &ndash; знаменитого производителя профессиональных графических паншетов. А самое главное &ndash; он всегда под рукой.', 'galaxy_s23_ultra_256gb_cream.jpg', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `status_id` tinyint(2) UNSIGNED NOT NULL,
  `status_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`status_id`, `status_name`) VALUES
(1, 'Принят'),
(2, 'Оплачен'),
(3, 'В работе'),
(4, 'Доставлен'),
(5, 'Отменен');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` char(64) NOT NULL,
  `user_is_admin` tinyint(2) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_is_admin`) VALUES
(1, 'Иванов Иван Иванович', 'ivan@mail.com', '123password', 0),
(2, 'Петров Петр Петрович', 'petr@yandex.ru', 'pass1234', 0),
(3, 'Сидоров Илья Владимирович', 'sidorov@mail.com', '12345', 0),
(4, 'Сидорова Анна Ивановна', 'anna@yandex.ru', '12345pass', 0),
(5, 'Тарасова Мария Анатольевна', 'mashat@rambler.ru', 'password1', 0),
(9, NULL, 'ivan.petrov@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 0),
(16, NULL, 'ivan.petrov@mail.ru', 'bd462d5d7e7d5f8416515c6b0f3ed640', 0),
(17, NULL, 'petrov@mail.ru', 'fe60374e15ae5f50e67cf94fed349337', 0),
(18, NULL, 'ivaniv.ivan@yandex.ru', '601a30b0ddaace9477677d1d3321a680', 0),
(19, NULL, 'vlad.p@yandex.ru', '8bac2bf478ff896c4c41aecc8d8c3b44', 0),
(20, NULL, 'random@mail.ru', '61bd60c60d9fb60cc8fc7767669d40a1', 0),
(21, NULL, 'random@gmail.com', '2af9b1ba42dc5eb01743e6b3759b6e4b', 0),
(22, NULL, 'randomdsf@mail.com', '827ccb0eea8a706c4c34a16891f84e7b', 0),
(23, NULL, 'vlad@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(25, NULL, 'vlad.ran@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(26, 'Влад', 'vlad.qw@gmail.com', '4dba74fc2cca1ebaa30baa51bcef150e', 1),
(27, 'Влад', 'safsaf@aff.ru', 'f7b8f1a6a181279285753b3eebd75f1b', 0),
(28, 'Влад', 'vlad.qwerty@gmail.com', '4dba74fc2cca1ebaa30baa51bcef150e', 0),
(29, 'Влад', 'vlad1@gmail.com', '4dba74fc2cca1ebaa30baa51bcef150e', 0),
(30, 'Влад', 'vlad.rac@gmail.com', '4dba74fc2cca1ebaa30baa51bcef150e', 0),
(31, 'Влад', 'vlad.qw2@gmail.com', '4dba74fc2cca1ebaa30baa51bcef150e', 0),
(32, 'Влад', 'vlad.qw7@gmail.com', '4dba74fc2cca1ebaa30baa51bcef150e', 0),
(33, 'Влад', 'vlad.qw0@gmail.com', '4dba74fc2cca1ebaa30baa51bcef150e', 1),
(36, 'Олег', '12345678@mail.ru', 'd1284588a8837dab62286bafaca9da17', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cart_product_id` (`cart_product_id`),
  ADD KEY `cart_order_id` (`cart_order_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Индексы таблицы `connects`
--
ALTER TABLE `connects`
  ADD PRIMARY KEY (`connect_id`),
  ADD KEY `connect_user_id` (`connect_user_id`);

--
-- Индексы таблицы `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Индексы таблицы `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`manufacturer_id`),
  ADD UNIQUE KEY `manufacturer_name` (`manufacturer_name`);

--
-- Индексы таблицы `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`mark_id`),
  ADD KEY `mark_user_id` (`mark_user_id`),
  ADD KEY `mark_product_id` (`mark_product_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_address_user_id` (`order_address`),
  ADD KEY `order_status_id` (`order_status_id`),
  ADD KEY `order_payment_id` (`order_payment_id`),
  ADD KEY `order_delivery_id` (`order_delivery_id`),
  ADD KEY `order_user_id` (`order_user_id`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category_id` (`product_category_id`),
  ADD KEY `product_manufacturer_id` (`product_manufacturer_id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`status_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `connects`
--
ALTER TABLE `connects`
  MODIFY `connect_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT для таблицы `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `delivery_id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `manufacturer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `marks`
--
ALTER TABLE `marks`
  MODIFY `mark_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `status_id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`cart_product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`cart_order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `connects`
--
ALTER TABLE `connects`
  ADD CONSTRAINT `connects_ibfk_1` FOREIGN KEY (`connect_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`mark_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `marks_ibfk_2` FOREIGN KEY (`mark_product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`order_status_id`) REFERENCES `statuses` (`status_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`order_payment_id`) REFERENCES `payments` (`payment_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`order_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`order_delivery_id`) REFERENCES `deliveries` (`delivery_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_category_id`) REFERENCES `categories` (`category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`product_manufacturer_id`) REFERENCES `manufacturers` (`manufacturer_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
