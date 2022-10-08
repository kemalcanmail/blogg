SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `ad-settings`;
CREATE TABLE `ad-settings` (
  `id` int(11) NOT NULL,
  `top_ad` text NOT NULL,
  `bottom_ad` text NOT NULL,
  `pop_ad` text NOT NULL,
  `top_ad_status` tinyint(1) NOT NULL DEFAULT 1,
  `bottom_ad_status` tinyint(1) NOT NULL DEFAULT 1,
  `pop_ad_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ad-settings` (`id`, `top_ad`, `bottom_ad`, `pop_ad`, `top_ad_status`, `bottom_ad_status`, `pop_ad_status`) VALUES
(1, '&lt;img src=&quot;https://via.placeholder.com/728x90?text=XLScripts.com&quot;&gt;&lt;/img&gt;asd', '&lt;img src=&quot;https://via.placeholder.com/728x90?text=XLScripts.com&quot;&gt;&lt;/img&gt;', '', 1, 1, 0);

DROP TABLE IF EXISTS `whois-servers`;
CREATE TABLE `whois-servers` (
  `id` int(11) NOT NULL,
  `tld` varchar(255) NOT NULL,
  `server` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `admin-users`;
CREATE TABLE `admin-users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin-users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, '', '', '', 0);

DROP TABLE IF EXISTS `analytics-settings`;
CREATE TABLE `analytics-settings` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `analytics-settings` (`id`, `code`) VALUES
(1, '');

DROP TABLE IF EXISTS `general-settings`;
CREATE TABLE `general-settings` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `logo` text NOT NULL,
  `favicon` text NOT NULL,
  `checksum` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `general-settings` (`id`, `title`, `description`, `keywords`, `logo`, `favicon`, `checksum`) VALUES
(1, 'WHOIS Lookup', 'Ultimate WHOIS Information Lookup Script', 'framework,2.0', 'logo.svg', 'favicon.svg', '');

DROP TABLE IF EXISTS `meta-tags-settings`;
CREATE TABLE `meta-tags-settings` (
  `id` int(11) NOT NULL,
  `meta_tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `meta-tags-settings` (`id`, `meta_tags`) VALUES
(1, '');

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `permalink` text NOT NULL,
  `content` text NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `page_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pages` (`id`, `title`, `permalink`, `content`, `position`, `status`, `page_order`) VALUES
(2, 'Privacy Policy', 'privacy-policy', '&lt;p&gt;Privacy Policy page.&lt;/p&gt;', 1, 1, 1),
(4, 'Terms &amp; Conditions', 'terms-conditions', '&lt;p&gt;Terms and Conditions Page.&lt;/p&gt;', 1, 1, 0);

DROP TABLE IF EXISTS `recaptcha-settings`;
CREATE TABLE `recaptcha-settings` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `site_key` text NOT NULL,
  `secret_key` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `recaptcha-settings` (`id`, `status`, `site_key`, `secret_key`) VALUES
(1, 0, '', '');

DROP TABLE IF EXISTS `scripts-settings`;
CREATE TABLE `scripts-settings` (
  `id` int(11) NOT NULL,
  `header` text NOT NULL,
  `footer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `scripts-settings` (`id`, `header`, `footer`) VALUES
(1, '', '');

DROP TABLE IF EXISTS `smtp-settings`;
CREATE TABLE `smtp-settings` (
  `id` int(11) NOT NULL,
  `host` text NOT NULL,
  `port` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `smtp-settings` (`id`, `host`, `port`, `username`, `password`, `status`, `email`) VALUES
(1, '', '', '', '', 0, 'nexthon@live.com');

DROP TABLE IF EXISTS `themes-settings`;
CREATE TABLE `themes-settings` (
  `id` int(11) NOT NULL,
  `theme` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `themes-settings` (`id`, `theme`) VALUES
(1, 'default');

INSERT INTO `whois-servers` (`id`, `tld`, `server`) VALUES
(476, 'ac', 'whois.nic.ac'),
(477, 'ae', 'whois.nic.ae'),
(478, 'aero', 'whois.aero'),
(479, 'af', 'whois.nic.af'),
(480, 'ag', 'whois.nic.ag'),
(481, 'ai', 'whois.ai'),
(482, 'al', 'whois.ripe.net'),
(483, 'am', 'whois.amnic.net'),
(484, 'arpa', 'whois.iana.org'),
(485, 'as', 'whois.nic.as'),
(486, 'asia', 'whois.nic.asia'),
(487, 'at', 'whois.nic.at'),
(488, 'au', 'whois.aunic.net'),
(489, 'ax', 'whois.ax'),
(490, 'az', 'whois.ripe.net'),
(491, 'be', 'whois.dns.be'),
(492, 'bg', 'whois.register.bg'),
(493, 'bi', 'whois.nic.bi'),
(494, 'biz', 'whois.biz'),
(495, 'bj', 'whois.nic.bj'),
(496, 'bo', 'whois.nic.bo'),
(497, 'br', 'whois.registro.br'),
(498, 'bt', 'whois.netnames.net'),
(499, 'by', 'whois.cctld.by'),
(500, 'bz', 'whois.belizenic.bz'),
(501, 'ca', 'whois.cira.ca'),
(502, 'cat', 'whois.cat'),
(503, 'cc', 'whois.nic.cc'),
(504, 'cd', 'whois.nic.cd'),
(505, 'ch', 'whois.nic.ch'),
(506, 'ci', 'whois.nic.ci'),
(507, 'ck', 'whois.nic.ck'),
(508, 'cl', 'whois.nic.cl'),
(509, 'cn', 'whois.cnnic.net.cn'),
(510, 'co', 'whois.nic.co'),
(511, 'com', 'whois.verisign-grs.com'),
(512, 'coop', 'whois.nic.coop'),
(513, 'cx', 'whois.nic.cx'),
(514, 'cz', 'whois.nic.cz'),
(515, 'de', 'whois.denic.de'),
(516, 'dk', 'whois.dk-hostmaster.dk'),
(517, 'dm', 'whois.nic.dm'),
(518, 'dz', 'whois.nic.dz'),
(519, 'ec', 'whois.nic.ec'),
(520, 'edu', 'whois.educause.edu'),
(521, 'ee', 'whois.eenet.ee'),
(522, 'eg', 'whois.ripe.net'),
(523, 'es', 'whois.nic.es'),
(524, 'eu', 'eu.whois-servers.net'),
(525, 'fi', 'whois.ficora.fi'),
(526, 'fo', 'whois.nic.fo'),
(527, 'fr', 'whois.nic.fr'),
(528, 'gd', 'whois.nic.gd'),
(529, 'gg', 'whois.gg'),
(530, 'gi', 'whois2.afilias-grs.net'),
(531, 'gl', 'whois.nic.gl'),
(532, 'gov', 'whois.nic.gov'),
(533, 'gs', 'whois.nic.gs'),
(534, 'gy', 'whois.registry.gy'),
(535, 'hk', 'whois.hkirc.hk'),
(536, 'hn', 'whois.nic.hn'),
(537, 'hr', 'whois.dns.hr'),
(538, 'ht', 'whois.nic.ht'),
(539, 'hu', 'whois.nic.hu'),
(540, 'ie', 'whois.domainregistry.ie'),
(541, 'il', 'whois.isoc.org.il'),
(542, 'im', 'whois.nic.im'),
(543, 'in', 'whois.inregistry.net'),
(544, 'info', 'whois.afilias.net'),
(545, 'int', 'whois.iana.org'),
(546, 'io', 'whois.nic.io'),
(547, 'iq', 'whois.cmc.iq'),
(548, 'ir', 'whois.nic.ir'),
(549, 'is', 'whois.isnic.is'),
(550, 'it', 'whois.nic.it'),
(551, 'je', 'whois.je'),
(552, 'jobs', 'jobswhois.verisign-grs.com'),
(553, 'jp', 'whois.jprs.jp'),
(554, 'ke', 'whois.kenic.or.ke'),
(555, 'kg', 'www.domain.kg'),
(556, 'ki', 'whois.nic.ki'),
(557, 'kr', 'whois.kr'),
(558, 'kz', 'whois.nic.kz'),
(559, 'la', 'whois.nic.la'),
(560, 'li', 'whois.nic.li'),
(561, 'lt', 'whois.domreg.lt'),
(562, 'lu', 'whois.dns.lu'),
(563, 'lv', 'whois.nic.lv'),
(564, 'ly', 'whois.nic.ly'),
(565, 'ma', 'whois.iam.net.ma'),
(566, 'md', 'whois.nic.md'),
(567, 'me', 'whois.nic.me'),
(568, 'mg', 'whois.nic.mg'),
(569, 'mil', 'whois.nic.mil'),
(570, 'ml', 'whois.dot.ml'),
(571, 'mn', 'whois.nic.mn'),
(572, 'mo', 'whois.monic.mo'),
(573, 'mobi', 'whois.dotmobiregistry.net'),
(574, 'mp', 'whois.nic.mp'),
(575, 'ms', 'whois.nic.ms'),
(576, 'mu', 'whois.nic.mu'),
(577, 'museum', 'whois.museum'),
(578, 'mx', 'whois.mx'),
(579, 'my', 'whois.domainregistry.my'),
(580, 'na', 'whois.na-nic.com.na'),
(581, 'name', 'whois.nic.name'),
(582, 'nc', 'whois.nc'),
(583, 'net', 'whois.verisign-grs.net'),
(584, 'nf', 'whois.nic.nf'),
(585, 'ng', 'whois.nic.net.ng'),
(586, 'nl', 'whois.domain-registry.nl'),
(587, 'no', 'whois.norid.no'),
(588, 'nu', 'whois.nic.nu'),
(589, 'nz', 'whois.srs.net.nz'),
(590, 'om', 'whois.registry.om'),
(591, 'org', 'whois.pir.org'),
(592, 'org', 'org.whois-servers.net'),
(593, 'pe', 'kero.yachay.pe'),
(594, 'pf', 'whois.registry.pf'),
(595, 'pl', 'whois.dns.pl'),
(596, 'pm', 'whois.nic.pm'),
(597, 'post', 'whois.dotpostregistry.net'),
(598, 'pr', 'whois.nic.pr'),
(599, 'pro', 'whois.dotproregistry.net'),
(600, 'pt', 'whois.dns.pt'),
(601, 'pw', 'whois.nic.pw'),
(602, 'qa', 'whois.registry.qa'),
(603, 're', 'whois.nic.re'),
(604, 'ro', 'whois.rotld.ro'),
(605, 'rs', 'whois.rnids.rs'),
(606, 'ru', 'whois.tcinet.ru'),
(607, 'sa', 'whois.nic.net.sa'),
(608, 'sb', 'whois.nic.net.sb'),
(609, 'sc', 'whois2.afilias-grs.net'),
(610, 'se', 'whois.iis.se'),
(611, 'sg', 'whois.sgnic.sg'),
(612, 'sh', 'whois.nic.sh'),
(613, 'si', 'whois.arnes.si'),
(614, 'sk', 'whois.sk-nic.sk'),
(615, 'sm', 'whois.nic.sm'),
(616, 'sn', 'whois.nic.sn'),
(617, 'so', 'whois.nic.so'),
(618, 'st', 'whois.nic.st'),
(619, 'su', 'whois.tcinet.ru'),
(620, 'sx', 'whois.sx'),
(621, 'sy', 'whois.tld.sy'),
(622, 'tc', 'whois.meridiantld.net'),
(623, 'tel', 'whois.nic.tel'),
(624, 'tf', 'whois.nic.tf'),
(625, 'th', 'whois.thnic.co.th'),
(626, 'tj', 'whois.nic.tj'),
(627, 'tk', 'whois.dot.tk'),
(628, 'tl', 'whois.nic.tl'),
(629, 'tm', 'whois.nic.tm'),
(630, 'tn', 'whois.ati.tn'),
(631, 'to', 'whois.tonic.to'),
(632, 'tp', 'whois.nic.tl'),
(633, 'tr', 'whois.nic.tr'),
(634, 'travel', 'whois.nic.travel'),
(635, 'tv', 'tvwhois.verisign-grs.com'),
(636, 'tw', 'whois.twnic.net.tw'),
(637, 'tz', 'whois.tznic.or.tz'),
(638, 'ua', 'whois.ua'),
(639, 'ug', 'whois.co.ug'),
(640, 'uk', 'whois.nic.uk'),
(641, 'us', 'whois.nic.us'),
(642, 'uy', 'whois.nic.org.uy'),
(643, 'uz', 'whois.cctld.uz'),
(644, 'vc', 'whois2.afilias-grs.net'),
(645, 've', 'whois.nic.ve'),
(646, 'vg', 'whois.adamsnames.tc'),
(647, 'wf', 'whois.nic.wf'),
(648, 'ws', 'whois.website.ws'),
(649, 'xxx', 'whois.nic.xxx'),
(650, 'yt', 'whois.nic.yt'),
(651, 'yu', 'whois.ripe.net');

ALTER TABLE `ad-settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admin-users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `analytics-settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `general-settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `meta-tags-settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `recaptcha-settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `scripts-settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `smtp-settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `themes-settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `whois-servers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `whois-servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `ad-settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `admin-users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `analytics-settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `general-settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `meta-tags-settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `recaptcha-settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `scripts-settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `smtp-settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `themes-settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;