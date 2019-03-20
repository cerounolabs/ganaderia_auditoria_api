<?php
    $app->get('/api/v1/1300', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		tipo_documento_codigo,
        d.DOMFIC_NOM		AS		tipo_documento_nombre,
        d.DOMFIC_VAL		AS		tipo_documento_valor,
        d.DOMFIC_OBS		AS		tipo_documento_observacion,
		c.DOMFIC_COD		AS		tipo_persona_codigo,
        c.DOMFIC_NOM		AS		tipo_persona_nombre,
        c.DOMFIC_VAL		AS		tipo_persona_valor,
        c.DOMFIC_OBS		AS		tipo_persona_observacion,
		b.DOMFIC_COD		AS		estado_persona_codigo,
        b.DOMFIC_NOM		AS		estado_persona_nombre,
        b.DOMFIC_VAL		AS		estado_persona_valor,
        b.DOMFIC_OBS		AS		estado_persona_observacion,
		a.PERFIC_COD		AS		persona_codigo,
        a.PERFIC_NOM		AS		persona_nombre,
		a.PERFIC_APE		AS		persona_apellido,
        a.PERFIC_RAZ		AS		persona_razon_social,
        a.PERFIC_DOC		AS		persona_documento,
        a.PERFIC_FNA		AS		persona_fecha_nacimiento,
        a.PERFIC_TEL		AS		persona_telefono,
        a.PERFIC_COR		AS		persona_correo_electronico
		
		FROM PERFIC a
		INNER JOIN DOMFIC b ON a.PERFIC_EPC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.PERFIC_TPC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.PERFIC_TDC = d.DOMFIC_COD
		
		ORDER BY a.PERFIC_APE, a.PERFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                if ($row['persona_nombre'] == NULL && $row['persona_apellido'] == NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
					'estado_persona_codigo'                     => $row['estado_persona_codigo'],
                    'estado_persona_nombre'		                => $row['estado_persona_nombre'],
					'estado_persona_valor'				        => $row['estado_persona_valor'],
                    'estado_persona_observacion'				=> $row['estado_persona_observacion'],
                    'tipo_persona_codigo'	                    => $row['tipo_persona_codigo'],
                    'tipo_persona_nombre'				        => $row['tipo_persona_nombre'],
					'tipo_persona_valor'					    => $row['tipo_persona_valor'],
                    'tipo_persona_observacion'					=> $row['tipo_persona_observacion'],
                    'tipo_documento_codigo'			            => $row['tipo_documento_codigo'],
                    'tipo_documento_nombre'			            => $row['tipo_documento_nombre'],
					'tipo_documento_valor'			            => $row['tipo_documento_valor'],
                    'tipo_documento_observacion'	            => $row['tipo_documento_observacion'],
                    'persona_codigo'			                => $row['persona_codigo'],
                    'persona_completo'		                    => $nombreCompleto,
                    'persona_nombre'			                => $row['persona_nombre'],
                    'persona_apellido'			                => $row['persona_apellido'],
                    'persona_razon_social'			            => $row['persona_razon_social'],
                    'persona_documento'			                => $row['persona_documento'],
                    'persona_fecha_nacimiento'			        => $row['persona_fecha_nacimiento'],
                    'persona_telefono'			                => $row['persona_telefono'],
                    'persona_correo_electronico'			    => $row['persona_correo_electronico']
				);	
                $result[]           = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => 'null'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		tipo_documento_codigo,
        d.DOMFIC_NOM		AS		tipo_documento_nombre,
        d.DOMFIC_VAL		AS		tipo_documento_valor,
        d.DOMFIC_OBS		AS		tipo_documento_observacion,
		c.DOMFIC_COD		AS		tipo_persona_codigo,
        c.DOMFIC_NOM		AS		tipo_persona_nombre,
        c.DOMFIC_VAL		AS		tipo_persona_valor,
        c.DOMFIC_OBS		AS		tipo_persona_observacion,
		b.DOMFIC_COD		AS		estado_persona_codigo,
        b.DOMFIC_NOM		AS		estado_persona_nombre,
        b.DOMFIC_VAL		AS		estado_persona_valor,
        b.DOMFIC_OBS		AS		estado_persona_observacion,
		a.PERFIC_COD		AS		persona_codigo,
        a.PERFIC_NOM		AS		persona_nombre,
		a.PERFIC_APE		AS		persona_apellido,
        a.PERFIC_RAZ		AS		persona_razon_social,
        a.PERFIC_DOC		AS		persona_documento,
        a.PERFIC_FNA		AS		persona_fecha_nacimiento,
        a.PERFIC_TEL		AS		persona_telefono,
        a.PERFIC_COR		AS		persona_correo_electronico
		
		FROM PERFIC a
		INNER JOIN DOMFIC b ON a.PERFIC_EPC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.PERFIC_TPC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.PERFIC_TDC = d.DOMFIC_COD
		
		WHERE a.PERFIC_COD = '$val00'
		ORDER BY a.PERFIC_APE, a.PERFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                if ($row['persona_nombre'] == NULL && $row['persona_apellido'] == NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }
                			
                $detalle			= array(
					'estado_persona_codigo'                     => $row['estado_persona_codigo'],
                    'estado_persona_nombre'		                => $row['estado_persona_nombre'],
					'estado_persona_valor'				        => $row['estado_persona_valor'],
                    'estado_persona_observacion'				=> $row['estado_persona_observacion'],
                    'tipo_persona_codigo'	                    => $row['tipo_persona_codigo'],
                    'tipo_persona_nombre'				        => $row['tipo_persona_nombre'],
					'tipo_persona_valor'					    => $row['tipo_persona_valor'],
                    'tipo_persona_observacion'					=> $row['tipo_persona_observacion'],
                    'tipo_documento_codigo'			            => $row['tipo_documento_codigo'],
                    'tipo_documento_nombre'			            => $row['tipo_documento_nombre'],
					'tipo_documento_valor'			            => $row['tipo_documento_valor'],
                    'tipo_documento_observacion'	            => $row['tipo_documento_observacion'],
                    'persona_codigo'			                => $row['persona_codigo'],
                    'persona_completo'		                    => $nombreCompleto,
                    'persona_nombre'			                => $row['persona_nombre'],
                    'persona_apellido'			                => $row['persona_apellido'],
                    'persona_razon_social'			            => $row['persona_razon_social'],
                    'persona_documento'			                => $row['persona_documento'],
                    'persona_fecha_nacimiento'			        => $row['persona_fecha_nacimiento'],
                    'persona_telefono'			                => $row['persona_telefono'],
                    'persona_correo_electronico'			    => $row['persona_correo_electronico']
				);
                $result[]           = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => 'null'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1300', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_persona_codigo'];
        $val02                      = $request->getParsedBody()['tipo_persona_codigo'];
        $val03                      = $request->getParsedBody()['tipo_documento_codigo'];
        $val04                      = strtoupper($request->getParsedBody()['persona_nombre']);
        $val05                      = strtoupper($request->getParsedBody()['persona_apellido']);
        $val06                      = strtoupper($request->getParsedBody()['persona_razon_social']);
        $val07                      = $request->getParsedBody()['persona_documento'];
        $val08                      = $request->getParsedBody()['persona_fecha_nacimiento'];
        $val09                      = $request->getParsedBody()['persona_telefono'];
        $val10                      = $request->getParsedBody()['persona_correo_electronico'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val07)) {
            $sql                    = "INSERT INTO PERFIC (PERFIC_EPC, PERFIC_TPC, PERFIC_TDC, PERFIC_NOM, PERFIC_APE, PERFIC_RAZ, PERFIC_DOC, PERFIC_FNA, PERFIC_TEL, PERFIC_COR) VALUES ('$val01', '$val02', '$val03', '".$val04."', '".$val05."', '".$val06."', '".$val07."', '".$val08."', '".$val09."', '".$val10."')";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se inserto con exito', 'codigo' => $mysqli->insert_id), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'No se pudo insertar', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });

	$app->put('/api/v1/1300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_persona_codigo'];
        $val02                      = $request->getParsedBody()['tipo_persona_codigo'];
        $val03                      = $request->getParsedBody()['tipo_documento_codigo'];
        $val04                      = strtoupper($request->getParsedBody()['persona_nombre']);
        $val05                      = strtoupper($request->getParsedBody()['persona_apellido']);
        $val06                      = strtoupper($request->getParsedBody()['persona_razon_social']);
        $val07                      = $request->getParsedBody()['persona_documento'];
        $val08                      = $request->getParsedBody()['persona_fecha_nacimiento'];
        $val09                      = $request->getParsedBody()['persona_telefono'];
        $val10                      = $request->getParsedBody()['persona_correo_electronico'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val07)) {
            $sql                    = "UPDATE PERFIC SET PERFIC_EPC = '$val01', PERFIC_TPC = '$val02', PERFIC_TDC = '$val03', PERFIC_NOM = '".$val04."', PERFIC_APE = '".$val05."', PERFIC_RAZ = '".$val06."', PERFIC_DOC = '".$val07."', PERFIC_FNA = '".$val08."', PERFIC_TEL = '".$val09."', PERFIC_COR = '".$val10."' WHERE PERFIC_COD = '$val00'";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se actualizo con exito'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'No se pudo actualizar'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });

	$app->delete('/api/v1/1300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM PERFIC WHERE PERFIC_COD = '$val00'";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se elimino con exito'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'No se pudo eliminar'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });