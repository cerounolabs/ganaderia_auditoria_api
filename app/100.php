<?php
    $app->get('/api/v1/100', function($request) {
        require __DIR__.'/../src/connect.php';

		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		b.DOMFIC_COD		    AS		estado_pais_codigo,
		b.DOMFIC_NOM		    AS		estado_pais_nombre,
		a.PAIFIC_COD		    AS		pais_codigo, 
		a.PAIFIC_NOM		    AS		pais_nombre, 
		a.PAIFIC_OBS		    AS		pais_observacion
		
		FROM PAIFIC a
		INNER JOIN DOMFIC b ON a.PAIFIC_EPC = b.DOMFIC_COD
		
		ORDER BY a.PAIFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_pais_codigo'	=> $row['estado_pais_codigo'],
					'estado_pais_nombre'	=> $row['estado_pais_nombre'],
					'pais_codigo'			=> $row['pais_codigo'], 
					'pais_nombre'			=> $row['pais_nombre'],
					'pais_observacion'		=> $row['pais_observacion']
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

    $app->get('/api/v1/100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		b.DOMFIC_COD		    AS		estado_pais_codigo,
		b.DOMFIC_NOM		    AS		estado_pais_nombre,
		a.PAIFIC_COD		    AS		pais_codigo, 
		a.PAIFIC_NOM		    AS		pais_nombre, 
		a.PAIFIC_OBS		    AS		pais_observacion
		
		FROM PAIFIC a
		INNER JOIN DOMFIC b ON a.PAIFIC_EPC = b.DOMFIC_COD
		
		WHERE a.PAIFIC_COD = '$val00'
		ORDER BY a.PAIFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_pais_codigo'	=> $row['estado_pais_codigo'],
					'estado_pais_nombre'	=> $row['estado_pais_nombre'],
					'pais_codigo'			=> $row['pais_codigo'], 
					'pais_nombre'			=> $row['pais_nombre'],
					'pais_observacion'		=> $row['pais_observacion']
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

	$app->post('/api/v1/100', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_pais_codigo'];
        $val02                      = strtoupper($request->getParsedBody()['pais_nombre']);
		$val03                      = $request->getParsedBody()['pais_observacion'];
        
        if (isset($val01) && isset($val02)) {
            $sql                    = "INSERT INTO PAIFIC (PAIFIC_EPC, PAIFIC_NOM, PAIFIC_OBS) VALUES ('$val01', '".$val02."', '".$val03."')";
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

	$app->put('/api/v1/100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_pais_codigo'];
        $val02                      = strtoupper($request->getParsedBody()['pais_nombre']);
		$val03                      = $request->getParsedBody()['pais_observacion'];
        
        if (isset($val00) && isset($val01) && isset($val02)) {
            $sql                    = "UPDATE PAIFIC SET PAIFIC_EPC = '$val01', PAIFIC_NOM = '".$val02."', PAIFIC_OBS = '".$val03."' WHERE PAIFIC_COD = '$val00'";
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

	$app->delete('/api/v1/100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM PAIFIC WHERE PAIFIC_COD = '$val00'";
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