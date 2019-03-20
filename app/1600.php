<?php
    $app->get('/api/v1/1600', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
        d.PERFIC_COD		AS		persona_codigo,
        d.PERFIC_NOM		AS		persona_nombre,
		d.PERFIC_APE		AS		persona_apellido,
        d.PERFIC_RAZ		AS		persona_razon_social,
        d.PERFIC_DOC		AS		persona_documento,
        d.PERFIC_FNA		AS		persona_fecha_nacimiento,
        d.PERFIC_TEL		AS		persona_telefono,
        d.PERFIC_COR		AS		persona_correo_electronico,
		c.DOMFIC_COD		AS		rol_codigo,
		c.DOMFIC_NOM		AS		rol_nombre,
		b.DOMFIC_COD		AS		estado_usuario_codigo,
		b.DOMFIC_NOM		AS		estado_usuario_nombre,
        a.USUFIC_COD		AS		usuario_codigo,
        a.USUFIC_USU		AS		usuario_nombre
		
		FROM USUFIC a
        INNER JOIN DOMFIC b ON a.USUFIC_EUC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.USUFIC_ROC = c.DOMFIC_COD
		INNER JOIN PERFIC d ON a.USUFIC_PEC = d.PERFIC_COD
		
		ORDER BY c.DOMFIC_NOM, a.USUFIC_USU";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                if ($row['persona_nombre'] == NULL && $row['persona_apellido'] == NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
                    'persona_codigo'		        => $row['persona_codigo'],
                    'persona_completo'		        => $nombreCompleto,
					'persona_nombre'		        => $row['persona_nombre'],
                    'persona_apellido'	            => $row['persona_apellido'],
                    'persona_razon_social'		    => $row['persona_razon_social'],
					'persona_documento'		        => $row['persona_documento'],
                    'persona_fecha_nacimiento'	    => $row['persona_fecha_nacimiento'],
                    'persona_telefono'	            => $row['persona_telefono'],
                    'persona_correo_electronico'	=> $row['persona_correo_electronico'],
					'rol_codigo'	                => $row['rol_codigo'],
					'rol_nombre'	                => $row['rol_nombre'],
                    'estado_usuario_codigo'		    => $row['estado_usuario_codigo'],
                    'estado_usuario_nombre'		    => $row['estado_usuario_nombre'],
                    'usuario_codigo'		        => $row['usuario_codigo'],
                    'usuario_nombre'		        => $row['usuario_nombre']
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
                'persona_codigo'		        => '',
                'persona_completo'		        => '',
                'persona_nombre'		        => '',
                'persona_apellido'	            => '',
                'persona_razon_social'		    => '',
                'persona_documento'		        => '',
                'persona_fecha_nacimiento'	    => '',
                'persona_telefono'	            => '',
                'persona_correo_electronico'	=> '',
                'rol_codigo'	                => '',
                'rol_nombre'	                => '',
                'estado_usuario_codigo'		    => '',
                'estado_usuario_nombre'		    => '',
                'usuario_codigo'		        => '',
                'usuario_nombre'		        => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        d.PERFIC_COD		AS		persona_codigo,
        d.PERFIC_NOM		AS		persona_nombre,
		d.PERFIC_APE		AS		persona_apellido,
        d.PERFIC_RAZ		AS		persona_razon_social,
        d.PERFIC_DOC		AS		persona_documento,
        d.PERFIC_FNA		AS		persona_fecha_nacimiento,
        d.PERFIC_TEL		AS		persona_telefono,
        d.PERFIC_COR		AS		persona_correo_electronico,
		c.DOMFIC_COD		AS		rol_codigo,
		c.DOMFIC_NOM		AS		rol_nombre,
		b.DOMFIC_COD		AS		estado_usuario_codigo,
		b.DOMFIC_NOM		AS		estado_usuario_nombre,
        a.USUFIC_COD		AS		usuario_codigo,
        a.USUFIC_USU		AS		usuario_nombre
		
		FROM USUFIC a
        INNER JOIN DOMFIC b ON a.USUFIC_EUC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.USUFIC_ROC = c.DOMFIC_COD
		INNER JOIN PERFIC d ON a.USUFIC_PEC = d.PERFIC_COD
		
		WHERE a.USUFIC_COD = '$val00'
		ORDER BY c.DOMFIC_NOM, a.USUFIC_USU";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                if ($row['persona_nombre'] == NULL && $row['persona_apellido'] == NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
                    'persona_codigo'		        => $row['persona_codigo'],
                    'persona_completo'		        => $nombreCompleto,
					'persona_nombre'		        => $row['persona_nombre'],
                    'persona_apellido'	            => $row['persona_apellido'],
                    'persona_razon_social'		    => $row['persona_razon_social'],
					'persona_documento'		        => $row['persona_documento'],
                    'persona_fecha_nacimiento'	    => $row['persona_fecha_nacimiento'],
                    'persona_telefono'	            => $row['persona_telefono'],
                    'persona_correo_electronico'	=> $row['persona_correo_electronico'],
					'rol_codigo'	                => $row['rol_codigo'],
					'rol_nombre'	                => $row['rol_nombre'],
                    'estado_usuario_codigo'		    => $row['estado_usuario_codigo'],
                    'estado_usuario_nombre'		    => $row['estado_usuario_nombre'],
                    'usuario_codigo'		        => $row['usuario_codigo'],
                    'usuario_nombre'		        => $row['usuario_nombre']
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
                'persona_codigo'		        => '',
                'persona_completo'		        => '',
                'persona_nombre'		        => '',
                'persona_apellido'	            => '',
                'persona_razon_social'		    => '',
                'persona_documento'		        => '',
                'persona_fecha_nacimiento'	    => '',
                'persona_telefono'	            => '',
                'persona_correo_electronico'	=> '',
                'rol_codigo'	                => '',
                'rol_nombre'	                => '',
                'estado_usuario_codigo'		    => '',
                'estado_usuario_nombre'		    => '',
                'usuario_codigo'		        => '',
                'usuario_nombre'		        => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1600/rol/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.PERFIC_COD		AS		persona_codigo,
        d.PERFIC_NOM		AS		persona_nombre,
		d.PERFIC_APE		AS		persona_apellido,
        d.PERFIC_RAZ		AS		persona_razon_social,
        d.PERFIC_DOC		AS		persona_documento,
        d.PERFIC_FNA		AS		persona_fecha_nacimiento,
        d.PERFIC_TEL		AS		persona_telefono,
        d.PERFIC_COR		AS		persona_correo_electronico,
		c.DOMFIC_COD		AS		rol_codigo,
		c.DOMFIC_NOM		AS		rol_nombre,
		b.DOMFIC_COD		AS		estado_usuario_codigo,
		b.DOMFIC_NOM		AS		estado_usuario_nombre,
        a.USUFIC_COD		AS		usuario_codigo,
        a.USUFIC_USU		AS		usuario_nombre
		
		FROM USUFIC a
        INNER JOIN DOMFIC b ON a.USUFIC_EUC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.USUFIC_ROC = c.DOMFIC_COD
		INNER JOIN PERFIC d ON a.USUFIC_PEC = d.PERFIC_COD
		
		WHERE a.USUFIC_ROC = '$val00'
		ORDER BY c.DOMFIC_NOM, a.USUFIC_USU";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                if ($row['persona_nombre'] == NULL && $row['persona_apellido'] == NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
                    'persona_codigo'		        => $row['persona_codigo'],
                    'persona_completo'		        => $nombreCompleto,
					'persona_nombre'		        => $row['persona_nombre'],
                    'persona_apellido'	            => $row['persona_apellido'],
                    'persona_razon_social'		    => $row['persona_razon_social'],
					'persona_documento'		        => $row['persona_documento'],
                    'persona_fecha_nacimiento'	    => $row['persona_fecha_nacimiento'],
                    'persona_telefono'	            => $row['persona_telefono'],
                    'persona_correo_electronico'	=> $row['persona_correo_electronico'],
					'rol_codigo'	                => $row['rol_codigo'],
					'rol_nombre'	                => $row['rol_nombre'],
                    'estado_usuario_codigo'		    => $row['estado_usuario_codigo'],
                    'estado_usuario_nombre'		    => $row['estado_usuario_nombre'],
                    'usuario_codigo'		        => $row['usuario_codigo'],
                    'usuario_nombre'		        => $row['usuario_nombre']
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
                'persona_codigo'		        => '',
                'persona_completo'		        => '',
                'persona_nombre'		        => '',
                'persona_apellido'	            => '',
                'persona_razon_social'		    => '',
                'persona_documento'		        => '',
                'persona_fecha_nacimiento'	    => '',
                'persona_telefono'	            => '',
                'persona_correo_electronico'	=> '',
                'rol_codigo'	                => '',
                'rol_nombre'	                => '',
                'estado_usuario_codigo'		    => '',
                'estado_usuario_nombre'		    => '',
                'usuario_codigo'		        => '',
                'usuario_nombre'		        => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1600', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_usuario_nombre'];
        $val02                      = $request->getParsedBody()['rol_codigo'];
        $val03                      = $request->getParsedBody()['persona_codigo'];
        $val04                      = strtoupper($request->getParsedBody()['usuario_nombre']);
        $val05                      = $request->getParsedBody()['usuario_contrasena'];
        $val06                      = password_hash($val05, PASSWORD_DEFAULT);
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {
            $sql                    = "INSERT INTO USUFIC (USUFIC_EUC, USUFIC_ROC, USUFIC_PEC, USUFIC_USU, USUFIC_PASS) VALUES ('$val01', '$val02', '$val03', '".$val04."', '".$val06."')";
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

	$app->put('/api/v1/1600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_usuario_nombre'];
        $val02                      = $request->getParsedBody()['rol_codigo'];
        $val03                      = $request->getParsedBody()['persona_codigo'];
        $val04                      = strtoupper($request->getParsedBody()['usuario_nombre']);
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "UPDATE USUFIC SET USUFIC_EUC = '$val01', USUFIC_ROC = '$val02', USUFIC_PEC = '$val03', USUFIC_USU = '".$val04."' WHERE USUFIC_COD = '$val00'";
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

    $app->put('/api/v1/1600/usuario/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        $val01                      = $request->getParsedBody()['usuario_contrasena'];
        $val02                      = password_hash($val01, PASSWORD_DEFAULT);
        
        if (isset($val00) && isset($val01) && isset($val02)) {
            $sql                    = "UPDATE USUFIC SET USUFIC_PASS = '".$val02."' WHERE USUFIC_COD = '$val00'";
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

	$app->delete('/api/v1/1600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM USUFIC WHERE USUFIC_COD = '$val00'";
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