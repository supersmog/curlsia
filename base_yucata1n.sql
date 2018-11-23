-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.2.18-MariaDB - openSUSE package
-- SO del servidor:              Linux
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para yucatan
CREATE DATABASE IF NOT EXISTS `yucatan` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `yucatan`;

-- Volcando estructura para tabla yucatan.afecta_presupuesto
CREATE TABLE IF NOT EXISTS `afecta_presupuesto` (
  `id` int(11) DEFAULT NULL,
  `solicitud` varchar(12) DEFAULT NULL,
  `presupuesto` varchar(10) DEFAULT NULL,
  `status_sia` varchar(4) DEFAULT NULL,
  `monto _financiar` double DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `status_valido` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='contiene las soliitudes que afectan al presupuesto';

-- Volcando datos para la tabla yucatan.afecta_presupuesto: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `afecta_presupuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `afecta_presupuesto` ENABLE KEYS */;

-- Volcando estructura para tabla yucatan.colocadas_sia
CREATE TABLE IF NOT EXISTS `colocadas_sia` (
  `id_colocada` int(11) NOT NULL AUTO_INCREMENT,
  `solicitud` varchar(12) NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `subprograma` varchar(4) DEFAULT NULL,
  `id_estatus` varchar(4) DEFAULT NULL,
  `rpu` varchar(12) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `colonia` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_colocada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='contiene las solicitudes capturadas en el dia a dia en el sistema SIA';

-- Volcando datos para la tabla yucatan.colocadas_sia: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `colocadas_sia` DISABLE KEYS */;
/*!40000 ALTER TABLE `colocadas_sia` ENABLE KEYS */;

-- Volcando estructura para tabla yucatan.login_distribuidor
CREATE TABLE IF NOT EXISTS `login_distribuidor` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_login`),
  KEY `FK_login_distribuidor_proveedores` (`id_proveedor`),
  CONSTRAINT `FK_login_distribuidor_proveedores` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='contiene los diversos logins de los distribuidores';

-- Volcando datos para la tabla yucatan.login_distribuidor: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `login_distribuidor` DISABLE KEYS */;
INSERT INTO `login_distribuidor` (`id_login`, `id_proveedor`, `login`) VALUES
	(1, 1, 'elmame00118'),
	(2, 2, 'rosu1me00218'),
	(3, 3, 'creplme00318'),
	(4, 4, 'hociame00418'),
	(5, 5, 'comeme00518');
/*!40000 ALTER TABLE `login_distribuidor` ENABLE KEYS */;

-- Volcando estructura para tabla yucatan.proveedores
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_comercial` varchar(100) DEFAULT NULL,
  `nombre_fiscal` varchar(100) DEFAULT NULL,
  `representante_legal` varchar(100) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `id_coordinacion` varchar(5) DEFAULT NULL,
  `tipo_persona` varchar(50) DEFAULT NULL,
  `subprogramas` varchar(20) DEFAULT NULL,
  `presupuesto_asignado` double DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='Contiene los datos basicos de los proveedores inscritos ';

-- Volcando datos para la tabla yucatan.proveedores: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` (`id_proveedor`, `nombre_comercial`, `nombre_fiscal`, `representante_legal`, `direccion`, `id_coordinacion`, `tipo_persona`, `subprogramas`, `presupuesto_asignado`) VALUES
	(1, 'MAYORISTA', 'MAYORISTA DEL SURESTE S. DE R.L. DE C.V.', 'PATRICIO CORREA LOSA', 'CALLE 9 #251C X 36 Y 38 COLONIA CAMPESTRE', 'YUC', 'moral', 'RF,AA', 3879310.34),
	(2, 'RODEKA', 'RODEKA DEL SURESTE S.A. DE C.V.', 'KARINA ROSAS DELGADO', 'CALLE 32A #510 X 9 Y 9A COLONIA MAYA CP 97134, MÉRIDA, YUCATÁN.', 'YUC', 'moral', 'RF,AA', 2068965.51),
	(3, 'CREDIPLUS', 'DISTRIBUIDORA ELECTRÓNICA DEL SURESTE S.A. DE C.V.', 'ALEJANDRO LOPEZ SEMERENA', 'CALLE 62 #596 X 73 Y 75 COLONIA CENTRO CP 97000 MÉRIDA, YUCATÁN', 'YUC', 'moral', 'RF,AA', 2586206.89),
	(4, 'HOGARCIA', 'JAVIER ROBERTO GARCIA CASELLAS', 'JAVIER ROBERTO GARCIA CASELLAS', 'CALLE 73 #542 X 68 Y 70 COLONIA CENTRO CP 97000 MÉRIDA, YUCATÁN', 'YUC', 'fisica', 'RF,AA', 3879310.34),
	(5, 'COMERMEX', 'COMERCIALIZADORA DE MUEBLES, ELECTRÓNICA Y REFRIGERACIÓN DE MÉXICO S.A. DE C.V.', 'SABRINA DAYANA FUENTE LOPEZ', 'CALLE 39 #243 X 8 Y 10 COLONIA LEANDRO VALLE CP 97143, MÉRIDA, YUCATÁN.', 'YUC', 'moral', 'RF,AA', 3017241.37);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;

-- Volcando estructura para tabla yucatan.status_sia
CREATE TABLE IF NOT EXISTS `status_sia` (
  `id_status` varchar(4) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `status_valido` varchar(3) DEFAULT NULL,
  `afecta_presupuesto` varchar(3) DEFAULT NULL,
  `xliberar` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Contiene los distintos estatus de las solicitudes en el Sistema SIA';

-- Volcando datos para la tabla yucatan.status_sia: ~14 rows (aproximadamente)
/*!40000 ALTER TABLE `status_sia` DISABLE KEYS */;
INSERT INTO `status_sia` (`id_status`, `descripcion`, `status_valido`, `afecta_presupuesto`, `xliberar`) VALUES
	('IMP', 'PARA IMPRESIÓN', 'SI', 'SI', 'Si'),
	('INE', 'INTEGRACIÓN DE EXPEDIENTE', 'SI', 'No', 'No'),
	('LPA', 'Liberada por autorizar', 'si', 'si', 'si'),
	('LPC', 'Liberada por autorizar', 'si', 'si', 'si'),
	('LSC', 'LIBERADA EN SCC', 'SI', 'SI', 'No'),
	('PEX', 'PAQUETE DE EXPEDIENTE', 'SI', 'SI', 'Si'),
	('PIN', 'PARA INSTALACIÓN', 'SI', 'SI', 'Si'),
	('PLI', 'PARA LIBERACION', 'SI', 'SI', 'Si'),
	('PPO', 'PARA PRESUPUESTO', 'SI', 'No', 'No'),
	('PSU', 'PARA SUPERVISION', 'SI', 'SI', 'Si'),
	('RAT', 'RECHAZADA ATENCION', 'No', 'No', 'No'),
	('REC', 'RECHAZADA CLIENTE', 'No', 'No', 'No'),
	('REX', 'RECEPCIÓN DE EXPEDIENTE', 'SI', 'SI', 'Si'),
	('SVT', 'SOLICITUD VENCIDA', 'No', 'No', 'No');
/*!40000 ALTER TABLE `status_sia` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
