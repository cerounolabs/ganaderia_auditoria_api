<?php
    $app->get('/api/v1/1100', function($request) {
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
        a.ODTEXI_COD		AS		ot_existencia_codigo, 
		a.ODTEXI_FEC		AS		ot_existencia_fecha, 
		a.ODTEXI_CAN		AS		ot_existencia_cantidad,
        a.ODTEXI_PES		AS		ot_existencia_peso,
        a.ODTEXI_OBS		AS		ot_existencia_observacion
		
		FROM ODTEXI a
		INNER JOIN ODTFIC b ON a.ODTEXI_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTEXI_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTEXI_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTEXI_TRC = g.DOMFIC_COD
        INNER JOIN ESTPOT h ON a.ODTEXI_POC = h.ESTPOT_COD
        INNER JOIN ESTSEC i ON h.ESTPOT_SEC = i.ESTSEC_COD
        INNER JOIN ESTPRO j ON a.ODTEXI_PRC = j.ESTPRO_COD
        INNER JOIN PERFIC k ON j.ESTPRO_PRC = k.PERFIC_COD
		
		ORDER BY a.ODTEXI_FEC";
		
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

                $dia3    = substr($row['ot_existencia_fecha'], 8);
                $mes3    = substr($row['ot_existencia_fecha'], 5, -3);
                $ano3    = substr($row['ot_existencia_fecha'], 0, -6);
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
                    'ot_existencia_codigo'	                                => $row['ot_existencia_codigo'],
                    'ot_existencia_fecha'	                                => $row['ot_existencia_fecha'],
                    'ot_existencia_fecha_2'	                                => $fecha3,
                    'ot_existencia_cantidad'	                            => $row['ot_existencia_cantidad'],
                    'ot_existencia_peso'	                                => $row['ot_existencia_peso'],
                    'ot_existencia_observacion'	                            => $row['ot_existencia_observacion']
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
                'ot_existencia_codigo'	                                => "",
                'ot_existencia_fecha'	                                => "",
                'ot_existencia_fecha_2'	                                => "",
                'ot_existencia_cantidad'	                            => "",
                'ot_existencia_peso'	                                => "",
                'ot_existencia_observacion'	                            => ""
            );
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1100/{codigo}', function($request) {
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
        a.ODTEXI_COD		AS		ot_existencia_codigo, 
		a.ODTEXI_FEC		AS		ot_existencia_fecha, 
		a.ODTEXI_CAN		AS		ot_existencia_cantidad,
        a.ODTEXI_PES		AS		ot_existencia_peso,
        a.ODTEXI_OBS		AS		ot_existencia_observacion
		
		FROM ODTEXI a
		INNER JOIN ODTFIC b ON a.ODTEXI_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTEXI_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTEXI_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTEXI_TRC = g.DOMFIC_COD
        INNER JOIN ESTPOT h ON a.ODTEXI_POC = h.ESTPOT_COD
        INNER JOIN ESTSEC i ON h.ESTPOT_SEC = i.ESTSEC_COD
        INNER JOIN ESTPRO j ON a.ODTEXI_PRC = j.ESTPRO_COD
        INNER JOIN PERFIC k ON j.ESTPRO_PRC = k.PERFIC_COD
		
		WHERE a.ODTEXI_COD = '$val00'
		ORDER BY a.ODTEXI_COD";
		
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

                $dia3    = substr($row['ot_existencia_fecha'], 8);
                $mes3    = substr($row['ot_existencia_fecha'], 5, -3);
                $ano3    = substr($row['ot_existencia_fecha'], 0, -6);
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
                    'ot_existencia_codigo'	                                => $row['ot_existencia_codigo'],
                    'ot_existencia_fecha'	                                => $row['ot_existencia_fecha'],
                    'ot_existencia_fecha_2'	                                => $fecha3,
                    'ot_existencia_cantidad'	                            => $row['ot_existencia_cantidad'],
                    'ot_existencia_peso'	                                => $row['ot_existencia_peso'],
                    'ot_existencia_observacion'	                            => $row['ot_existencia_observacion']
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
                'ot_existencia_codigo'	                                => "",
                'ot_existencia_fecha'	                                => "",
                'ot_existencia_fecha_2'	                                => "",
                'ot_existencia_cantidad'	                            => "",
                'ot_existencia_peso'	                                => "",
                'ot_existencia_observacion'	                            => ""
            );
            header("Content-Type: application/json; charset=utf-8");
            $json       = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/1100/ot/detalle/{codigo}', function($request) {
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
        a.ODTEXI_COD		AS		ot_existencia_codigo, 
		a.ODTEXI_FEC		AS		ot_existencia_fecha, 
		a.ODTEXI_CAN		AS		ot_existencia_cantidad,
        a.ODTEXI_PES		AS		ot_existencia_peso,
        a.ODTEXI_OBS		AS		ot_existencia_observacion
		
		FROM ODTEXI a
		INNER JOIN ODTFIC b ON a.ODTEXI_ORC = b.ODTFIC_COD
		INNER JOIN DOMTYS c ON a.ODTEXI_CSC = c.DOMTYS_COD
        INNER JOIN DOMFIC d ON c.DOMTYS_TIC = d.DOMFIC_COD
        INNER JOIN DOMFIC e ON c.DOMTYS_SUC = e.DOMFIC_COD
        INNER JOIN DOMFIC f ON a.ODTEXI_TOC = f.DOMFIC_COD
        INNER JOIN DOMFIC g ON a.ODTEXI_TRC = g.DOMFIC_COD
        INNER JOIN ESTPOT h ON a.ODTEXI_POC = h.ESTPOT_COD
        INNER JOIN ESTSEC i ON h.ESTPOT_SEC = i.ESTSEC_COD
        INNER JOIN ESTPRO j ON a.ODTEXI_PRC = j.ESTPRO_COD
        INNER JOIN PERFIC k ON j.ESTPRO_PRC = k.PERFIC_COD
		
		WHERE a.ODTEXI_ORC = '$val00'
		ORDER BY a.ODTEXI_FEC";
		
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

                $dia3    = substr($row['ot_existencia_fecha'], 8);
                $mes3    = substr($row['ot_existencia_fecha'], 5, -3);
                $ano3    = substr($row['ot_existencia_fecha'], 0, -6);
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
                    'ot_existencia_codigo'	                                => $row['ot_existencia_codigo'],
                    'ot_existencia_fecha'	                                => $row['ot_existencia_fecha'],
                    'ot_existencia_fecha_2'	                                => $fecha3,
                    'ot_existencia_cantidad'	                            => $row['ot_existencia_cantidad'],
                    'ot_existencia_peso'	                                => $row['ot_existencia_peso'],
                    'ot_existencia_observacion'	                            => $row['ot_existencia_observacion']
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
                'ot_existencia_codigo'	                                => "",
                'ot_existencia_fecha'	                                => "",
                'ot_existencia_fecha_2'	                                => "",
                'ot_existencia_cantidad'	                            => "",
                'ot_existencia_peso'	                                => "",
                'ot_existencia_observacion'	                            => ""
            );
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/1100', function($request) {
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
            $sql                    = "INSERT INTO ODTEXI (ODTEXI_PRC, ODTEXI_TOC, ODTEXI_TRC, ODTEXI_CSC, ODTEXI_POC, ODTEXI_ORC, ODTEXI_FEC, ODTEXI_CAN, ODTEXI_PES, ODTEXI_OBS) VALUES ('$val01', '$val02', '$val03', '$val04', '$val05', '$val06', '".$val07."', '$val08', '".$val09."', '".$val10."')";
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

	$app->put('/api/v1/1100/{codigo}', function($request) {
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
            $sql                    = "UPDATE ODTEXI SET ODTEXI_PRC = '$val01', ODTEXI_TOC = '$val02', ODTEXI_TRC = '$val03', ODTEXI_CSC = '$val04', ODTEXI_POC = '$val05', ODTEXI_ORC = '$val06', ODTEXI_FEC = '".$val07."', ODTEXI_CAN = '$val08', ODTEXI_PES = '".$val09."', ODTEXI_OBS = '".$val10."' WHERE ODTEXI_COD = '$val00'";
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

	$app->delete('/api/v1/1100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM ODTEXI WHERE ODTEXI_COD = '$val00'";
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