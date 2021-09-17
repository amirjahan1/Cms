<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!--   Css File   -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="css/tailwind.css"/>
    <link rel="stylesheet" href="css/style.css"/>

</head>
<body>

<?php
require_once "./Connection/connection.php";
require_once "./common/sanitizetion.php";
session_start();
 require_once "./common/jdf.php";
date_default_timezone_set("ASIA/Tehran");
$haserror = false;

function getUserBrowser($userAgent){
    if(strpos($userAgent,"Edg")){
        return "مایکروسافت اج";
    }


    else if(strpos($userAgent,"Chrome")){
        return "گوگل کروم";
    }


    else if(strpos($userAgent,"Safari")){
        return " اپل سافاری";
    }


    else if(strpos($userAgent,"Firefox")){
        return " موزیلا فایرفاکس";
    }
    else if(strpos($userAgent,"MSIE") || strpos($userAgent,"Trident/7")){
        return " اینترنت اکسپلورر ملعون";
    }
    else if(strpos($userAgent,"Opera") || strpos($userAgent,"OPR/") ){
        return " اپرا";
    }
    else{
        return  "سابر مرورگرها";
    }

}

function jalalidate($data=null){

    $data = explode(" ",$data);

    list($year,$mounth,$day) = explode("-",$data[0]);
    list($hour,$minute,$second) = explode(":",$data[1]);

    $timestamp = mktime($hour,$minute,$second,$mounth,$day,$year);
    return  jdate("تاریخ : y/m/d زمان H:i:s",$timestamp);
}

if (isset($_POST["login"])){
    if (isset($_POST["email"]) AND isset($_POST["password"])){


        function doLogin($email=null, $password=null){
global $connection , $tblname , $tblLogin , $haserror;

        $sql = "SELECT `id`, `fname`, `lname`, `uname`, `email`, `password`, `mobile`, `role` FROM `$tblname` WHERE  `email` = ? AND `password` = ? ";

            $select = "SELECT `LoginTime` from `login` WHERE email = ? ";

            $email = sanitize($email);

            $password = sanitize($password);

            $password = sha1($password);

                $sel= $connection->prepare($select);
                $sel->bindValue(1,$email);
                $sel->execute();

            $result = $connection->prepare($sql);
            $result->bindValue(1,$email);
            $result->bindValue(2,$password);
            $result->execute();

            if ($result->rowCount()){
                $row = $result->fetch(PDO::FETCH_ASSOC);

                $selec = $sel->fetch(PDO::FETCH_ASSOC);


                $sql = "INSERT `$tblLogin` SET `userId` = ? , `userIp` = ? , `browser` = ? , `email` = ? , `userName` = ? , `details` = ? ";


                $userId = $row["id"];

                $userIp = $_SERVER["REMOTE_ADDR"];

                $browser = getUserBrowser($_SERVER["HTTP_USER_AGENT"]);

                $userName = $row["uname"];

                $details = "Log In";

                $result = $connection->prepare($sql);
                $result->bindValue(1,$userId);
                $result->bindValue(2,$userIp);
                $result->bindValue(3,$browser);
                $result->bindValue(4,$email);
                $result->bindValue(5,$userName);
                $result->bindValue(6,$details);
                $result->execute();

                $userSession = array(
                    "signInKey"=>true,
                    "userEmail"=> $row["email"],
                    "id"=>$row["id"],
                    "firstName" => $row["fname"] ,
                    "lastName" => $row["lname"] ,
                    "userName" => $row["uname"] ,
                    "role" => $row["role"] ,
                    "fullName" => $row["fname"] . " " . $row["lname"],
                    "expireTime" => time() + 30,
                    "logintime" => $selec["LoginTime"]
                );

                $_SESSION["userInfo"] = $userSession;



                return $result;
            }

            $haserror = true;
            return false;
        }



            function blacklist($email){
            global $connection;
            $sql = "SELECT `email` from `blcklist` WHERE `email` = ? ";

            $result = $connection->prepare($sql);

            $result->bindValue(1,$email);
            $result->execute();

            if($result->rowCount()){
                return true;
            }
            return false;
            }


    }
}




?>



