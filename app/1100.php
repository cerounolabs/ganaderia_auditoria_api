<?php
    $app->get('/api/v1/1100', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
        g.DOMFIC_COD		AS		raza_codigo,
		g.DOMFIC_NOM		AS		raza_nombre,
        f.DOMFIC_COD		AS		origen_codigo,
		f.DOMFIC_NOM		AS		origen_nombre,
		e.DOMFIC_COD		AS		subcategoria_codigo,
		e.DOMFIC_NOM		AS		subcategoria_nombre,
        d.DOMFIC_COD		AS		categoria_codigo,
		d.DOMFIC_NOM		AS		categoria_nombre,
		b.ODTFIC_COD		AS		ot_codigo, 
		b.ODTFIC_NRO		AS		ot_numero, 
		b.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        b.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        b.ODTFIC_OBS		AS		ot_observacion,
        a.ODTEXI_COD		AS		ot_existencia_codigo, 
		a.ODTEXI_CAN		AS		ot_existencia_cantidad, 
		a.ODTEXI_OBS		AS		ot_existencia_observacion
		
		FROM ODTEXI a
		INNER JOIN ODTFIC b ON a.ODTEXI_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTEXI_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTEXI_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTEXI_TRC = g.DOMFIC_COD
		
		ORDER BY a.ODTEXI_ORC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
                    'raza_codigo'	                                        => $row['raza_codigo'],
                    'raza_nombre'	                                        => $row['raza_nombre'],
                    'origen_codigo'	                                        => $row['origen_codigo'],
					'origen_nombre'	                                        => $row['origen_nombre'],
					'subcategoria_codigo'	                                => $row['subcategoria_codigo'],
                    'subcategoria_nombre'	                                => $row['subcategoria_nombre'],
                    'categoria_codigo'	                                    => $row['categoria_codigo'],
					'categoria_nombre'	                                    => $row['categoria_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_inicio_trabajo']),
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_final_trabajo']),
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_existencia_codigo'	                                => $row['ot_existencia_codigo'],
                    'ot_existencia_cantidad'	                            => $row['ot_existencia_cantidad'],
                    'ot_existencia_observacion'	                            => $row['ot_existencia_observacion']
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
            $detalle    = array(
                'raza_codigo'	                                        => "",
                'raza_nombre'	                                        => "",
                'origen_codigo'	                                        => "",
                'origen_nombre'	                                        => "",
                'subcategoria_codigo'	                                => "",
                'subcategoria_nombre'	                                => "",
                'categoria_codigo'	                                    => "",
                'categoria_nombre'	                                    => "",
                'ot_codigo'		                                        => "",
                'ot_numero'		                                        => "",
                'ot_fecha_inicio_trabajo'	                            => "",
                'ot_fecha_inicio_trabajo_2'	                            => "",
                'ot_fecha_final_trabajo'	                            => "",
                'ot_fecha_final_trabajo_2'	                            => "",
                'ot_observacion'	                                    => "",
                'ot_existencia_codigo'	                                => "",
                'ot_existencia_cantidad'	                            => "",
                'ot_existencia_observacion'	                            => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        g.DOMFIC_COD		AS		raza_codigo,
		g.DOMFIC_NOM		AS		raza_nombre,
        f.DOMFIC_COD		AS		origen_codigo,
		f.DOMFIC_NOM		AS		origen_nombre,
		e.DOMFIC_COD		AS		subcategoria_codigo,
		e.DOMFIC_NOM		AS		subcategoria_nombre,
        d.DOMFIC_COD		AS		categoria_codigo,
		d.DOMFIC_NOM		AS		categoria_nombre,
		b.ODTFIC_COD		AS		ot_codigo, 
		b.ODTFIC_NRO		AS		ot_numero, 
		b.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        b.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        b.ODTFIC_OBS		AS		ot_observacion,
        a.ODTEXI_COD		AS		ot_existencia_codigo, 
		a.ODTEXI_CAN		AS		ot_existencia_cantidad, 
		a.ODTEXI_OBS		AS		ot_existencia_observacion
		
		FROM ODTEXI a
		INNER JOIN ODTFIC b ON a.ODTEXI_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTEXI_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTEXI_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTEXI_TRC = g.DOMFIC_COD
		
		WHERE a.ODTEXI_COD = '$val00'
		ORDER BY a.ODTEXI_COD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
                    'raza_codigo'	                                        => $row['raza_codigo'],
                    'raza_nombre'	                                        => $row['raza_nombre'],
                    'origen_codigo'	                                        => $row['origen_codigo'],
					'origen_nombre'	                                        => $row['origen_nombre'],
					'subcategoria_codigo'	                                => $row['subcategoria_codigo'],
                    'subcategoria_nombre'	                                => $row['subcategoria_nombre'],
                    'categoria_codigo'	                                    => $row['categoria_codigo'],
					'categoria_nombre'	                                    => $row['categoria_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_inicio_trabajo']),
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_final_trabajo']),
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_existencia_codigo'	                                => $row['ot_existencia_codigo'],
                    'ot_existencia_cantidad'	                            => $row['ot_existencia_cantidad'],
                    'ot_existencia_observacion'	                            => $row['ot_existencia_observacion']
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
            $detalle    = array(
                'raza_codigo'	                                        => "",
                'raza_nombre'	                                        => "",
                'origen_codigo'	                                        => "",
                'origen_nombre'	                                        => "",
                'subcategoria_codigo'	                                => "",
                'subcategoria_nombre'	                                => "",
                'categoria_codigo'	                                    => "",
                'categoria_nombre'	                                    => "",
                'ot_codigo'		                                        => "",
                'ot_numero'		                                        => "",
                'ot_fecha_inicio_trabajo'	                            => "",
                'ot_fecha_inicio_trabajo_2'	                            => "",
                'ot_fecha_final_trabajo'	                            => "",
                'ot_fecha_final_trabajo_2'	                            => "",
                'ot_observacion'	                                    => "",
                'ot_existencia_codigo'	                                => "",
                'ot_existencia_cantidad'	                            => "",
                'ot_existencia_observacion'	                            => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1100/ot/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        g.DOMFIC_COD		AS		raza_codigo,
		g.DOMFIC_NOM		AS		raza_nombre,
        f.DOMFIC_COD		AS		origen_codigo,
		f.DOMFIC_NOM		AS		origen_nombre,
		e.DOMFIC_COD		AS		subcategoria_codigo,
		e.DOMFIC_NOM		AS		subcategoria_nombre,
        d.DOMFIC_COD		AS		categoria_codigo,
		d.DOMFIC_NOM		AS		categoria_nombre,
		b.ODTFIC_COD		AS		ot_codigo, 
		b.ODTFIC_NRO		AS		ot_numero, 
		b.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        b.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        b.ODTFIC_OBS		AS		ot_observacion,
        a.ODTEXI_COD		AS		ot_existencia_codigo, 
		a.ODTEXI_CAN		AS		ot_existencia_cantidad, 
		a.ODTEXI_OBS		AS		ot_existencia_observacion
		
		FROM ODTEXI a
		INNER JOIN ODTFIC b ON a.ODTEXI_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTEXI_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTEXI_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTEXI_TRC = g.DOMFIC_COD
		
		WHERE a.ODTEXI_ORC = '$val00'
		ORDER BY a.ODTEXI_COD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
                    'raza_codigo'	                                        => $row['raza_codigo'],
                    'raza_nombre'	                                        => $row['raza_nombre'],
                    'origen_codigo'	                                        => $row['origen_codigo'],
					'origen_nombre'	                                        => $row['origen_nombre'],
					'subcategoria_codigo'	                                => $row['subcategoria_codigo'],
                    'subcategoria_nombre'	                                => $row['subcategoria_nombre'],
                    'categoria_codigo'	                                    => $row['categoria_codigo'],
					'categoria_nombre'	                                    => $row['categoria_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_inicio_trabajo']),
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_final_trabajo']),
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_existencia_codigo'	                                => $row['ot_existencia_codigo'],
                    'ot_existencia_cantidad'	                            => $row['ot_existencia_cantidad'],
                    'ot_existencia_observacion'	                            => $row['ot_existencia_observacion']
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
            $detalle    = array(
                'raza_codigo'	                                        => "",
                'raza_nombre'	                                        => "",
                'origen_codigo'	                                        => "",
                'origen_nombre'	                                        => "",
                'subcategoria_codigo'	                                => "",
                'subcategoria_nombre'	                                => "",
                'categoria_codigo'	                                    => "",
                'categoria_nombre'	                                    => "",
                'ot_codigo'		                                        => "",
                'ot_numero'		                                        => "",
                'ot_fecha_inicio_trabajo'	                            => "",
                'ot_fecha_inicio_trabajo_2'	                            => "",
                'ot_fecha_final_trabajo'	                            => "",
                'ot_fecha_final_trabajo_2'	                            => "",
                'ot_observacion'	                                    => "",
                'ot_existencia_codigo'	                                => "",
                'ot_existencia_cantidad'	                            => "",
                'ot_existencia_observacion'	                            => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1100', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['subcategoria_ot_existencia_codigo'];
        $val02                      = $request->getParsedBody()['ot_codigo'];
        $val03                      = $request->getParsedBody()['ot_existencia_cantidad'];
        $val04                      = $request->getParsedBody()['ot_existencia_observacion'];
        $val05                      = $request->getParsedBody()['origen_codigo'];
        $val06                      = $request->getParsedBody()['raza_codigo'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val05) && isset($val06)) {
            $sql                    = "INSERT INTO ODTEXI (ODTEXI_CSC, ODTEXI_ORC, ODTEXI_CAN, ODTEXI_OBS, ODTEXI_TOC, ODTEXI_TRC) VALUES ('$val01', '$val02', '$val03', '".$val04."', '$val05', '$val06')";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se inserto con exito', 'codigo' => $mysqli->insert_id), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'No se pudo insertar el resgistro, ya existe!', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });

	$app->put('/api/v1/1100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['subcategoria_ot_existencia_codigo'];
        $val02                      = $request->getParsedBody()['ot_codigo'];
        $val03                      = $request->getParsedBody()['ot_existencia_cantidad'];
        $val04                      = $request->getParsedBody()['ot_existencia_observacion'];
        $val05                      = $request->getParsedBody()['origen_codigo'];
        $val06                      = $request->getParsedBody()['raza_codigo'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val05) && isset($val06)) {
            $sql                    = "UPDATE ODTEXI SET ODTEXI_CSC = '$val01', ODTEXI_ORC = '$val02', ODTEXI_CAN = '$val03', ODTEXI_OBS = '".$val04."', ODTEXI_TOC = '$val05', ODTEXI_TRC = '$val06' WHERE ODTEXI_COD = '$val00'";
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

	$app->delete('/api/v1/1100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM ODTEXI WHERE ODTEXI_COD = '$val00'";
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