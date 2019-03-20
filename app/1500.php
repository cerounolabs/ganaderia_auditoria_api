<?php
    $app->get('/api/v1/1500', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		rol_codigo,
		d.DOMFIC_NOM		AS		rol_nombre,
        c.DOMFIC_COD		AS		programa_codigo,
		c.DOMFIC_NOM		AS		programa_nombre,
		b.DOMFIC_COD		AS		estado_acceso_codigo,
		b.DOMFIC_NOM		AS		estado_acceso_nombre,
        a.USUACC_COD		AS		acceso_codigo,
        a.USUACC_ING		AS		acceso_ingresar,
        a.USUACC_DSP		AS		acceso_visualizar,
        a.USUACC_INS		AS		acceso_insertar,
        a.USUACC_UPD		AS		acceso_modificar,
        a.USUACC_DLT		AS		acceso_eliminar
		
		FROM USUACC a
        INNER JOIN DOMFIC b ON a.USUACC_EPC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.USUACC_PRC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.USUACC_ROC = d.DOMFIC_COD
		
		ORDER BY c.DOMFIC_NOM, d.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'rol_codigo'	                => $row['rol_codigo'],
					'rol_nombre'	                => $row['rol_nombre'],
					'programa_codigo'	            => $row['programa_codigo'],
					'programa_nombre'	            => $row['programa_nombre'],
                    'estado_acceso_codigo'		    => $row['estado_acceso_codigo'],
                    'estado_acceso_nombre'		    => $row['estado_acceso_nombre'],
                    'acceso_codigo'		            => $row['acceso_codigo'],
                    'acceso_ingresar'		        => $row['acceso_ingresar'],
					'acceso_visualizar'		        => $row['acceso_visualizar'],
                    'acceso_insertar'	            => $row['acceso_insertar'],
                    'acceso_modificar'		        => $row['acceso_modificar'],
					'acceso_eliminar'		        => $row['acceso_eliminar']
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
                'rol_codigo'	                => '',
                'rol_nombre'	                => '',
                'programa_codigo'	            => '',
                'programa_nombre'	            => '',
                'estado_acceso_codigo'		    => '',
                'estado_acceso_nombre'		    => '',
                'acceso_codigo'		            => '',
                'acceso_ingresar'		        => '',
                'acceso_visualizar'		        => '',
                'acceso_insertar'	            => '',
                'acceso_modificar'		        => '',
                'acceso_eliminar'		        => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		rol_codigo,
		d.DOMFIC_NOM		AS		rol_nombre,
        c.DOMFIC_COD		AS		programa_codigo,
		c.DOMFIC_NOM		AS		programa_nombre,
		b.DOMFIC_COD		AS		estado_acceso_codigo,
		b.DOMFIC_NOM		AS		estado_acceso_nombre,
        a.USUACC_COD		AS		acceso_codigo,
        a.USUACC_ING		AS		acceso_ingresar,
        a.USUACC_DSP		AS		acceso_visualizar,
        a.USUACC_INS		AS		acceso_insertar,
        a.USUACC_UPD		AS		acceso_modificar,
        a.USUACC_DLT		AS		acceso_eliminar
		
		FROM USUACC a
        INNER JOIN DOMFIC b ON a.USUACC_EPC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.USUACC_PRC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.USUACC_ROC = d.DOMFIC_COD
		
		WHERE a.USUACC_COD = '$val00'
		ORDER BY c.DOMFIC_NOM, d.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'rol_codigo'	                => $row['rol_codigo'],
					'rol_nombre'	                => $row['rol_nombre'],
					'programa_codigo'	            => $row['programa_codigo'],
					'programa_nombre'	            => $row['programa_nombre'],
                    'estado_acceso_codigo'		    => $row['estado_acceso_codigo'],
                    'estado_acceso_nombre'		    => $row['estado_acceso_nombre'],
                    'acceso_codigo'		            => $row['acceso_codigo'],
                    'acceso_ingresar'		        => $row['acceso_ingresar'],
					'acceso_visualizar'		        => $row['acceso_visualizar'],
                    'acceso_insertar'	            => $row['acceso_insertar'],
                    'acceso_modificar'		        => $row['acceso_modificar'],
					'acceso_eliminar'		        => $row['acceso_eliminar']
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
                'rol_codigo'	                => '',
                'rol_nombre'	                => '',
                'programa_codigo'	            => '',
                'programa_nombre'	            => '',
                'estado_acceso_codigo'		    => '',
                'estado_acceso_nombre'		    => '',
                'acceso_codigo'		            => '',
                'acceso_ingresar'		        => '',
                'acceso_visualizar'		        => '',
                'acceso_insertar'	            => '',
                'acceso_modificar'		        => '',
                'acceso_eliminar'		        => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1500/programa/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		rol_codigo,
		d.DOMFIC_NOM		AS		rol_nombre,
        c.DOMFIC_COD		AS		programa_codigo,
		c.DOMFIC_NOM		AS		programa_nombre,
		b.DOMFIC_COD		AS		estado_acceso_codigo,
		b.DOMFIC_NOM		AS		estado_acceso_nombre,
        a.USUACC_COD		AS		acceso_codigo,
        a.USUACC_ING		AS		acceso_ingresar,
        a.USUACC_DSP		AS		acceso_visualizar,
        a.USUACC_INS		AS		acceso_insertar,
        a.USUACC_UPD		AS		acceso_modificar,
        a.USUACC_DLT		AS		acceso_eliminar
		
		FROM USUACC a
        INNER JOIN DOMFIC b ON a.USUACC_EPC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.USUACC_PRC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.USUACC_ROC = d.DOMFIC_COD
		
		WHERE a.USUACC_PRC = '$val00'
		ORDER BY c.DOMFIC_NOM, d.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'rol_codigo'	                => $row['rol_codigo'],
					'rol_nombre'	                => $row['rol_nombre'],
					'programa_codigo'	            => $row['programa_codigo'],
					'programa_nombre'	            => $row['programa_nombre'],
                    'estado_acceso_codigo'		    => $row['estado_acceso_codigo'],
                    'estado_acceso_nombre'		    => $row['estado_acceso_nombre'],
                    'acceso_codigo'		            => $row['acceso_codigo'],
                    'acceso_ingresar'		        => $row['acceso_ingresar'],
					'acceso_visualizar'		        => $row['acceso_visualizar'],
                    'acceso_insertar'	            => $row['acceso_insertar'],
                    'acceso_modificar'		        => $row['acceso_modificar'],
					'acceso_eliminar'		        => $row['acceso_eliminar']
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
                'rol_codigo'	                => '',
                'rol_nombre'	                => '',
                'programa_codigo'	            => '',
                'programa_nombre'	            => '',
                'estado_acceso_codigo'		    => '',
                'estado_acceso_nombre'		    => '',
                'acceso_codigo'		            => '',
                'acceso_ingresar'		        => '',
                'acceso_visualizar'		        => '',
                'acceso_insertar'	            => '',
                'acceso_modificar'		        => '',
                'acceso_eliminar'		        => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1500/rol/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.DOMFIC_COD		AS		rol_codigo,
		d.DOMFIC_NOM		AS		rol_nombre,
        c.DOMFIC_COD		AS		programa_codigo,
		c.DOMFIC_NOM		AS		programa_nombre,
		b.DOMFIC_COD		AS		estado_acceso_codigo,
		b.DOMFIC_NOM		AS		estado_acceso_nombre,
        a.USUACC_COD		AS		acceso_codigo,
        a.USUACC_ING		AS		acceso_ingresar,
        a.USUACC_DSP		AS		acceso_visualizar,
        a.USUACC_INS		AS		acceso_insertar,
        a.USUACC_UPD		AS		acceso_modificar,
        a.USUACC_DLT		AS		acceso_eliminar
		
		FROM USUACC a
        INNER JOIN DOMFIC b ON a.USUACC_EPC = b.DOMFIC_COD
		INNER JOIN DOMFIC c ON a.USUACC_PRC = c.DOMFIC_COD
		INNER JOIN DOMFIC d ON a.USUACC_ROC = d.DOMFIC_COD
		
		WHERE a.USUACC_ROC = '$val00'
		ORDER BY c.DOMFIC_NOM, d.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'rol_codigo'	                => $row['rol_codigo'],
					'rol_nombre'	                => $row['rol_nombre'],
					'programa_codigo'	            => $row['programa_codigo'],
					'programa_nombre'	            => $row['programa_nombre'],
                    'estado_acceso_codigo'		    => $row['estado_acceso_codigo'],
                    'estado_acceso_nombre'		    => $row['estado_acceso_nombre'],
                    'acceso_codigo'		            => $row['acceso_codigo'],
                    'acceso_ingresar'		        => $row['acceso_ingresar'],
					'acceso_visualizar'		        => $row['acceso_visualizar'],
                    'acceso_insertar'	            => $row['acceso_insertar'],
                    'acceso_modificar'		        => $row['acceso_modificar'],
					'acceso_eliminar'		        => $row['acceso_eliminar']
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
                'rol_codigo'	                => '',
                'rol_nombre'	                => '',
                'programa_codigo'	            => '',
                'programa_nombre'	            => '',
                'estado_acceso_codigo'		    => '',
                'estado_acceso_nombre'		    => '',
                'acceso_codigo'		            => '',
                'acceso_ingresar'		        => '',
                'acceso_visualizar'		        => '',
                'acceso_insertar'	            => '',
                'acceso_modificar'		        => '',
                'acceso_eliminar'		        => ''
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1500', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_acceso_codigo'];
        $val02                      = $request->getParsedBody()['programa_codigo'];
        $val03                      = $request->getParsedBody()['rol_codigo'];
        $val04                      = $request->getParsedBody()['acceso_ingresar'];
        $val05                      = $request->getParsedBody()['acceso_visualizar'];
        $val06                      = $request->getParsedBody()['acceso_insertar'];
        $val07                      = $request->getParsedBody()['acceso_modificar'];
        $val08                      = $request->getParsedBody()['acceso_eliminar'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08)) {
            $sql                    = "INSERT INTO USUACC (USUACC_EPC, USUACC_PRC, USUACC_ROC, USUACC_ING, USUACC_DSP, USUACC_INS, USUACC_UPD, USUACC_DLT) VALUES ('$val01', '$val02', '$val03', '".$val04."', '".$val05."', '".$val06."', '".$val07."', '".$val08."')";
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

	$app->put('/api/v1/1500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val01                      = $request->getParsedBody()['estado_acceso_codigo'];
        $val02                      = $request->getParsedBody()['programa_codigo'];
        $val03                      = $request->getParsedBody()['rol_codigo'];
        $val04                      = $request->getParsedBody()['acceso_ingresar'];
        $val05                      = $request->getParsedBody()['acceso_visualizar'];
        $val06                      = $request->getParsedBody()['acceso_insertar'];
        $val07                      = $request->getParsedBody()['acceso_modificar'];
        $val08                      = $request->getParsedBody()['acceso_eliminar'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08)) {
            $sql                    = "UPDATE USUACC SET USUACC_EPC = '$val01', USUACC_PRC = '$val02', USUACC_ROC = '$val03', USUACC_ING = '".$val04."', USUACC_DSP = '".$val05."', USUACC_INS = '".$val06."', USUACC_UPD = '".$val07."', USUACC_DLT = '".$val08."' WHERE USUACC_COD = '$val00'";
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

	$app->delete('/api/v1/1500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM USUACC WHERE USUACC_COD = '$val00'";
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