<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit User</title>


    <!--   CDN SWEET ALERT   -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!--   Css File   -->
    <link rel="stylesheet" href="css/tailwind.css"/>
    <link rel="stylesheet" href="css/style.css"/>



    <?php

    require_once "./Connection/connection.php";
    require_once "./common/sanitizetion.php";

    if (isset($_GET["uniqeID"]) && !empty($_GET["uniqeID"])){
        $ID = intval($_GET["uniqeID"]);


    }

    function selectUser($id){

        global $connection , $tblname;

        $sqlSelect = "SELECT `fname`, `lname`, `uname`, `email`, `mobile`, `role` FROM `$tblname` WHERE `id` = ?";

        $result = $connection->prepare($sqlSelect);
        $result->bindValue(1,$id);
        $result->execute();

        if ($result->rowCount()>0){
            return $result;
        }

        return false;
    }

    function updateUser($fname,$lname,$uname,$email,$mobile,$role,$id){
        global $tblname , $connection;

        $sqlupdate = "UPDATE `$tblname` SET `fname` = ? ,`lname` = ? ,`uname`= ? ,`email`= ? ,`mobile`= ? ,`role`= ? WHERE `id` = ? LIMIT 1";





        $result = $connection->prepare($sqlupdate);

        $result->bindValue(1,"$fname");
        $result->bindValue(2,"$lname");
        $result->bindValue(3,"$uname");
        $result->bindValue(4,"$email");
        $result->bindValue(5,"$mobile");
        $result->bindValue(6,"$role");
        $result->bindValue(7,"$id");


        $result->execute();

        return $result;
    }




    if (isset($_POST["update"])){
        $updateU = false;
            $updateU = updateUser($_POST["fname"], $_POST["lname"], $_POST["uname"], $_POST["email"], $_POST["mobile"], $_POST["role"], $_GET["uniqeID"]);

        if($updateU){
            echo " User Update success";
        }
    }

    ?>


    <script src="js/jquery-3.6.0.js" ></script>
</head>
<body>



<!--    Form    -->
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 form ">
    <div class="max-w-md w-full space-y-8">

        <!--      IMAGE   TITR         -->
        <div>
            <img class="mx-auto h-56 w-auto" src="./img/Sign%20in%20(1).gif" alt="Workflow">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
               Edit User account
            </h2>

        </div>


<?php
$selectFunc = null;
$selectFunc = selectUser($ID);
if ($selectFunc) {
    $row = $selectFunc->fetch(PDO::FETCH_ASSOC);

}
?>

        <form action="" method="post" class="mt-8 space-y-6">

            <div class="rounded-md shadow-sm -space-y-px">

                <!--  First Name name="fname" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>

                    <input id="fname" name="fname" type="text" value="<?php echo $row["fname"]; ?>"  class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="First Name">
                </div>

                <!--  Last Name name="lname" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    <input id="lname" name="lname" type="text"   value="<?php echo $row["lname"]; ?>"  class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Last Name">
                </div>

                <!--  User Name name="uname" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>

                    <input id="uname" name="uname" type="text"  value="<?php echo $row["uname"]; ?>"   class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="User Name">

                </div>

                <!--  Email  name="email" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5  absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd" />
                    </svg>
                    <input id="email" name="email" type="email"  value="<?php echo $row["email"]; ?>"   autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                </div>


                <!--  Mobile name="mobile" -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute z-10 right-2 top-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    <input id="mob" name="mobile" type="text" value="<?php echo $row["mobile"]; ?>"    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Mobile">
                </div>

                <!--  Select Role name="role" -->
                <div class="relative">
                    <svg id="select" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <select name="role" id="role" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">

                        <script>
                            $(function () {

                                var userRole = '<?php echo $row["role"] ?>'

                                $("select option").each(function (index,element) {
                                    if($(element).attr("value") ==  userRole ){
                                        $(element).attr("selected","selected")
                                    }
                                })
                            })
                        </script>


                        <option value="1">the User</option>
                        <option value="2" >the writer</option>
                        <option value="3" >the manager</option>
                    </select>
                </div>

            </div>


            <div class="flex">
                <button type="submit" name="update"  class="group relative w-6/12 flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">

							<svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
							</svg>
						</span>
                    Update User
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



</body>
</html>