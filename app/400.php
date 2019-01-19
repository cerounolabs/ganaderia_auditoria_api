<?php
    $app->get('/api/v1/400', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		e.DOMFIC_COD		AS		estado_compania_codigo,
		e.DOMFIC_NOM		AS		estado_compania_nombre,
		d.PAIFIC_COD		AS		pais_codigo, 
		d.PAIFIC_NOM		AS		pais_nombre, 
		d.PAIFIC_OBS		AS		pais_observacion,
		c.PAIDEP_COD		AS		departamento_codigo, 
		c.PAIDEP_NOM		AS		departamento_nombre, 
		c.PAIDEP_OBS		AS		departamento_observacion,
		b.PAIDIS_COD		AS		distrito_codigo,
		b.PAIDIS_NOM		AS		distrito_nombre,
		b.PAIDIS_OBS		AS		distrito_observacion,
		a.PAICOM_COD		AS		compania_codigo,
		a.PAICOM_NOM		AS		compania_nombre,
		a.PAICOM_OBS		AS		compania_observacion
		
		FROM PAICOM a
		INNER JOIN PAIDIS b ON a.PAICOM_DIC = b.PAIDIS_COD
		INNER JOIN PAIDEP c ON b.PAIDIS_DEC = c.PAIDEP_COD
		INNER JOIN PAIFIC d ON c.PAIDEP_PAC = d.PAIFIC_COD
		INNER JOIN DOMFIC e ON a.PAICOM_ECC = e.DOMFIC_COD
		
		ORDER BY d.PAIFIC_NOM, c.PAIDEP_NOM, b.PAIDIS_NOM, a.PAICOM_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_compania_codigo'        => $row['estado_compania_codigo'],
					'estado_compania_nombre'	    => $row['estado_compania_nombre'],
					'pais_codigo'			        => $row['pais_codigo'],
					'pais_nombre'			        => $row['pais_nombre'],
					'pais_observacion'		        => $row['pais_observacion'],
					'departamento_codigo'		    => $row['departamento_codigo'],
					'departamento_nombre'		    => $row['departamento_nombre'],
					'departamento_observacion'	    => $row['departamento_observacion'],
					'distrito_codigo'			    => $row['distrito_codigo'],
					'distrito_nombre'			    => $row['distrito_nombre'],
					'distrito_observacion'	        => $row['distrito_observacion'],
					'compania_codigo'			    => $row['compania_codigo'],
					'compania_nombre'			    => $row['compania_nombre'],
					'compania_observacion'	        => $row['compania_observacion']
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

    $app->get('/api/v1/400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		
		$sql                        = "SELECT
		e.DOMFIC_COD		AS		estado_compania_codigo,
		e.DOMFIC_NOM		AS		estado_compania_nombre,
		d.PAIFIC_COD		AS		pais_codigo, 
		d.PAIFIC_NOM		AS		pais_nombre, 
		d.PAIFIC_OBS		AS		pais_observacion,
		c.PAIDEP_COD		AS		departamento_codigo, 
		c.PAIDEP_NOM		AS		departamento_nombre, 
		c.PAIDEP_OBS		AS		departamento_observacion,
		b.PAIDIS_COD		AS		distrito_codigo,
		b.PAIDIS_NOM		AS		distrito_nombre,
		b.PAIDIS_OBS		AS		distrito_observacion,
		a.PAICOM_COD		AS		compania_codigo,
		a.PAICOM_NOM		AS		compania_nombre,
		a.PAICOM_OBS		AS		compania_observacion
		
		FROM PAICOM a
		INNER JOIN PAIDIS b ON a.PAICOM_DIC = b.PAIDIS_COD
		INNER JOIN PAIDEP c ON b.PAIDIS_DEC = c.PAIDEP_COD
		INNER JOIN PAIFIC d ON c.PAIDEP_PAC = d.PAIFIC_COD
		INNER JOIN DOMFIC e ON a.PAICOM_ECC = e.DOMFIC_COD
		
		WHERE a.PAICOM_COD = '$val00'
		ORDER BY d.PAIFIC_NOM, c.PAIDEP_NOM, b.PAIDIS_NOM, a.PAICOM_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_compania_codigo'        => $row['estado_compania_codigo'],
					'estado_compania_nombre'	    => $row['estado_compania_nombre'],
					'pais_codigo'			        => $row['pais_codigo'],
					'pais_nombre'			        => $row['pais_nombre'],
					'pais_observacion'		        => $row['pais_observacion'],
					'departamento_codigo'		    => $row['departamento_codigo'],
					'departamento_nombre'		    => $row['departamento_nombre'],
					'departamento_observacion'	    => $row['departamento_observacion'],
					'distrito_codigo'			    => $row['distrito_codigo'],
					'distrito_nombre'			    => $row['distrito_nombre'],
					'distrito_observacion'	        => $row['distrito_observacion'],
					'compania_codigo'			    => $row['compania_codigo'],
					'compania_nombre'			    => $row['compania_nombre'],
					'compania_observacion'	        => $row['compania_observacion']
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

	$app->post('/api/v1/400', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_compania_codigo'];
        $val02                      = $request->getParsedBody()['distrito_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['compania_nombre']);
		$val04                      = $request->getParsedBody()['compania_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO PAICOM (PAICOM_ECC, PAICOM_DIC, PAICOM_NOM, PAICOM_OBS) VALUES ('$val01', '$val02', '".$val03."', '".$val04."')";
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

	$app->put('/api/v1/400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_compania_codigo'];
        $val02                      = $request->getParsedBody()['distrito_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['compania_nombre']);
		$val04                      = $request->getParsedBody()['compania_observacion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE PAICOM SET PAICOM_ECC = '$val01', PAICOM_DIC = '$val02', PAICOM_NOM = '".$val03."', PAICOM_OBS = '".$val04."' WHERE PAICOM_COD = '$val00'";
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

	$app->delete('/api/v1/400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM PAICOM WHERE PAICOM_COD = '$val00'";
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