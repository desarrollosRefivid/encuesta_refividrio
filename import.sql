-- SQL SERVER
--Empresa  

  SELECT CONCAT('INSERT INTO refividrio.empresa(
  	 fecha_creado, empresa_nombre, empresa_rfc, empresa_observaciones, empresa_activo)
  	VALUES (NOW(),''',RTRIM(LTRIM(razonSocial))   ,''',''',RTRIM(LTRIM(rfcEmpresa)),''',''',  RTRIM(LTRIM(razonSocial)) ,''',true);')
  	, * FROM Empresa  WHERE esActivo = 1
 

-- Segmento 

SELECT ('INSERT INTO refividrio.segmento(
	 id_empresa, fecha_creado, nombre, activo, fecha_actualizado)
	VALUES ((	SELECT id_empresa FROM refividrio.empresa WHERE empresa_rfc = ''' + RTRIM(LTRIM(rfcEmpresa)) +  '''), NOW(),''' +
	RTRIM(LTRIM(s.nombreSucursal))    + ''',true,NOW());')
	,
* FROM Sucursal s
INNER JOIN Empresa e ON e.idEmpresa = s.idEmpresa 
 WHERE s.esActivo = 1
 AND e.esActivo = 1
 
 
-- Empleado 

	SELECT   
   'INSERT INTO refividrio.empleado(
  fecha_creado, activo ,fecha_actualizado, nombre, paterno, materno, 
	celular, correo, genero,  usuario,password,id_segmento ,fecha_nacimiento) VALUES (NOW(), true, NOW(), 
	   ''' + COALESCE(e.nombreEmpleado,'')  +''', ''' + COALESCE(e.apPatEmpleado,'') +''', ''' +  COALESCE(e.apMatEmpleado,'')  +''', ''' + COALESCE(e.telcasa,'') +''', ''' + 
	  COALESCE( e.correoPersonal,'') +''', ''' + COALESCE(IIF(e.genero = 'MASCULINO','H','M') ,'O')  + ''', ''' +
	 
	COALESCE(( CASE WHEN CHARINDEX(' ',RTRIM(LTRIM(nombreEmpleado) )) > 0 THEN  
	   LOWER(CONCAT( SUBSTRING(RTRIM(LTRIM(nombreEmpleado)), 0, CHARINDEX(' ',RTRIM(LTRIM(nombreEmpleado) )) ) ,'.',apPatEmpleado))
	ELSE 
	   LOWER(CONCAT(REPLACE(RTRIM(LTRIM(nombreEmpleado)),' ','.'),'.',apPatEmpleado))
	END),'')
	+  
	''',MD5(''' + 'refividrio'  +'''), ' + '(SELECT id_segmento FROM segmento WHERE nombre  = ''' + RTRIM(LTRIM( COALESCE( s.nombreSucursal,''))) + ''' AND id_empresa = (SELECT id_empresa FROM empresa WHERE empresa_rfc = ''' +  COALESCE(RTRIM(LTRIM(rfcEmpresa)),'') +  ''' )),''' + COALESCE(RTRIM(LTRIM(fechaNacimiento)),'') +  ''');' 
	 
	FROM Empleado e
	INNER JOIN Sucursal s ON s.idSucursal = e.idSucursal  
	INNER JOIN Empresa empresa ON empresa.idEmpresa = e.idEmpresa  
	WHERE e.esActivo = 1
	AND empresa.esActivo = 1
	AND s.esActivo = 1
	 
-- SQL SERVER


-- PostgreSQL
INSERT INTO refividrio.empleado_rol(  id_rol, id_empleado) 
SELECT 2,id_empleado FROM empleado;


INSERT INTO refividrio.empleado_rol(  id_rol, id_empleado) 
SELECT 1,id_empleado FROM empleado WHERE usuario in ('victor.rivera','marcos.moreno') ;

-- Encuesta 


INSERT INTO refividrio.encuesta(
	id_encuesta, id_creadopor, fecha_creado, nombre, observaciones, activo, validodesde, id_actualizado, fecha_actualizado, validohasta)
	VALUES (1, NULL, NOW(), 'INSTRUMENTO PARA IDENTIFICAR SÍNTOMAS (COVID-19)', 'INSTRUMENTO PARA IDENTIFICAR SÍNTOMAS Y CONTACTOS EN EL TRABAJO, FAMILIARES Y COMUNITARIOS (COVID-19)', true, NOW(), NULL, NOW(), '2020-08-28');
  
INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (1, 1, 8, '2020-08-18 10:53:49.772726-05', '1. ¿Perteneces a alguno de los siguientes grupos vulnerables?', true, 5, 8, '2020-08-18 11:01:35.283037-05', 1, true);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (2, 1, 8, '2020-08-18 10:42:40.741747-05', '2. ¿Has presentado al menos dos de los síntomas siguientes en las últimas dos semanas? En caso de responder Si, marca cuales. ', true, 5, 8, '2020-08-18 10:42:40.741747-05', 2, true);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (3, 1, 8, '2020-08-18 10:43:57.770395-05', '3. Aparte de los síntomas anteriores, ¿has presentado al menos uno de los síntomas siguientes en las últimas dos semanas? En caso de responder Si, marca cuales.', true, 5, 8, '2020-08-18 10:43:57.770395-05', 3, true);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (4, 1, 8, '2020-08-18 11:00:54.08376-05', '4. Fecha de inicio de síntomas: (calendario)', true, 6, 8, '2020-08-18 11:00:54.08376-05', 4, true);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (5, 1, 8, '2020-08-18 10:48:25.118307-05', '5. ¿Has tenido contacto con alguna persona que padece, padeció o falleció por COVID-19?', true, 5, 8, '2020-08-18 10:48:25.118307-05', 5, true);
 
INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (6, 1, 8, '2020-08-18 10:50:02.024304-05', '6. En caso de responder Si a sospechoso o confirmado, ¿hace cuánto tiempo fue que tuviste el último contacto?', true, 5, 8, '2020-08-18 11:03:07.972756-05', 6, false);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (7, 1, 8, '2020-08-18 11:03:47.73259-05', '7. ¿Qué medio utilizas para trasladarte de tu casa al trabajo y viceversa?', true, 5, 8, '2020-08-18 11:05:07.155088-05', 7, true);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (8, 1, 8, '2020-08-18 11:30:18.65423-05', '8. ¿Qué medidas toman en casa para prevenir la entrada del virus causante de COVID-19?', true, 5, 8, '2020-08-18 11:30:18.65423-05', 8, true);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (9, 1, 8, '2020-08-18 11:31:28.985428-05', '9. ¿Has visitado a familiares en las últimas dos semanas? ', true, 4, 8, '2020-08-18 11:31:28.985428-05', 9, true);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (10, 1, 8, '2020-08-18 11:32:14.803847-05', '10. En caso de responder Si, ¿En qué estado de la república radican?
(Lista desplegable de estados)', true, 1, 8, '2020-08-18 11:33:04.947387-05', 10, false);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (11, 1, 8, '2020-08-18 11:36:56.968918-05', '11. En caso de responder Si a la pregunta 8, ¿Qué medio utilizaste para visitarlos?', true, 5, 8, '2020-08-18 11:36:56.968918-05', 11, false);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (12, 1, 8, '2020-08-18 11:38:00.848599-05', '12. ¿Has acudido a lugares concurridos (además de tu trabajo) en las últimas dos semanas?', true, 4, 8, '2020-08-18 11:38:00.848599-05', 12, true);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (13, 1, 8, '2020-08-18 11:38:29.926798-05', '13. En caso de responder Si por favor menciona a que lugares has acudido', true, 3, 8, '2020-08-18 11:38:29.926798-05', 13, false);

INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (14, 1, 8, '2020-08-18 11:38:56.003071-05', '14. En caso de responder Si a la pregunta 11, ¿Qué medios ocupas para trasladarte a estos lugares?', true, 5, 8, '2020-08-18 11:39:41.436297-05', 14, false);


INSERT INTO refividrio.pregunta (id_pregunta, id_encuesta, id_creado, fecha_creado, nombre_pregunta, activo, id_tipo, id_actualizadopor, fecha_actualizado, numero_pregunta, obligatoria) 
VALUES (15, 1, 8, '2020-08-18 11:40:00.247934-05', '15. ¿Cuáles son las medidas que tomas para prevenir un posible contagio cuando estás fuera de
casa?', true, 5, 8, '2020-08-18 11:40:00.247934-05', 15, true);

 

INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 2, NULL, '2020-08-18 10:43:22.791434-05', 'Tos seca (puede ser leve)', true, NULL, '2020-08-18 10:43:22.791434-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 2, NULL, '2020-08-18 10:43:22.893502-05', 'Fiebre', true, NULL, '2020-08-18 10:43:22.893502-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 2, NULL, '2020-08-18 10:43:22.993751-05', 'Dolor de cabeza', true, NULL, '2020-08-18 10:43:22.993751-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 3, NULL, '2020-08-18 10:45:23.83006-05', 'Fatiga', true, NULL, '2020-08-18 10:45:23.83006-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 3, NULL, '2020-08-18 10:45:23.926545-05', 'Dolor en articulaciones', true, NULL, '2020-08-18 10:45:23.926545-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 3, NULL, '2020-08-18 10:45:24.017418-05', 'Dolor muscular', true, NULL, '2020-08-18 10:45:24.017418-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 3, NULL, '2020-08-18 10:45:24.11348-05', 'Dolor o ardor en la garganta ', true, NULL, '2020-08-18 10:45:24.11348-05', 4);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 3, NULL, '2020-08-18 10:45:24.208184-05', 'Dolor en el tórax o pecho', true, NULL, '2020-08-18 10:45:24.208184-05', 5);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 3, NULL, '2020-08-18 10:45:24.31615-05', 'Conjuntivitis', true, NULL, '2020-08-18 10:45:24.31615-05', 6);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 3, NULL, '2020-08-18 10:45:24.418157-05', 'Escurrimiento nasal', true, NULL, '2020-08-18 10:45:24.418157-05', 7);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 3, NULL, '2020-08-18 10:45:24.785084-05', 'Falta de aire', true, NULL, '2020-08-18 10:45:24.785084-05', 8);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 1, NULL, '2020-08-18 10:42:20.157815-05', 'Mayor de 60 años', true, NULL, '2020-08-18 10:42:20.157815-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 1, NULL, '2020-08-18 10:42:20.250369-05', 'Embarazada', true, NULL, '2020-08-18 10:42:20.250369-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 1, NULL, '2020-08-18 10:42:20.345086-05', 'Enfermedad crónica (diabetes, hipertensión, cáncer, enfermedad pulmonar, renal o del hígado).', true, NULL, '2020-08-18 10:42:20.345086-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 1, NULL, '2020-08-18 10:42:20.441019-05', 'Cualquier causa que condicione una inmunosupresión (baja de defensas)', true, NULL, '2020-08-18 10:42:20.441019-05', 4);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 1, NULL, '2020-08-18 10:42:20.533723-05', 'Ninguna', true, NULL, '2020-08-18 10:42:20.533723-05', 5);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 5, NULL, '2020-08-18 11:02:22.450648-05', 'Si, sospechoso por síntomas', true, NULL, '2020-08-18 11:02:22.450648-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 5, NULL, '2020-08-18 11:02:22.546736-05', 'Si, confirmado con prueba PCR', true, NULL, '2020-08-18 11:02:22.546736-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 5, NULL, '2020-08-18 11:02:22.649511-05', 'No, ninguno', true, NULL, '2020-08-18 11:02:22.649511-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 6, NULL, '2020-08-18 11:02:57.467287-05', 'de 1 a 7 días', true, NULL, '2020-08-18 11:03:21.915118-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 6, NULL, '2020-08-18 11:02:57.604492-05', 'de 8 a 14 días', true, NULL, '2020-08-18 11:03:22.013034-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 6, NULL, '2020-08-18 11:02:57.698292-05', 'de 15 a 30 días', true, NULL, '2020-08-18 11:03:22.122472-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 6, NULL, '2020-08-18 11:03:22.240882-05', '31 días o más', true, NULL, '2020-08-18 11:03:22.240882-05', 4);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 7, NULL, '2020-08-18 11:04:22.752456-05', 'Caminando', true, NULL, '2020-08-18 11:04:22.752456-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 7, NULL, '2020-08-18 11:04:22.847478-05', 'Transporte público (combi, camión, metro, etc.)', true, NULL, '2020-08-18 11:04:22.847478-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 7, NULL, '2020-08-18 11:04:22.937766-05', 'Transporte particular (automóvil, motocicleta, bicicleta, etc.)', true, NULL, '2020-08-18 11:04:22.937766-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 7, NULL, '2020-08-18 11:04:23.029762-05', 'Contrato de servicio de transporte (pj. Uber)', true, NULL, '2020-08-18 11:04:23.029762-05', 4);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 8, NULL, '2020-08-18 11:31:09.659651-05', 'Uso de gel antibacterial', true, NULL, '2020-08-18 11:31:09.659651-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 8, NULL, '2020-08-18 11:31:09.799756-05', 'Uso de cubrebocas', true, NULL, '2020-08-18 11:31:09.799756-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 8, NULL, '2020-08-18 11:31:09.891036-05', 'Lavado de manos', true, NULL, '2020-08-18 11:31:09.891036-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 8, NULL, '2020-08-18 11:31:09.993144-05', 'Sana distancia', true, NULL, '2020-08-18 11:31:09.993144-05', 4);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 8, NULL, '2020-08-18 11:31:10.08414-05', 'Ninguna', true, NULL, '2020-08-18 11:31:10.08414-05', 5);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 8, NULL, '2020-08-18 11:31:10.175049-05', 'Otra', true, NULL, '2020-08-18 11:31:10.175049-05', 6);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 9, NULL, '2020-08-18 11:31:49.460333-05', 'Si', true, NULL, '2020-08-18 11:31:49.460333-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 9, NULL, '2020-08-18 11:31:49.561997-05', 'No', true, NULL, '2020-08-18 11:31:49.561997-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:33:20.237122-05', 'México', true, NULL, '2020-08-18 11:36:01.95794-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.089017-05', 'San luis', true, NULL, '2020-08-18 11:36:02.089017-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.184649-05', 'Campeche', true, NULL, '2020-08-18 11:36:02.184649-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.275795-05', 'Durango', true, NULL, '2020-08-18 11:36:02.275795-05', 4);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.375318-05', 'Hidalgo', true, NULL, '2020-08-18 11:36:02.375318-05', 5);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.471076-05', 'Puebla', true, NULL, '2020-08-18 11:36:02.471076-05', 6);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.563186-05', 'Monterrey', true, NULL, '2020-08-18 11:36:02.563186-05', 7);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.653681-05', 'Chiapas', true, NULL, '2020-08-18 11:36:02.653681-05', 8);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.745277-05', 'Oaxaca', true, NULL, '2020-08-18 11:36:02.745277-05', 9);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.835822-05', 'Guanajuato', true, NULL, '2020-08-18 11:36:02.835822-05', 10);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:02.947116-05', 'Guadalajara', true, NULL, '2020-08-18 11:36:02.947116-05', 11);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:03.049477-05', 'Sinalo', true, NULL, '2020-08-18 11:36:03.049477-05', 12);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:03.13948-05', 'Gerrero', true, NULL, '2020-08-18 11:36:03.13948-05', 13);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:03.238036-05', 'CDMX', true, NULL, '2020-08-18 11:36:03.238036-05', 14);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:03.329252-05', 'Michoacan', true, NULL, '2020-08-18 11:36:03.329252-05', 15);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:03.41998-05', 'Queretaro', true, NULL, '2020-08-18 11:36:03.41998-05', 16);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:03.510918-05', 'Baja California sur', true, NULL, '2020-08-18 11:36:03.510918-05', 17);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 10, NULL, '2020-08-18 11:36:03.605311-05', 'Baja California Norte', true, NULL, '2020-08-18 11:36:03.605311-05', 18);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 11, NULL, '2020-08-18 11:37:32.863943-05', 'Caminando', true, NULL, '2020-08-18 11:37:32.863943-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 11, NULL, '2020-08-18 11:37:32.959231-05', 'Transporte público (combi, camión, metro, etc.)', true, NULL, '2020-08-18 11:37:32.959231-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 11, NULL, '2020-08-18 11:37:33.050836-05', 'Transporte particular (automóvil, motocicleta, bicicleta, etc.)', true, NULL, '2020-08-18 11:37:33.050836-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 11, NULL, '2020-08-18 11:37:33.146871-05', 'Contrato de servicio de transporte (pj. Uber)', true, NULL, '2020-08-18 11:37:33.146871-05', 4);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 12, NULL, '2020-08-18 11:38:14.369812-05', 'Si', true, NULL, '2020-08-18 11:38:14.369812-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 12, NULL, '2020-08-18 11:38:14.464262-05', 'No', true, NULL, '2020-08-18 11:38:14.464262-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 14, NULL, '2020-08-18 11:39:28.93342-05', 'Caminando', true, NULL, '2020-08-18 11:39:28.93342-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 14, NULL, '2020-08-18 11:39:29.0424-05', 'Transporte público (combi, camión, metro, etc.)', true, NULL, '2020-08-18 11:39:29.0424-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 14, NULL, '2020-08-18 11:39:29.136516-05', 'Transporte particular (automóvil, motocicleta, bicicleta, etc.)', true, NULL, '2020-08-18 11:39:29.136516-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 14, NULL, '2020-08-18 11:39:29.239165-05', 'Contrato de servicio de transporte (pj. Uber)', true, NULL, '2020-08-18 11:39:29.239165-05', 4);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 15, NULL, '2020-08-18 11:40:45.064963-05', 'Uso de gel antibacterial', true, NULL, '2020-08-18 11:40:45.064963-05', 1);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 15, NULL, '2020-08-18 11:40:45.158092-05', 'Uso de cubrebocas', true, NULL, '2020-08-18 11:40:45.158092-05', 2);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 15, NULL, '2020-08-18 11:40:45.24928-05', 'Lavado de manos', true, NULL, '2020-08-18 11:40:45.24928-05', 3);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 15, NULL, '2020-08-18 11:40:45.339931-05', 'Sana distancia', true, NULL, '2020-08-18 11:40:45.339931-05', 4);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 15, NULL, '2020-08-18 11:40:45.430441-05', 'Ninguna', true, NULL, '2020-08-18 11:40:45.430441-05', 5);
INSERT INTO refividrio.opciones ( id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) VALUES ( 15, NULL, '2020-08-18 11:40:45.526551-05', 'Otra', true, NULL, '2020-08-18 11:40:45.526551-05', 6);
