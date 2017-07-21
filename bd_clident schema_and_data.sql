/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : clident

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-07-21 13:10:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ajustes
-- ----------------------------
DROP TABLE IF EXISTS `ajustes`;
CREATE TABLE `ajustes` (
  `ID_AJUSTE` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) NOT NULL,
  `VALOR` varchar(250) NOT NULL,
  PRIMARY KEY (`ID_AJUSTE`),
  UNIQUE KEY `IX_NOMBRE_SETTINGS` (`NOMBRE`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ajustes
-- ----------------------------
INSERT INTO `ajustes` VALUES ('1', 'KEY_PERSONAL_DENTISTA', '8');
INSERT INTO `ajustes` VALUES ('2', 'KEY_PRE_CITA', '');

-- ----------------------------
-- Table structure for almacen
-- ----------------------------
DROP TABLE IF EXISTS `almacen`;
CREATE TABLE `almacen` (
  `ID_ALMACEN` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PROVEEDOR` int(11) DEFAULT NULL,
  `TIPO_MOVIMIENTO` int(11) DEFAULT NULL,
  `COMENTARIO` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `USUARIO_REGISTRO` int(11) NOT NULL,
  `FECHA_MODIFICACION` datetime NOT NULL,
  `USUARIO_MODIFICACION` int(11) NOT NULL,
  PRIMARY KEY (`ID_ALMACEN`),
  KEY `fk_almacen_proveedor` (`ID_PROVEEDOR`),
  KEY `fk_almacen_tipo` (`TIPO_MOVIMIENTO`),
  CONSTRAINT `fk_almacen_proveedor` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `proveedor` (`ID_PROVEEDOR`),
  CONSTRAINT `fk_almacen_tipo` FOREIGN KEY (`TIPO_MOVIMIENTO`) REFERENCES `tipo` (`ID_TIPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of almacen
-- ----------------------------

-- ----------------------------
-- Table structure for area
-- ----------------------------
DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `ID_AREA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PARENT_AREA` int(11) DEFAULT NULL,
  `NOMBRE` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPCION` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ESTADO` int(11) NOT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) NOT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_AREA`),
  KEY `FK_area_area` (`ID_PARENT_AREA`),
  CONSTRAINT `FK_area_area` FOREIGN KEY (`ID_PARENT_AREA`) REFERENCES `area` (`ID_AREA`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of area
-- ----------------------------
INSERT INTO `area` VALUES ('1', null, 'Cirujia', 'CIRUJIA DENTAL', '1', '', '2017-06-16 00:00:00', '2017-07-19 22:59:19', '1', '1');
INSERT INTO `area` VALUES ('2', null, 'Rayos X', 'Rayos X', '1', '', '2017-06-16 00:00:00', '2017-07-19 22:59:40', '1', '1');
INSERT INTO `area` VALUES ('3', null, 'CIRUJIA', 'CIRUJIA DENTAL PRUEBA', '1', '\0', '2017-06-16 00:00:00', '2017-06-17 00:00:00', '1', '1');
INSERT INTO `area` VALUES ('4', null, 'CIRUJIA', 'CIRUJIA DENTAL', '1', '\0', '2017-06-16 00:00:00', '2017-06-17 00:00:00', '1', '1');
INSERT INTO `area` VALUES ('5', null, 'Gerencia General', '', '1', '', '2017-06-16 00:00:00', '2017-07-19 22:59:30', '1', '1');
INSERT INTO `area` VALUES ('6', '5', 'Gerencia Financiera', '', '1', '', '2017-06-16 00:00:00', '2017-07-19 22:55:55', '1', '1');

-- ----------------------------
-- Table structure for articulo
-- ----------------------------
DROP TABLE IF EXISTS `articulo`;
CREATE TABLE `articulo` (
  `ID_ARTICULO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ID_CATEGORIA` int(11) DEFAULT NULL,
  `ID_MARCA` int(11) DEFAULT NULL,
  `ID_UNIDAD_MEDIDA` int(11) DEFAULT NULL,
  `PRECIO_COMPRA` decimal(10,0) DEFAULT NULL,
  `STOCK` decimal(6,2) DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `USUARIO_REGISTRO` int(11) NOT NULL,
  `FECHA_MODIFICACION` datetime NOT NULL,
  `USUARIO_MODIFICACION` int(11) NOT NULL,
  PRIMARY KEY (`ID_ARTICULO`),
  KEY `fk_articulo_marca` (`ID_MARCA`),
  KEY `fk_articulo_unidadmedida` (`ID_UNIDAD_MEDIDA`),
  KEY `FK_articulo_categoria` (`ID_CATEGORIA`),
  CONSTRAINT `FK_articulo_categoria` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`),
  CONSTRAINT `fk_articulo_marca` FOREIGN KEY (`ID_MARCA`) REFERENCES `marca` (`ID_MARCA`),
  CONSTRAINT `fk_articulo_unidadmedida` FOREIGN KEY (`ID_UNIDAD_MEDIDA`) REFERENCES `unidad_medida` (`ID_UNIDAD_MEDIDA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of articulo
-- ----------------------------

-- ----------------------------
-- Table structure for categoria
-- ----------------------------
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `ID_CATEGORIA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PARENT_CATGORIA` int(11) DEFAULT NULL,
  `NOMBRE` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DESCRIPCION` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_CATEGORIA`),
  KEY `FK_categoria_categoria` (`ID_PARENT_CATGORIA`),
  CONSTRAINT `FK_categoria_categoria` FOREIGN KEY (`ID_PARENT_CATGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of categoria
-- ----------------------------

-- ----------------------------
-- Table structure for cita
-- ----------------------------
DROP TABLE IF EXISTS `cita`;
CREATE TABLE `cita` (
  `ID_CITA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PACIENTE` int(11) NOT NULL,
  `ID_DENTISTA` int(11) NOT NULL,
  `TIPO_CITA` int(11) NOT NULL,
  `FECHA_CITA` date NOT NULL,
  `HORA_INICIO` time NOT NULL,
  `HORA_FIN` time NOT NULL,
  `ESTADO` int(11) NOT NULL,
  `NOTA` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CITA`),
  KEY `FK_cita_paciente` (`ID_PACIENTE`),
  KEY `FK_cita_dentista` (`ID_DENTISTA`),
  CONSTRAINT `FK_cita_dentista` FOREIGN KEY (`ID_DENTISTA`) REFERENCES `personal` (`ID_PERSONAL`),
  CONSTRAINT `FK_cita_paciente` FOREIGN KEY (`ID_PACIENTE`) REFERENCES `paciente` (`ID_PACIENTE`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cita
-- ----------------------------
INSERT INTO `cita` VALUES ('1', '2', '1', '2', '2017-07-21', '12:50:00', '13:20:00', '1', '212', '', '2017-07-21 04:19:03', '2017-07-21 20:08:53', '1', '1');
INSERT INTO `cita` VALUES ('2', '3', '1', '2', '2017-07-26', '15:30:00', '16:00:00', '1', null, '', '2017-07-21 18:35:39', '2017-07-21 20:00:59', '1', '1');
INSERT INTO `cita` VALUES ('3', '2', '1', '2', '2017-07-29', '11:10:00', '12:40:00', '2', null, '', '2017-07-21 18:37:53', null, '1', null);

-- ----------------------------
-- Table structure for detalle_almacen
-- ----------------------------
DROP TABLE IF EXISTS `detalle_almacen`;
CREATE TABLE `detalle_almacen` (
  `ID_DETALLE_ALMACEN` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ALMACEN` int(11) DEFAULT NULL,
  `ID_ARTICULO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `ESTADO` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `USUARIO_REGISTRO` int(11) NOT NULL,
  `FECHA_MODIFICACION` datetime NOT NULL,
  `USUARIO_MODIFICACION` int(11) NOT NULL,
  PRIMARY KEY (`ID_DETALLE_ALMACEN`),
  KEY `fk_almacen_detalle_almacen` (`ID_ALMACEN`),
  KEY `fk_articulo_detalle_almacen` (`ID_ARTICULO`),
  CONSTRAINT `fk_almacen_detalle_almacen` FOREIGN KEY (`ID_ALMACEN`) REFERENCES `almacen` (`ID_ALMACEN`),
  CONSTRAINT `fk_articulo_detalle_almacen` FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of detalle_almacen
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_horario
-- ----------------------------
DROP TABLE IF EXISTS `detalle_horario`;
CREATE TABLE `detalle_horario` (
  `ID_DETALLE_HORARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_HORARIO` int(11) NOT NULL,
  `DIA` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `HORA_INICIO` time NOT NULL,
  `HORA_FIN` time NOT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_DETALLE_HORARIO`),
  KEY `FK_horario_detalle_horario` (`ID_HORARIO`),
  CONSTRAINT `FK_horario_detalle_horario` FOREIGN KEY (`ID_HORARIO`) REFERENCES `horario` (`ID_HORARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of detalle_horario
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_odontograma
-- ----------------------------
DROP TABLE IF EXISTS `detalle_odontograma`;
CREATE TABLE `detalle_odontograma` (
  `ID_DETALLE_ODONTOGRAMA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ODONTOGRAMA` int(11) NOT NULL,
  `NUMERO_DIENTE` int(11) NOT NULL,
  `CARA_DIENTE` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ID_TRATAMIENTO` int(11) NOT NULL,
  `ID_DENTISTA` int(11) NOT NULL,
  `DESCRIPCION` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FECHA_APLICACION` datetime NOT NULL,
  `ESTADO` int(11) NOT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_DETALLE_ODONTOGRAMA`),
  KEY `FK_detalle_odontograma_odontograma` (`ID_ODONTOGRAMA`),
  KEY `FK_detalle_odontograma_tratamiento` (`ID_TRATAMIENTO`),
  KEY `FK_detalle_odontograma_dentista` (`ID_DENTISTA`),
  CONSTRAINT `FK_detalle_odontograma_dentista` FOREIGN KEY (`ID_DENTISTA`) REFERENCES `personal` (`ID_PERSONAL`),
  CONSTRAINT `FK_detalle_odontograma_odontograma` FOREIGN KEY (`ID_ODONTOGRAMA`) REFERENCES `odontograma` (`ID_ODONTOGRAMA`),
  CONSTRAINT `FK_detalle_odontograma_tratamiento` FOREIGN KEY (`ID_TRATAMIENTO`) REFERENCES `tratamiento` (`ID_TRATAMIENTO`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of detalle_odontograma
-- ----------------------------
INSERT INTO `detalle_odontograma` VALUES ('1', '2', '44', 'X', '1', '1', 'Obturación Con Amalgama....', '2017-07-20 20:46:28', '1', '', '2017-07-20 00:09:38', '2017-07-20 20:46:28', '1', '1');
INSERT INTO `detalle_odontograma` VALUES ('3', '4', '14', 'Z', '3', '1', 'Adfggf Sdsd', '2017-07-19 17:15:32', '1', '', '2017-07-20 00:12:32', null, '1', null);
INSERT INTO `detalle_odontograma` VALUES ('4', '1', '47', 'C', '1', '1', 'Fgf Dftr', '2017-07-20 05:13:07', '1', '', '2017-07-20 05:13:07', null, '1', null);
INSERT INTO `detalle_odontograma` VALUES ('5', '2', '44', 'Z', '4', '1', 'Obt. Con Ionomero Cavidad Simple', '2017-07-20 19:58:40', '1', '', '2017-07-20 19:58:40', null, '1', null);
INSERT INTO `detalle_odontograma` VALUES ('6', '2', '46', 'S', '1', '1', 'Obturación Con Amalgama.', '2017-07-20 21:08:22', '1', '', '2017-07-20 20:01:39', '2017-07-20 21:08:22', '1', '1');
INSERT INTO `detalle_odontograma` VALUES ('7', '2', '48', 'D', '5', '1', 'Aplicación De Lampara Luz Alógena.', '2017-07-20 21:08:04', '1', '', '2017-07-20 20:03:26', '2017-07-20 21:08:04', '1', '1');
INSERT INTO `detalle_odontograma` VALUES ('10', '2', '43', 'C', '2', '1', 'Tratamiento', '2017-07-20 21:09:21', '1', '', '2017-07-20 21:09:21', null, '1', null);
INSERT INTO `detalle_odontograma` VALUES ('11', '1', '45', 'S', '2', '1', 'Mmm', '2017-07-20 22:01:24', '1', '', '2017-07-20 22:01:24', null, '1', null);
INSERT INTO `detalle_odontograma` VALUES ('12', '1', '71', 'X', '5', '1', 'Lampara Luz Halógena', '2017-07-20 22:04:07', '1', '', '2017-07-20 22:04:07', null, '1', null);
INSERT INTO `detalle_odontograma` VALUES ('13', '2', '55', 'C', '4', '1', 'Obtención Con Ionómero Cavidad Simple', '2017-07-20 23:20:30', '1', '', '2017-07-20 22:56:03', '2017-07-20 23:20:30', '1', '1');

-- ----------------------------
-- Table structure for horario
-- ----------------------------
DROP TABLE IF EXISTS `horario`;
CREATE TABLE `horario` (
  `ID_HORARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PERSONAL` int(11) NOT NULL,
  `ID_AREA` int(11) NOT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_HORARIO`),
  KEY `FK_horario_area` (`ID_PERSONAL`),
  CONSTRAINT `FK_horario_area` FOREIGN KEY (`ID_PERSONAL`) REFERENCES `area` (`ID_AREA`),
  CONSTRAINT `FK_horario_personal` FOREIGN KEY (`ID_PERSONAL`) REFERENCES `personal` (`ID_PERSONAL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of horario
-- ----------------------------

-- ----------------------------
-- Table structure for marca
-- ----------------------------
DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca` (
  `ID_MARCA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_MARCA` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `USUARIO_REGISTRO` int(11) NOT NULL,
  `FECHA_MODIFICACION` datetime NOT NULL,
  `USUARIO_MODIFICACION` int(11) NOT NULL,
  PRIMARY KEY (`ID_MARCA`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of marca
-- ----------------------------
INSERT INTO `marca` VALUES ('1', 'GENERAL', '', '2017-07-20 18:38:40', '1', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for medicacion
-- ----------------------------
DROP TABLE IF EXISTS `medicacion`;
CREATE TABLE `medicacion` (
  `ID_MEDICACION` int(11) NOT NULL AUTO_INCREMENT,
  `ID_MEDICAMENTO` int(255) DEFAULT NULL,
  `ID_DETALLE_ODONTOGRAMA` int(11) NOT NULL,
  `ID_UNIDAD_MEDIDA` int(11) DEFAULT NULL,
  `DESCRIPCION_MEDICACION` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CANTIDAD` decimal(4,2) DEFAULT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_MEDICACION`),
  KEY `FK_medicacion_detalle_odontograma` (`ID_DETALLE_ODONTOGRAMA`),
  KEY `FK_medicacion_medicamento` (`ID_MEDICAMENTO`),
  KEY `FK_medicacion_unidad` (`ID_UNIDAD_MEDIDA`),
  CONSTRAINT `FK_medicacion_detalle_odontograma` FOREIGN KEY (`ID_DETALLE_ODONTOGRAMA`) REFERENCES `detalle_odontograma` (`ID_DETALLE_ODONTOGRAMA`),
  CONSTRAINT `FK_medicacion_medicamento` FOREIGN KEY (`ID_MEDICAMENTO`) REFERENCES `medicamento` (`ID_MEDICAMENTO`),
  CONSTRAINT `FK_medicacion_unidad` FOREIGN KEY (`ID_UNIDAD_MEDIDA`) REFERENCES `unidad_medida` (`ID_UNIDAD_MEDIDA`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of medicacion
-- ----------------------------
INSERT INTO `medicacion` VALUES ('1', '1', '1', '1', 'Aplicación De Anestecia General Una Dosis De 3.0 Mililitros.', '3.00', '', '2017-07-20 18:40:05', '1', '2017-07-21 10:15:51', '1');
INSERT INTO `medicacion` VALUES ('2', '1', '1', '3', 'Sdsd', '4.00', '', '2017-07-21 10:50:53', '1', null, null);

-- ----------------------------
-- Table structure for medicamento
-- ----------------------------
DROP TABLE IF EXISTS `medicamento`;
CREATE TABLE `medicamento` (
  `ID_MEDICAMENTO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_MARCA` int(11) NOT NULL,
  `NOMBRE` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DESCRIPCION` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_MEDICAMENTO`),
  KEY `FK_medicamento_marca` (`ID_MARCA`),
  CONSTRAINT `FK_medicamento_marca` FOREIGN KEY (`ID_MARCA`) REFERENCES `marca` (`ID_MARCA`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of medicamento
-- ----------------------------
INSERT INTO `medicamento` VALUES ('1', '1', 'ANESTECIA', 'ANESTECIA GENERICA', '', '2017-07-20 18:39:06', '1', null, null);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `ID_MENU` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PARENT_MENU` int(11) DEFAULT NULL,
  `ICONO` varchar(15) NOT NULL,
  `NOMBRE` varchar(30) NOT NULL,
  `DESCRIPCION` varchar(255) DEFAULT NULL,
  `URL` varchar(250) DEFAULT '#',
  `ESTADO` char(1) DEFAULT NULL,
  `ACTIVE` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID_MENU`),
  KEY `FK_menu_submenu` (`ID_PARENT_MENU`),
  CONSTRAINT `FK_menu_submenu` FOREIGN KEY (`ID_PARENT_MENU`) REFERENCES `menu` (`ID_MENU`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', null, 'fa fa-gear', 'Configuración', null, '#', null, '');
INSERT INTO `menu` VALUES ('2', null, 'fa fa-gears', 'Mantenimiento', null, '#', null, '');
INSERT INTO `menu` VALUES ('3', null, 'fa fa-navicon', 'Procesos', null, '#', null, '');
INSERT INTO `menu` VALUES ('4', '1', 'fa fa-indent', 'Tipo', null, 'tipo', null, '');
INSERT INTO `menu` VALUES ('5', '1', 'fa fa-users', 'Usuarios', null, 'usuario', null, '');
INSERT INTO `menu` VALUES ('6', '2', 'fa fa-check', 'Áreas', null, 'area', null, '');
INSERT INTO `menu` VALUES ('7', '2', 'fa fa-child', 'Personal', null, 'persona', null, '');
INSERT INTO `menu` VALUES ('8', '2', 'fa fa-user-plus', 'Pacientes', null, 'paciente', null, '');
INSERT INTO `menu` VALUES ('9', '2', 'fa fa-tint', 'Tratamientos', null, 'tratamiento', null, '');
INSERT INTO `menu` VALUES ('10', '3', 'fa fa-calendar', 'Odontograma', null, 'odontograma', null, '');
INSERT INTO `menu` VALUES ('11', '3', 'fa fa-group', 'Citas', null, 'cita', null, '');

-- ----------------------------
-- Table structure for menu_rol
-- ----------------------------
DROP TABLE IF EXISTS `menu_rol`;
CREATE TABLE `menu_rol` (
  `ID_MENU_ROL` int(11) NOT NULL AUTO_INCREMENT,
  `ID_MENU` int(11) DEFAULT NULL,
  `ID_ROL` int(11) DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_MENU_ROL`),
  KEY `FK_menu_menu` (`ID_MENU`),
  KEY `FK_menu_rol` (`ID_ROL`),
  CONSTRAINT `FK_menu_menu` FOREIGN KEY (`ID_MENU`) REFERENCES `menu` (`ID_MENU`),
  CONSTRAINT `FK_menu_rol` FOREIGN KEY (`ID_ROL`) REFERENCES `rol` (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu_rol
-- ----------------------------
INSERT INTO `menu_rol` VALUES ('1', '1', '1', '', '2017-07-19 07:34:39', null);
INSERT INTO `menu_rol` VALUES ('2', '2', '1', '', '2017-07-19 07:37:16', null);
INSERT INTO `menu_rol` VALUES ('3', '3', '1', '', '2017-07-19 07:37:28', null);

-- ----------------------------
-- Table structure for odontograma
-- ----------------------------
DROP TABLE IF EXISTS `odontograma`;
CREATE TABLE `odontograma` (
  `ID_ODONTOGRAMA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PACIENTE` int(11) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ODONTOGRAMA`),
  KEY `FK_odontograma_paciente` (`ID_PACIENTE`),
  CONSTRAINT `FK_odontograma_paciente` FOREIGN KEY (`ID_PACIENTE`) REFERENCES `paciente` (`ID_PACIENTE`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of odontograma
-- ----------------------------
INSERT INTO `odontograma` VALUES ('1', '1', '2017-07-02 05:17:24', null, '1', null);
INSERT INTO `odontograma` VALUES ('2', '2', '2017-07-02 05:18:10', null, '1', null);
INSERT INTO `odontograma` VALUES ('3', '3', '2017-07-02 05:18:30', null, '1', null);
INSERT INTO `odontograma` VALUES ('4', '4', '2017-07-02 05:19:00', null, '1', null);

-- ----------------------------
-- Table structure for paciente
-- ----------------------------
DROP TABLE IF EXISTS `paciente`;
CREATE TABLE `paciente` (
  `ID_PACIENTE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PERSONA` int(11) NOT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_PACIENTE`),
  KEY `FK_paciente_persona` (`ID_PERSONA`),
  CONSTRAINT `FK_paciente_persona` FOREIGN KEY (`ID_PERSONA`) REFERENCES `persona` (`ID_PERSONA`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of paciente
-- ----------------------------
INSERT INTO `paciente` VALUES ('1', '1', '', '2017-06-16 00:00:00', '2017-06-17 00:00:00', '1', '1');
INSERT INTO `paciente` VALUES ('2', '2', '', '2017-06-17 00:00:00', '2017-07-20 04:05:26', '1', '1');
INSERT INTO `paciente` VALUES ('3', '3', '', '2017-06-17 00:00:00', '2017-07-19 23:06:13', '1', '1');
INSERT INTO `paciente` VALUES ('4', '4', '', '2017-06-17 00:00:00', '2017-07-19 23:05:05', '1', '1');

-- ----------------------------
-- Table structure for persona
-- ----------------------------
DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `ID_PERSONA` int(11) NOT NULL AUTO_INCREMENT,
  `TIPO_DOCUMENTO` int(11) DEFAULT NULL,
  `NUMERO_DOCUMENTO` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `NOMBRE` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `APELLIDOS` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `DIRECCION` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EMAIL` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CELULAR` char(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TELEFONO` char(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FECHA_NACIMIENTO` date NOT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_PERSONA`),
  KEY `fk_persona_tipo` (`TIPO_DOCUMENTO`),
  CONSTRAINT `fk_persona_tipo` FOREIGN KEY (`TIPO_DOCUMENTO`) REFERENCES `tipo` (`ID_TIPO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of persona
-- ----------------------------
INSERT INTO `persona` VALUES ('1', '1', '70129676', 'Alexander Estevan', 'Tume Naquiche', 'AMP. NUEVA GENERACION MZ B LT 3', 'TUMENAQUICHE@GMAIL.COM', '', '', '1994-10-05', '', '2017-06-16 00:00:00', '2017-07-19 23:07:18', '1', '1');
INSERT INTO `persona` VALUES ('2', '1', '05623412', 'Alexander', 'Martinez Rodriguez', '', 'AMARTINEZRODRIGUEZ@HOTMAIL.COM', '', '', '1995-10-02', '', '2017-06-17 00:00:00', '2017-07-20 04:05:26', '1', '1');
INSERT INTO `persona` VALUES ('3', '1', '89712871', 'Alicia ', 'Garcia Mendez', '', 'ALICIA.G.M@GMAIL.COM', '', '', '1995-09-12', '', '2017-06-17 00:00:00', '2017-07-19 23:06:13', '1', '1');
INSERT INTO `persona` VALUES ('4', '1', '01275323', 'Stefany Bricyit', 'Alvarado Gamboa', 'Enrrique Palacios #155', '', '', '', '1995-06-09', '', '2017-06-17 00:00:00', '2017-07-19 23:05:05', '1', '1');

-- ----------------------------
-- Table structure for personal
-- ----------------------------
DROP TABLE IF EXISTS `personal`;
CREATE TABLE `personal` (
  `ID_PERSONAL` int(11) NOT NULL AUTO_INCREMENT,
  `ID_AREA` int(11) NOT NULL,
  `ID_PERSONA` int(11) NOT NULL,
  `TIPO_PERSONAL` int(11) DEFAULT NULL,
  `FECHA_INGRESO` datetime NOT NULL,
  `FECHA_CONTRATO_INICIO` datetime DEFAULT NULL,
  `FECHA_CONTRATO_FIN` datetime DEFAULT NULL,
  `ESPECIALIDAD` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CARGO` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_PERSONAL`),
  KEY `FK_personal_area` (`ID_AREA`),
  KEY `FK_personal_persona` (`ID_PERSONA`),
  CONSTRAINT `FK_personal_area` FOREIGN KEY (`ID_AREA`) REFERENCES `area` (`ID_AREA`),
  CONSTRAINT `FK_personal_persona` FOREIGN KEY (`ID_PERSONA`) REFERENCES `persona` (`ID_PERSONA`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of personal
-- ----------------------------
INSERT INTO `personal` VALUES ('1', '1', '1', '8', '2017-07-01 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'Admin', '', '2017-07-01 08:31:39', '2017-07-19 23:07:18', '1', '1');

-- ----------------------------
-- Table structure for proveedor
-- ----------------------------
DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor` (
  `ID_PROVEEDOR` int(11) NOT NULL AUTO_INCREMENT,
  `RUC` char(12) COLLATE utf8_unicode_ci NOT NULL,
  `RAZON_SOCIAL` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `DIRECCION` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EMAIL` int(150) DEFAULT NULL,
  `TELEFONO` char(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CELULAR` char(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PAGINA_WEB` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_PROVEEDOR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of proveedor
-- ----------------------------

-- ----------------------------
-- Table structure for rol
-- ----------------------------
DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `ID_ROL` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_ROL` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rol
-- ----------------------------
INSERT INTO `rol` VALUES ('1', 'ADMINISTRADOR');
INSERT INTO `rol` VALUES ('2', 'DENTISTA');

-- ----------------------------
-- Table structure for tipo
-- ----------------------------
DROP TABLE IF EXISTS `tipo`;
CREATE TABLE `tipo` (
  `ID_TIPO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_GRUPO` int(11) DEFAULT NULL,
  `NOMBRE` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `VALOR` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SIGLA` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_TIPO`),
  KEY `FK_tipo_tipo_grupo` (`ID_GRUPO`),
  CONSTRAINT `FK_tipo_tipo_grupo` FOREIGN KEY (`ID_GRUPO`) REFERENCES `tipo_grupo` (`ID_GRUPO`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tipo
-- ----------------------------
INSERT INTO `tipo` VALUES ('1', '1', 'DOCUMENTO NACIONAL DE IDENTIDAD', '8', 'DNI', '', '2017-06-16 00:00:00', '1', null, null);
INSERT INTO `tipo` VALUES ('2', '1', 'CARNET DE EXTRANJERIA', '20', 'CE', '', '2017-06-16 06:06:24', '1', '2017-07-19 22:47:30', '1');
INSERT INTO `tipo` VALUES ('3', '1', 'LIBRETA ELECTORAL', '10', 'LE.', '', '2017-06-16 06:07:09', '1', '2017-07-19 22:47:48', '1');
INSERT INTO `tipo` VALUES ('4', '1', 'REGISTRO ÚNICO DE CONTRIBUYENTE', '12', 'RUC', '', '2017-06-17 00:00:00', '1', null, null);
INSERT INTO `tipo` VALUES ('5', '2', 'CITA', '', 'Cta', '', '2017-06-17 00:00:00', '1', '2017-07-19 22:48:03', '1');
INSERT INTO `tipo` VALUES ('6', '2', 'PRE CITA', '', 'PCita', '', '2017-06-17 00:00:00', '1', '2017-07-19 22:48:15', '1');
INSERT INTO `tipo` VALUES ('7', '3', 'ADMINISTRATIVO', '', 'ADMIN', '', '2017-06-17 00:00:00', '1', '2017-06-17 00:00:00', '1');
INSERT INTO `tipo` VALUES ('8', '3', 'DENTISTA', '', 'DSTA', '', '2017-06-17 00:00:00', '1', null, null);
INSERT INTO `tipo` VALUES ('9', '3', 'PERSONAL', '', 'PRSNL', '', '2017-06-17 00:00:00', '1', null, null);

-- ----------------------------
-- Table structure for tipo_grupo
-- ----------------------------
DROP TABLE IF EXISTS `tipo_grupo`;
CREATE TABLE `tipo_grupo` (
  `ID_GRUPO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_GRUPO` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DESCRIPCION_GRUPO` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_GRUPO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tipo_grupo
-- ----------------------------
INSERT INTO `tipo_grupo` VALUES ('1', 'TIPO DOCUMENTO', 'DNI, CE, LE');
INSERT INTO `tipo_grupo` VALUES ('2', 'TIPO CITA', 'CITA, PRE-CITAS');
INSERT INTO `tipo_grupo` VALUES ('3', 'TIPO PERSONAL', 'ADMINISTRATIVO, DENTISTA, PERSONAL');
INSERT INTO `tipo_grupo` VALUES ('4', 'TIPO MEDICAMENTO', '');

-- ----------------------------
-- Table structure for tratamiento
-- ----------------------------
DROP TABLE IF EXISTS `tratamiento`;
CREATE TABLE `tratamiento` (
  `ID_TRATAMIENTO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPCION` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `APLICA_CARA` bit(1) NOT NULL,
  `APLICA_DIENTE` bit(1) NOT NULL,
  `PRECIO` double NOT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_TRATAMIENTO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tratamiento
-- ----------------------------
INSERT INTO `tratamiento` VALUES ('1', 'Obturación C/ Amalgama', 'Cavidad Simple - Solo Cara', '', '\0', '34', '', '2017-07-02 20:57:12', '2017-07-18 00:00:00', '1', '1');
INSERT INTO `tratamiento` VALUES ('2', 'Obturación C/ Amalgama - Solo Diente', 'Cavidad Compuesta - Solo Diente', '\0', '', '40', '', '2017-07-02 21:23:58', '2017-07-19 23:07:46', '1', '1');
INSERT INTO `tratamiento` VALUES ('3', 'Obturacion C/resinas Acrilicas: Cavidad', 'Obturacion C/resinas Acrilicas: Cavidad', '', '', '90.8', '', '2017-07-18 00:00:00', '2017-07-18 00:00:00', '1', '1');
INSERT INTO `tratamiento` VALUES ('4', 'Obt.con Ionómero Cav.simple', 'Obt.con Ionómero Cav.simple - Sin Cara Y Sin Diente', '\0', '\0', '40.9', '', '2017-07-18 00:00:00', '2017-07-18 18:28:24', '1', '1');
INSERT INTO `tratamiento` VALUES ('5', 'Lampara Luz Halógena', 'Lampara Luz Halógena', '', '', '30', '', '2017-07-18 18:30:42', '2017-07-18 18:39:03', '1', '1');

-- ----------------------------
-- Table structure for unidad_medida
-- ----------------------------
DROP TABLE IF EXISTS `unidad_medida`;
CREATE TABLE `unidad_medida` (
  `ID_UNIDAD_MEDIDA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `SIGLAS_UNIDAD` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `USUARIO_REGISTRO` int(11) NOT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_UNIDAD_MEDIDA`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of unidad_medida
-- ----------------------------
INSERT INTO `unidad_medida` VALUES ('1', 'Onzas', 'ONZ.', '', '2017-07-21 00:52:40', '1', '0000-00-00 00:00:00', null);
INSERT INTO `unidad_medida` VALUES ('2', 'Unidades', 'UNID.', '', '2017-07-21 03:18:05', '1', null, null);
INSERT INTO `unidad_medida` VALUES ('3', 'Mililitros', 'MTROS', '', '2017-07-21 03:18:38', '1', null, null);

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PERSONA` int(11) NOT NULL,
  `ID_ROL` int(11) DEFAULT NULL,
  `USERNAME` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `PASSWORD` varchar(51) COLLATE utf8_unicode_ci NOT NULL,
  `ESTADO` int(11) NOT NULL,
  `ACTIVE` bit(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `USUARIO_CREACION` int(11) DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `USUARIO_MODIFICACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_USUARIO`),
  KEY `FK_usuario_personal` (`ID_PERSONA`),
  KEY `FK_usuario_rol` (`ID_ROL`),
  CONSTRAINT `FK_usuario_persona` FOREIGN KEY (`ID_PERSONA`) REFERENCES `persona` (`ID_PERSONA`),
  CONSTRAINT `FK_usuario_rol` FOREIGN KEY (`ID_ROL`) REFERENCES `rol` (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('1', '1', '1', 'ADMIN', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1', '', '2017-07-01 08:30:13', '1', null, null);

-- ----------------------------
-- Function structure for CAP_FIRST
-- ----------------------------
DROP FUNCTION IF EXISTS `CAP_FIRST`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `CAP_FIRST`(input VARCHAR(255)) RETURNS varchar(255) CHARSET utf8
    DETERMINISTIC
BEGIN
	DECLARE len INT;
	DECLARE i INT;

	SET len   = CHAR_LENGTH(input);
	SET input = LOWER(input);
	SET i = 0;

	WHILE (i < len) DO
		IF (MID(input,i,1) = ' ' OR i = 0) THEN
			IF (i < len) THEN
				SET input = CONCAT(
					LEFT(input,i),
					UPPER(MID(input,i + 1,1)),
					RIGHT(input,len - i - 1)
				);
			END IF;
		END IF;
		SET i = i + 1;
	END WHILE;

	RETURN input;
END
;;
DELIMITER ;
