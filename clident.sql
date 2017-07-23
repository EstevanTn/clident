/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : clident

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-07-23 00:27:51
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Table structure for rol
-- ----------------------------
DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `ID_ROL` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_ROL` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
