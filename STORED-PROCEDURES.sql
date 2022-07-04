BEGIN
	SET @CONDIC_T = "";
    SET @CONDIC_1 = "";
    SET @CONDIC_2 = "";
    SET @GROUP_BY = " ta.nombre_tipo_actividad ";
    SET @WHERE_C = false;
    
    IF MES != "" THEN
    	SET @CONDIC_1 = CONCAT(" MONTH(ac.fecdisp_actividad)='",MES,"' ");        
        IF @WHERE_C = false THEN 
        	SET @CONDIC_1 = CONCAT(" WHERE",@CONDIC_1);
            SET @WHERE_C = true;
        END IF;       
    END IF;

    IF USUARIO != "" THEN
        SET @CONDIC_2 = CONCAT(" ac.fk_usuario='",USUARIO,"' ");
        IF @WHERE_C = false THEN 
            SET @CONDIC_2 = CONCAT(" WHERE",@CONDIC_2);
            SET @WHERE_C = true;
        ELSE
            SET @CONDIC_2 = CONCAT(" AND",@CONDIC_2);
        END IF; 
    END IF;
    
    SET @CONDIC_T = CONCAT(" ",@CONDIC_1,@CONDIC_2," ");
    
    SET @query = CONCAT("SELECT ac.nombre_actividad AS NOM_ACT, COUNT(ac.pk_actividad) AS CANTIDAD, ta.nombre_tipo_actividad AS TIPO_ACT, ac.fecdisp_actividad AS FECDIS_ACT FROM u726886248_bd_academico.actividad ac JOIN u726886248_bd_academico.tipo_actividad ta ON ac.fk_tipo_actividad = ta.pk_tipo_actividad",@CONDIC_T,"GROUP BY",@GROUP_BY,"ORDER BY ta.nombre_tipo_actividad");
    PREPARE stmt1 FROM @query; 
    EXECUTE stmt1; 
    DEALLOCATE PREPARE stmt1;
END







BEGIN
    SET @CONDIC_T = "";
    SET @CONDIC_1 = "";
    SET @CONDIC_2 = "";
    SET @GROUP_BY = " ESTADO_ACT ";
    SET @WHERE_C = false;
    
    IF MES != "" THEN
        SET @CONDIC_1 = CONCAT(" MONTH(ac.fecdisp_actividad)='",MES,"' ");        
        IF @WHERE_C = false THEN 
            SET @CONDIC_1 = CONCAT(" WHERE",@CONDIC_1);
            SET @WHERE_C = true;
        END IF;       
    END IF;

    IF USUARIO != "" THEN
        SET @CONDIC_2 = CONCAT(" ac.fk_usuario='",USUARIO,"' ");
        IF @WHERE_C = false THEN 
            SET @CONDIC_2 = CONCAT(" WHERE",@CONDIC_2);
            SET @WHERE_C = true;
        ELSE
            SET @CONDIC_2 = CONCAT(" AND",@CONDIC_2);
        END IF; 
    END IF;
    
    SET @CONDIC_T = CONCAT(" ",@CONDIC_1,@CONDIC_2," ");
    
    SET @query = CONCAT("SELECT (CASE WHEN IFNULL(ua.estado_usuario_actividad, 0) = 0 THEN 'PENDIENTE' WHEN IFNULL(ua.estado_usuario_actividad, 0) = 1 THEN 'EN PROCESO' ELSE 'COMPLETADO' END) AS ESTADO_ACT, COUNT(IFNULL(ua.estado_usuario_actividad, 0)) AS CANTIDAD FROM u726886248_bd_academico.actividad ac LEFT JOIN u726886248_bd_academico.usuario_actividad ua ON ac.pk_actividad = ua.fk_actividad",@CONDIC_T,"GROUP BY",@GROUP_BY,"ORDER BY ESTADO_ACT ASC");
    PREPARE stmt1 FROM @query; 
    EXECUTE stmt1; 
    DEALLOCATE PREPARE stmt1;
END