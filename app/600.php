<?php
    $app->get('/api/v1/600', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_tipo_subtipo_codigo,
		d.DOMFIC_NOM		AS		estado_tipo_subtipo_nombre,
		c.DOMFIC_COD		AS		subtipo_codigo, 
		c.DOMFIC_NOM		AS		subtipo_nombre,
        c.DOMFIC_VAL		AS		subtipo_valor,
        c.DOMFIC_OBS		AS		subtipo_observacion, 
		b.DOMFIC_COD		AS		tipo_codigo,
		b.DOMFIC_NOM		AS		tipo_nombre,
        b.DOMFIC_VAL		AS		tipo_valor,
        b.DOMFIC_OBS		AS		tipo_observacion, 
		a.DOMTYS_COD		AS		tipo_subtipo_codigo,
        a.DOMTYS_VAL		AS		tipo_subtipo_valor, 
		a.DOMTYS_OBS		AS		tipo_subtipo_observacion
		
		FROM DOMTYS a
		INNER JOIN DOMFIC b ON a.DOMTYS_TIC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.DOMTYS_SUC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.DOMTYS_ESC = d.DOMFIC_COD
		
		ORDER BY b.DOMFIC_NOM, c.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_tipo_subtipo_codigo'                => $row['estado_tipo_subtipo_codigo'],
                    'estado_tipo_subtipo_nombre'		        => $row['estado_tipo_subtipo_nombre'],
					'subtipo_codigo'				            => $row['subtipo_codigo'],
                    'subtipo_nombre'				            => $row['subtipo_nombre'],
                    'subtipo_valor'	                            => $row['subtipo_valor'],
                    'subtipo_observacion'				        => $row['subtipo_observacion'],
					'tipo_codigo'					            => $row['tipo_codigo'],
                    'tipo_nombre'					            => $row['tipo_nombre'],
                    'tipo_valor'			                    => $row['tipo_valor'],
                    'tipo_observacion'			                => $row['tipo_observacion'],
					'tipo_subtipo_codigo'			            => $row['tipo_subtipo_codigo'],
                    'tipo_subtipo_valor'	                    => $row['tipo_subtipo_valor'],
                    'tipo_subtipo_observacion'			        => $row['tipo_subtipo_observacion']
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

    $app->get('/api/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_tipo_subtipo_codigo,
		d.DOMFIC_NOM		AS		estado_tipo_subtipo_nombre,
		c.DOMFIC_COD		AS		subtipo_codigo, 
		c.DOMFIC_NOM		AS		subtipo_nombre,
        c.DOMFIC_VAL		AS		subtipo_valor,
        c.DOMFIC_OBS		AS		subtipo_observacion, 
		b.DOMFIC_COD		AS		tipo_codigo,
		b.DOMFIC_NOM		AS		tipo_nombre,
        b.DOMFIC_VAL		AS		tipo_valor,
        b.DOMFIC_OBS		AS		tipo_observacion, 
		a.DOMTYS_COD		AS		tipo_subtipo_codigo,
        a.DOMTYS_VAL		AS		tipo_subtipo_valor, 
		a.DOMTYS_OBS		AS		tipo_subtipo_observacion
		
		FROM DOMTYS a
		INNER JOIN DOMFIC b ON a.DOMTYS_TIC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.DOMTYS_SUC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.DOMTYS_ESC = d.DOMFIC_COD
		
		WHERE a.DOMTYS_COD = '$val00'
		ORDER BY b.DOMFIC_NOM, c.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_tipo_subtipo_codigo'                => $row['estado_tipo_subtipo_codigo'],
                    'estado_tipo_subtipo_nombre'		        => $row['estado_tipo_subtipo_nombre'],
					'subtipo_codigo'				            => $row['subtipo_codigo'],
                    'subtipo_nombre'				            => $row['subtipo_nombre'],
                    'subtipo_valor'	                            => $row['subtipo_valor'],
                    'subtipo_observacion'				        => $row['subtipo_observacion'],
					'tipo_codigo'					            => $row['tipo_codigo'],
                    'tipo_nombre'					            => $row['tipo_nombre'],
                    'tipo_valor'			                    => $row['tipo_valor'],
                    'tipo_observacion'			                => $row['tipo_observacion'],
					'tipo_subtipo_codigo'			            => $row['tipo_subtipo_codigo'],
                    'tipo_subtipo_valor'	                    => $row['tipo_subtipo_valor'],
                    'tipo_subtipo_observacion'			        => $row['tipo_subtipo_observacion']
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

    $app->get('/api/v1/600/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_tipo_subtipo_codigo,
		d.DOMFIC_NOM		AS		estado_tipo_subtipo_nombre,
		c.DOMFIC_COD		AS		subtipo_codigo, 
		c.DOMFIC_NOM		AS		subtipo_nombre,
        c.DOMFIC_VAL		AS		subtipo_valor,
        c.DOMFIC_OBS		AS		subtipo_observacion, 
		b.DOMFIC_COD		AS		tipo_codigo,
		b.DOMFIC_NOM		AS		tipo_nombre,
        b.DOMFIC_VAL		AS		tipo_valor,
        b.DOMFIC_OBS		AS		tipo_observacion, 
		a.DOMTYS_COD		AS		tipo_subtipo_codigo,
        a.DOMTYS_VAL		AS		tipo_subtipo_valor, 
		a.DOMTYS_OBS		AS		tipo_subtipo_observacion
		
		FROM DOMTYS a
		INNER JOIN DOMFIC b ON a.DOMTYS_TIC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.DOMTYS_SUC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.DOMTYS_ESC = d.DOMFIC_COD
		
		WHERE a.DOMTYS_VAL = '$val00'
		ORDER BY b.DOMFIC_NOM, c.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_tipo_subtipo_codigo'                => $row['estado_tipo_subtipo_codigo'],
                    'estado_tipo_subtipo_nombre'		        => $row['estado_tipo_subtipo_nombre'],
					'subtipo_codigo'				            => $row['subtipo_codigo'],
                    'subtipo_nombre'				            => $row['subtipo_nombre'],
                    'subtipo_valor'	                            => $row['subtipo_valor'],
                    'subtipo_observacion'				        => $row['subtipo_observacion'],
					'tipo_codigo'					            => $row['tipo_codigo'],
                    'tipo_nombre'					            => $row['tipo_nombre'],
                    'tipo_valor'			                    => $row['tipo_valor'],
                    'tipo_observacion'			                => $row['tipo_observacion'],
					'tipo_subtipo_codigo'			            => $row['tipo_subtipo_codigo'],
                    'tipo_subtipo_valor'	                    => $row['tipo_subtipo_valor'],
                    'tipo_subtipo_observacion'			        => $row['tipo_subtipo_observacion']
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

	$app->post('/api/v1/600', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_tipo_subtipo_codigo'];
        $val02                      = $request->getParsedBody()['tipo_codigo'];
        $val03                      = $request->getParsedBody()['subtipo_codigo'];
        $val04                      = $request->getParsedBody()['tipo_subtipo_valor'];
        $val05                      = $request->getParsedBody()['tipo_subtipo_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO DOMTYS (DOMTYS_ESC, DOMTYS_TIC, DOMTYS_SUC, DOMTYS_VAL, DOMTYS_OBS) VALUES ('$val01', '$val02', '$val03', '".$val04."', '".$val05."')";
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

	$app->put('/api/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_tipo_subtipo_codigo'];
        $val02                      = $request->getParsedBody()['tipo_codigo'];
        $val03                      = $request->getParsedBody()['subtipo_codigo'];
        $val04                      = $request->getParsedBody()['tipo_subtipo_valor'];
        $val05                      = $request->getParsedBody()['tipo_subtipo_observacion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "UPDATE DOMTYS SET DOMTYS_ESC = '$val01', DOMTYS_TIC = '$val02', DOMTYS_SUC = '$val03', DOMTYS_OBS = '".$val05."' WHERE DOMTYS_COD = '$val00'";
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

	$app->delete('/api/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM DOMTYS WHERE DOMTYS_COD = '$val00'";
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