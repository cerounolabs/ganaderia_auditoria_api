<?php
    $app->get('/api/v1/300', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_distrito_codigo,
		d.DOMFIC_NOM		AS		estado_distrito_nombre,
		c.PAIFIC_COD		AS		pais_codigo, 
		c.PAIFIC_NOM		AS		pais_nombre, 
		c.PAIFIC_OBS		AS		pais_observacion,
		b.PAIDEP_COD		AS		departamento_codigo, 
		b.PAIDEP_NOM		AS		departamento_nombre, 
		b.PAIDEP_OBS		AS		departamento_observacion,
		a.PAIDIS_COD		AS		distrito_codigo,
		a.PAIDIS_NOM		AS		distrito_nombre,
		a.PAIDIS_OBS		AS		distrito_observacion
		
		FROM PAIDIS a
		INNER JOIN PAIDEP b ON a.PAIDIS_DEC = b.PAIDEP_COD
		INNER JOIN PAIFIC c ON b.PAIDEP_PAC = c.PAIFIC_COD
		INNER JOIN DOMFIC d ON a.PAIDIS_ECC = d.DOMFIC_COD
		
		ORDER BY c.PAIFIC_NOM, b.PAIDEP_NOM, a.PAIDIS_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_distrito_codigo'	    => $row['estado_distrito_codigo'],
					'estado_distrito_nombre'	    => $row['estado_distrito_nombre'],
					'pais_codigo'			        => $row['pais_codigo'],
					'pais_nombre'			        => $row['pais_nombre'],
					'pais_observacion'		        => $row['pais_observacion'],
					'departamento_codigo'		    => $row['departamento_codigo'],
					'departamento_nombre'		    => $row['departamento_nombre'],
					'departamento_observacion'	    => $row['departamento_observacion'],
					'distrito_codigo'			    => $row['distrito_codigo'],
					'distrito_nombre'			    => $row['distrito_nombre'],
					'distrito_observacion'	        => $row['distrito_observacion']
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

    $app->get('/api/v1/300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_distrito_codigo,
		d.DOMFIC_NOM		AS		estado_distrito_nombre,
		c.PAIFIC_COD		AS		pais_codigo, 
		c.PAIFIC_NOM		AS		pais_nombre, 
		c.PAIFIC_OBS		AS		pais_observacion,
		b.PAIDEP_COD		AS		departamento_codigo, 
		b.PAIDEP_NOM		AS		departamento_nombre, 
		b.PAIDEP_OBS		AS		departamento_observacion,
		a.PAIDIS_COD		AS		distrito_codigo,
		a.PAIDIS_NOM		AS		distrito_nombre,
		a.PAIDIS_OBS		AS		distrito_observacion
		
		FROM PAIDIS a
		INNER JOIN PAIDEP b ON a.PAIDIS_DEC = b.PAIDEP_COD
		INNER JOIN PAIFIC c ON b.PAIDEP_PAC = c.PAIFIC_COD
		INNER JOIN DOMFIC d ON a.PAIDIS_ECC = d.DOMFIC_COD
		
		WHERE a.PAIDIS_COD = '$val00'
		ORDER BY c.PAIFIC_NOM, b.PAIDEP_NOM, a.PAIDIS_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_distrito_codigo'	    => $row['estado_distrito_codigo'],
					'estado_distrito_nombre'	    => $row['estado_distrito_nombre'],
					'pais_codigo'			        => $row['pais_codigo'],
					'pais_nombre'			        => $row['pais_nombre'],
					'pais_observacion'		        => $row['pais_observacion'],
					'departamento_codigo'		    => $row['departamento_codigo'],
					'departamento_nombre'		    => $row['departamento_nombre'],
					'departamento_observacion'	    => $row['departamento_observacion'],
					'distrito_codigo'			    => $row['distrito_codigo'],
					'distrito_nombre'			    => $row['distrito_nombre'],
					'distrito_observacion'	        => $row['distrito_observacion']
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

	$app->post('/api/v1/300', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_distrito_codigo'];
        $val02                      = $request->getParsedBody()['departamento_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['distrito_nombre']);
		$val04                      = $request->getParsedBody()['distrito_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO PAIDIS (PAIDIS_ECC, PAIDIS_DEC, PAIDIS_NOM, PAIDIS_OBS) VALUES ('$val01', '$val02', '".$val03."', '".$val04."')";
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

	$app->put('/api/v1/300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_distrito_codigo'];
        $val02                      = $request->getParsedBody()['departamento_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['distrito_nombre']);
		$val04                      = $request->getParsedBody()['distrito_observacion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE PAIDIS SET PAIDIS_ECC = '$val01', PAIDIS_DEC = '$val02', PAIDIS_NOM = '".$val03."', PAIDIS_OBS = '".$val04."' WHERE PAIDIS_COD = '$val00'";
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

	$app->delete('/api/v1/300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM PAIDIS WHERE PAIDIS_COD = '$val00'";
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