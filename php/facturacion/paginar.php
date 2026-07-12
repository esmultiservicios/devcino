<?php
session_start();
include '../funtions.php';

header('Content-Type: application/json; charset=utf-8');

$mysqli = connect_mysqli();

/*
|--------------------------------------------------------------------------
| RESPUESTA DE ERROR COMPATIBLE CON EL JS
|--------------------------------------------------------------------------
*/
function responder_error($mensaje) {
	echo json_encode(
		array(
			0 => '<table class="table table-striped table-condensed table-hover">
					<tr>
						<td colspan="13" style="color:#C7030D">' .
							htmlspecialchars(
								$mensaje,
								ENT_QUOTES,
								'UTF-8'
							) .
						'</td>
					</tr>
				  </table>',
			1 => ''
		),
		JSON_UNESCAPED_UNICODE
	);

	exit;
}

/*
|--------------------------------------------------------------------------
| CONSULTAS PREPARADAS
|--------------------------------------------------------------------------
*/
function ejecutar_consulta(
	$mysqli,
	$sql,
	$tipos = '',
	$parametros = array()
) {
	$stmt = $mysqli->prepare($sql);

	if (!$stmt) {
		throw new Exception(
			'Error preparando la consulta: ' .
			$mysqli->error
		);
	}

	if ($tipos !== '' && count($parametros) > 0) {
		$referencias = array($tipos);

		foreach ($parametros as $indice => $valor) {
			$referencias[] = &$parametros[$indice];
		}

		if (
			!call_user_func_array(
				array($stmt, 'bind_param'),
				$referencias
			)
		) {
			$mensaje = $stmt->error;
			$stmt->close();

			throw new Exception(
				'Error vinculando parámetros: ' .
				$mensaje
			);
		}
	}

	if (!$stmt->execute()) {
		$mensaje = $stmt->error;
		$stmt->close();

		throw new Exception(
			'Error ejecutando la consulta: ' .
			$mensaje
		);
	}

	return $stmt;
}

function agregar_parametro(
	&$tipos,
	&$parametros,
	$tipo,
	$valor
) {
	$tipos .= $tipo;
	$parametros[] = $valor;
}

/*
|--------------------------------------------------------------------------
| NORMALIZAR FECHA DEL FILTRO
|--------------------------------------------------------------------------
| Acepta:
| - YYYY-MM-DD
| - MM/DD/YYYY
*/
function normalizar_fecha_facturacion($fecha) {
	$fecha = trim((string)$fecha);

	if ($fecha === '') {
		return '';
	}

	$formatos = array(
		'Y-m-d',
		'm/d/Y',
		'n/j/Y'
	);

	foreach ($formatos as $formato) {
		$objeto = DateTime::createFromFormat(
			$formato,
			$fecha
		);

		$errores = DateTime::getLastErrors();

		$fechaSinErrores = (
			$errores === false ||
			(
				isset($errores['warning_count']) &&
				isset($errores['error_count']) &&
				$errores['warning_count'] === 0 &&
				$errores['error_count'] === 0
			)
		);

		if (
			$objeto !== false &&
			$fechaSinErrores
		) {
			return $objeto->format('Y-m-d');
		}
	}

	return '';
}

