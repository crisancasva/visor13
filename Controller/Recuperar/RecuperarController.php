<?php
include_once '../Model/Recuperar/RecuperarModel.php';
include_once '../lib/helpers.php';

class RecuperarController{

    public function getRecuperar(){
      include_once '../View/Recuperar/recuperar.php';  

    }
    public function postRecuperar(){ 
        $obj=new RecuperarModel();
        $correo =$_POST['correo'];

        if(empty($correo)){
            echo json_encode(array(
                "success" => false,
                "message" => "Debe digitar el correo"
            ));
            exit();
        }else{
            $sql="SELECT * from tblusuario WHERE usucorreo='$correo'";
            $usuario=$obj->select($sql);

            if($usuario){

                $nuevaContrasena=generarContrasena(8);
                $hash = md5($nuevaContrasena);
                $sql="UPDATE tblusuario set usuclave='$hash' WHERE usucorreo='$correo' ";
                $resultado=$obj->update($sql);

                if($resultado){

                
                    require '../web/assets/phpmailer/PHPMailerAutoload.php';

                    $mail = new PHPMailer;

                    
                    //Server settings
                    
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'geovisor13@gmail.com';                     //SMTP username
                    $mail->Password   = 'kiscreotjjjleoxp';                               //SMTP password
                
                    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('visor13@gmail.com', 'VISOR13');
                    $mail->addAddress("$correo");     //Add a recipient
                

                
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Recuperar Contrasena';
                    $mail->AddEmbeddedImage('../web/assets/img/kaiadmin/LogoFinalSinFondo.png', 'logoimg'); // 'logoimg' será el ID usado en el HTML

                    $mail->Body = '
                            <!DOCTYPE html>
                            <html lang="es">
                            <head>
                            <meta charset="UTF-8">
                            <title>Recuperación de contraseña</title>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    background-color: #f6f6f6;
                                    margin: 0;
                                    padding: 0;
                                }
                                .container {
                                    width: 100%;
                                    padding: 20px;
                                    background-color: #ffffff;
                                    max-width: 600px;
                                    margin: 40px auto;
                                    border-radius: 10px;
                                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                                }
                                .logo {
                                    text-align: center;
                                    margin-bottom: 20px;
                                }
                                h2 {
                                    color: #333333;
                                }
                                p {
                                    color: #555555;
                                    line-height: 1.6;
                                    font-size: 14px;
                                }
                                .password-box {
                                    background-color: #f0f0f0;
                                    border: 1px dashed #ccc;
                                    padding: 15px;
                                    font-size: 18px;
                                    font-weight: bold;
                                    text-align: center;
                                    margin: 20px 0;
                                    border-radius: 5px;
                                    letter-spacing: 2px;
                                }
                                .footer {
                                    margin-top: 30px;
                                    font-size: 12px;
                                    color: #888888;
                                    text-align: center;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <div class="logo">
                                    <img src="cid:logoimg" alt="VISOR13 logo" style="width: 150px; display: inline-block;">
                                </div>
                                <h2>Hola,</h2>
                                <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en <strong>VISOR13</strong>. Para garantizar la seguridad de tu cuenta, hemos generado una contraseña temporal única que te permitirá acceder nuevamente.</p>

                                <div class="password-box">' . htmlspecialchars($nuevaContrasena) . '</div>
                                <p>Te recomendamos iniciar sesión lo antes posible y cambiar esta contraseña temporal desde la sección <strong>Actualizar</strong>.</p>
                                <p>Si no realizaste esta solicitud contacta al equipo por medio del correo geovisor13@gmail.com y tambien ingresa al sitema con la contraseña generada y actualizala.</p>
                                <p>Gracias por confiar en <strong>VISOR13</strong>. Estamos comprometidos en ofrecerte una excelente experiencia.</p>
                                <div class="footer">
                                    <p>Este mensaje fue enviado automáticamente. No respondas a este correo.<br>
                                    Equipo Visor13</p>
                                </div>
                            </div>
                        </body>
                        </html>';
                        $mail->AltBody = "Hola,\n\nHemos generado una nueva contraseña temporal para tu cuenta en VISOR13:\n\n$nuevaContrasena\n\nIniciá sesión y cámbiala desde la sección de seguridad.\n\nSi no pediste esto, ignorá este correo.\n\nGracias.";


                    $mail->send();
                    echo json_encode(array(
                        "success" => true,
                        "message" => "Contraseña enviada ",
                        "text"=> "",
                        "redirectUrl" =>getUrl("Acceso","Acceso","getLogin")
                    ));
                    exit();
                }
            
                
            }else{
                
                echo json_encode(array(
                    "success" => false,
                    "message" => "Correo electronico no existe"
                ));
                exit();
            }
        }
         
    }
}
?>