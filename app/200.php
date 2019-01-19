<?php
    $app->get('/api/v1/200', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_departamento_codigo,
		c.DOMFIC_NOM		AS		estado_departamento_nombre,
		b.PAIFIC_COD		AS		pais_codigo, 
		b.PAIFIC_NOM		AS		pais_nombre, 
		b.PAIFIC_OBS		AS		pais_observacion,
		a.PAIDEP_COD		AS		departamento_codigo, 
		a.PAIDEP_NOM		AS		departamento_nombre, 
		a.PAIDEP_OBS		AS		departamento_observacion
		
		FROM PAIDEP a
		INNER JOIN PAIFIC b ON a.PAIDEP_PAC = b.PAIFIC_COD
		INNER JOIN DOMFIC c ON a.PAIDEP_EDC = c.DOMFIC_COD
		
		ORDER BY b.PAIFIC_NOM, a.PAIDEP_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_departamento_codigo'	    => $row['estado_departamento_codigo'],
					'estado_departamento_nombre'	    => $row['estado_departamento_nombre'],
					'pais_codigo'			            => $row['pais_codigo'],
					'pais_nombre'			            => $row['pais_nombre'],
					'pais_observacion'		            => $row['pais_observacion'],
					'departamento_codigo'		        => $row['departamento_codigo'],
					'departamento_nombre'		        => $row['departamento_nombre'],
					'departamento_observacion'	        => $row['departamento_observacion']
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

    $app->get('/api/v1/200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_departamento_codigo,
		c.DOMFIC_NOM		AS		estado_departamento_nombre,
		b.PAIFIC_COD		AS		pais_codigo, 
		b.PAIFIC_NOM		AS		pais_nombre, 
		b.PAIFIC_OBS		AS		pais_observacion,
		a.PAIDEP_COD		AS		departamento_codigo, 
		a.PAIDEP_NOM		AS		departamento_nombre, 
		a.PAIDEP_OBS		AS		departamento_observacion
		
		FROM PAIDEP a
		INNER JOIN PAIFIC b ON a.PAIDEP_PAC = b.PAIFIC_COD
		INNER JOIN DOMFIC c ON a.PAIDEP_EDC = c.DOMFIC_COD
		
		WHERE a.PAIDEP_COD = '$val00'
		ORDER BY b.PAIFIC_NOM, a.PAIDEP_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_departamento_codigo'	    => $row['estado_departamento_codigo'],
					'estado_departamento_nombre'	    => $row['estado_departamento_nombre'],
					'pais_codigo'			            => $row['pais_codigo'],
					'pais_nombre'			            => $row['pais_nombre'],
					'pais_observacion'		            => $row['pais_observacion'],
					'departamento_codigo'		        => $row['departamento_codigo'],
					'departamento_nombre'		        => $row['departamento_nombre'],
					'departamento_observacion'	        => $row['departamento_observacion']
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

	$app->post('/api/v1/200', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_departamento_codigo'];
        $val02                      = $request->getParsedBody()['pais_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['departamento_nombre']);
		$val04                      = $request->getParsedBody()['departamento_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO PAIDEP (PAIDEP_EDC, PAIDEP_PAC, PAIDEP_NOM, PAIDEP_OBS) VALUES ('$val01', '$val02', '".$val03."', '".$val04."')";
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

	$app->put('/api/v1/200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_departamento_codigo'];
        $val02                      = $request->getParsedBody()['pais_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['departamento_nombre']);
		$val04                      = $request->getParsedBody()['departamento_observacion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE PAIDEP SET PAIDEP_EDC = '$val01', PAIDEP_PAC = '$val02', PAIDEP_NOM = '".$val03."', PAIDEP_OBS = '".$val04."' WHERE PAIDEP_COD = '$val00'";
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

	$app->delete('/api/v1/200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM PAIDEP WHERE PAIDEP_COD = '$val00'";
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