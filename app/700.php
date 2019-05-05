<?php
    $app->get('/api/v1/700', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		e.DOMFIC_COD		AS		estado_establecimiento_codigo,
		e.DOMFIC_NOM		AS		estado_establecimiento_nombre,
		d.PAIFIC_COD		AS		pais_codigo, 
		d.PAIFIC_NOM		AS		pais_nombre, 
		d.PAIFIC_OBS		AS		pais_observacion,
		c.PAIDEP_COD		AS		departamento_codigo, 
		c.PAIDEP_NOM		AS		departamento_nombre, 
		c.PAIDEP_OBS		AS		departamento_observacion,
		b.PAIDIS_COD		AS		distrito_codigo,
		b.PAIDIS_NOM		AS		distrito_nombre,
		b.PAIDIS_OBS		AS		distrito_observacion,
		a.ESTFIC_COD		AS		establecimiento_codigo,
		a.ESTFIC_NOM		AS		establecimiento_nombre,
		a.ESTFIC_SIC		AS		establecimiento_sigor,
        a.ESTFIC_OBS		AS		establecimiento_observacion
		
		FROM ESTFIC a
		INNER JOIN PAIDIS b ON a.ESTFIC_DIC = b.PAIDIS_COD
		INNER JOIN PAIDEP c ON b.PAIDIS_DEC = c.PAIDEP_COD
		INNER JOIN PAIFIC d ON c.PAIDEP_PAC = d.PAIFIC_COD
		INNER JOIN DOMFIC e ON a.ESTFIC_EEC = e.DOMFIC_COD
		
		ORDER BY d.PAIFIC_NOM, c.PAIDEP_NOM, b.PAIDIS_NOM, a.ESTFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_establecimiento_codigo'     => $row['estado_establecimiento_codigo'],
					'estado_establecimiento_nombre'	    => $row['estado_establecimiento_nombre'],
					'pais_codigo'			            => $row['pais_codigo'],
					'pais_nombre'			            => $row['pais_nombre'],
					'pais_observacion'		            => $row['pais_observacion'],
					'departamento_codigo'		        => $row['departamento_codigo'],
					'departamento_nombre'		        => $row['departamento_nombre'],
					'departamento_observacion'	        => $row['departamento_observacion'],
					'distrito_codigo'			        => $row['distrito_codigo'],
					'distrito_nombre'			        => $row['distrito_nombre'],
					'distrito_observacion'	            => $row['distrito_observacion'],
					'establecimiento_codigo'			=> $row['establecimiento_codigo'],
                    'establecimiento_nombre'	        => $row['establecimiento_nombre'],
                    'establecimiento_sigor'	            => $row['establecimiento_sigor'],
					'establecimiento_observacion'	    => $row['establecimiento_observacion']
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

    $app->get('/api/v1/700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		
		$sql                        = "SELECT
		e.DOMFIC_COD		AS		estado_establecimiento_codigo,
		e.DOMFIC_NOM		AS		estado_establecimiento_nombre,
		d.PAIFIC_COD		AS		pais_codigo, 
		d.PAIFIC_NOM		AS		pais_nombre, 
		d.PAIFIC_OBS		AS		pais_observacion,
		c.PAIDEP_COD		AS		departamento_codigo, 
		c.PAIDEP_NOM		AS		departamento_nombre, 
		c.PAIDEP_OBS		AS		departamento_observacion,
		b.PAIDIS_COD		AS		distrito_codigo,
		b.PAIDIS_NOM		AS		distrito_nombre,
		b.PAIDIS_OBS		AS		distrito_observacion,
		a.ESTFIC_COD		AS		establecimiento_codigo,
		a.ESTFIC_NOM		AS		establecimiento_nombre,
		a.ESTFIC_SIC		AS		establecimiento_sigor,
        a.ESTFIC_OBS		AS		establecimiento_observacion
		
		FROM ESTFIC a
		INNER JOIN PAIDIS b ON a.ESTFIC_DIC = b.PAIDIS_COD
		INNER JOIN PAIDEP c ON b.PAIDIS_DEC = c.PAIDEP_COD
		INNER JOIN PAIFIC d ON c.PAIDEP_PAC = d.PAIFIC_COD
		INNER JOIN DOMFIC e ON a.ESTFIC_EEC = e.DOMFIC_COD
		
		WHERE a.ESTFIC_COD = '$val00'
		ORDER BY d.PAIFIC_NOM, c.PAIDEP_NOM, b.PAIDIS_NOM, a.ESTFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_establecimiento_codigo'     => $row['estado_establecimiento_codigo'],
					'estado_establecimiento_nombre'	    => $row['estado_establecimiento_nombre'],
					'pais_codigo'			            => $row['pais_codigo'],
					'pais_nombre'			            => $row['pais_nombre'],
					'pais_observacion'		            => $row['pais_observacion'],
					'departamento_codigo'		        => $row['departamento_codigo'],
					'departamento_nombre'		        => $row['departamento_nombre'],
					'departamento_observacion'	        => $row['departamento_observacion'],
					'distrito_codigo'			        => $row['distrito_codigo'],
					'distrito_nombre'			        => $row['distrito_nombre'],
					'distrito_observacion'	            => $row['distrito_observacion'],
					'establecimiento_codigo'			=> $row['establecimiento_codigo'],
                    'establecimiento_nombre'	        => $row['establecimiento_nombre'],
                    'establecimiento_sigor'	            => $row['establecimiento_sigor'],
					'establecimiento_observacion'	    => $row['establecimiento_observacion']
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

	$app->post('/api/v1/700', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_establecimiento_codigo'];
        $val02                      = $request->getParsedBody()['distrito_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['establecimiento_nombre']);
        $val04                      = strtoupper($request->getParsedBody()['establecimiento_sigor']);
        $val05                      = $request->getParsedBody()['establecimiento_observacion'];
        
        $aud01                      = strtoupper($request->getParsedBody()['auditoria_usuario']);
        $aud02                      = strtoupper($request->getParsedBody()['auditoria_fechahora']);
        $aud03                      = strtoupper($request->getParsedBody()['auditoria_ip']);
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "INSERT INTO ESTFIC (ESTFIC_EEC, ESTFIC_DIC, ESTFIC_NOM, ESTFIC_SIC, ESTFIC_OBS, ESTFIC_AUS, ESTFIC_AFH, ESTFIC_AIP) VALUES ('$val01', '$val02', '".$val03."', '".$val04."', '".$val05."', '".$aud01."', '".$aud02."', '".$aud03."')";
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

	$app->put('/api/v1/700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_establecimiento_codigo'];
        $val02                      = $request->getParsedBody()['distrito_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['establecimiento_nombre']);
        $val04                      = strtoupper($request->getParsedBody()['establecimiento_sigor']);
        $val05                      = $request->getParsedBody()['establecimiento_observacion'];
        
        $aud01                      = strtoupper($request->getParsedBody()['auditoria_usuario']);
        $aud02                      = strtoupper($request->getParsedBody()['auditoria_fechahora']);
        $aud03                      = strtoupper($request->getParsedBody()['auditoria_ip']);
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "UPDATE ESTFIC SET ESTFIC_EEC = '$val01', ESTFIC_DIC = '$val02', ESTFIC_NOM = '".$val03."', ESTFIC_SIC = '".$val04."', ESTFIC_OBS = '".$val05."', ESTFIC_AUS = '".$aud01."', ESTFIC_AFH = '".$aud02."', ESTFIC_AIP = '".$aud03."' WHERE ESTFIC_COD = '$val00'";
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

	$app->delete('/api/v1/700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');

        $aud01                      = strtoupper($request->getParsedBody()['auditoria_usuario']);
        $aud02                      = strtoupper($request->getParsedBody()['auditoria_fechahora']);
        $aud03                      = strtoupper($request->getParsedBody()['auditoria_ip']);
        
        if (isset($val00)) {
            $sql = "UPDATE ESTFIC SET ESTFIC_AUS = '".$aud01."', ESTFIC_AFH = '".$aud02."', ESTFIC_AIP = '".$aud03."' WHERE ESTFIC_COD = '$val00'";
            if ($mysqli->query($sql) === TRUE) {
                $sql1 = "DELETE FROM ESTFIC WHERE ESTFIC_COD = '$val00'";
                if ($mysqli->query($sql1) === TRUE) {
                    header("Content-Type: application/json; charset=utf-8");
                    $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se elimino con exito'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    header("Content-Type: application/json; charset=utf-8");
                    $json               = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'No se pudo eliminar'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });