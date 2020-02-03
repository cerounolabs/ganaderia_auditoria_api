<?php
    $app->get('/api/v1/1000', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_ot_codigo,
		c.DOMFIC_NOM		AS		estado_ot_nombre,
		b.ESTFIC_COD		AS		establecimiento_codigo,
		b.ESTFIC_NOM		AS		establecimiento_nombre,
		b.ESTFIC_SIC		AS		establecimiento_sigor,
        b.ESTFIC_OBS		AS		establecimiento_observacion,
		a.ODTFIC_COD		AS		ot_codigo, 
		a.ODTFIC_NRO		AS		ot_numero, 
		a.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        a.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        a.ODTFIC_ADM        AS      ot_administrador,
        a.ODTFIC_AUD        AS      ot_auditor,
        a.ODTFIC_OBS		AS		ot_observacion
		
		FROM ODTFIC a
		INNER JOIN ESTFIC b ON a.ODTFIC_ESC = b.ESTFIC_COD
		INNER JOIN DOMFIC c ON a.ODTFIC_EOC = c.DOMFIC_COD
		
		ORDER BY a.ODTFIC_NRO DESC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $dia1    = substr($row['ot_fecha_inicio_trabajo'], 8);
                $mes1    = substr($row['ot_fecha_inicio_trabajo'], 5, -3);
                $ano1    = substr($row['ot_fecha_inicio_trabajo'], 0, -6);
                $fecha1  = $dia1.'/'.$mes1.'/'.$ano1;

                $dia2    = substr($row['ot_fecha_final_trabajo'], 8);
                $mes2    = substr($row['ot_fecha_final_trabajo'], 5, -3);
                $ano2    = substr($row['ot_fecha_final_trabajo'], 0, -6);
                $fecha2  = $dia2.'/'.$mes2.'/'.$ano2;

                $detalle			= array(
					'estado_ot_codigo'	                    => $row['estado_ot_codigo'],
					'estado_ot_nombre'	                    => $row['estado_ot_nombre'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'ot_codigo'		                        => $row['ot_codigo'],
					'ot_numero'		                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	            => $fecha1,
                    'ot_fecha_final_trabajo'	            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	            => $fecha2,
                    'ot_administrador'	                    => $row['ot_administrador'],
                    'ot_auditor'	                        => $row['ot_auditor'],
                    'ot_observacion'	                    => $row['ot_observacion']
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
            $detalle			= array(
                'estado_ot_codigo'	                    => "",
                'estado_ot_nombre'	                    => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'ot_codigo'		                        => "",
                'ot_numero'		                        => "",
                'ot_fecha_inicio_trabajo'	            => "",
                'ot_fecha_inicio_trabajo_2'	            => "",
                'ot_fecha_final_trabajo'	            => "",
                'ot_fecha_final_trabajo_2'	            => "",
                'ot_administrador'	                    => "",
                'ot_auditor'	                        => "",
                'ot_observacion'	                    => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_ot_codigo,
		c.DOMFIC_NOM		AS		estado_ot_nombre,
		b.ESTFIC_COD		AS		establecimiento_codigo,
		b.ESTFIC_NOM		AS		establecimiento_nombre,
		b.ESTFIC_SIC		AS		establecimiento_sigor,
        b.ESTFIC_OBS		AS		establecimiento_observacion,
		a.ODTFIC_COD		AS		ot_codigo, 
		a.ODTFIC_NRO		AS		ot_numero, 
		a.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        a.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        a.ODTFIC_ADM        AS      ot_administrador,
        a.ODTFIC_AUD        AS      ot_auditor,
        a.ODTFIC_OBS		AS		ot_observacion
		
		FROM ODTFIC a
		INNER JOIN ESTFIC b ON a.ODTFIC_ESC = b.ESTFIC_COD
		INNER JOIN DOMFIC c ON a.ODTFIC_EOC = c.DOMFIC_COD
		
		WHERE a.ODTFIC_COD = '$val00'
		ORDER BY a.ODTFIC_NRO DESC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $dia1    = substr($row['ot_fecha_inicio_trabajo'], 8);
                $mes1    = substr($row['ot_fecha_inicio_trabajo'], 5, -3);
                $ano1    = substr($row['ot_fecha_inicio_trabajo'], 0, -6);
                $fecha1  = $dia1.'/'.$mes1.'/'.$ano1;

                $dia2    = substr($row['ot_fecha_final_trabajo'], 8);
                $mes2    = substr($row['ot_fecha_final_trabajo'], 5, -3);
                $ano2    = substr($row['ot_fecha_final_trabajo'], 0, -6);
                $fecha2  = $dia2.'/'.$mes2.'/'.$ano2;

                $detalle			= array(
					'estado_ot_codigo'	                    => $row['estado_ot_codigo'],
					'estado_ot_nombre'	                    => $row['estado_ot_nombre'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'ot_codigo'		                        => $row['ot_codigo'],
					'ot_numero'		                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	            => $fecha1,
                    'ot_fecha_final_trabajo'	            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	            => $fecha2,
                    'ot_administrador'	                    => $row['ot_administrador'],
                    'ot_auditor'	                        => $row['ot_auditor'],
                    'ot_observacion'	                    => $row['ot_observacion']
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
            $detalle			= array(
                'estado_ot_codigo'	                    => "",
                'estado_ot_nombre'	                    => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'ot_codigo'		                        => "",
                'ot_numero'		                        => "",
                'ot_fecha_inicio_trabajo'	            => "",
                'ot_fecha_inicio_trabajo_2'	            => "",
                'ot_fecha_final_trabajo'	            => "",
                'ot_fecha_final_trabajo_2'	            => "",
                'ot_administrador'	                    => "",
                'ot_auditor'	                        => "",
                'ot_observacion'	                    => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1000/establecimiento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		c.DOMFIC_COD		AS		estado_ot_codigo,
		c.DOMFIC_NOM		AS		estado_ot_nombre,
		b.ESTFIC_COD		AS		establecimiento_codigo,
		b.ESTFIC_NOM		AS		establecimiento_nombre,
		b.ESTFIC_SIC		AS		establecimiento_sigor,
        b.ESTFIC_OBS		AS		establecimiento_observacion,
		a.ODTFIC_COD		AS		ot_codigo, 
		a.ODTFIC_NRO		AS		ot_numero, 
		a.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        a.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        a.ODTFIC_ADM        AS      ot_administrador,
        a.ODTFIC_AUD        AS      ot_auditor,
        a.ODTFIC_OBS		AS		ot_observacion
		
		FROM ODTFIC a
		INNER JOIN ESTFIC b ON a.ODTFIC_ESC = b.ESTFIC_COD
		INNER JOIN DOMFIC c ON a.ODTFIC_EOC = c.DOMFIC_COD
		
		WHERE a.ODTFIC_ESC = '$val00'
		ORDER BY a.ODTFIC_NRO DESC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $dia1    = substr($row['ot_fecha_inicio_trabajo'], 8);
                $mes1    = substr($row['ot_fecha_inicio_trabajo'], 5, -3);
                $ano1    = substr($row['ot_fecha_inicio_trabajo'], 0, -6);
                $fecha1  = $dia1.'/'.$mes1.'/'.$ano1;

                $dia2    = substr($row['ot_fecha_final_trabajo'], 8);
                $mes2    = substr($row['ot_fecha_final_trabajo'], 5, -3);
                $ano2    = substr($row['ot_fecha_final_trabajo'], 0, -6);
                $fecha2  = $dia2.'/'.$mes2.'/'.$ano2;

                $detalle			= array(
					'estado_ot_codigo'	                    => $row['estado_ot_codigo'],
					'estado_ot_nombre'	                    => $row['estado_ot_nombre'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'ot_codigo'		                        => $row['ot_codigo'],
					'ot_numero'		                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	            => $fecha1,
                    'ot_fecha_final_trabajo'	            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	            => $fecha2,
                    'ot_administrador'	                    => $row['ot_administrador'],
                    'ot_auditor'	                        => $row['ot_auditor'],
                    'ot_observacion'	                    => $row['ot_observacion']
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
            $detalle			= array(
                'estado_ot_codigo'	                    => "",
                'estado_ot_nombre'	                    => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'ot_codigo'		                        => "",
                'ot_numero'		                        => "",
                'ot_fecha_inicio_trabajo'	            => "",
                'ot_fecha_inicio_trabajo_2'	            => "",
                'ot_fecha_final_trabajo'	            => "",
                'ot_fecha_final_trabajo_2'	            => "",
                'ot_administrador'	                    => "",
                'ot_auditor'	                        => "",
                'ot_observacion'	                    => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1000/usuario/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		e.DOMFIC_COD		AS		estado_ot_codigo,
		e.DOMFIC_NOM		AS		estado_ot_nombre,
		c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		a.ODTFIC_COD		AS		ot_codigo, 
		a.ODTFIC_NRO		AS		ot_numero, 
		a.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        a.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        a.ODTFIC_ADM        AS      ot_administrador,
        a.ODTFIC_AUD        AS      ot_auditor,
        a.ODTFIC_OBS		AS		ot_observacion
		
		FROM ODTFIC a
		INNER JOIN ESTUSU b ON a.ODTFIC_ESC = b.ESTUSU_ESC
        INNER JOIN ESTFIC c ON b.ESTUSU_ESC = c.ESTFIC_COD
        INNER JOIN USUFIC d ON b.ESTUSU_USC = d.USUFIC_COD
        INNER JOIN DOMFIC e ON a.ODTFIC_EOC = e.DOMFIC_COD
		
		WHERE d.USUFIC_USU = '$val00'
		
		ORDER BY a.ODTFIC_NRO DESC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $dia1    = substr($row['ot_fecha_inicio_trabajo'], 8);
                $mes1    = substr($row['ot_fecha_inicio_trabajo'], 5, -3);
                $ano1    = substr($row['ot_fecha_inicio_trabajo'], 0, -6);
                $fecha1  = $dia1.'/'.$mes1.'/'.$ano1;

                $dia2    = substr($row['ot_fecha_final_trabajo'], 8);
                $mes2    = substr($row['ot_fecha_final_trabajo'], 5, -3);
                $ano2    = substr($row['ot_fecha_final_trabajo'], 0, -6);
                $fecha2  = $dia2.'/'.$mes2.'/'.$ano2;

                $detalle			= array(
					'estado_ot_codigo'	                    => $row['estado_ot_codigo'],
					'estado_ot_nombre'	                    => $row['estado_ot_nombre'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'ot_codigo'		                        => $row['ot_codigo'],
					'ot_numero'		                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	            => $fecha1,
                    'ot_fecha_final_trabajo'	            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	            => $fecha2,
                    'ot_administrador'	                    => $row['ot_administrador'],
                    'ot_auditor'	                        => $row['ot_auditor'],
                    'ot_observacion'	                    => $row['ot_observacion']
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
            $detalle			= array(
                'estado_ot_codigo'	                    => "",
                'estado_ot_nombre'	                    => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'ot_codigo'		                        => "",
                'ot_numero'		                        => "",
                'ot_fecha_inicio_trabajo'	            => "",
                'ot_fecha_inicio_trabajo_2'	            => "",
                'ot_fecha_final_trabajo'	            => "",
                'ot_fecha_final_trabajo_2'	            => "",
                'ot_administrador'	                    => "",
                'ot_auditor'	                        => "",
                'ot_observacion'	                    => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1000/resumen/establecimiento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        SUM(e.ODTAUD_CAN)   AS      ot_auditada_cantidad,
        AVG(e.ODTAUD_PES)   AS      ot_auditada_peso,
		c.ESTFIC_COD		AS		establecimiento_codigo,
		c.ESTFIC_NOM		AS		establecimiento_nombre,
		c.ESTFIC_SIC		AS		establecimiento_sigor,
        c.ESTFIC_OBS		AS		establecimiento_observacion,
		a.ODTFIC_COD		AS		ot_codigo, 
		a.ODTFIC_NRO		AS		ot_numero, 
		a.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        a.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        a.ODTFIC_ADM        AS      ot_administrador,
        a.ODTFIC_AUD        AS      ot_auditor,
        a.ODTFIC_OBS		AS		ot_observacion
		
		FROM ODTFIC a
		INNER JOIN ESTUSU b ON a.ODTFIC_ESC = b.ESTUSU_ESC
        INNER JOIN ESTFIC c ON b.ESTUSU_ESC = c.ESTFIC_COD
        INNER JOIN USUFIC d ON b.ESTUSU_USC = d.USUFIC_COD
        INNER JOIN ODTAUD e ON a.ODTFIC_COD = e.ODTAUD_ORC
		
		WHERE d.USUFIC_USU = '$val00'

		GROUP BY a.ODTFIC_COD, c.ESTFIC_COD
		ORDER BY a.ODTFIC_COD, c.ESTFIC_COD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $dia1    = substr($row['ot_fecha_inicio_trabajo'], 8);
                $mes1    = substr($row['ot_fecha_inicio_trabajo'], 5, -3);
                $ano1    = substr($row['ot_fecha_inicio_trabajo'], 0, -6);
                $fecha1  = $dia1.'/'.$mes1.'/'.$ano1;

                $dia2    = substr($row['ot_fecha_final_trabajo'], 8);
                $mes2    = substr($row['ot_fecha_final_trabajo'], 5, -3);
                $ano2    = substr($row['ot_fecha_final_trabajo'], 0, -6);
                $fecha2  = $dia2.'/'.$mes2.'/'.$ano2;

                $detalle			= array(
					'ot_auditada_cantidad'	                => $row['ot_auditada_cantidad'],
                    'ot_auditada_peso'	                    => $row['ot_auditada_peso'],
					'establecimiento_codigo'	            => $row['establecimiento_codigo'],
					'establecimiento_nombre'	            => $row['establecimiento_nombre'],
                    'establecimiento_sigor'		            => $row['establecimiento_sigor'],
                    'establecimiento_observacion'		    => $row['establecimiento_observacion'],
					'ot_codigo'		                        => $row['ot_codigo'],
					'ot_numero'		                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	            => $fecha1,
                    'ot_fecha_final_trabajo'	            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	            => $fecha2,
                    'ot_administrador'	                    => $row['ot_administrador'],
                    'ot_auditor'	                        => $row['ot_auditor'],
                    'ot_observacion'	                    => $row['ot_observacion']
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
            $detalle			= array(
                'ot_auditada_cantidad'	                => "",
                'ot_auditada_peso'	                    => "",
                'establecimiento_codigo'	            => "",
                'establecimiento_nombre'	            => "",
                'establecimiento_sigor'		            => "",
                'establecimiento_observacion'		    => "",
                'ot_codigo'		                        => "",
                'ot_numero'		                        => "",
                'ot_fecha_inicio_trabajo'	            => "",
                'ot_fecha_inicio_trabajo_2'	            => "",
                'ot_fecha_final_trabajo'	            => "",
                'ot_fecha_final_trabajo_2'	            => "",
                'ot_administrador'	                    => "",
                'ot_auditor'	                        => "",
                'ot_observacion'	                    => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1000', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['estado_ot_codigo'];
        $val02                      = $request->getParsedBody()['establecimiento_codigo'];
        $val03                      = $request->getParsedBody()['ot_numero'];
        $val04                      = $request->getParsedBody()['ot_fecha_inicio_trabajo'];
        $val05                      = $request->getParsedBody()['ot_fecha_final_trabajo'];
        $val06                      = $request->getParsedBody()['ot_observacion'];
        $val07                      = $request->getParsedBody()['ot_administrador'];
        $val08                      = $request->getParsedBody()['ot_auditor'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "INSERT INTO ODTFIC (ODTFIC_EOC, ODTFIC_ESC, ODTFIC_NRO, ODTFIC_FIT, ODTFIC_FFT, ODTFIC_ADM, ODTFIC_AUD, ODTFIC_OBS) VALUES ('$val01', '$val02', '".$val03."', '".$val04."', '".$val05."', '".$val07."', '".$val08."', '".$val06."')";
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

	$app->put('/api/v1/1000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['estado_ot_codigo'];
        $val02                      = $request->getParsedBody()['establecimiento_codigo'];
        $val03                      = $request->getParsedBody()['ot_numero'];
        $val04                      = $request->getParsedBody()['ot_fecha_inicio_trabajo'];
        $val05                      = $request->getParsedBody()['ot_fecha_final_trabajo'];
        $val06                      = $request->getParsedBody()['ot_observacion'];
        $val07                      = $request->getParsedBody()['ot_administrador'];
        $val08                      = $request->getParsedBody()['ot_auditor'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "UPDATE ODTFIC SET ODTFIC_EOC = '$val01', ODTFIC_ESC = '$val02', ODTFIC_NRO = '".$val03."', ODTFIC_FIT = '".$val04."', ODTFIC_FFT = '".$val05."', ODTFIC_ADM = '".$val07."', ODTFIC_AUD = '".$val08."', ODTFIC_OBS = '".$val06."' WHERE ODTFIC_COD = '$val00'";
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

	$app->delete('/api/v1/1000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM ODTFIC WHERE ODTFIC_COD = '$val00'";
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