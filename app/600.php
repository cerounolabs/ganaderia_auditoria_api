<?php
    $app->get('/api/v1/600', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_categoria_subcategoria_codigo,
		d.DOMFIC_NOM		AS		estado_categoria_subcategoria_nombre,
		c.DOMFIC_COD		AS		subcategoria_codigo, 
		c.DOMFIC_NOM		AS		subcategoria_nombre, 
		b.DOMFIC_COD		AS		categoria_codigo,
		b.DOMFIC_NOM		AS		categoria_nombre, 
		a.DOMCYS_COD		AS		categoria_subcategoria_codigo, 
		a.DOMCYS_OBS		AS		categoria_subcategoria_observacion
		
		FROM DOMCYS a
		INNER JOIN DOMFIC b ON a.DOMFIC_CAC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.DOMFIC_SUC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.DOMFIC_COD = d.DOMFIC_COD
		
		ORDER BY b.DOMFIC_NOM, c.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_categoria_subcategoria_codigo'					=> $row['estado_categoria_subcategoria_codigo'],
					'estado_categoria_subcategoria_nombre'					=> $row['estado_categoria_subcategoria_nombre'],
					'subcategoria_codigo'				                    => $row['subcategoria_codigo'],
					'subcategoria_nombre'				                    => $row['subcategoria_nombre'],
					'categoria_codigo'					                    => $row['categoria_codigo'],
					'categoria_nombre'					                    => $row['categoria_nombre'],
					'categoria_subcategoria_codigo'			                => $row['categoria_subcategoria_codigo'],
                    'categoria_subcategoria_observacion'	                => $row['categoria_subcategoria_observacion']
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

    $app->get('/api/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		estado_categoria_subcategoria_codigo,
		d.DOMFIC_NOM		AS		estado_categoria_subcategoria_nombre,
		c.DOMFIC_COD		AS		subcategoria_codigo, 
		c.DOMFIC_NOM		AS		subcategoria_nombre, 
		b.DOMFIC_COD		AS		categoria_codigo,
		b.DOMFIC_NOM		AS		categoria_nombre, 
		a.DOMCYS_COD		AS		categoria_subcategoria_codigo, 
		a.DOMCYS_OBS		AS		categoria_subcategoria_observacion
		
		FROM DOMCYS a
		INNER JOIN DOMFIC b ON a.DOMFIC_CAC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.DOMFIC_SUC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.DOMFIC_COD = d.DOMFIC_COD
		
		WHERE a.DOMCYS_COD = '$val00'
		ORDER BY b.DOMFIC_NOM, c.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'estado_categoria_subcategoria_codigo'					=> $row['estado_categoria_subcategoria_codigo'],
					'estado_categoria_subcategoria_nombre'					=> $row['estado_categoria_subcategoria_nombre'],
					'subcategoria_codigo'				                    => $row['subcategoria_codigo'],
					'subcategoria_nombre'				                    => $row['subcategoria_nombre'],
					'categoria_codigo'					                    => $row['categoria_codigo'],
					'categoria_nombre'					                    => $row['categoria_nombre'],
					'categoria_subcategoria_codigo'			                => $row['categoria_subcategoria_codigo'],
                    'categoria_subcategoria_observacion'	                => $row['categoria_subcategoria_observacion']
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

	$app->post('/api/v1/600', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_categoria_subcategoria_codigo'];
        $val02                      = $request->getParsedBody()['categoria_codigo'];
        $val03                      = $request->getParsedBody()['subcategoria_codigo'];
		$val04                      = $request->getParsedBody()['categoria_subcategoria_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO DOMCYS (DOMCYS_ECS, DOMCYS_CAC, DOMCYS_SUC, DOMCYS_OBS) VALUES ('$val01', '$val02', '$val03', '".$val04."')";
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

	$app->put('/api/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_categoria_subcategoria_codigo'];
        $val02                      = $request->getParsedBody()['categoria_codigo'];
        $val03                      = $request->getParsedBody()['subcategoria_codigo'];
		$val04                      = $request->getParsedBody()['categoria_subcategoria_observacion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE DOMCYS SET DOMCYS_COD = '$val01', DOMCYS_CAC = '$val02', DOMCYS_SUC = '$val03', MTCCSD_OBS = '".$val04."' WHERE MTCCSD_COD = '$val00'";
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

	$app->delete('/api/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM DOMCYS WHERE DOMCYS_COD = '$val00'";
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