try {
	/*
	|--------------------------------------------------------------------------
	| VALIDAR SESIÓN
	|--------------------------------------------------------------------------
	*/
	if (
		!isset($_SESSION['colaborador_id']) ||
		(int)$_SESSION['colaborador_id'] <= 0
	) {
		throw new Exception(
			'La sesión ha expirado'
		);
	}

	$colaborador_id =
		(int)$_SESSION['colaborador_id'];

	/*
	|--------------------------------------------------------------------------
	| RECIBIR FILTROS
	|--------------------------------------------------------------------------
	*/
	$paginaActual =
		isset($_POST['partida'])
			? (int)$_POST['partida']
			: 1;

	if ($paginaActual <= 0) {
		$paginaActual = 1;
	}

	$fechai = normalizar_fecha_facturacion(
		isset($_POST['fechai'])
			? $_POST['fechai']
			: ''
	);

	$fechaf = normalizar_fecha_facturacion(
		isset($_POST['fechaf'])
			? $_POST['fechaf']
			: ''
	);

	$dato =
		isset($_POST['dato'])
			? trim((string)$_POST['dato'])
			: '';

	$profesional = (
		isset($_POST['profesional']) &&
		$_POST['profesional'] !== ''
	)
		? (int)$_POST['profesional']
		: 0;

	$estado = (
		isset($_POST['estado']) &&
		$_POST['estado'] !== ''
	)
		? (int)$_POST['estado']
		: 1;

	if ($estado <= 0) {
		$estado = 1;
	}

	/*
	|--------------------------------------------------------------------------
	| CONSTRUIR FILTROS
	|--------------------------------------------------------------------------
	*/
	$condiciones = array();
	$tipos = '';
	$parametros = array();

	$condiciones[] = 'f.estado = ?';

	agregar_parametro(
		$tipos,
		$parametros,
		'i',
		$estado
	);

	if (
		$fechai !== '' &&
		$fechaf !== ''
	) {
		$condiciones[] =
			'f.fecha BETWEEN ? AND ?';

		agregar_parametro(
			$tipos,
			$parametros,
			's',
			$fechai
		);

		agregar_parametro(
			$tipos,
			$parametros,
			's',
			$fechaf
		);
	} elseif ($fechai !== '') {
		$condiciones[] = 'f.fecha >= ?';

		agregar_parametro(
			$tipos,
			$parametros,
			's',
			$fechai
		);
	} elseif ($fechaf !== '') {
		$condiciones[] = 'f.fecha <= ?';

		agregar_parametro(
			$tipos,
			$parametros,
			's',
			$fechaf
		);
	}

	if ($profesional > 0) {
		$condiciones[] =
			'f.colaborador_id = ?';

		agregar_parametro(
			$tipos,
			$parametros,
			'i',
			$profesional
		);
	}

	/*
	|--------------------------------------------------------------------------
	| RESTRICCIÓN ORIGINAL
	|--------------------------------------------------------------------------
	| Pagadas y Crédito se filtran por el usuario que las registró.
	*/
	if (
		$estado === 2 ||
		$estado === 4
	) {
		$condiciones[] = 'f.usuario = ?';

		agregar_parametro(
			$tipos,
			$parametros,
			'i',
			$colaborador_id
		);
	}

	if ($dato !== '') {
		$condiciones[] = "(
			CAST(COALESCE(p.expediente, '') AS CHAR) LIKE ?
			OR CONCAT(
				COALESCE(p.nombre, ''),
				' ',
				COALESCE(p.apellido, '')
			) LIKE ?
			OR COALESCE(p.identidad, '') LIKE ?
			OR COALESCE(p.apellido, '') LIKE ?
			OR CAST(COALESCE(f.number, 0) AS CHAR) LIKE ?
		)";

		$datoGeneral = '%' . $dato . '%';
		$datoInicio = $dato . '%';

		agregar_parametro(
			$tipos,
			$parametros,
			's',
			$datoGeneral
		);

		agregar_parametro(
			$tipos,
			$parametros,
			's',
			$datoGeneral
		);

		agregar_parametro(
			$tipos,
			$parametros,
			's',
			$datoInicio
		);

		agregar_parametro(
			$tipos,
			$parametros,
			's',
			$datoInicio
		);

		agregar_parametro(
			$tipos,
			$parametros,
			's',
			$datoInicio
		);
	}

	$where =
		'WHERE ' .
		implode(
			' AND ',
			$condiciones
		);

	/*
	|--------------------------------------------------------------------------
	| CONSULTA BASE
	|--------------------------------------------------------------------------
	| LEFT JOIN evita ocultar una factura si una relación secundaria todavía
	| no tiene coincidencia.
	*/
	$from = "
		FROM facturas AS f
		LEFT JOIN pacientes AS p
			ON f.pacientes_id =
			   p.pacientes_id
		LEFT JOIN secuencia_facturacion AS sc
			ON f.secuencia_facturacion_id =
			   sc.secuencia_facturacion_id
		LEFT JOIN servicios AS s
			ON f.servicio_id =
			   s.servicio_id
		LEFT JOIN colaboradores AS c
			ON f.colaborador_id =
			   c.colaborador_id
	";

	/*
	|--------------------------------------------------------------------------
	| CONTAR REGISTROS
	|--------------------------------------------------------------------------
	*/
	$sqlConteo = "
		SELECT
			COUNT(DISTINCT f.facturas_id) AS total
		$from
		$where
	";

	$stmtConteo = ejecutar_consulta(
		$mysqli,
		$sqlConteo,
		$tipos,
		$parametros
	);

	$resultConteo =
		$stmtConteo->get_result();

	$filaConteo =
		$resultConteo->fetch_assoc();

	$nroProductos =
		isset($filaConteo['total'])
			? (int)$filaConteo['total']
			: 0;

	$stmtConteo->close();

	/*
	|--------------------------------------------------------------------------
	| PAGINACIÓN
	|--------------------------------------------------------------------------
	*/
	$nroLotes = 10;

	$nroPaginas =
		$nroProductos > 0
			? (int)ceil(
				$nroProductos / $nroLotes
			)
			: 0;

	if (
		$nroPaginas > 0 &&
		$paginaActual > $nroPaginas
	) {
		$paginaActual = $nroPaginas;
	}

	$limit =
		$nroLotes *
		($paginaActual - 1);

	$lista = '';

	if ($paginaActual > 1) {
		$lista .=
			'<li class="page-item">
				<a class="page-link"
				   href="javascript:pagination(1);void(0);">
					Inicio
				</a>
			</li>';

		$lista .=
			'<li class="page-item">
				<a class="page-link"
				   href="javascript:pagination(' .
					($paginaActual - 1) .
				   ');void(0);">
					Anterior ' .
					($paginaActual - 1) .
				'</a>
			</li>';
	}

	if ($paginaActual < $nroPaginas) {
		$lista .=
			'<li class="page-item">
				<a class="page-link"
				   href="javascript:pagination(' .
					($paginaActual + 1) .
				   ');void(0);">
					Siguiente ' .
					($paginaActual + 1) .
					' de ' .
					$nroPaginas .
				'</a>
			</li>';

		$lista .=
			'<li class="page-item">
				<a class="page-link"
				   href="javascript:pagination(' .
					$nroPaginas .
				   ');void(0);">
					Última
				</a>
			</li>';
	}

	/*
	|--------------------------------------------------------------------------
	| CONSULTAR FACTURAS
	|--------------------------------------------------------------------------
	| El importe mostrado conserva la lógica del archivo original:
	| suma de precio por línea. El neto usa cantidad, ISV y descuento.
	*/
	$sqlRegistro = "
		SELECT
			f.facturas_id,
			DATE_FORMAT(
				f.fecha,
				'%d/%m/%Y'
			) AS fecha,
			CONCAT(
				COALESCE(p.nombre, ''),
				' ',
				COALESCE(p.apellido, '')
			) AS paciente,
			COALESCE(
				p.identidad,
				''
			) AS identidad,
			CONCAT(
				COALESCE(c.nombre, ''),
				' ',
				COALESCE(c.apellido, '')
			) AS profesional,
			f.estado,
			COALESCE(
				s.nombre,
				''
			) AS consultorio,
			COALESCE(
				sc.prefijo,
				''
			) AS prefijo,
			COALESCE(
				f.number,
				0
			) AS numero,
			COALESCE(
				sc.relleno,
				0
			) AS relleno,
			COALESCE(
				SUM(fd.precio),
				0
			) AS importe,
			COALESCE(
				SUM(fd.isv_valor),
				0
			) AS isv,
			COALESCE(
				SUM(fd.descuento),
				0
			) AS descuento,
			COALESCE(
				SUM(
					(fd.precio * fd.cantidad) +
					fd.isv_valor -
					fd.descuento
				),
				0
			) AS neto
		$from
		LEFT JOIN facturas_detalle AS fd
			ON f.facturas_id =
			   fd.facturas_id
		$where
		GROUP BY
			f.facturas_id,
			f.fecha,
			p.nombre,
			p.apellido,
			p.identidad,
			c.nombre,
			c.apellido,
			f.estado,
			s.nombre,
			sc.prefijo,
			f.number,
			sc.relleno
		ORDER BY
			f.facturas_id DESC
		LIMIT ?, ?
	";

	$tiposRegistro =
		$tipos . 'ii';

	$parametrosRegistro =
		$parametros;

	$parametrosRegistro[] = $limit;
	$parametrosRegistro[] = $nroLotes;

	$stmtRegistro = ejecutar_consulta(
		$mysqli,
		$sqlRegistro,
		$tiposRegistro,
		$parametrosRegistro
	);

	$result =
		$stmtRegistro->get_result();

	/*
	|--------------------------------------------------------------------------
	| TABLA
	|--------------------------------------------------------------------------
	*/
	$tabla =
		'<table class="table table-striped table-condensed table-hover">
			<tr>
				<th width="2.69%">No.</th>
				<th width="7.69%">Fecha</th>
				<th width="10.69%">Factura</th>
				<th width="10.69%">Paciente</th>
				<th width="7.69%">Identidad</th>
				<th width="7.69%">Profesional</th>
				<th width="7.69%">Consultorio</th>
				<th width="7.69%">Importe</th>
				<th width="7.69%">ISV</th>
				<th width="7.69%">Descuento</th>
				<th width="7.69%">Neto</th>
				<th width="7.69%">Estado</th>
				<th width="7.69%">Opciones</th>
			</tr>';

	$i = $limit + 1;

	while (
		$registro2 =
			$result->fetch_assoc()
	) {
		$facturas_id =
			(int)$registro2['facturas_id'];

		$estadoFactura =
			(int)$registro2['estado'];

		if (
			(int)$registro2['numero'] === 0
		) {
			$numero =
				'Aún no se ha generado';
		} else {
			$numero =
				$registro2['prefijo'] .
				rellenarDigitos(
					$registro2['numero'],
					$registro2['relleno']
				);
		}

		$factura = '';
		$eliminar = '';
		$pay = '';
		$send_mail = '';
		$pay_credit = '';

		if ($estadoFactura === 1) {
			$eliminar =
				'<a
					style="text-decoration:none;"
					data-toggle="tooltip"
					data-placement="right"
					href="javascript:deleteBill(' .
						$facturas_id .
					');void(0);"
					class="fas fa-trash fa-lg"
					title="Eliminar Factura">
				</a>';

			$pay =
				'<a
					style="text-decoration:none;"
					data-toggle="tooltip"
					data-placement="right"
					title="Realizar Cobro"
					href="javascript:pay(' .
						$facturas_id .
					');void(0);"
					class="fas fa-file-invoice fa-lg">
				</a>';
		}

		if (
			$estadoFactura === 2 ||
			$estadoFactura === 3 ||
			$estadoFactura === 4
		) {
			$factura =
				'<a
					style="text-decoration:none;"
					data-toggle="tooltip"
					data-placement="right"
					href="javascript:printBill(' .
						$facturas_id .
					');void(0);"
					class="fas fa-print fa-lg"
					title="Imprimir Factura">
				</a>';
		}

		if ($estadoFactura === 2) {
			$send_mail =
				'<a
					style="text-decoration:none;"
					data-toggle="tooltip"
					data-placement="right"
					href="javascript:mailBill(' .
						$facturas_id .
					');void(0);"
					class="far fa-paper-plane fa-lg"
					title="Enviar Factura">
				</a>';
		}

		if ($estadoFactura === 4) {
			$pay_credit =
				'<a
					style="text-decoration:none;"
					data-toggle="tooltip"
					data-placement="right"
					href="javascript:pago(' .
						$facturas_id .
					');void(0);"
					class="fab fa-amazon-pay fa-lg"
					title="Pagar Factura">
				</a>';
		}

		switch ($estadoFactura) {
			case 1:
				$estadoTexto = 'Borrador';
				break;

			case 2:
				$estadoTexto = 'Pagada';
				break;

			case 3:
				$estadoTexto = 'Cancelada';
				break;

			case 4:
				$estadoTexto = 'Crédito';
				break;

			default:
				$estadoTexto = '';
				break;
		}

		$tabla .=
			'<tr>
				<td>' . $i . '</td>
				<td>' .
					htmlspecialchars(
						$registro2['fecha'],
						ENT_QUOTES,
						'UTF-8'
					) .
				'</td>
				<td>' .
					htmlspecialchars(
						$numero,
						ENT_QUOTES,
						'UTF-8'
					) .
				'</td>
				<td>' .
					htmlspecialchars(
						trim($registro2['paciente']),
						ENT_QUOTES,
						'UTF-8'
					) .
				'</td>
				<td>' .
					htmlspecialchars(
						$registro2['identidad'],
						ENT_QUOTES,
						'UTF-8'
					) .
				'</td>
				<td>' .
					htmlspecialchars(
						trim($registro2['profesional']),
						ENT_QUOTES,
						'UTF-8'
					) .
				'</td>
				<td>' .
					htmlspecialchars(
						$registro2['consultorio'],
						ENT_QUOTES,
						'UTF-8'
					) .
				'</td>
				<td>' .
					number_format(
						(float)$registro2['importe'],
						2
					) .
				'</td>
				<td>' .
					number_format(
						(float)$registro2['isv'],
						2
					) .
				'</td>
				<td>' .
					number_format(
						(float)$registro2['descuento'],
						2
					) .
				'</td>
				<td>' .
					number_format(
						(float)$registro2['neto'],
						2
					) .
				'</td>
				<td>' .
					$estadoTexto .
				'</td>
				<td>
					' . $send_mail . '
					' . $pay_credit . '
					' . $pay . '
					' . $factura . '
					' . $eliminar . '
				</td>
			</tr>';

		$i++;
	}

	if ($nroProductos === 0) {
		$tabla .=
			'<tr>
				<td
					colspan="13"
					style="color:#C7030D">
					No se encontraron resultados con los filtros seleccionados
				</td>
			</tr>';
	} else {
		$tabla .=
			'<tr>
				<td colspan="13">
					<b>
						<p align="center">
							Total de Registros Encontrados ' .
							$nroProductos .
						'</p>
					</b>
				</td>
			</tr>';
	}

	$tabla .= '</table>';

	echo json_encode(
		array(
			0 => $tabla,
			1 => $lista
		),
		JSON_UNESCAPED_UNICODE
	);

	$stmtRegistro->close();
	$mysqli->close();

} catch (Throwable $error) {
	if (
		isset($mysqli) &&
		$mysqli
	) {
		$mysqli->close();
	}

	responder_error(
		$error->getMessage()
	);
}