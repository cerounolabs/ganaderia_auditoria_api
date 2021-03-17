<?php
    $app->get('/api/v1/1200', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
        k.PERFIC_COD		AS		persona_codigo,
        k.PERFIC_NOM		AS		persona_nombre,
		k.PERFIC_APE		AS		persona_apellido,
        k.PERFIC_RAZ		AS		persona_razon_social,
        k.PERFIC_DOC		AS		persona_documento,
        k.PERFIC_FNA		AS		persona_fecha_nacimiento,
        k.PERFIC_TEL		AS		persona_telefono,
        k.PERFIC_COR		AS		persona_correo_electronico,
        j.ESTPRO_MAR        AS      establecimiento_propietario_codigo,
        j.ESTPRO_MAR        AS      establecimiento_propietario_marca,
        i.ESTSEC_COD		AS		seccion_codigo, 
		i.ESTSEC_NOM		AS		seccion_nombre,
        h.ESTPOT_COD        AS      potrero_codigo,
        h.ESTPOT_NOM        AS      potrero_nombre,
        g.DOMFIC_COD		AS		raza_codigo,
		g.DOMFIC_NOM		AS		raza_nombre,
        f.DOMFIC_COD		AS		origen_codigo,
		f.DOMFIC_NOM		AS		origen_nombre,
		e.DOMFIC_COD		AS		subcategoria_codigo,
		e.DOMFIC_NOM		AS		subcategoria_nombre,
        d.DOMFIC_COD		AS		categoria_codigo,
		d.DOMFIC_NOM		AS		categoria_nombre,
		b.ODTFIC_COD		AS		ot_codigo, 
		b.ODTFIC_NRO		AS		ot_numero, 
		b.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        b.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        b.ODTFIC_OBS		AS		ot_observacion,
        a.ODTAUD_COD		AS		ot_auditada_codigo, 
		a.ODTAUD_FEC		AS		ot_auditada_fecha, 
		a.ODTAUD_CAN		AS		ot_auditada_cantidad,
        a.ODTAUD_PES		AS		ot_auditada_peso,
        a.ODTAUD_OBS		AS		ot_auditada_observacion
		
		FROM ODTAUD a
		INNER JOIN ODTFIC b ON a.ODTAUD_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTAUD_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTAUD_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTAUD_TRC = g.DOMFIC_COD
        INNER JOIN ESTPOT h ON a.ODTAUD_POC = h.ESTPOT_COD
        INNER JOIN ESTSEC i ON h.ESTPOT_SEC = i.ESTSEC_COD
        INNER JOIN ESTPRO j ON a.ODTAUD_PRC = j.ESTPRO_COD
        INNER JOIN PERFIC k ON j.ESTPRO_PRC = k.PERFIC_COD
		
		ORDER BY a.ODTAUD_FEC, i.ESTSEC_COD, h.ESTPOT_COD";
		
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

                $dia3    = substr($row['ot_auditada_fecha'], 8);
                $mes3    = substr($row['ot_auditada_fecha'], 5, -3);
                $ano3    = substr($row['ot_auditada_fecha'], 0, -6);
                $fecha3  = $dia3.'/'.$mes3.'/'.$ano3;

                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
                    'propietario_codigo'	                                => $row['persona_codigo'],
                    'propietario_nombre'                                    => $nombreCompleto,
                    'propietario_marca'                                     => $row['establecimiento_propietario_marca'],
                    'origen_codigo'	                                        => $row['origen_codigo'],
					'origen_nombre'	                                        => $row['origen_nombre'],
                    'raza_codigo'	                                        => $row['raza_codigo'],
                    'raza_nombre'	                                        => $row['raza_nombre'],
                    'categoria_codigo'	                                    => $row['categoria_codigo'],
					'categoria_nombre'	                                    => $row['categoria_nombre'],
					'subcategoria_codigo'	                                => $row['subcategoria_codigo'],
                    'subcategoria_nombre'	                                => $row['subcategoria_nombre'],
                    'seccion_codigo'		                                => $row['seccion_codigo'],
					'seccion_nombre'		                                => $row['seccion_nombre'],
                    'potrero_codigo'	                                    => $row['potrero_codigo'],
                    'potrero_nombre'	                                    => $row['potrero_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => $fecha1,
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => $fecha2,
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_auditada_codigo'	                                => $row['ot_auditada_codigo'],
                    'ot_auditada_fecha'	                                    => $row['ot_auditada_fecha'],
                    'ot_auditada_fecha_2'	                                => $fecha3,
                    'ot_auditada_cantidad'	                                => $row['ot_auditada_cantidad'],
                    'ot_auditada_peso'	                                    => $row['ot_auditada_peso'],
                    'ot_auditada_observacion'	                            => $row['ot_auditada_observacion']
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
            $detalle    = array(
                'propietario_codigo'	                                => "",
                'propietario_nombre'                                    => "",
                'propietario_marca'                                     => "",
                'origen_codigo'	                                        => "",
                'origen_nombre'	                                        => "",
                'raza_codigo'	                                        => "",
                'raza_nombre'	                                        => "",
                'categoria_codigo'	                                    => "",
                'categoria_nombre'	                                    => "",
                'subcategoria_codigo'	                                => "",
                'subcategoria_nombre'	                                => "",
                'seccion_codigo'		                                => "",
				'seccion_nombre'		                                => "",
                'potrero_codigo'	                                    => "",
                'potrero_nombre'	                                    => "",
                'ot_codigo'		                                        => "",
                'ot_numero'		                                        => "",
                'ot_fecha_inicio_trabajo'	                            => "",
                'ot_fecha_inicio_trabajo_2'	                            => "",
                'ot_fecha_final_trabajo'	                            => "",
                'ot_fecha_final_trabajo_2'	                            => "",
                'ot_observacion'	                                    => "",
                'ot_auditada_codigo'	                                => "",
                'ot_auditada_fecha'	                                    => "",
                'ot_auditada_fecha_2'	                                => "",
                'ot_auditada_cantidad'	                                => "",
                'ot_auditada_peso'	                                    => "",
                'ot_auditada_observacion'	                            => ""
            );
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        k.PERFIC_COD		AS		persona_codigo,
        k.PERFIC_NOM		AS		persona_nombre,
		k.PERFIC_APE		AS		persona_apellido,
        k.PERFIC_RAZ		AS		persona_razon_social,
        k.PERFIC_DOC		AS		persona_documento,
        k.PERFIC_FNA		AS		persona_fecha_nacimiento,
        k.PERFIC_TEL		AS		persona_telefono,
        k.PERFIC_COR		AS		persona_correo_electronico,
        j.ESTPRO_MAR        AS      establecimiento_propietario_codigo,
        j.ESTPRO_MAR        AS      establecimiento_propietario_marca,
        i.ESTSEC_COD		AS		seccion_codigo, 
		i.ESTSEC_NOM		AS		seccion_nombre,
        h.ESTPOT_COD        AS      potrero_codigo,
        h.ESTPOT_NOM        AS      potrero_nombre,
        g.DOMFIC_COD		AS		raza_codigo,
		g.DOMFIC_NOM		AS		raza_nombre,
        f.DOMFIC_COD		AS		origen_codigo,
		f.DOMFIC_NOM		AS		origen_nombre,
		e.DOMFIC_COD		AS		subcategoria_codigo,
		e.DOMFIC_NOM		AS		subcategoria_nombre,
        d.DOMFIC_COD		AS		categoria_codigo,
		d.DOMFIC_NOM		AS		categoria_nombre,
		b.ODTFIC_COD		AS		ot_codigo, 
		b.ODTFIC_NRO		AS		ot_numero, 
		b.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        b.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        b.ODTFIC_OBS		AS		ot_observacion,
        a.ODTAUD_COD		AS		ot_auditada_codigo, 
		a.ODTAUD_FEC		AS		ot_auditada_fecha, 
		a.ODTAUD_CAN		AS		ot_auditada_cantidad,
        a.ODTAUD_PES		AS		ot_auditada_peso,
        a.ODTAUD_OBS		AS		ot_auditada_observacion
		
		FROM ODTAUD a
		INNER JOIN ODTFIC b ON a.ODTAUD_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTAUD_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTAUD_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTAUD_TRC = g.DOMFIC_COD
        INNER JOIN ESTPOT h ON a.ODTAUD_POC = h.ESTPOT_COD
        INNER JOIN ESTSEC i ON h.ESTPOT_SEC = i.ESTSEC_COD
        INNER JOIN ESTPRO j ON a.ODTAUD_PRC = j.ESTPRO_COD
        INNER JOIN PERFIC k ON j.ESTPRO_PRC = k.PERFIC_COD
		
		WHERE a.ODTAUD_COD = '$val00'
		ORDER BY a.ODTAUD_FEC, i.ESTSEC_COD, h.ESTPOT_COD";
		
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

                $dia3    = substr($row['ot_auditada_fecha'], 8);
                $mes3    = substr($row['ot_auditada_fecha'], 5, -3);
                $ano3    = substr($row['ot_auditada_fecha'], 0, -6);
                $fecha3  = $dia3.'/'.$mes3.'/'.$ano3;

                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
                    'propietario_codigo'	                                => $row['persona_codigo'],
                    'propietario_nombre'                                    => $nombreCompleto,
                    'propietario_marca'                                     => $row['establecimiento_propietario_marca'],
                    'origen_codigo'	                                        => $row['origen_codigo'],
					'origen_nombre'	                                        => $row['origen_nombre'],
                    'raza_codigo'	                                        => $row['raza_codigo'],
                    'raza_nombre'	                                        => $row['raza_nombre'],
                    'categoria_codigo'	                                    => $row['categoria_codigo'],
					'categoria_nombre'	                                    => $row['categoria_nombre'],
					'subcategoria_codigo'	                                => $row['subcategoria_codigo'],
                    'subcategoria_nombre'	                                => $row['subcategoria_nombre'],
                    'seccion_codigo'		                                => $row['seccion_codigo'],
					'seccion_nombre'		                                => $row['seccion_nombre'],
                    'potrero_codigo'	                                    => $row['potrero_codigo'],
                    'potrero_nombre'	                                    => $row['potrero_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => $fecha1,
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => $fecha2,
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_auditada_codigo'	                                => $row['ot_auditada_codigo'],
                    'ot_auditada_fecha'	                                    => $row['ot_auditada_fecha'],
                    'ot_auditada_fecha_2'	                                => $fecha3,
                    'ot_auditada_cantidad'	                                => $row['ot_auditada_cantidad'],
                    'ot_auditada_peso'	                                    => $row['ot_auditada_peso'],
                    'ot_auditada_observacion'	                            => $row['ot_auditada_observacion']
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
            $detalle    = array(
                'propietario_codigo'	                                => "",
                'propietario_nombre'                                    => "",
                'propietario_marca'                                     => "",
                'origen_codigo'	                                        => "",
                'origen_nombre'	                                        => "",
                'raza_codigo'	                                        => "",
                'raza_nombre'	                                        => "",
                'categoria_codigo'	                                    => "",
                'categoria_nombre'	                                    => "",
                'subcategoria_codigo'	                                => "",
                'subcategoria_nombre'	                                => "",
                'seccion_codigo'		                                => "",
				'seccion_nombre'		                                => "",
                'potrero_codigo'	                                    => "",
                'potrero_nombre'	                                    => "",
                'ot_codigo'		                                        => "",
                'ot_numero'		                                        => "",
                'ot_fecha_inicio_trabajo'	                            => "",
                'ot_fecha_inicio_trabajo_2'	                            => "",
                'ot_fecha_final_trabajo'	                            => "",
                'ot_fecha_final_trabajo_2'	                            => "",
                'ot_observacion'	                                    => "",
                'ot_auditada_codigo'	                                => "",
                'ot_auditada_fecha'	                                    => "",
                'ot_auditada_fecha_2'	                                => "",
                'ot_auditada_cantidad'	                                => "",
                'ot_auditada_peso'	                                    => "",
                'ot_auditada_observacion'	                            => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1200/ot/detalle/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        k.PERFIC_COD		AS		persona_codigo,
        k.PERFIC_NOM		AS		persona_nombre,
		k.PERFIC_APE		AS		persona_apellido,
        k.PERFIC_RAZ		AS		persona_razon_social,
        k.PERFIC_DOC		AS		persona_documento,
        k.PERFIC_FNA		AS		persona_fecha_nacimiento,
        k.PERFIC_TEL		AS		persona_telefono,
        k.PERFIC_COR		AS		persona_correo_electronico,
        j.ESTPRO_MAR        AS      establecimiento_propietario_codigo,
        j.ESTPRO_MAR        AS      establecimiento_propietario_marca,
        i.ESTSEC_COD		AS		seccion_codigo, 
		i.ESTSEC_NOM		AS		seccion_nombre,
        h.ESTPOT_COD        AS      potrero_codigo,
        h.ESTPOT_NOM        AS      potrero_nombre,
        g.DOMFIC_COD		AS		raza_codigo,
		g.DOMFIC_NOM		AS		raza_nombre,
        f.DOMFIC_COD		AS		origen_codigo,
		f.DOMFIC_NOM		AS		origen_nombre,
		e.DOMFIC_COD		AS		subcategoria_codigo,
		e.DOMFIC_NOM		AS		subcategoria_nombre,
        d.DOMFIC_COD		AS		categoria_codigo,
		d.DOMFIC_NOM		AS		categoria_nombre,
		b.ODTFIC_COD		AS		ot_codigo, 
		b.ODTFIC_NRO		AS		ot_numero, 
		b.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        b.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        b.ODTFIC_OBS		AS		ot_observacion,
        a.ODTAUD_COD		AS		ot_auditada_codigo, 
		a.ODTAUD_FEC		AS		ot_auditada_fecha, 
		a.ODTAUD_CAN		AS		ot_auditada_cantidad,
        a.ODTAUD_PES		AS		ot_auditada_peso,
        a.ODTAUD_OBS		AS		ot_auditada_observacion
		
		FROM ODTAUD a
		INNER JOIN ODTFIC b ON a.ODTAUD_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTAUD_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTAUD_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTAUD_TRC = g.DOMFIC_COD
        INNER JOIN ESTPOT h ON a.ODTAUD_POC = h.ESTPOT_COD
        INNER JOIN ESTSEC i ON h.ESTPOT_SEC = i.ESTSEC_COD
        INNER JOIN ESTPRO j ON a.ODTAUD_PRC = j.ESTPRO_COD
        INNER JOIN PERFIC k ON j.ESTPRO_PRC = k.PERFIC_COD
		
		WHERE a.ODTAUD_ORC = '$val00'
		ORDER BY a.ODTAUD_FEC, i.ESTSEC_COD, h.ESTPOT_COD";
		
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

                $dia3    = substr($row['ot_auditada_fecha'], 8);
                $mes3    = substr($row['ot_auditada_fecha'], 5, -3);
                $ano3    = substr($row['ot_auditada_fecha'], 0, -6);
                $fecha3  = $dia3.'/'.$mes3.'/'.$ano3;

                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
                    'propietario_codigo'	                                => $row['persona_codigo'],
                    'propietario_nombre'                                    => $nombreCompleto,
                    'propietario_marca'                                     => $row['establecimiento_propietario_marca'],
                    'origen_codigo'	                                        => $row['origen_codigo'],
					'origen_nombre'	                                        => $row['origen_nombre'],
                    'raza_codigo'	                                        => $row['raza_codigo'],
                    'raza_nombre'	                                        => $row['raza_nombre'],
                    'categoria_codigo'	                                    => $row['categoria_codigo'],
					'categoria_nombre'	                                    => $row['categoria_nombre'],
					'subcategoria_codigo'	                                => $row['subcategoria_codigo'],
                    'subcategoria_nombre'	                                => $row['subcategoria_nombre'],
                    'seccion_codigo'		                                => $row['seccion_codigo'],
					'seccion_nombre'		                                => $row['seccion_nombre'],
                    'potrero_codigo'	                                    => $row['potrero_codigo'],
                    'potrero_nombre'	                                    => $row['potrero_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => $fecha1,
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => $fecha2,
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_auditada_codigo'	                                => $row['ot_auditada_codigo'],
                    'ot_auditada_fecha'	                                    => $row['ot_auditada_fecha'],
                    'ot_auditada_fecha_2'	                                => $fecha3,
                    'ot_auditada_cantidad'	                                => $row['ot_auditada_cantidad'],
                    'ot_auditada_peso'	                                    => $row['ot_auditada_peso'],
                    'ot_auditada_observacion'	                            => $row['ot_auditada_observacion']
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
            $detalle    = array(
                'propietario_codigo'	                                => "",
                'propietario_nombre'                                    => "",
                'propietario_marca'                                     => "",
                'origen_codigo'	                                        => "",
                'origen_nombre'	                                        => "",
                'raza_codigo'	                                        => "",
                'raza_nombre'	                                        => "",
                'categoria_codigo'	                                    => "",
                'categoria_nombre'	                                    => "",
                'subcategoria_codigo'	                                => "",
                'subcategoria_nombre'	                                => "",
                'seccion_codigo'		                                => "",
				'seccion_nombre'		                                => "",
                'potrero_codigo'	                                    => "",
                'potrero_nombre'	                                    => "",
                'ot_codigo'		                                        => "",
                'ot_numero'		                                        => "",
                'ot_fecha_inicio_trabajo'	                            => "",
                'ot_fecha_inicio_trabajo_2'	                            => "",
                'ot_fecha_final_trabajo'	                            => "",
                'ot_fecha_final_trabajo_2'	                            => "",
                'ot_observacion'	                                    => "",
                'ot_auditada_codigo'	                                => "",
                'ot_auditada_fecha'	                                    => "",
                'ot_auditada_fecha_2'	                                => "",
                'ot_auditada_cantidad'	                                => "",
                'ot_auditada_peso'	                                    => "",
                'ot_auditada_observacion'	                            => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1200/ot/partediario/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        k.PERFIC_COD		AS		persona_codigo,
        k.PERFIC_NOM		AS		persona_nombre,
		k.PERFIC_APE		AS		persona_apellido,
        k.PERFIC_RAZ		AS		persona_razon_social,
        k.PERFIC_DOC		AS		persona_documento,
        k.PERFIC_FNA		AS		persona_fecha_nacimiento,
        k.PERFIC_TEL		AS		persona_telefono,
        k.PERFIC_COR		AS		persona_correo_electronico,
        j.ESTPRO_MAR        AS      establecimiento_propietario_codigo,
        j.ESTPRO_MAR        AS      establecimiento_propietario_marca,
        i.ESTSEC_COD		AS		seccion_codigo, 
		i.ESTSEC_NOM		AS		seccion_nombre,
        h.ESTPOT_COD        AS      potrero_codigo,
        h.ESTPOT_NOM        AS      potrero_nombre,
        g.DOMFIC_COD		AS		raza_codigo,
		g.DOMFIC_NOM		AS		raza_nombre,
        f.DOMFIC_COD		AS		origen_codigo,
		f.DOMFIC_NOM		AS		origen_nombre,
		e.DOMFIC_COD		AS		subcategoria_codigo,
		e.DOMFIC_NOM		AS		subcategoria_nombre,
        d.DOMFIC_COD		AS		categoria_codigo,
		d.DOMFIC_NOM		AS		categoria_nombre,
		b.ODTFIC_COD		AS		ot_codigo, 
		b.ODTFIC_NRO		AS		ot_numero, 
		b.ODTFIC_FIT		AS		ot_fecha_inicio_trabajo,
        b.ODTFIC_FFT		AS		ot_fecha_final_trabajo,
        b.ODTFIC_OBS		AS		ot_observacion,
        a.ODTAUD_COD		AS		ot_auditada_codigo, 
		a.ODTAUD_FEC		AS		ot_auditada_fecha, 
		a.ODTAUD_CAN		AS		ot_auditada_cantidad,
        a.ODTAUD_PES		AS		ot_auditada_peso,
        a.ODTAUD_OBS		AS		ot_auditada_observacion
		
		FROM ODTAUD a
		INNER JOIN ODTFIC b ON a.ODTAUD_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTAUD_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTAUD_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTAUD_TRC = g.DOMFIC_COD
        INNER JOIN ESTPOT h ON a.ODTAUD_POC = h.ESTPOT_COD
        INNER JOIN ESTSEC i ON h.ESTPOT_SEC = i.ESTSEC_COD
        INNER JOIN ESTPRO j ON a.ODTAUD_PRC = j.ESTPRO_COD
        INNER JOIN PERFIC k ON j.ESTPRO_PRC = k.PERFIC_COD
		
		WHERE a.ODTAUD_ORC = '$val00'
		ORDER BY a.ODTAUD_FEC, a.ODTAUD_POC, a.ODTAUD_TOC, a.ODTAUD_TRC";
		
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

                $dia3    = substr($row['ot_auditada_fecha'], 8);
                $mes3    = substr($row['ot_auditada_fecha'], 5, -3);
                $ano3    = substr($row['ot_auditada_fecha'], 0, -6);
                $fecha3  = $dia3.'/'.$mes3.'/'.$ano3;

                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
                    'propietario_codigo'	                                => $row['persona_codigo'],
                    'propietario_nombre'                                    => $nombreCompleto,
                    'propietario_marca'                                     => $row['establecimiento_propietario_marca'],
                    'origen_codigo'	                                        => $row['origen_codigo'],
					'origen_nombre'	                                        => $row['origen_nombre'],
                    'raza_codigo'	                                        => $row['raza_codigo'],
                    'raza_nombre'	                                        => $row['raza_nombre'],
                    'categoria_codigo'	                                    => $row['categoria_codigo'],
					'categoria_nombre'	                                    => $row['categoria_nombre'],
					'subcategoria_codigo'	                                => $row['subcategoria_codigo'],
                    'subcategoria_nombre'	                                => $row['subcategoria_nombre'],
                    'seccion_codigo'		                                => $row['seccion_codigo'],
					'seccion_nombre'		                                => $row['seccion_nombre'],
                    'potrero_codigo'	                                    => $row['potrero_codigo'],
                    'potrero_nombre'	                                    => $row['potrero_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => $fecha1,
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => $fecha2,
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_auditada_codigo'	                                => $row['ot_auditada_codigo'],
                    'ot_auditada_fecha'	                                    => $row['ot_auditada_fecha'],
                    'ot_auditada_fecha_2'	                                => $fecha3,
                    'ot_auditada_cantidad'	                                => $row['ot_auditada_cantidad'],
                    'ot_auditada_peso'	                                    => $row['ot_auditada_peso'],
                    'ot_auditada_observacion'	                            => $row['ot_auditada_observacion']
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
            $detalle    = array(
                'propietario_codigo'	                                => "",
                'propietario_nombre'                                    => "",
                'propietario_marca'                                     => "",
                'origen_codigo'	                                        => "",
                'origen_nombre'	                                        => "",
                'raza_codigo'	                                        => "",
                'raza_nombre'	                                        => "",
                'categoria_codigo'	                                    => "",
                'categoria_nombre'	                                    => "",
                'subcategoria_codigo'	                                => "",
                'subcategoria_nombre'	                                => "",
                'seccion_codigo'		                                => "",
				'seccion_nombre'		                                => "",
                'potrero_codigo'	                                    => "",
                'potrero_nombre'	                                    => "",
                'ot_codigo'		                                        => "",
                'ot_numero'		                                        => "",
                'ot_fecha_inicio_trabajo'	                            => "",
                'ot_fecha_inicio_trabajo_2'	                            => "",
                'ot_fecha_final_trabajo'	                            => "",
                'ot_fecha_final_trabajo_2'	                            => "",
                'ot_observacion'	                                    => "",
                'ot_auditada_codigo'	                                => "",
                'ot_auditada_fecha'	                                    => "",
                'ot_auditada_fecha_2'	                                => "",
                'ot_auditada_cantidad'	                                => "",
                'ot_auditada_peso'	                                    => "",
                'ot_auditada_observacion'	                            => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1200/ot/filtro/fechaauditada/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00  = $request->getAttribute('codigo');
		$sql    = "SELECT
            a.ODTAUD_FEC		AS		ot_auditada_fecha
            
            FROM ODTAUD a
            
            WHERE a.ODTAUD_ORC = '$val00'
            GROUP BY a.ODTAUD_FEC
            ORDER BY a.ODTAUD_FEC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle    = array(
                    'ot_auditada_fecha' => $row['ot_auditada_fecha']
				);
                $result[]   = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            $detalle    = array(
                'ot_auditada_fecha'     => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1200/ot/filtro/sector/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00  = $request->getAttribute('codigo');
		$sql    = "SELECT
            i.ESTSEC_COD		AS		sector_codigo, 
            i.ESTSEC_NOM		AS		sector_nombre
            
            FROM ODTAUD a
            INNER JOIN ESTPOT h ON a.ODTAUD_POC = h.ESTPOT_COD
            INNER JOIN ESTSEC i ON h.ESTPOT_SEC = i.ESTSEC_COD
            
            WHERE a.ODTAUD_ORC = '$val00'
            GROUP BY i.ESTSEC_COD, i.ESTSEC_NOM
            ORDER BY i.ESTSEC_COD, i.ESTSEC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle    = array(
                    'sector_codigo'     => $row['sector_codigo'],
                    'sector_nombre'     => $row['sector_nombre']
				);
                $result[]   = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            $detalle        = array(
                'sector_codigo'         => "",
                'sector_nombre'         => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1200/ot/filtro/potrero/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00  = $request->getAttribute('codigo');
		$sql    = "SELECT
        h.ESTPOT_COD        AS      potrero_codigo,
        h.ESTPOT_NOM        AS      potrero_nombre
		
		FROM ODTAUD a
        INNER JOIN ESTPOT h ON a.ODTAUD_POC = h.ESTPOT_COD
		
		WHERE a.ODTAUD_ORC = '$val00'
        GROUP BY h.ESTPOT_COD, h.ESTPOT_NOM
		ORDER BY h.ESTPOT_COD, h.ESTPOT_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle    = array(
                    'potrero_codigo'        => $row['potrero_codigo'],
                    'potrero_nombre'        => $row['potrero_nombre']
				);
                $result[]   = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            $detalle    = array(
                'potrero_codigo'            => "",
                'potrero_nombre'            => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1200/ot/filtro/categoria/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00      = $request->getAttribute('codigo');
		$sql        = "SELECT
            d.DOMFIC_COD		AS		categoria_codigo,
            d.DOMFIC_NOM		AS		categoria_nombre
            
            FROM ODTAUD a
            INNER JOIN DOMTYS c ON a.ODTAUD_CSC = c.DOMTYS_COD
            INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
            
            WHERE a.ODTAUD_ORC = '$val00'
            GROUP BY d.DOMFIC_COD, d.DOMFIC_NOM
            ORDER BY d.DOMFIC_COD, d.DOMFIC_NOM";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle    = array(
                    'categoria_codigo'      => $row['categoria_codigo'],
                    'categoria_nombre'      => $row['categoria_nombre']
				);
                $result[]   = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json           = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            $detalle    = array(
                'categoria_codigo'          => "",
                'categoria_nombre'          => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1200/ot/resumen/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        b.DOMFIC_COD		AS		origen_codigo,
        b.DOMFIC_NOM		AS		origen_nombre,
        c.DOMFIC_COD		AS		raza_codigo,
        c.DOMFIC_NOM		AS		raza_nombre,
        e.DOMFIC_COD		AS		categoria_codigo,
        e.DOMFIC_NOM		AS		categoria_nombre,
        f.DOMFIC_COD		AS		subcategoria_codigo,
        f.DOMFIC_NOM		AS		subcategoria_nombre,
        SUM(a.ODTAUD_CAN)   AS      ot_auditada_cantidad,
        AVG(a.ODTAUD_PES)   AS      ot_auditada_peso

        FROM ODTAUD a
        INNER JOIN DOMFIC b ON a.ODTAUD_TOC = b.DOMFIC_COD
        INNER JOIN DOMFIC c ON a.ODTAUD_TRC = c.DOMFIC_COD
		INNER JOIN DOMTYS d ON a.ODTAUD_CSC = d.DOMTYS_COD
        INNER JOIN DOMFIC e ON d.DOMTYS_TIC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON d.DOMTYS_SUC = f.DOMFIC_COD

        WHERE a.ODTAUD_ORC = '$val00'

        GROUP BY b.DOMFIC_COD, c.DOMFIC_COD, e.DOMFIC_COD, f.DOMFIC_COD
        ORDER BY b.DOMFIC_COD, c.DOMFIC_COD, e.DOMFIC_COD, f.DOMFIC_COD";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
                    'origen_codigo'	                                        => $row['origen_codigo'],
					'origen_nombre'	                                        => $row['origen_nombre'],
                    'raza_codigo'	                                        => $row['raza_codigo'],
                    'raza_nombre'	                                        => $row['raza_nombre'],
                    'categoria_codigo'	                                    => $row['categoria_codigo'],
					'categoria_nombre'	                                    => $row['categoria_nombre'],
					'subcategoria_codigo'	                                => $row['subcategoria_codigo'],
                    'subcategoria_nombre'	                                => $row['subcategoria_nombre'],
                    'ot_auditada_cantidad'	                                => $row['ot_auditada_cantidad'],
                    'ot_auditada_peso'	                                    => $row['ot_auditada_peso']
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
            $detalle    = array(
                'origen_codigo'	                                        => "",
                'origen_nombre'	                                        => "",
                'raza_codigo'	                                        => "",
                'raza_nombre'	                                        => "",
                'categoria_codigo'	                                    => "",
                'categoria_nombre'	                                    => "",
                'subcategoria_codigo'	                                => "",
                'subcategoria_nombre'	                                => "",
                'ot_auditada_cantidad'	                                => "",
                'ot_auditada_peso'	                                    => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1200/ot/resumen/dia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        a.ODTAUD_FEC		AS		ot_auditada_fecha,
        SUM(a.ODTAUD_CAN)   AS      ot_auditada_cantidad,
        AVG(a.ODTAUD_PES)   AS      ot_auditada_peso

        FROM ODTAUD a

        WHERE a.ODTAUD_ORC = '$val00'

        GROUP BY a.ODTAUD_FEC
        ORDER BY a.ODTAUD_FEC";
		
        if ($query = $mysqli->query($sql)) {
            $item = 0;
            while($row = $query->fetch_assoc()) {
                $item   = $item + 1;
                $dia    = substr($row['ot_auditada_fecha'], 8);
                $mes    = substr($row['ot_auditada_fecha'], 5, -3);
                $ano    = substr($row['ot_auditada_fecha'], 0, -6);
                $fecha  = $dia.'/'.$mes.'/'.$ano;
                $fecha2 = $dia.'/'.$mes;

                $detalle			= array(
                    'ot_auditada_titulo'	                                => 'Dia '.$item.' '.$fecha,
                    'ot_auditada_titulo_2'	                                => 'Dia '.$item.' '.$fecha2,
                    'ot_auditada_fecha'	                                    => $row['ot_auditada_fecha'],
                    'ot_auditada_cantidad'	                                => $row['ot_auditada_cantidad'],
                    'ot_auditada_peso'	                                    => $row['ot_auditada_peso']
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
            $detalle    = array(
                'ot_auditada_fecha'	                                    => "",
                'ot_auditada_cantidad'	                                => "",
                'ot_auditada_peso'	                                    => ""
            );	
            $result[]   = $detalle;
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1200', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01                      = $request->getParsedBody()['propietario_codigo'];
        $val02                      = $request->getParsedBody()['origen_codigo'];
        $val03                      = $request->getParsedBody()['raza_codigo'];
        $val04                      = $request->getParsedBody()['categoria_subcategoria_codigo'];
        $val05                      = $request->getParsedBody()['potrero_codigo'];  
        $val06                      = $request->getParsedBody()['ot_codigo'];
        $val07                      = $request->getParsedBody()['ot_fecha'];
        $val08                      = $request->getParsedBody()['ot_cantidad'];
        $val09                      = $request->getParsedBody()['ot_peso'];
        $val10                      = $request->getParsedBody()['ot_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08)) {
            $sql                    = "INSERT INTO ODTAUD (ODTAUD_PRC, ODTAUD_TOC, ODTAUD_TRC, ODTAUD_CSC, ODTAUD_POC, ODTAUD_ORC, ODTAUD_FEC, ODTAUD_CAN, ODTAUD_PES, ODTAUD_OBS) VALUES ('$val01', '$val02', '$val03', '$val04', '$val05', '$val06', '".$val07."', '$val08', '".$val09."', '".$val10."')";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se inserto con exito', 'codigo' => $mysqli->insert_id), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'No se pudo insertar el resgistro, ya existe!', 'codigo' => $mysqli->error), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.', 'codigo' => $mysqli->error), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });

	$app->put('/api/v1/1200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        $val01                      = $request->getParsedBody()['propietario_codigo'];
        $val02                      = $request->getParsedBody()['origen_codigo'];
        $val03                      = $request->getParsedBody()['raza_codigo'];
        $val04                      = $request->getParsedBody()['categoria_subcategoria_codigo'];
        $val05                      = $request->getParsedBody()['potrero_codigo'];  
        $val06                      = $request->getParsedBody()['ot_codigo'];
        $val07                      = $request->getParsedBody()['ot_fecha'];
        $val08                      = $request->getParsedBody()['ot_cantidad'];
        $val09                      = $request->getParsedBody()['ot_peso'];
        $val10                      = $request->getParsedBody()['ot_observacion'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08)) {
            $sql                    = "UPDATE ODTAUD SET ODTAUD_PRC = '$val01', ODTAUD_TOC = '$val02', ODTAUD_TRC = '$val03', ODTAUD_CSC = '$val04', ODTAUD_POC = '$val05', ODTAUD_ORC = '$val06', ODTAUD_FEC = '".$val07."', ODTAUD_CAN = '$val08', ODTAUD_PES = '".$val09."', ODTAUD_OBS = '".$val10."' WHERE ODTAUD_COD = '$val00'";
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

	$app->delete('/api/v1/1200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM ODTAUD WHERE ODTAUD_COD = '$val00'";
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