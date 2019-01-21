<?php
	$app->post('/api/v1/000', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01                      = strtoupper($request->getParsedBody()['usuario_var01']);
        $val02                      = $request->getParsedBody()['usuario_var02'];
        $val03                      = $request->getParsedBody()['usuario_var03'];
        $val04                      = $request->getParsedBody()['usuario_var04'];
        $val05                      = date("Y-m-d");
        $val06                      = date("H:i:s");

        $sql_01                     = "SELECT
        b.DOMFIC_COD		    AS		estado_usuario_codigo,
        b.DOMFIC_NOM		    AS		estado_usuario_nombre,
        a.USUFIC_COD		    AS		usuario_codigo, 
        a.USUFIC_USU		    AS		usuario_usuario, 
        a.USUFIC_PASS		    AS		usuario_password
        
        FROM USUFIC a
        INNER JOIN DOMFIC b ON a.USUFIC_EUC = b.DOMFIC_COD
        
        WHERE a.USUFIC_USU = '$val01'
        ORDER BY a.USUFIC_COD";

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            if ($query = $mysqli->query($sql_01)) {
                while($row = $query->fetch_assoc()) {
                    if (password_verify($val01, $row['usuario_password'])) {
                        $user   = $row['usuario_codigo'];
                        $sql_02 = "INSERT INTO USULOG (USULOG_EUC, USULOG_USC, USULOG_UUI, USULOG_DIP, USULOG_FEC, USULOG_HOR) VALUES (1, , $user, '".$val03."', '".$val04."', '".$val05."', '".$val06."')";
                        if ($mysqli->query($sql_02) === TRUE) {
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