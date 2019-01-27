<?php
    $app->get('/api/v1/1000', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_ot_codigo,
		c.DOMFIC_NOM		AS		estado_ot_nombre,
		b.ESTFIC_COD		AS		establecimiento_codigo,
		b.ESTFIC_NOM		AS		establecimiento_nombre,
		b.ESTFIC_SIC		AS		establecimiento_sigor,
        b.ESTFIC_OBS		AS		establecimiento_observacion,
		a.ODTFIC_COD		AS		ot_codigo, 
		a.ODTFIC_NRO		AS		ot_numero, 
		a.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        a.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        a.ODTFIC_OBS		AS		ot_observacion
		
		FROM ODTFIC a
		INNER JOIN ESTFIC b ON a.ODTFIC_ESC = b.ESTFIC_COD
		INNER JOIN DOMFIC c ON a.ODTFIC_EOC = c.DOMFIC_COD
		
		ORDER BY a.ODTFIC_NRO DESC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_ot_codigo'	                    => $row['estado_ot_codigo'],
					'estado_ot_nombre'	                    => $row['estado_ot_nombre'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'ot_codigo'		                        => $row['ot_codigo'],
					'ot_numero'		                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	            => str_replace("-", "/", $row['ot_fecha_inicio_trabajo']),
                    'ot_fecha_final_trabajo'	            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	            => str_replace("-", "/", $row['ot_fecha_final_trabajo']),
                    'ot_observacion'	                    => $row['ot_observacion']
				);	
                $result[]           = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            $detalle			= array(
                'estado_ot_codigo'	                    => "",
                'estado_ot_nombre'	                    => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'ot_codigo'		                        => "",
                'ot_numero'		                        => "",
                'ot_fecha_inicio_trabajo'	            => "",
                'ot_fecha_inicio_trabajo_2'	            => "",
                'ot_fecha_final_trabajo'	            => "",
                'ot_fecha_final_trabajo_2'	            => "",
                'ot_observacion'	                    => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_ot_codigo,
		c.DOMFIC_NOM		AS		estado_ot_nombre,
		b.ESTFIC_COD		AS		establecimiento_codigo,
		b.ESTFIC_NOM		AS		establecimiento_nombre,
		b.ESTFIC_SIC		AS		establecimiento_sigor,
        b.ESTFIC_OBS		AS		establecimiento_observacion,
		a.ODTFIC_COD		AS		ot_codigo, 
		a.ODTFIC_NRO		AS		ot_numero, 
		a.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        a.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        a.ODTFIC_OBS		AS		ot_observacion
		
		FROM ODTFIC a
		INNER JOIN ESTFIC b ON a.ODTFIC_ESC = b.ESTFIC_COD
		INNER JOIN DOMFIC c ON a.ODTFIC_EOC = c.DOMFIC_COD
		
		WHERE a.ODTFIC_COD = '$val00'
		ORDER BY a.ODTFIC_NRO DESC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_ot_codigo'	                    => $row['estado_ot_codigo'],
					'estado_ot_nombre'	                    => $row['estado_ot_nombre'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'ot_codigo'		                        => $row['ot_codigo'],
					'ot_numero'		                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	            => str_replace("-", "/", $row['ot_fecha_inicio_trabajo']),
                    'ot_fecha_final_trabajo'	            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	            => str_replace("-", "/", $row['ot_fecha_final_trabajo']),
                    'ot_observacion'	                    => $row['ot_observacion']
				);	
                $result[]           = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            $detalle			= array(
                'estado_ot_codigo'	                    => "",
                'estado_ot_nombre'	                    => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'ot_codigo'		                        => "",
                'ot_numero'		                        => "",
                'ot_fecha_inicio_trabajo'	            => "",
                'ot_fecha_inicio_trabajo_2'	            => "",
                'ot_fecha_final_trabajo'	            => "",
                'ot_fecha_final_trabajo_2'	            => "",
                'ot_observacion'	                    => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1000', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_ot_codigo'];
        $val02                      = $request->getParsedBody()['establecimiento_codigo'];
        $val03                      = $request->getParsedBody()['ot_numero'];
        $val04                      = $request->getParsedBody()['ot_fecha_inicio_trabajo'];
        $val05                      = $request->getParsedBody()['ot_fecha_final_trabajo'];
        $val06                      = $request->getParsedBody()['ot_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "INSERT INTO ODTFIC (ODTFIC_EOC, ODTFIC_ESC, ODTFIC_NRO, ODTFIC_FIT, ODTFIC_FFT, ODTFIC_OBS) VALUES ('$val01', '$val02', '".$val03."', '".$val04."', '".$val05."', '".$val06."')";
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

	$app->put('/api/v1/1000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_ot_codigo'];
        $val02                      = $request->getParsedBody()['establecimiento_codigo'];
        $val03                      = $request->getParsedBody()['ot_numero'];
        $val04                      = $request->getParsedBody()['ot_fecha_inicio_trabajo'];
        $val05                      = $request->getParsedBody()['ot_fecha_final_trabajo'];
        $val06                      = $request->getParsedBody()['ot_observacion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "UPDATE ODTFIC SET ODTFIC_EOC = '$val01', ODTFIC_ESC = '$val02', ODTFIC_NRO = '".$val03."', ODTFIC_FIT = '".$val04."', ODTFIC_FFT = '".$val05."', ODTFIC_OBS = '".$val06."' WHERE ODTFIC_COD = '$val00'";
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

	$app->delete('/api/v1/1000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM ODTFIC WHERE ODTFIC_COD = '$val00'";
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