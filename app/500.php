<?php
    $app->get('/api/v1/500', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		b.DOMFIC_COD		AS		estado_dominio_codigo,
		b.DOMFIC_NOM		AS		estado_dominio_nombre,
		a.DOMFIC_COD		AS		dominio_codigo, 
		a.DOMFIC_NOM		AS		dominio_nombre,
		a.DOMFIC_VAL		AS		dominio_valor,
		a.DOMFIC_OBS		AS		dominio_observacion
		
		FROM DOMFIC a
		INNER JOIN DOMFIC b ON a.DOMFIC_EDC = b.DOMFIC_COD
		
		ORDER BY a.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_dominio_codigo'			    => $row['estado_dominio_codigo'],
					'estado_dominio_nombre'			    => $row['estado_dominio_nombre'],
					'dominio_codigo'					=> $row['dominio_codigo'], 
					'dominio_nombre'					=> $row['dominio_nombre'],
					'dominio_valor'					    => $row['dominio_valor'],
					'dominio_observacion'				=> $row['dominio_observacion']
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

    $app->get('/api/v1/500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		b.DOMFIC_COD		AS		estado_dominio_codigo,
		b.DOMFIC_NOM		AS		estado_dominio_nombre,
		a.DOMFIC_COD		AS		dominio_codigo, 
		a.DOMFIC_NOM		AS		dominio_nombre,
		a.DOMFIC_VAL		AS		dominio_valor,
		a.DOMFIC_OBS		AS		dominio_observacion
		
		FROM DOMFIC a
		INNER JOIN DOMFIC b ON a.DOMFIC_EDC = b.DOMFIC_COD
		
		WHERE a.DOMFIC_COD = '$val00'
		ORDER BY a.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_dominio_codigo'			    => $row['estado_dominio_codigo'],
					'estado_dominio_nombre'			    => $row['estado_dominio_nombre'],
					'dominio_codigo'					=> $row['dominio_codigo'], 
					'dominio_nombre'					=> $row['dominio_nombre'],
					'dominio_valor'					    => $row['dominio_valor'],
					'dominio_observacion'				=> $row['dominio_observacion']
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

    $app->get('/api/v1/500/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		b.DOMFIC_COD		AS		estado_dominio_codigo,
		b.DOMFIC_NOM		AS		estado_dominio_nombre,
		a.DOMFIC_COD		AS		dominio_codigo, 
		a.DOMFIC_NOM		AS		dominio_nombre,
		a.DOMFIC_VAL		AS		dominio_valor,
		a.DOMFIC_OBS		AS		dominio_observacion
		
		FROM DOMFIC a
		INNER JOIN DOMFIC b ON a.DOMFIC_EDC = b.DOMFIC_COD
		
		WHERE a.DOMFIC_VAL = '$val00'
		ORDER BY a.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_dominio_codigo'			    => $row['estado_dominio_codigo'],
					'estado_dominio_nombre'			    => $row['estado_dominio_nombre'],
					'dominio_codigo'					=> $row['dominio_codigo'], 
					'dominio_nombre'					=> $row['dominio_nombre'],
					'dominio_valor'					    => $row['dominio_valor'],
					'dominio_observacion'				=> $row['dominio_observacion']
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
	
	$app->post('/api/v1/500', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        $val01                      = $request->getParsedBody()['estado_dominio_codigo'];
		$val02                      = strtoupper($request->getParsedBody()['dominio_nombre']);
		$val03                      = strtoupper($request->getParsedBody()['dominio_valor']);
		$val04                      = $request->getParsedBody()['dominio_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO DOMFIC (DOMFIC_EDC, DOMFIC_NOM, DOMFIC_VAL, DOMFIC_OBS) VALUES ('$val01', '".$val02."', '".$val03."', '".$val04."')";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se inserto con exito', 'codigo' => $mysqli->insert_id), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo insertar', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });

	$app->put('/api/v1/500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        $val01                      = $request->getParsedBody()['tipo_estado_codigo'];
		$val02                      = strtoupper($request->getParsedBody()['tipo_nombre']);
		$val03                      = strtoupper($request->getParsedBody()['tipo_dominio']);
		$val04                      = $request->getParsedBody()['tipo_observacion'];
        
        if (isset($val00) &&isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE DOMFIC SET DOMFIC_EDC = '$val01', DOMFIC_NOM = '".$val02."', DOMFIC_VAL = '".$val03."', DOMFIC_OBS = '".$val04."' WHERE DOMFIC_COD = '$val00'";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se actualizo con exito'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo actualizar'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });

	$app->delete('/api/v1/500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM DOMFIC WHERE DOMFIC_COD = '$val00'";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se elimino con exito'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo eliminar'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });