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

		a.DOMFIC_ACOD_OLD		AS		dominio_codigo_anterior, 
		b.DOMFIC_NOM		    AS		dominio_estado_anterior,
		a.DOMFIC_ANOM_OLD		AS		dominio_nombre_anterior,
		a.DOMFIC_AVAL_OLD		AS		dominio_valor_anterior,
        a.DOMFIC_AOBS_OLD		AS		dominio_observacion_anterior,

        a.DOMFIC_ACOD_NEW		AS		dominio_codigo_actual, 
		c.DOMFIC_NOM		    AS		dominio_estado_actual,
		a.DOMFIC_ANOM_NEW		AS		dominio_nombre_actual,
		a.DOMFIC_AVAL_NEW		AS		dominio_valor_actual,
        a.DOMFIC_AOBS_NEW		AS		dominio_observacion_actual
		
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
                    'dominio_codigo_anterior'		                => $row['dominio_codigo_anterior'],
                    'dominio_estado_anterior'		                => $row['dominio_estado_anterior'],
                    'dominio_nombre_anterior'		                => $row['dominio_nombre_anterior'],
                    'dominio_valor_anterior'	                    => $row['dominio_valor_anterior'],
                    'dominio_observacion_anterior'	                => $row['dominio_observacion_anterior'],
                    'dominio_codigo_actual'		                    => $row['dominio_codigo_actual'],
                    'dominio_estado_actual'		                    => $row['dominio_estado_actual'],
                    'dominio_nombre_actual'		                    => $row['dominio_nombre_actual'],
                    'dominio_valor_actual'	                        => $row['dominio_valor_actual'],
                    'dominio_observacion_actual'	                => $row['dominio_observacion_actual']
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
                'dominio_codigo_anterior'		                => '',
                'dominio_estado_anterior'		                => '',
                'dominio_nombre_anterior'		                => '',
                'dominio_valor_anterior'	                    => '',
                'dominio_observacion_anterior'	                => '',
                'dominio_codigo_actual'		                    => '',
                'dominio_estado_actual'		                    => '',
                'dominio_nombre_actual'		                    => '',
                'dominio_valor_actual'	                        => '',
                'dominio_observacion_actual'	                => ''
            );

            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });