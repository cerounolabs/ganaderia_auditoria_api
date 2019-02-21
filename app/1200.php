<?php
    $app->get('/api/v1/1200', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
        j.PERFIC_COD		AS		persona_codigo,
        j.PERFIC_NOM		AS		persona_nombre,
		j.PERFIC_APE		AS		persona_apellido,
        j.PERFIC_RAZ		AS		persona_razon_social,
        j.PERFIC_DOC		AS		persona_documento,
        j.PERFIC_FNA		AS		persona_fecha_nacimiento,
        j.PERFIC_TEL		AS		persona_telefono,
        j.PERFIC_COR		AS		persona_correo_electronico,
        i.ESTPRO_MAR        AS      establecimiento_propietario_codigo,
        i.ESTPRO_MAR        AS      establecimiento_propietario_marca,
        h.ESTPOR_COD        AS      potrero_codigo,
        h.ESTPOR_NOM        AS      potrero_nombre,
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
        INNER JOIN ESTPOR h ON a.ODTAUD_POC = h.ESTPOR_COD
        INNER JOIN ESTPRO i ON a.ODTAUD_PRC = i.ESTPRO_COD
        INNER JOIN PERFIC j ON i.ESTPRO_PRC = j.PERFIC_COD
		
		ORDER BY a.ODTAUD_FEC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }

                $detalle			= array(
                    'propietario_codigo'	                                => $row['establecimiento_propietario_codigo'],
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
                    'potrero_codigo'	                                    => $row['potrero_codigo'],
                    'potrero_nombre'	                                    => $row['potrero_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_inicio_trabajo']),
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_final_trabajo']),
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_auditada_codigo'	                                => $row['ot_auditada_codigo'],
                    'ot_auditada_fecha'	                                    => $row['ot_auditada_fecha'],
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

    $app->get('/api/v1/1200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
        j.PERFIC_COD		AS		persona_codigo,
        j.PERFIC_NOM		AS		persona_nombre,
		j.PERFIC_APE		AS		persona_apellido,
        j.PERFIC_RAZ		AS		persona_razon_social,
        j.PERFIC_DOC		AS		persona_documento,
        j.PERFIC_FNA		AS		persona_fecha_nacimiento,
        j.PERFIC_TEL		AS		persona_telefono,
        j.PERFIC_COR		AS		persona_correo_electronico,
        i.ESTPRO_MAR        AS      establecimiento_propietario_codigo,
        i.ESTPRO_MAR        AS      establecimiento_propietario_marca,
        h.ESTPOR_COD        AS      potrero_codigo,
        h.ESTPOR_NOM        AS      potrero_nombre,
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
        INNER JOIN ESTPOR h ON a.ODTAUD_POC = h.ESTPOR_COD
        INNER JOIN ESTPRO i ON a.ODTAUD_PRC = i.ESTPRO_COD
        INNER JOIN PERFIC j ON i.ESTPRO_PRC = j.PERFIC_COD
		
		WHERE a.ODTAUD_COD = '$val00'
		ORDER BY a.ODTAUD_FEC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }
                
                $detalle			= array(
                    'propietario_codigo'	                                => $row['establecimiento_propietario_codigo'],
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
                    'potrero_codigo'	                                    => $row['potrero_codigo'],
                    'potrero_nombre'	                                    => $row['potrero_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_inicio_trabajo']),
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_final_trabajo']),
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_auditada_codigo'	                                => $row['ot_auditada_codigo'],
                    'ot_auditada_fecha'	                                    => $row['ot_auditada_fecha'],
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
        j.PERFIC_COD		AS		persona_codigo,
        j.PERFIC_NOM		AS		persona_nombre,
		j.PERFIC_APE		AS		persona_apellido,
        j.PERFIC_RAZ		AS		persona_razon_social,
        j.PERFIC_DOC		AS		persona_documento,
        j.PERFIC_FNA		AS		persona_fecha_nacimiento,
        j.PERFIC_TEL		AS		persona_telefono,
        j.PERFIC_COR		AS		persona_correo_electronico,
        i.ESTPRO_MAR        AS      establecimiento_propietario_codigo,
        i.ESTPRO_MAR        AS      establecimiento_propietario_marca,
        h.ESTPOR_COD        AS      potrero_codigo,
        h.ESTPOR_NOM        AS      potrero_nombre,
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
        INNER JOIN ESTPOR h ON a.ODTAUD_POC = h.ESTPOR_COD
        INNER JOIN ESTPRO i ON a.ODTAUD_PRC = i.ESTPRO_COD
        INNER JOIN PERFIC j ON i.ESTPRO_PRC = j.PERFIC_COD
		
		WHERE a.ODTAUD_ORC = '$val00'
		ORDER BY a.ODTAUD_FEC";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                if ($row['persona_nombre'] === NULL && $row['persona_apellido'] === NULL) {
                    $nombreCompleto = $row['persona_razon_social'];
                } else {
                    $nombreCompleto = $row['persona_apellido'].', '.$row['persona_nombre'];
                }
                
                $detalle			= array(
                    'propietario_codigo'	                                => $row['establecimiento_propietario_codigo'],
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
                    'potrero_codigo'	                                    => $row['potrero_codigo'],
                    'potrero_nombre'	                                    => $row['potrero_nombre'],
					'ot_codigo'		                                        => $row['ot_codigo'],
					'ot_numero'		                                        => $row['ot_numero'],
                    'ot_fecha_inicio_trabajo'	                            => $row['ot_fecha_inicio_trabajo'],
                    'ot_fecha_inicio_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_inicio_trabajo']),
                    'ot_fecha_final_trabajo'	                            => $row['ot_fecha_final_trabajo'],
                    'ot_fecha_final_trabajo_2'	                            => str_replace("-", "/", $row['ot_fecha_final_trabajo']),
                    'ot_observacion'	                                    => $row['ot_observacion'],
                    'ot_auditada_codigo'	                                => $row['ot_auditada_codigo'],
                    'ot_auditada_fecha'	                                    => $row['ot_auditada_fecha'],
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
                $dia    = substr($row['fecEvento'], 8);
                $mes    = substr($row['fecEvento'], 5, -3);
                $ano    = substr($row['fecEvento'], 0, -6);
                $fecha  = $dia.'/'.$mes.'/'.$ano;

                $detalle			= array(
                    'ot_auditada_titulo'	                                => 'Dia '.$item.' '.$fecha,
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

        $val01                      = $request->getParsedBody()['origen_codigo'];
        $val02                      = $request->getParsedBody()['raza_codigo'];
        $val03                      = $request->getParsedBody()['categoria_subcategoria_codigo'];
        $val04                      = $request->getParsedBody()['potrero_codigo'];  
        $val05                      = $request->getParsedBody()['ot_codigo'];
        $val06                      = $request->getParsedBody()['ot_auditada_fecha'];
        $val07                      = $request->getParsedBody()['ot_auditada_cantidad'];
        $val08                      = $request->getParsedBody()['ot_auditada_peso'];
        $val09                      = $request->getParsedBody()['ot_auditada_observacion'];
        $val10                      = $request->getParsedBody()['propietario_codigo'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val05) && isset($val06) && isset($val07) && isset($val10)) {
            $sql                    = "INSERT INTO ODTAUD (ODTAUD_PRC, ODTAUD_TOC, ODTAUD_TRC, ODTAUD_CSC, ODTAUD_POC, ODTAUD_ORC, ODTAUD_FEC, ODTAUD_CAN, ODTAUD_PES, ODTAUD_OBS) 
                                                   VALUES ('$val10', '$val01', '$val02', '$val03', '$val04', '$val05', '".$val06."', '$val07', '".$val08."', '".$val09."')";
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
		$val01                      = $request->getParsedBody()['origen_codigo'];
        $val02                      = $request->getParsedBody()['raza_codigo'];
        $val03                      = $request->getParsedBody()['categoria_subcategoria_codigo'];
        $val04                      = $request->getParsedBody()['potrero_codigo'];  
        $val05                      = $request->getParsedBody()['ot_codigo'];
        $val06                      = $request->getParsedBody()['ot_auditada_fecha'];
        $val07                      = $request->getParsedBody()['ot_auditada_cantidad'];
        $val08                      = $request->getParsedBody()['ot_auditada_peso'];
        $val09                      = $request->getParsedBody()['ot_auditada_observacion'];
        $val10                      = $request->getParsedBody()['propietario_codigo'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val05) && isset($val06) && isset($val07) && isset($val10)) {
            $sql                    = "UPDATE ODTAUD SET ODTAUD_PRC = '$val10', ODTAUD_TOC = '$val01', ODTAUD_TRC = '$val02', ODTAUD_CSC = '$val03', ODTAUD_POC = '$val04', ODTAUD_ORC = '$val05', ODTAUD_FEC = '".$val06."', ODTAUD_CAN = '$val07', ODTAUD_PES = '".$val08."', ODTAUD_OBS = '".$val09."' WHERE ODTAUD_COD = '$val00'";
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