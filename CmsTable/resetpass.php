<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/tailwind.css"/>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>resetPassword</title>
</head>
<body style="background-color: #F9FAFB;">




<?php

require_once"./Connection/connection.php";

if (isset($_POST['email']) && isset($_POST["sendemail"])) {

    $current_time = microtime(true);

    $token = str_replace(".", "", $current_time);

    $activation_key = sha1($current_time . $_POST["email"]);


    function sendMail($current_user_email, $mail_subject, $mail_body)
    {
        require_once "./phpmailer/class.phpmailer.php";
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "Write Your email";
            $mail->Password ="Write Your password emai";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->IsHTML(true);
            $mail->Subject = $mail_subject;
            $mail->Body = $mail_body;
            $mail->FromName = "From Your name";
            $mail->AddAddress($current_user_email, "a human");
            $mail->Send();

            echo "  <script>
  Swal.fire(
  'We send you an email!',
  'Please check your email and click the link!',
  'success'
)
</script> ";

        }

        catch (Exception $err) {
            echo "OMG,can't send";
        }
    }

    $mail_subject = "send email to you for reset password";

    $mail_body = ' 
  
 
<section style="width:80%; position: relative; height:300px; border-radius: 4px; margin: 20px 7.5%; background-color:rgba(226,226,226,0.72);  align-items: center; ">


    <h3 style="color:rgba(23,23,23,0.4); font-weight: 800; padding-top:50px ; font-size: 25px ; text-align: center"> Reset your password </h3>

    <a href="http://localhost:8080/Project/CmsTable/resetpass.php?upkey=' . $activation_key . '" style="text-decoration: none; line-height:100px ; font-size: 20px; text-align: center;width: 80%; height: 100px; font-weight: 800; position: absolute; bottom: 50px; margin: 0px 10% ;  padding: 10px; background-color: dodgerblue;  border-radius: 4px;  ;color: #F9FAFB"> Click hear for reset your password</a>

</section>

      ';

    sendMail($_POST["email"], $mail_subject, $mail_body);

}



function updatepass($email,$pass){
global $connection;
    $update = "UPDATE `cmstbl` SET `password`= ?  WHERE `email`= ? ";

    $result = $connection->prepare($update);

    $pass = sha1($pass);

    $result->bindValue(1,$pass);
    $result->bindValue(2,$email);

    $result->execute();
}

if (isset($_GET["upkey"]) && isset($_POST["uppass"])) {
    updatepass($_POST["email"], $_POST["pass"]);
    echo "  <script>
  Swal.fire(
  'H00000000RY!',
  'Your password update!',
  'success'
)
</script> ";
}
?>


<!--      IMAGE   TITR         -->
<div>
    <img class="mx-auto h-80 mt-10 w-auto" src="./img/Forgot%20password.gif" alt="Workflow">
    <h2 class="mt-6 text-center text-1xl  text-gray-900">
       <strong> do you forget your password ?  </strong> <br>
        ( Don,t worry we send email to you and you can reset you pass )
    </h2>

    <form action="" method="POST">

    <div class="relative w-6/12 mx-auto mt-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5  absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd" />
        </svg>
        <input id="email" name="email" type="email"   autocomplete="email" requigreen class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 focus:z-10 sm:text-sm" placeholder="Email address">





        <?php global $activation_key ;if (isset($_GET["upkey"]) && !empty($_GET["upkey"])  ):?>


        <div class="relative w-12/12 mx-auto mt-10">
            <h1 class="font-bold my-4 text-center">Update your password</h1>

            <input id="pass" name="pass" type="password"   autocomplete="pass"  class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 focus:z-10 sm:text-sm" placeholder="update password">






        </div>
    </form>
    <?php endif?>


        <button type="submit"
         <?php if (isset($_GET["upkey"]) && !empty($_GET["upkey"]) ) {

            if(isset($_GET["upkey"]) && !empty($_GET["upkey"] )):?>
                name=" uppass"
            <?php endif;} ?>


            <?php   if(!isset($_GET["upkey"]) && empty($_GET["upkey"])):?>
                name="sendemail"
            <?php endif; ?>


                class="group mt-5 relative mx-auto flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 w-6/12">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">


						</span>
         <?php if (isset($_GET["upkey"]) ||!empty($_GET["upkey"]) ) {

          if(isset($_GET["upkey"]) || !empty($_GET["upkey"] || $_GET["upkey"] == $activation_key)):?>
             Update password
            <?php endif;} ?>


            <?php   if(!isset($_GET["upkey"]) || empty($_GET["upkey"])):?>
                Send Email
            <?php endif; ?>
        </button>


    </div>






</div>

</body>
</html>