<!---->
<?php
if (isset($_POST["login"])){
    $blacklist = blacklist($_POST["email"]);


    if (empty($_POST["email"]) || empty($_POST["password"])){
        $haserror = true;
    }


if ($blacklist == false) {


    $doLogIn = doLogin($_POST["email"], $_POST["password"]);

    if ($doLogIn):?>


<div class="w-3/12 bg-gray-100 absolute animate__animated   animate__bounceInLeft" style="height:100vh" >


    <div class="bg-gray-500 w-40 overflow-hidden h-40 mt-28 ml-28 rounded-full">

    </div>

    <div class="mt-12 ">
        <h1 class="text-2xl w-full text-center">  Welcome <?php echo  $_SESSION["userInfo"]["firstName"]." " . $_SESSION["userInfo"]["lastName"]   ?>  </h1>
    </div>

    <div class="mt-12 ">
        <h1 class="text-1xl w-full text-center">  ورود <br> <?php echo jalalidate($_SESSION["userInfo"]["logintime"]); ?>  </h1>
    </div>


    <div class="absolute w-full h-14 bg-gray-400 bottom-0 border-t-2 solid black">
        <a href="./Session/Session.php" class="absolute right-4 top-3 text-red-600 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </a>
    </div>
</div>


    <?php endif; }}?>





<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 form ">
    <div class="max-w-md w-full space-y-8">

        <!--      IMAGE   TITR         -->
        <div>
            <img class="mx-auto h-56 w-auto" src="./img/Login.gif" alt="Workflow">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Log in to your account
            </h2>

        </div>


        <form action="" method="post" class="mt-8 space-y-6">

            <div class="rounded-md shadow-sm -space-y-px">
                <?php
                if (isset($_POST["login"])){

                    if (empty($_POST["email"]) || empty($_POST["password"])){
                        $haserror = true;
                    }
                if ($blacklist == false) {
                    $doLogIn = doLogin($_POST["email"],$_POST["password"]);

                if ($doLogIn):?>


                    <div class="alert flex flex-row items-center bg-green-200 p-5 rounded border-b-2 border-green-300 my-10">
                        <div class="alert-icon flex items-center bg-green-100 border-2 border-green-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
				<span class="text-green-500">
					<svg fill="currentColor"
                         viewBox="0 0 20 20"
                         class="h-6 w-6">
						<path fill-rule="evenodd"
                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                              clip-rule="evenodd"></path>
					</svg>
				</span>
                        </div>
                        <div class="alert-content ml-4">
                            <div class="alert-title font-semibold text-lg text-green-800">
                                Success
                            </div>
                            <div class="alert-description text-sm text-green-600">

                                <?php echo "You can LogIn "?>
                            </div>
                        </div>
                    </div>

                <?php endif; }}?>


                <?php
                if ( isset( $_POST["email"])){
                if ($blacklist):?>


                    <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                            <div>
                                <p class="font-bold">So Sorry , you are in Black list</p>
                                <p class="text-sm">Please don't try agian and call to Support</p>
                            </div>
                        </div>
                    </div>

                        <?php endif;}?>
                <br>
                <!--  Email  name="email" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5  absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd" />
                    </svg>
                    <input id="email" name="email" type="email"   autocomplete="email" requigreen class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Email address">
                </div>

                <!--  Password name="password" -->
                <div class="relative ">
                    <svg id="eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400 " viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                    </svg>

                    <input id="pass" name="password" type="password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Password">
                </div>
            </div>

            <?php
            if (isset($_POST["login"])){

            if ($haserror): ?>

                <div class="alert flex flex-row items-center bg-red-200 p-5 rounded border-b-2 border-red-300">
                    <div class="alert-icon flex items-center bg-red-100 border-2 border-red-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
				<span class="text-red-500">
					<svg fill="currentColor"
                         viewBox="0 0 20 20"
                         class="h-6 w-6">
						<path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
					</svg>
				</span>
                    </div>
                    <div class="alert-content ml-4">
                        <div class="alert-title font-semibold text-lg text-red-800">
                            Error
                        </div>
                        <div class="alert-description text-sm text-red-600">
                            <?php echo "Sorry Email or Password inValid!"?>
                        </div>
                    </div>
                </div>

            <?php endif; }?>
            <div class="flex justify-between">
            <div class="text-sm relative">
                <a href="resetpass.php" class="font-medium text-green-600 hover:text-green-500">
                    Forgot your password?
                </a>
            </div>

                <div>
                    <label class="font-medium text-green-600 hover:text-green-500" for="remember">Remember me</label>
                    <input id="remember" type="checkbox">
                </div>
            </div>

            <div class="flex">
                <button type="submit" name="login" class="group relative w-full flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">

							<svg class="h-5 w-5 text-green-500 group-hover:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
							</svg>
						</span>
                    Log in
                </button>
            </div>
        </form>
    </div>
</div>


<script src="js/jquery-3.6.0.js"></script>
<script src="js/script.js"></script>
</body>
</html>