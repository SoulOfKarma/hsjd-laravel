<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Ticket N° {{ $seguimiento->id }}</title>
</head>
<body>
    <p>Hola {{ $seguimiento->nombre }}</p>
    <p>ha respondido al Ticket N°: {{ $seguimiento->id }}</p>   
    <p>Descripcion: {{ $seguimiento->descripcionSeguimiento }}</p>   
    <p>Este correo es informativo, favor no responder a esta dirección de correo, ya que no se encuentra habilitada para recibir mensajes. 
        Si requiere mayor información sobre el contenido de este mensaje.
        Para cualquier duda o consulta favor comunicarse al correo 
        </p>
        <p>Teléfono: (+56 2)  - Anexo: </p>
</body>
</html>