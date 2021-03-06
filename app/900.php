<?php
    $app->get('/api/v1/900', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_potrero_codigo,
		d.DOMFIC_NOM		AS		estado_potrero_nombre,
		c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.ESTSEC_COD		AS		seccion_codigo, 
		b.ESTSEC_NOM		AS		seccion_nombre, 
		b.ESTSEC_OBS		AS		seccion_observacion,
        a.ESTPOT_COD		AS		potrero_codigo, 
		a.ESTPOT_NOM		AS		potrero_nombre, 
		a.ESTPOT_OBS		AS		potrero_observacion
		
		FROM ESTPOT a
        INNER JOIN ESTSEC b ON a.ESTPOT_SEC = b.ESTSEC_COD
		INNER JOIN ESTFIC c ON b.ESTSEC_ESC = c.ESTFIC_COD
		INNER JOIN DOMFIC d ON a.ESTPOT_EPC = d.DOMFIC_COD
		
		ORDER BY c.ESTFIC_NOM, b.ESTSEC_NOM, a.ESTPOT_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_potrero_codigo'	                => $row['estado_potrero_codigo'],
					'estado_potrero_nombre'	                => $row['estado_potrero_nombre'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'seccion_codigo'		                => $row['seccion_codigo'],
					'seccion_nombre'		                => $row['seccion_nombre'],
                    'seccion_observacion'	                => $row['seccion_observacion'],
                    'potrero_codigo'		                => $row['potrero_codigo'],
					'potrero_nombre'		                => $row['potrero_nombre'],
					'potrero_observacion'	                => $row['potrero_observacion']
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
            $detalle			= array(
                'estado_potrero_codigo'	                => "",
                'estado_potrero_nombre'	                => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'seccion_codigo'		                => "",
                'seccion_nombre'		                => "",
                'seccion_observacion'	                => "",
                'potrero_codigo'		                => "",
                'potrero_nombre'		                => "",
                'potrero_observacion'	                => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/900/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_potrero_codigo,
		d.DOMFIC_NOM		AS		estado_potrero_nombre,
		c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.ESTSEC_COD		AS		seccion_codigo, 
		b.ESTSEC_NOM		AS		seccion_nombre, 
		b.ESTSEC_OBS		AS		seccion_observacion,
        a.ESTPOT_COD		AS		potrero_codigo, 
		a.ESTPOT_NOM		AS		potrero_nombre, 
		a.ESTPOT_OBS		AS		potrero_observacion
		
		FROM ESTPOT a
        INNER JOIN ESTSEC b ON a.ESTPOT_SEC = b.ESTSEC_COD
		INNER JOIN ESTFIC c ON b.ESTSEC_ESC = c.ESTFIC_COD
		INNER JOIN DOMFIC d ON a.ESTPOT_EPC = d.DOMFIC_COD
		
		WHERE a.ESTPOT_COD = '$val00'
		ORDER BY c.ESTFIC_NOM, b.ESTSEC_NOM, a.ESTPOT_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_potrero_codigo'	                => $row['estado_potrero_codigo'],
					'estado_potrero_nombre'	                => $row['estado_potrero_nombre'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'seccion_codigo'		                => $row['seccion_codigo'],
					'seccion_nombre'		                => $row['seccion_nombre'],
                    'seccion_observacion'	                => $row['seccion_observacion'],
                    'potrero_codigo'		                => $row['potrero_codigo'],
					'potrero_nombre'		                => $row['potrero_nombre'],
					'potrero_observacion'	                => $row['potrero_observacion']
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
            $detalle			= array(
                'estado_potrero_codigo'	                => "",
                'estado_potrero_nombre'	                => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'seccion_codigo'		                => "",
                'seccion_nombre'		                => "",
                'seccion_observacion'	                => "",
                'potrero_codigo'		                => "",
                'potrero_nombre'		                => "",
                'potrero_observacion'	                => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/900/establecimiento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_potrero_codigo,
		d.DOMFIC_NOM		AS		estado_potrero_nombre,
		c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.ESTSEC_COD		AS		seccion_codigo, 
		b.ESTSEC_NOM		AS		seccion_nombre, 
		b.ESTSEC_OBS		AS		seccion_observacion,
        a.ESTPOT_COD		AS		potrero_codigo, 
		a.ESTPOT_NOM		AS		potrero_nombre, 
		a.ESTPOT_OBS		AS		potrero_observacion
		
		FROM ESTPOT a
        INNER JOIN ESTSEC b ON a.ESTPOT_SEC = b.ESTSEC_COD
		INNER JOIN ESTFIC c ON b.ESTSEC_ESC = c.ESTFIC_COD
		INNER JOIN DOMFIC d ON a.ESTPOT_EPC = d.DOMFIC_COD
		
		WHERE c.ESTFIC_COD = '$val00'
		ORDER BY c.ESTFIC_NOM, b.ESTSEC_NOM, a.ESTPOT_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_potrero_codigo'	                => $row['estado_potrero_codigo'],
					'estado_potrero_nombre'	                => $row['estado_potrero_nombre'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'seccion_codigo'		                => $row['seccion_codigo'],
					'seccion_nombre'		                => $row['seccion_nombre'],
                    'seccion_observacion'	                => $row['seccion_observacion'],
                    'potrero_codigo'		                => $row['potrero_codigo'],
					'potrero_nombre'		                => $row['potrero_nombre'],
					'potrero_observacion'	                => $row['potrero_observacion']
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
            $detalle			= array(
                'estado_potrero_codigo'	                => "",
                'estado_potrero_nombre'	                => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'seccion_codigo'		                => "",
                'seccion_nombre'		                => "",
                'seccion_observacion'	                => "",
                'potrero_codigo'		                => "",
                'potrero_nombre'		                => "",
                'potrero_observacion'	                => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/900', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_potrero_codigo'];
        $val02                      = $request->getParsedBody()['seccion_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['potrero_nombre']);
		$val04                      = $request->getParsedBody()['potrero_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO ESTPOT (ESTPOT_EPC, ESTPOT_SEC, ESTPOT_NOM, ESTPOT_OBS) VALUES ('$val01', '$val02', '".$val03."', '".$val04."')";
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

	$app->put('/api/v1/900/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_potrero_codigo'];
        $val02                      = $request->getParsedBody()['seccion_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['potrero_nombre']);
		$val04                      = $request->getParsedBody()['potrero_observacion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE ESTPOT SET ESTPOT_EPC = '$val01', ESTPOT_SEC = '$val02', ESTPOT_NOM = '".$val03."', ESTPOT_OBS = '".$val04."' WHERE ESTPOT_COD = '$val00'";
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

	$app->delete('/api/v1/900/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM ESTPOT WHERE ESTPOT_COD = '$val00'";
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