<?php
    $app->get('/api/v1/800', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_seccion_codigo,
		c.DOMFIC_NOM		AS		estado_seccion_nombre,
		b.ESTFIC_COD		AS		establecimiento_codigo,
		b.ESTFIC_NOM		AS		establecimiento_nombre,
        b.ESTFIC_SIC		AS		establecimiento_sigor,
        b.ESTFIC_OBS		AS		establecimiento_observacion,
		a.ESTSEC_COD		AS		seccion_codigo, 
		a.ESTSEC_NOM		AS		seccion_nombre, 
		a.ESTSEC_OBS		AS		seccion_observacion
		
		FROM ESTSEC a
		INNER JOIN ESTFIC b ON a.ESTSEC_ESC = b.ESTFIC_COD
		INNER JOIN DOMFIC c ON a.ESTSEC_EEC = c.DOMFIC_COD
		
		ORDER BY b.ESTFIC_NOM, a.ESTSEC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle    = array(
                    'estado_seccion_codigo'                 => $row['estado_seccion_codigo'],
                    'estado_seccion_nombre'                 => $row['estado_seccion_nombre'],
                    'establecimiento_codigo'                => $row['establecimiento_codigo'],
                    'establecimiento_nombre'                => $row['establecimiento_nombre'],
                    'establecimiento_sigor'                 => $row['establecimiento_sigor'],
                    'establecimiento_observacion'           => $row['establecimiento_observacion'],
                    'seccion_codigo'                        => $row['seccion_codigo'],
                    'seccion_nombre'                        => $row['seccion_nombre'],
                    'seccion_observacion'                   => $row['seccion_observacion']
                );
                $result[]   = $detalle;
            }
            $query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            $detalle    = array(
                'estado_seccion_codigo'                 => "",
                'estado_seccion_nombre'                 => "",
                'establecimiento_codigo'                => "",
                'establecimiento_nombre'                => "",
                'establecimiento_sigor'                 => "",
                'establecimiento_observacion'           => "",
                'seccion_codigo'                        => "",
                'seccion_nombre'                        => "",
                'seccion_observacion'                   => ""
            );
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/800/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        $sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_seccion_codigo,
		c.DOMFIC_NOM		AS		estado_seccion_nombre,
		b.ESTFIC_COD		AS		establecimiento_codigo,
		b.ESTFIC_NOM		AS		establecimiento_nombre,
		b.ESTFIC_SIC		AS		establecimiento_sigor,
        b.ESTFIC_OBS		AS		establecimiento_observacion,
		a.ESTSEC_COD		AS		seccion_codigo, 
		a.ESTSEC_NOM		AS		seccion_nombre, 
		a.ESTSEC_OBS		AS		seccion_observacion
		
		FROM ESTSEC a
		INNER JOIN ESTFIC b ON a.ESTSEC_ESC = b.ESTFIC_COD
		INNER JOIN DOMFIC c ON a.ESTSEC_EEC = c.DOMFIC_COD
		
        WHERE a.ESTSEC_COD = '$val00'
		ORDER BY b.ESTFIC_NOM, a.ESTSEC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle    = array(
                    'estado_seccion_codigo'                 => $row['estado_seccion_codigo'],
                    'estado_seccion_nombre'                 => $row['estado_seccion_nombre'],
                    'establecimiento_codigo'                => $row['establecimiento_codigo'],
                    'establecimiento_nombre'                => $row['establecimiento_nombre'],
                    'establecimiento_sigor'                 => $row['establecimiento_sigor'],
                    'establecimiento_observacion'           => $row['establecimiento_observacion'],
                    'seccion_codigo'                        => $row['seccion_codigo'],
                    'seccion_nombre'                        => $row['seccion_nombre'],
                    'seccion_observacion'                   => $row['seccion_observacion']
                );
                $result[]   = $detalle;
            }
            $query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            $detalle    = array(
                'estado_seccion_codigo'                 => "",
                'estado_seccion_nombre'                 => "",
                'establecimiento_codigo'                => "",
                'establecimiento_nombre'                => "",
                'establecimiento_sigor'                 => "",
                'establecimiento_observacion'           => "",
                'seccion_codigo'                        => "",
                'seccion_nombre'                        => "",
                'seccion_observacion'                   => ""
            );
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/800/establecimiento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        $sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_seccion_codigo,
		c.DOMFIC_NOM		AS		estado_seccion_nombre,
		b.ESTFIC_COD		AS		establecimiento_codigo,
		b.ESTFIC_NOM		AS		establecimiento_nombre,
		b.ESTFIC_SIC		AS		establecimiento_sigor,
        b.ESTFIC_OBS        AS      establecimiento_observacion,
        a.ESTSEC_COD		AS		seccion_codigo, 
		a.ESTSEC_NOM		AS		seccion_nombre, 
		a.ESTSEC_OBS		AS		seccion_observacion
		
		FROM ESTSEC a
		INNER JOIN ESTFIC b ON a.ESTSEC_ESC = b.ESTFIC_COD
		INNER JOIN DOMFIC c ON a.ESTSEC_EEC = c.DOMFIC_COD
		
        WHERE a.ESTSEC_ESC = '$val00'
		ORDER BY b.ESTFIC_NOM, a.ESTSEC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle    = array(
                    'estado_seccion_codigo'                 => $row['estado_seccion_codigo'],
                    'estado_seccion_nombre'                 => $row['estado_seccion_nombre'],
                    'establecimiento_codigo'                => $row['establecimiento_codigo'],
                    'establecimiento_nombre'                => $row['establecimiento_nombre'],
                    'establecimiento_sigor'                 => $row['establecimiento_sigor'],
                    'establecimiento_observacion'           => $row['establecimiento_observacion'],
                    'seccion_codigo'                        => $row['seccion_codigo'],
                    'seccion_nombre'                        => $row['seccion_nombre'],
                    'seccion_observacion'                   => $row['seccion_observacion']
                );
                $result[]   = $detalle;
            }
            $query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            $detalle    = array(
                'estado_seccion_codigo'                 => "",
                'estado_seccion_nombre'                 => "",
                'establecimiento_codigo'                => "",
                'establecimiento_nombre'                => "",
                'establecimiento_sigor'                 => "",
                'establecimiento_observacion'           => "",
                'seccion_codigo'                        => "",
                'seccion_nombre'                        => "",
                'seccion_observacion'                   => ""
            );
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });
    
    $app->post('/api/v1/800', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getParsedBody()['estado_seccion_codigo'];
        $val02      = $request->getParsedBody()['establecimiento_codigo'];
        $val03      = strtoupper($request->getParsedBody()['seccion_nombre']);
        $val04      = $request->getParsedBody()['seccion_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql    = "INSERT INTO ESTSEC (ESTSEC_EEC, ESTSEC_ESC, ESTSEC_NOM, ESTSEC_OBS) VALUES ('$val01', '$val02', '".$val03."', '".$val04."')";
            
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se inserto con exito', 'codigo' => $mysqli->insert_id), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo insertar', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        $mysqli->close();
        
        return $json;
    });
    
    $app->put('/api/v1/800/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['estado_seccion_codigo'];
        $val02      = $request->getParsedBody()['establecimiento_codigo'];
        $val03      = strtoupper($request->getParsedBody()['seccion_nombre']);
        $val04      = $request->getParsedBody()['seccion_observacion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql    = "UPDATE ESTSEC SET ESTSEC_EEC = '$val01', ESTSEC_ESC = '$val02', ESTSEC_NOM = '".$val03."', ESTSEC_OBS = '".$val04."' WHERE ESTSEC_COD = '$val00'";
            
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se actualizo con exito'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo actualizar'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        $mysqli->close();
        
        return $json;
    });
    
    $app->delete('/api/v1/800/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM ESTSEC WHERE ESTSEC_COD = '$val00'";
            
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se elimino con exito'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo eliminar'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        $mysqli->close();
        
        return $json;
    });