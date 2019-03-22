<?php
	$app->post('/api/v1/000', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01                      = strtoupper($request->getParsedBody()['usuario_var01']);
        $val02                      = $request->getParsedBody()['usuario_var02'];
        $val03                      = $request->getParsedBody()['usuario_var03'];
        $val04                      = $request->getParsedBody()['usuario_var04'];
        $val05                      = $request->getParsedBody()['usuario_var05'];
        $val06                      = $request->getParsedBody()['usuario_var06'];
        $val07                      = $request->getParsedBody()['usuario_var07'];
        $val08                      = date("Y-m-d");
        $val09                      = date("H:i:s");

        $sql_01                     = "SELECT
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
        a.USUFIC_USU		AS		usuario_usuario,
        a.USUFIC_PAS        AS		usuario_password
        
        FROM USUFIC a
        INNER JOIN DOMFIC b ON a.USUFIC_EUC = b.DOMFIC_COD
        INNER JOIN DOMFIC c ON a.USUFIC_ROC = c.DOMFIC_COD
        INNER JOIN PERFIC d ON a.USUFIC_PEC = d.PERFIC_COD
        
        WHERE a.USUFIC_USU = '$val01'
        ORDER BY a.USUFIC_COD";

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            if ($query = $mysqli->query($sql_01)) {
                while($row = $query->fetch_assoc()) {
                    if ($row['persona_nombre'] == NULL && $row['persona_apellido'] == NULL) {
                        $nombreCompleto = $row['persona_razon_social'];
                    } else {
                        $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                    }
    
                    $detalle    = array(
                        'persona_codigo'		            => $row['persona_codigo'],
                        'persona_completo'		            => $nombreCompleto,
                        'persona_nombre'		            => $row['persona_nombre'],
                        'persona_apellido'	                => $row['persona_apellido'],
                        'persona_razon_social'		        => $row['persona_razon_social'],
                        'persona_documento'		            => $row['persona_documento'],
                        'persona_fecha_nacimiento'	        => $row['persona_fecha_nacimiento'],
                        'persona_telefono'	                => $row['persona_telefono'],
                        'persona_correo_electronico'	    => $row['persona_correo_electronico'],
                        'rol_codigo'	                    => $row['rol_codigo'],
                        'rol_nombre'	                    => $row['rol_nombre'],
                        'estado_usuario_codigo'             => $row['estado_usuario_codigo'],
                        'estado_usuario_nombre'             => $row['estado_usuario_nombre'],
                        'usuario_codigo'                    => $row['usuario_codigo'],
                        'usuario_nombre'                    => $row['usuario_nombre']
                    );	
                    $result[]   = $detalle;
                    $pass       = $row['usuario_password'];

                    if (password_verify($val02, $pass)) {
                        $user   = $row['usuario_codigo'];
                        $sql_02 = "INSERT INTO USULOG (USULOG_EUC, USULOG_USC, USULOG_UUI, USULOG_DIP, USULOG_FEC, USULOG_HOR, USULOG_HOS, USULOG_NAV, USULOG_ANT) VALUES ('1', '$user', '".$val03."', '".$val04."', '".$val08."', '".$val09."', '".$val05."', '".$val06."', '".$val07."')";
                        if ($mysqli->query($sql_02) === TRUE) {
                            header("Content-Type: application/json; charset=utf-8");
                            $json   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Acceso correcto. Bienvenido', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                        } else {
                            header("Content-Type: application/json; charset=utf-8");
                            $json   = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'No se pudo acceder, vuelve a intentar', 'data' => ''), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                        }
                    } else {
                        header("Content-Type: application/json; charset=utf-8");
                        $json = json_encode(array('code' => 401, 'status' => 'failure', 'message' => 'Contraseña invalida, vuelve a intentar', 'data' => ''), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
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