<?php
session_start();   
include "../funtions.php";

$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_SESSION['colaborador_id'];

//CONSULTAMOS DATOS DEL PACIENTE
$consultar_datos = "SELECT CONCAT(nombre, ' ', apellido) AS 'paciente', email 
FROM pacientes WHERE pacientes_id = '$pacientes_id'";
$result = $mysqli->query($consultar_datos);
$consultar_datos1 = $result->fetch_assoc();
$paciente = $consultar_datos1['paciente'];
$para = $consultar_datos1['email'];
$from = "Formulario Alimentos";

if($paciente != ""){ 
      //OBTENEMOS LOS DATOS DEL USUARIO Y DE LA EMPRESA
      $query_usuario = "SELECT e.telefono AS 'telefono', e.celular AS 'celular', e.correo AS 'correo', e.horario AS 'horario', e.eslogan AS 'eslogan', e.facebook AS 'facebook', e.sitioweb AS 'sitioweb'
        FROM users AS u
        INNER JOIN empresa AS e
        ON u.empresa_id = e.empresa_id
        WHERE u.colaborador_id = '$colaborador_id'";
      $result_usuario = $mysqli->query($query_usuario); 			

      $telefono = '';
      $celular = '';
      $telefono = '';
      $horario = '';
      $eslogan = '';
      $facebook = '';
      $sitioweb = '';	
      $correo = '';

      if($result_usuario->num_rows >= 0){
        $consulta_empresa = $result_usuario->fetch_assoc();
        $telefono = $consulta_empresa['telefono'];
        $celular = $consulta_empresa['celular'];
        $correo = $consulta_empresa['correo'];   
        $horario = $consulta_empresa['horario'];
        $eslogan = $consulta_empresa['eslogan'];
        $facebook = $consulta_empresa['facebook'];
        $sitioweb = $consulta_empresa['sitioweb'];					
      } 

      //OBTENER EL CORREO
      $tipo_correo = "Notificaciones";
      $query_correo = "SELECT c.correo_id AS 'correo_id', c.correo_tipo_id AS 'correo_tipo_id', ct.nombre AS 'tipo_correo', c.server AS 'server', c.correo AS 'correo', c.port AS 'port', c.smtp_secure AS 'smtp_secure', c.estado AS 'estado', c.password AS 'password'
        FROM correo AS c
        INNER JOIN correo_tipo AS ct
        ON c.correo_tipo_id = ct.correo_tipo_id
        WHERE ct.nombre = '$tipo_correo'";
      $result_correo = $mysqli->query($query_correo); 									

      $de = "";
      $contraseña = "";
      $server = "";
      $port = "";
      $smtp_secure = "";

      if($result_correo->num_rows >= 0){
        $consulta_correo = $result_correo->fetch_assoc();
        $de = $consulta_correo['correo'];
        $contraseña = decryption($consulta_correo['password']);
        $server = $consulta_correo['server'];   
        $port = $consulta_correo['port'];
        $smtp_secure = $consulta_correo['smtp_secure'];	
      }

      $asunto = "Formulario Alimentos\n";
      $CharSet = "UTF-8";
      $mensaje = "";
      $url_logo = SERVERURL."img/logo.png";
      $url_alimentos = SERVERURL."vistas/alimentos.php";
      $url_sistema = SERVERURL;
      $url_footer = "";
      $url_facebook = "#";
      $url_sitio_web = "#";	
  
      $mensaje="
          <table class='table table-striped table-responsive-md btn-table'>
            <tr>
                <td colspan='2'><center><img width='25%' heigh='20%' src='".$url_logo."'></center></td>
            </tr>
            <tr>
                <td colspan='2'><center><b><h4>Formulario Registro de Alimentos</h4></b></center></td>
            </tr>
            <tr>
              <td>
                <p style='text-align: justify'>
                    Estimado(a) <b>".$paciente."</b>, Se le informa que se le está haciendo llegar el formulario de registro de alimentos, <a href='".$url_alimentos."'>Presione este enlace para acceder al Formulario de Registro de Alimentos</a> Una vez que ingrese, vera el formulario el cual deberá llenar marcando o escribiendo según las preguntas solicitadas.
                </p>
             </td>
            </tr>
            <tr>
              <td>
                <p style='text-align: justify; font-size:12px;'>
                   <b>
                      Este correo fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje..
                   </b>
                 </p>
               </td>
             </tr>
            <tr>
              <td>
                <p><img width='25%' heigh='20%' src='".$url_footer."'></p>
              </td>			  
             </tr>   
          </table>
        ";		

      $cabeceras = "MIME-Version: 1.0\r\n";
      $cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
      $cabeceras .= "From: $de \r\n";

      //$archivo = $_FILES["archivo_fls"]["tmp_name"];
      //$destino = $_FILES["archivo_fls"]["name"];

      //incluyo la clase phpmailer	
      include_once("../phpmailer/class.phpmailer.php");
      include_once("../phpmailer/class.smtp.php");

      $mail = new PHPMailer(); //creo un objeto de tipo PHPMailer
      $mail->SMTPDebug = 1;
      $mail->IsSMTP(); //protocolo SMTP
      $mail->IsHTML(true);
      $mail->CharSet = $CharSet;
      $mail->SMTPAuth = true;//autenticación en el SMTP
      $mail->SMTPSecure = $smtp_secure;
      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );		
      $mail->Host = $server;//servidor de SMTP de gmail
      $mail->Port = $port;//puerto seguro del servidor SMTP de gmail
      $mail->From = $de; //Remitente del correo	
      $mail->FromName = $from; //Remitente del correo
      $mail->AddAddress($para);// Destinatario
      $mail->Username = $de;//Aqui pon tu correo de gmail
      $mail->Password = $contraseña;//Aqui pon tu contraseña de gmail
      $mail->Subject = $asunto; //Asunto del correo
      $mail->Body = $mensaje; //Contenido del correo
      $mail->WordWrap = 50; //No. de columnas
      $mail->MsgHTML($mensaje);//Se indica que el cuerpo del correo tendrá formato html

      if($para != ""){		
          if($mail->Send()){ //enviamos el correo por PHPMailer
            $respuesta = "El mensaje ha sido enviado con la clase PHPMailer =)";
            echo 1;//CORREO ENVIADO
          }else{
            $respuesta = "El mensaje no se pudo enviar con la clase PHPMailer =(";
            $respuesta .= " Error: ".$mail->ErrorInfo;
            echo 2; //EL CORREO NO PUDO SER ENVIADO
          }			   
      }else{
        echo 3;//EL USUARIO NO TIENE REGISTRADO UN CORREO ELECTRONICO
      }
}else{
	echo 3;//EL USUARIO INGRESADO NO EXISTE
}	 
$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>