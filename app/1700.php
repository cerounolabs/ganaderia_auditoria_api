<?php
    $app->get('/api/v1/1700', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
        d.USUFIC_COD		AS		usuario_codigo,
        d.USUFIC_USU		AS		usuario_nombre,
        c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.DOMFIC_COD		AS		estado_establecimiento_usuario_codigo,
		b.DOMFIC_NOM		AS		estado_establecimiento_usuario_nombre,
        a.ESTUSU_COD		AS		establecimiento_usuario_codigo
		
		FROM ESTUSU a
        INNER JOIN DOMFIC b ON a.ESTUSU_EUC = b.DOMFIC_COD
		INNER JOIN ESTFIC c ON a.ESTUSU_ESC = c.ESTFIC_COD
		INNER JOIN USUFIC d ON a.ESTUSU_USC = d.USUFIC_COD
		
		ORDER BY a.ESTUSU_COD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_establecimiento_usuario_codigo'	        => $row['estado_establecimiento_usuario_codigo'],
                    'estado_establecimiento_usuario_nombre'	        => $row['estado_establecimiento_usuario_nombre'],
					'establecimiento_codigo'	                    => $row['establecimiento_codigo'],
					'establecimiento_nombre'	                    => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		                    => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		            => $row['establecimiento_observacion'],
                    'usuario_codigo'		                        => $row['usuario_codigo'],
                    'usuario_nombre'		                        => $row['usuario_nombre'],
                    'establecimiento_usuario_codigo'	            => $row['establecimiento_usuario_codigo']
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
            $detalle    = array(
                'estado_establecimiento_usuario_codigo'	        => '',
                'estado_establecimiento_usuario_nombre'	        => '',
                'establecimiento_codigo'	                    => '',
                'establecimiento_nombre'	                    => '',
                'establecimiento_sigor'		                    => '',
                'establecimiento_observacion'		            => '',
                'usuario_codigo'		                        => '',
                'usuario_nombre'		                        => '',
                'establecimiento_usuario_codigo'	            => ''
            );

            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        d.USUFIC_COD		AS		usuario_codigo,
        d.USUFIC_USU		AS		usuario_nombre,
        c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.DOMFIC_COD		AS		estado_establecimiento_usuario_codigo,
		b.DOMFIC_NOM		AS		estado_establecimiento_usuario_nombre,
        a.ESTUSU_COD		AS		establecimiento_usuario_codigo
		
		FROM ESTUSU a
        INNER JOIN DOMFIC b ON a.ESTUSU_EUC = b.DOMFIC_COD
		INNER JOIN ESTFIC c ON a.ESTUSU_ESC = c.ESTFIC_COD
		INNER JOIN USUFIC d ON a.ESTUSU_USC = d.USUFIC_COD
		
		WHERE a.ESTUSU_COD = '$val00'
		ORDER BY a.ESTUSU_COD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_establecimiento_usuario_codigo'	        => $row['estado_establecimiento_usuario_codigo'],
                    'estado_establecimiento_usuario_nombre'	        => $row['estado_establecimiento_usuario_nombre'],
					'establecimiento_codigo'	                    => $row['establecimiento_codigo'],
					'establecimiento_nombre'	                    => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		                    => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		            => $row['establecimiento_observacion'],
                    'usuario_codigo'		                        => $row['usuario_codigo'],
                    'usuario_nombre'		                        => $row['usuario_nombre'],
                    'establecimiento_usuario_codigo'	            => $row['establecimiento_usuario_codigo']
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
            $detalle    = array(
                'estado_establecimiento_usuario_codigo'	        => '',
                'estado_establecimiento_usuario_nombre'	        => '',
                'establecimiento_codigo'	                    => '',
                'establecimiento_nombre'	                    => '',
                'establecimiento_sigor'		                    => '',
                'establecimiento_observacion'		            => '',
                'usuario_codigo'		                        => '',
                'usuario_nombre'		                        => '',
                'establecimiento_usuario_codigo'	            => ''
            );

            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1700/establecimiento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        d.USUFIC_COD		AS		usuario_codigo,
        d.USUFIC_USU		AS		usuario_nombre,
        c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.DOMFIC_COD		AS		estado_establecimiento_usuario_codigo,
		b.DOMFIC_NOM		AS		estado_establecimiento_usuario_nombre,
        a.ESTUSU_COD		AS		establecimiento_usuario_codigo
		
		FROM ESTUSU a
        INNER JOIN DOMFIC b ON a.ESTUSU_EUC = b.DOMFIC_COD
		INNER JOIN ESTFIC c ON a.ESTUSU_ESC = c.ESTFIC_COD
		INNER JOIN USUFIC d ON a.ESTUSU_USC = d.USUFIC_COD
		
		WHERE c.ESTFIC_COD = '$val00'
		ORDER BY a.ESTUSU_COD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_establecimiento_usuario_codigo'	        => $row['estado_establecimiento_usuario_codigo'],
                    'estado_establecimiento_usuario_nombre'	        => $row['estado_establecimiento_usuario_nombre'],
					'establecimiento_codigo'	                    => $row['establecimiento_codigo'],
					'establecimiento_nombre'	                    => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		                    => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		            => $row['establecimiento_observacion'],
                    'usuario_codigo'		                        => $row['usuario_codigo'],
                    'usuario_nombre'		                        => $row['usuario_nombre'],
                    'establecimiento_usuario_codigo'	            => $row['establecimiento_usuario_codigo']
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
            $detalle    = array(
                'estado_establecimiento_usuario_codigo'	        => '',
                'estado_establecimiento_usuario_nombre'	        => '',
                'establecimiento_codigo'	                    => '',
                'establecimiento_nombre'	                    => '',
                'establecimiento_sigor'		                    => '',
                'establecimiento_observacion'		            => '',
                'usuario_codigo'		                        => '',
                'usuario_nombre'		                        => '',
                'establecimiento_usuario_codigo'	            => ''
            );

            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1700/usuario/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        d.USUFIC_COD		AS		usuario_codigo,
        d.USUFIC_USU		AS		usuario_nombre,
        c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.DOMFIC_COD		AS		estado_establecimiento_usuario_codigo,
		b.DOMFIC_NOM		AS		estado_establecimiento_usuario_nombre,
        a.ESTUSU_COD		AS		establecimiento_usuario_codigo
		
		FROM ESTUSU a
        INNER JOIN DOMFIC b ON a.ESTUSU_EUC = b.DOMFIC_COD
		INNER JOIN ESTFIC c ON a.ESTUSU_ESC = c.ESTFIC_COD
		INNER JOIN USUFIC d ON a.ESTUSU_USC = d.USUFIC_COD
		
		WHERE d.USUFIC_USU = '$val00'
		ORDER BY a.ESTUSU_COD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_establecimiento_usuario_codigo'	        => $row['estado_establecimiento_usuario_codigo'],
                    'estado_establecimiento_usuario_nombre'	        => $row['estado_establecimiento_usuario_nombre'],
					'establecimiento_codigo'	                    => $row['establecimiento_codigo'],
					'establecimiento_nombre'	                    => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		                    => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		            => $row['establecimiento_observacion'],
                    'usuario_codigo'		                        => $row['usuario_codigo'],
                    'usuario_nombre'		                        => $row['usuario_nombre'],
                    'establecimiento_usuario_codigo'	            => $row['establecimiento_usuario_codigo']
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
            $detalle    = array(
                'estado_establecimiento_usuario_codigo'	        => '',
                'estado_establecimiento_usuario_nombre'	        => '',
                'establecimiento_codigo'	                    => '',
                'establecimiento_nombre'	                    => '',
                'establecimiento_sigor'		                    => '',
                'establecimiento_observacion'		            => '',
                'usuario_codigo'		                        => '',
                'usuario_nombre'		                        => '',
                'establecimiento_usuario_codigo'	            => ''
            );

            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1700', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_establecimiento_usuario_codigo'];
        $val02                      = $request->getParsedBody()['establecimiento_codigo'];
        $val03                      = $request->getParsedBody()['usuario_codigo'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO ESTUSU (ESTUSU_EUC, ESTUSU_ESC, ESTUSU_USC) VALUES ('$val01', '$val02', '$val03')";
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

	$app->put('/api/v1/1700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_establecimiento_usuario_codigo'];
        $val02                      = $request->getParsedBody()['establecimiento_codigo'];
        $val03                      = $request->getParsedBody()['usuario_codigo'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE ESTUSU SET ESTUSU_EUC = '$val01', ESTUSU_ESC = '$val02', ESTUSU_USC = '$val03' WHERE ESTUSU_COD = '$val00'";
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

	$app->delete('/api/v1/1700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM ESTUSU WHERE ESTUSU_COD = '$val00'";
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