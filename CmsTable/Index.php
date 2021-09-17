<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cms-Table</title>

<!--   CDN SWEET ALERT   -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!--   Css File   -->
    <link rel="stylesheet" href="css/tailwind.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body class="bg-gray-50">



<?php
require_once "./Connection/connection.php";
require_once "./common/sanitizetion.php";

function createUser($fname,$lname,$uname,$email,$password,$mobile,$role,$activation_key){
    global $tblname , $connection;
    $sql = "INSERT `$tblname` SET `fname` = ? , `lname` = ? , `uname` = ? , `email` = ? , `password` = ? , `mobile` = ? , `role` = ? , `activation_key` = ?  ";

    $fname = sanitize($fname);
    $lname = sanitize($lname);
    $uname = sanitize($uname);
    $email = sanitize($email);
    $password = sanitize($password);
    $password = sha1($password);
    $mobile = sanitize($mobile);
    $role = sanitize($role);
    $activation_key = sanitize($activation_key);





    $result = $connection->prepare($sql);

    $result->bindValue(1,"$fname");
    $result->bindValue(2,"$lname");
    $result->bindValue(3,"$uname");
    $result->bindValue(4,"$email");
    $result->bindValue(5,"$password");
    $result->bindValue(6,"$mobile");
    $result->bindValue(7,"$role");
    $result->bindValue(8,"$activation_key");

    $result->execute();

    return $result;
}

function userExist($uname){

global $tblname , $connection;
    $sql = "SELECT `uname` FROM `$tblname` WHERE `uname` = ? ";
    $result = $connection->prepare($sql);
    $result->bindValue(1,$uname);
    $result->execute();
    if ($result->rowCount() > 0){
        return $result;
    }
    return false;
}

$haserr = false;
$msgerr = "";
$successmsg = false;
$msgsuc = "";

if (isset($_POST["submit"])){



    $queryExist = userExist($_POST["uname"]);
if ($queryExist){
    $haserr = true ;
    $msgerr = "Please change your Username,duplicate!!!";
}
else {

//      ACTIVATION KEY
    $activ_key = microtime(true);
    $activ_key = str_replace(".", "", $activ_key);
    $activ_key = sha1($_POST["uname"] . $_POST["email"] . $activ_key);


//          QUERY CREATE
    $query = createUser($_POST["fname"], $_POST["lname"], $_POST["uname"], $_POST["email"], $_POST["password"], $_POST["mobile"], $_POST["role"], $activ_key);

    $haserr = false;
    $msgerr = '<script>
swal({
  title: "Welcome :)",
  text: "You join to us !!!",
  icon: "success",
  button: "0K;",
});
</script>';
}


}


?>




<!--    Form    -->
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 form ">
    <div class="max-w-md w-full space-y-8">

                            <!--      IMAGE   TITR         -->
        <div>
            <img class="mx-auto h-56 w-auto" src="./img/Signin.gif" alt="Workflow">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Sign in to your account
            </h2>

        </div>

        <?php if ($haserr == false): ?>
        <?php echo $msgerr ;?>
        <?php endif; ?>
        <?php if($haserr): ?>
            <div role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                    Warning
                </div>
                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                    <p> <?php echo $msgerr; ?>  </p>
                </div>
            </div>
        <?php endif; ?>
        <form action="" method="post" class="mt-8 space-y-6">

            <div class="rounded-md shadow-sm -space-y-px">

<!--  First Name name="fname" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>

                    <input id="fname" name="fname" type="text"class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="First Name">
                </div>

<!--  Last Name name="lname" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    <input id="lname" name="lname" type="text"  class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Last Name">
                </div>

<!--  User Name name="uname" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>

                    <input id="uname" name="uname" type="text"   class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="User Name">

                </div>

<!--  Email  name="email" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5  absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd" />
                    </svg>
                    <input id="email" name="email" type="email"   autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                </div>

<!--  Password name="password" -->
                <div class="relative">
                    <svg id="eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400 bg-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                    </svg>

                    <input id="pass" name="password" type="password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                </div>

<!--  Mobile name="mobile" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    <input id="mob" name="mobile" type="text"class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Mobile">
                </div>

<!--  Select Role name="role" -->
                <div class="relative">
                    <svg id="select" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <select name="role" id="role" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">



                        <option value="1">the User</option>
                        <option value="2" >the writer</option>
                        <option value="3" >the manager</option>
                    </select>
                </div>

            </div>

            <div class="flex items-center justify-between">


                <div class="text-sm">
                    <a href="./login.php" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Have an acount?
                    </a>
                </div>
            </div>

            <div class="flex">
                <button type="submit" name="submit" class="group relative w-6/12 flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">

							<svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
							</svg>
						</span>
                    Sign in
                </button>

                <a href="tableUI.php" class="group relative w-6/12 flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700  focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 showUser ">

                <button type="button" id="showUser"  class=" text-sm font-medium text-white focus:outline-none">
						<span class="absolute left-0 inset-y-0  items-center pl-3">


							<svg xmlns="http://www.w3.org/2000/svg" class="mt-2 h-5 w-5 text-yellow-500 group-hover:text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
  <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
</svg>
						</span>
                    Show User
                </button>
</a>
            </div>
        </form>
    </div>
</div>




<script src="js/jquery-3.6.0.js"></script>
<script src="js/script.js"></script>
</body>
</html>