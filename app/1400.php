<?php
    $app->get('/api/v1/1400', function($request) {
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
		c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.DOMFIC_COD		AS		estado_establecimiento_propietario_codigo,
		b.DOMFIC_NOM		AS		estado_establecimiento_propietario_nombre,
        a.ESTPRO_COD		AS		establecimiento_propietario_codigo
		
		FROM ESTPRO a
        INNER JOIN DOMFIC b ON a.ESTPRO_EPC = b.DOMFIC_COD
		INNER JOIN ESTFIC c ON a.ESTPRO_ESC = c.ESTFIC_COD
		INNER JOIN PERFIC d ON a.ESTPRO_PRC = d.PERFIC_COD
		
		ORDER BY c.ESTFIC_NOM, d.PERFIC_APE, d.PERFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
					'estado_establecimiento_propietario_codigo'	                => $row['estado_establecimiento_propietario_codigo'],
					'estado_establecimiento_propietario_nombre'	                => $row['estado_establecimiento_propietario_nombre'],
					'establecimiento_codigo'	                                => $row['establecimiento_codigo'],
					'establecimiento_nombre'	                                => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		                                => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		                        => $row['establecimiento_observacion'],
                    'persona_codigo'		                                    => $row['persona_codigo'],
                    'persona_completo'		                                    => $nombreCompleto,
					'persona_nombre'		                                    => $row['persona_nombre'],
                    'persona_apellido'	                                        => $row['persona_apellido'],
                    'persona_razon_social'		                                => $row['persona_razon_social'],
					'persona_documento'		                                    => $row['persona_documento'],
                    'persona_fecha_nacimiento'	                                => $row['persona_fecha_nacimiento'],
                    'persona_telefono'	                                        => $row['persona_telefono'],
                    'persona_correo_electronico'	                            => $row['persona_correo_electronico'],
                    'establecimiento_propietario_codigo'	                    => $row['establecimiento_propietario_codigo']
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
                'estado_establecimiento_propietario_codigo'	                => '',
                'estado_establecimiento_propietario_nombre'	                => '',
                'establecimiento_codigo'	                                => '',
                'establecimiento_nombre'	                                => '',
                'establecimiento_sigor'		                                => '',
                'establecimiento_observacion'		                        => '',
                'persona_codigo'		                                    => '',
                'persona_completo'		                                    => '',
                'persona_nombre'		                                    => '',
                'persona_apellido'	                                        => '',
                'persona_razon_social'		                                => '',
                'persona_documento'		                                    => '',
                'persona_fecha_nacimiento'	                                => '',
                'persona_telefono'	                                        => '',
                'persona_correo_electronico'	                            => '',
                'establecimiento_propietario_codigo'	                    => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1400/{codigo}', function($request) {
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
		c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.DOMFIC_COD		AS		estado_establecimiento_propietario_codigo,
		b.DOMFIC_NOM		AS		estado_establecimiento_propietario_nombre,
        a.ESTPRO_COD		AS		establecimiento_propietario_codigo
		
		FROM ESTPRO a
        INNER JOIN DOMFIC b ON a.ESTPRO_EPC = b.DOMFIC_COD
		INNER JOIN ESTFIC c ON a.ESTPRO_ESC = c.ESTFIC_COD
		INNER JOIN PERFIC d ON a.ESTPRO_PRC = d.PERFIC_COD
		
		WHERE a.ESTPRO_COD = '$val00'
		ORDER BY c.ESTFIC_NOM, d.PERFIC_APE, d.PERFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
					'estado_establecimiento_propietario_codigo'	                => $row['estado_establecimiento_propietario_codigo'],
					'estado_establecimiento_propietario_nombre'	                => $row['estado_establecimiento_propietario_nombre'],
					'establecimiento_codigo'	                                => $row['establecimiento_codigo'],
					'establecimiento_nombre'	                                => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		                                => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		                        => $row['establecimiento_observacion'],
                    'persona_codigo'		                                    => $row['persona_codigo'],
                    'persona_completo'		                                    => $nombreCompleto,
					'persona_nombre'		                                    => $row['persona_nombre'],
                    'persona_apellido'	                                        => $row['persona_apellido'],
                    'persona_razon_social'		                                => $row['persona_razon_social'],
					'persona_documento'		                                    => $row['persona_documento'],
                    'persona_fecha_nacimiento'	                                => $row['persona_fecha_nacimiento'],
                    'persona_telefono'	                                        => $row['persona_telefono'],
                    'persona_correo_electronico'	                            => $row['persona_correo_electronico'],
                    'establecimiento_propietario_codigo'	                    => $row['establecimiento_propietario_codigo']
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
                'estado_establecimiento_propietario_codigo'	                => '',
                'estado_establecimiento_propietario_nombre'	                => '',
                'establecimiento_codigo'	                                => '',
                'establecimiento_nombre'	                                => '',
                'establecimiento_sigor'		                                => '',
                'establecimiento_observacion'		                        => '',
                'persona_codigo'		                                    => '',
                'persona_completo'		                                    => '',
                'persona_nombre'		                                    => '',
                'persona_apellido'	                                        => '',
                'persona_razon_social'		                                => '',
                'persona_documento'		                                    => '',
                'persona_fecha_nacimiento'	                                => '',
                'persona_telefono'	                                        => '',
                'persona_correo_electronico'	                            => '',
                'establecimiento_propietario_codigo'	                    => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1400/establecimiento/{codigo}', function($request) {
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
		c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		b.DOMFIC_COD		AS		estado_establecimiento_propietario_codigo,
		b.DOMFIC_NOM		AS		estado_establecimiento_propietario_nombre,
        a.ESTPRO_COD		AS		establecimiento_propietario_codigo
		
		FROM ESTPRO a
        INNER JOIN DOMFIC b ON a.ESTPRO_EPC = b.DOMFIC_COD
		INNER JOIN ESTFIC c ON a.ESTPRO_ESC = c.ESTFIC_COD
		INNER JOIN PERFIC d ON a.ESTPRO_PRC = d.PERFIC_COD
		
		WHERE c.ESTFIC_COD = '$val00'
		ORDER BY c.ESTFIC_NOM, d.PERFIC_APE, d.PERFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
					'estado_establecimiento_propietario_codigo'	                => $row['estado_establecimiento_propietario_codigo'],
					'estado_establecimiento_propietario_nombre'	                => $row['estado_establecimiento_propietario_nombre'],
					'establecimiento_codigo'	                                => $row['establecimiento_codigo'],
					'establecimiento_nombre'	                                => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		                                => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		                        => $row['establecimiento_observacion'],
                    'persona_codigo'		                                    => $row['persona_codigo'],
                    'persona_completo'		                                    => $nombreCompleto,
					'persona_nombre'		                                    => $row['persona_nombre'],
                    'persona_apellido'	                                        => $row['persona_apellido'],
                    'persona_razon_social'		                                => $row['persona_razon_social'],
					'persona_documento'		                                    => $row['persona_documento'],
                    'persona_fecha_nacimiento'	                                => $row['persona_fecha_nacimiento'],
                    'persona_telefono'	                                        => $row['persona_telefono'],
                    'persona_correo_electronico'	                            => $row['persona_correo_electronico'],
                    'establecimiento_propietario_codigo'	                    => $row['establecimiento_propietario_codigo']
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
                'estado_establecimiento_propietario_codigo'	                => '',
                'estado_establecimiento_propietario_nombre'	                => '',
                'establecimiento_codigo'	                                => '',
                'establecimiento_nombre'	                                => '',
                'establecimiento_sigor'		                                => '',
                'establecimiento_observacion'		                        => '',
                'persona_codigo'		                                    => '',
                'persona_completo'		                                    => '',
                'persona_nombre'		                                    => '',
                'persona_apellido'	                                        => '',
                'persona_razon_social'		                                => '',
                'persona_documento'		                                    => '',
                'persona_fecha_nacimiento'	                                => '',
                'persona_telefono'	                                        => '',
                'persona_correo_electronico'	                            => '',
                'establecimiento_propietario_codigo'	                    => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1400', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_establecimiento_propietario_codigo'];
        $val02                      = $request->getParsedBody()['establecimiento_codigo'];
        $val03                      = $request->getParsedBody()['persona_codigo'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO ESTPRO (ESTPRO_EPC, ESTPRO_ESC, ESTPRO_PRC) VALUES ('$val01', '$val02', '$val03')";
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

	$app->put('/api/v1/1400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_establecimiento_propietario_codigo'];
        $val02                      = $request->getParsedBody()['establecimiento_codigo'];
        $val03                      = $request->getParsedBody()['persona_codigo'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE ESTPRO SET ESTPRO_EPC = '$val01', ESTPRO_ESC = '$val02', ESTPRO_PRC = '$val03' WHERE ESTPRO_COD = '$val00'";
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

	$app->delete('/api/v1/1400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM ESTPRO WHERE ESTPRO_COD = '$val00'";
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