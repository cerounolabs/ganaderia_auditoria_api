<?php
    $app->get('/api/v1/000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		b.DOMFIC_COD		    AS		estado_pais_codigo,
		b.DOMFIC_NOM		    AS		estado_pais_nombre,
		a.PAIFIC_COD		    AS		pais_codigo, 
		a.PAIFIC_NOM		    AS		pais_nombre, 
		a.PAIFIC_OBS		    AS		pais_observacion
		
		FROM PAIFIC a
		INNER JOIN DOMFIC b ON a.PAIFIC_EPC = b.DOMFIC_COD
		
		WHERE a.PAIFIC_COD = '$val00'
		ORDER BY a.PAIFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'estado_pais_codigo'	=> $row['estado_pais_codigo'],
					'estado_pais_nombre'	=> $row['estado_pais_nombre'],
					'pais_codigo'			=> $row['pais_codigo'], 
					'pais_nombre'			=> $row['pais_nombre'],
					'pais_observacion'		=> $row['pais_observacion']
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

	$app->post('/api/v1/000/user/{user}/pass/{pass}/uuid/{uuid}/ip/{ip}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('user');
        $val01                      = $request->getAttribute('pass');
        $val02                      = $request->getAttribute('uuid');
        $val03                      = $request->getAttribute('ip');
        $val04                      = date("Y-m-d");
        $val05                      = date("H:i:s");

        $sql_00                     = "INSERT INTO USULOG (USULOG_EUC, USULOG_USC, USULOG_UUI, USULOG_DIP, USULOG_FEC, USULOG_HOR) VALUES (1, '$val01', '".$val02."', '".$val03."', '".$val04."', '".$val05."')";
        $sql_01                     = "SELECT
        b.DOMFIC_COD		    AS		estado_usuario_codigo,
        b.DOMFIC_NOM		    AS		estado_usuario_nombre,
        a.USUFIC_COD		    AS		usuario_codigo, 
        a.USUFIC_USU		    AS		usuario_usuario, 
        a.USUFIC_PASS		    AS		usuario_password
        
        FROM USUFIC a
        INNER JOIN DOMFIC b ON a.USUFIC_EUC = b.DOMFIC_COD
        
        WHERE a.USUFIC_USU = '$val00' AND a.USUFIC_PASS = '$val01'
        ORDER BY a.USUFIC_COD";

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            if ($query = $mysqli->query($sql_01)) {
                while($row = $query->fetch_assoc()) {
                    if (password_verify($val01, $row['usuario_password'])) {
                        if ($mysqli->query($sql_00) === TRUE) {
                            header("Content-Type: application/json; charset=utf-8");
                            $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Acceso correcto. Bienvenido', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                        } else {
                            header("Content-Type: application/json; charset=utf-8");
                            $json               = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo acceder, vuelve a intentar', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                        }
                    } else {
                        header("Content-Type: application/json; charset=utf-8");
                        $json               = json_encode(array('code' => 401, 'status' => 'ok', 'message' => 'Contraseña invalida, vuelve a intentar', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                    }
                }
                $query->free();
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });