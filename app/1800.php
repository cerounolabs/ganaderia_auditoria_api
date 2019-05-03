<?php
    $app->get('/api/v1/1800/dominio', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		a.DOMFIC_ACOD		    AS		auditoria_codigo,
		a.DOMFIC_AMET		    AS		auditoria_metodo,
        a.DOMFIC_AUSU		    AS		auditoria_usuario,
        a.DOMFIC_AFEC		    AS		auditoria_fecha_hora,
        a.DOMFIC_ADIP		    AS		auditoria_ip,

		a.DOMFIC_ACOD_OLD		AS		dominio_codigo_antes, 
		b.DOMFIC_NOM		    AS		dominio_estado_antes,
		a.DOMFIC_ANOM_OLD		AS		dominio_nombre_antes,
		a.DOMFIC_AVAL_OLD		AS		dominio_valor_antes,
        a.DOMFIC_AOBS_OLD		AS		dominio_observacion_antes,

        a.DOMFIC_ACOD_NEW		AS		dominio_codigo_despues,
		c.DOMFIC_NOM		    AS		dominio_estado_despues,
		a.DOMFIC_ANOM_NEW		AS		dominio_nombre_despues,
		a.DOMFIC_AVAL_NEW		AS		dominio_valor_despues,
        a.DOMFIC_AOBS_NEW		AS		dominio_observacion_despues
		
		FROM DOMFIC_A a
		LEFT JOIN DOMFIC b ON a.DOMFIC_AEDC_OLD = b.DOMFIC_COD
        LEFT JOIN DOMFIC c ON a.DOMFIC_AEDC_NEW = c.DOMFIC_COD
		
		ORDER BY a.DOMFIC_ACOD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'auditoria_codigo'	                            => $row['auditoria_codigo'],
                    'auditoria_metodo'	                            => $row['auditoria_metodo'],
					'auditoria_usuario'	                            => $row['auditoria_usuario'],
					'auditoria_fecha_hora'	                        => $row['auditoria_fecha_hora'],
                    'auditoria_ip'		                            => $row['auditoria_ip'],
                    'dominio_codigo_antes'		                    => $row['dominio_codigo_antes'],
                    'dominio_estado_antes'		                    => $row['dominio_estado_antes'],
                    'dominio_nombre_antes'		                    => $row['dominio_nombre_antes'],
                    'dominio_valor_antes'	                        => $row['dominio_valor_antes'],
                    'dominio_observacion_antes'	                    => $row['dominio_observacion_antes'],
                    'dominio_codigo_despues'		                => $row['dominio_codigo_despues'],
                    'dominio_estado_despues'		                => $row['dominio_estado_despues'],
                    'dominio_nombre_despues'		                => $row['dominio_nombre_despues'],
                    'dominio_valor_despues'	                        => $row['dominio_valor_despues'],
                    'dominio_observacion_despues'	                => $row['dominio_observacion_despues']
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
                'auditoria_codigo'	                            => '',
                'auditoria_metodo'	                            => '',
                'auditoria_usuario'	                            => '',
                'auditoria_fecha_hora'	                        => '',
                'auditoria_ip'		                            => '',
                'dominio_codigo_antes'		                    => '',
                'dominio_estado_antes'		                    => '',
                'dominio_nombre_antes'		                    => '',
                'dominio_valor_antes'	                        => '',
                'dominio_observacion_antes'	                    => '',
                'dominio_codigo_despues'	                    => '',
                'dominio_estado_despues'	                    => '',
                'dominio_nombre_despues'	                    => '',
                'dominio_valor_despues'                         => '',
                'dominio_observacion_despues'                   => ''
            );

            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1800/establecimiento', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
        $sql                        = "SELECT
        a.ESTFIC_ACOD		    AS		auditoria_codigo,
		a.ESTFIC_AMET		    AS		auditoria_metodo,
        a.ESTFIC_AUSU		    AS		auditoria_usuario,
        a.ESTFIC_AFEC		    AS		auditoria_fecha_hora,
        a.ESTFIC_ADIP		    AS		auditoria_ip,

		a.ESTFIC_ACOD_OLD		AS		establecimiento_codigo_antes,
		b.DOMFIC_NOM            AS		establecimiento_estado_antes,
		c.PAIDIS_NOM            AS		establecimiento_distrito_antes,
        a.ESTFIC_ANOM_OLD		AS		establecimiento_nombre_antes,
        a.ESTFIC_ASIC_OLD		AS		establecimiento_sigor_antes,
        a.ESTFIC_AOBS_OLD		AS		establecimiento_observacion_antes,

        a.ESTFIC_ACOD_NEW		AS		establecimiento_codigo_despues,
		d.DOMFIC_NOM            AS		establecimiento_estado_despues,
		e.PAIDIS_NOM		    AS		establecimiento_distrito_despues,
        a.ESTFIC_ANOM_NEW		AS		establecimiento_nombre_despues,
        a.ESTFIC_ASIC_NEW		AS		establecimiento_sigor_despues,
        a.ESTFIC_AOBS_NEW		AS		establecimiento_observacion_despues
		
		FROM ESTFIC_A a
		LEFT JOIN DOMFIC b ON a.ESTFIC_AEEC_OLD = b.DOMFIC_COD
        LEFT JOIN PAIDIS c ON a.ESTFIC_ADIC_OLD = c.PAIDIS_COD
        LEFT JOIN DOMFIC d ON a.ESTFIC_AEEC_NEW = d.DOMFIC_COD
        LEFT JOIN PAIDIS e ON a.ESTFIC_ADIC_NEW = e.PAIDIS_COD
		
		ORDER BY a.ESTFIC_ACOD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'auditoria_codigo'	                            => $row['auditoria_codigo'],
                    'auditoria_metodo'	                            => $row['auditoria_metodo'],
					'auditoria_usuario'	                            => $row['auditoria_usuario'],
					'auditoria_fecha_hora'	                        => $row['auditoria_fecha_hora'],
                    'auditoria_ip'		                            => $row['auditoria_ip'],
                    'establecimiento_codigo_antes'		            => $row['establecimiento_codigo_antes'],
                    'establecimiento_estado_antes'		            => $row['establecimiento_estado_antes'],
                    'establecimiento_distrito_antes'		        => $row['establecimiento_distrito_antes'],
                    'establecimiento_nombre_antes'	                => $row['establecimiento_nombre_antes'],
                    'establecimiento_sigor_antes'	                => $row['establecimiento_sigor_antes'],
                    'establecimiento_observacion_antes'	            => $row['establecimiento_observacion_antes'],
                    'establecimiento_codigo_despues'		        => $row['establecimiento_codigo_despues'],
                    'establecimiento_estado_despues'		        => $row['establecimiento_estado_despues'],
                    'establecimiento_distrito_despues'		        => $row['establecimiento_distrito_despues'],
                    'establecimiento_nombre_despues'	            => $row['establecimiento_nombre_despues'],
                    'establecimiento_sigor_despues'	                => $row['establecimiento_sigor_despues'],
                    'establecimiento_observacion_despues'	        => $row['establecimiento_observacion_despues']
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
                'auditoria_codigo'	                            => '',
                'auditoria_metodo'	                            => '',
                'auditoria_usuario'	                            => '',
                'auditoria_fecha_hora'	                       => '',
                'auditoria_ip'		                            => '',
                'establecimiento_codigo_antes'		            => '',
                'establecimiento_estado_antes'		            => '',
                'establecimiento_distrito_antes'		        => '',
                'establecimiento_nombre_antes'	                => '',
                'establecimiento_sigor_antes'	                => '',
                'establecimiento_observacion_antes'	            => '',
                'establecimiento_codigo_despues'		        => '',
                'establecimiento_estado_despues'		        => '',
                'establecimiento_distrito_despues'		        => '',
                'establecimiento_nombre_despues'	            => '',
                'establecimiento_sigor_despues'	                => '',
                'establecimiento_observacion_despues'	        => ''
            );

            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });