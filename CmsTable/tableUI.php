<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Table User</title>


    <!--   CDN SWEET ALERT   -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!--   Css File   -->
    <link rel="stylesheet" href="css/tailwind.css"/>
    <link rel="stylesheet" href="css/style.css"/>

</head>
<body>


<?php
require_once "./Connection/connection.php";






function findUser(){

    global $connection , $tblname ;

    $sqlSelect = ("SELECT `id` , `fname`, `lname`, `uname`, `email`,   `mobile`, `role`,  `status` FROM `$tblname` ");

    $result = $connection->query($sqlSelect);
    $result->execute();

    if($result->rowCount()){
        return $result;
    }

    return false;
}


if (isset($_GET["uniqeID"]) and !empty($_GET["uniqeID"])){

   function deleteUser($id){
        global $connection , $tblname;
        $sqlDelete = "DELETE FROM `$tblname` WHERE `id` = ? ";
        $result=$connection->prepare($sqlDelete);
        $result->bindValue(1,$id);
        $result->execute();

    }
    deleteUser($_GET["uniqeID"]);
}

if (isset($_POST["delete"])){

    function deleteCheckUser(){
        global $connection , $tblname;

        $check = $_POST["userCheck"];
        for ($i=0 ; $i < count($check) ; $i++){
            $checked = $check[$i];
            $sqlDelet ="DELETE FROM `$tblname` WHERE `id` = ? ";
            $result = $connection->prepare($sqlDelet);
            $result->bindValue(1,$checked);
            $result->execute();
        }
    }
    deleteCheckUser();
}

?>




<div class="w-11/12 mx-auto table">
    <form method="post" action=""  class="" >
    <div class="flex my-2">

<!--    Form    -->

        <button type="submit" name="delete" class=" group relative w-3/12 flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700  focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 addForm">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">


						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm1 8a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
</svg>
						</span>
            Delete
        </button>


        <button type="button" class="group relative w-2/12 flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shUser">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">


						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 group-hover:text-purple-400" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
</svg>
						</span>
            Show User
        </button>

        <button type="button" class="group relative w-2/12 flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500  shWriter">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">


						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 group-hover:text-green-400" viewBox="0 0 20 20" fill="currentColor">
  <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
  <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
</svg>
						</span>
            Show Writer
        </button>

        <button type="button" class="group relative w-2/12 flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-400 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-300  shManager">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">


							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-700 group-hover:text-red-800" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
</svg>
						</span>
            Show Manager
        </button>


        <button type="button" class="group relative w-3/12 flex justify-center py-2 mx-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500  alluser">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">


							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd" />
</svg>
						</span>
            All User
        </button>
    </div>


    <!--       Table        -->
    <table class="min-w-max w-full table-auto">
        <thead>
        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th class="py-3 px-6 text-left ">ID</th>
            <th class="py-3 px-6 text-left ">Fname & Lname</th>
            <th class="py-3 px-6 text-left">Username</th>
            <th class="py-3 px-6 text-center">Email</th>
            <th class="py-3 px-6 text-center">Mobile</th>
            <th class="py-3 px-6 text-center">Role</th>
            <th class="py-3 px-6 text-center">Actions</th>
            <th class="py-3 px-6 text-center">Check <input type="checkbox" onClick="check_uncheck_checkbox(this.checked);" name="checkAll"> </th>
        </tr>
        </thead>



        <tbody class="text-gray-600 text-sm font-light">

        <?php
        $finduser = findUser();
        $rows = $finduser->fetchAll(PDO::FETCH_ASSOC);

        $counter = 1;

        foreach ($rows as $row):?>
            <tr class="border-b border-gray-200 hover:bg-gray-100">

                <td id="id" class="py-3 px-6 text-left whitespace-nowrap font-bold">
                    <?php echo $counter ; ?>
                </td>

                <td id="fln" class="py-3 px-6 text-left whitespace-nowrap">
                    <?php echo $row["fname"] . " " . $row["lname"]; ?>
                </td>

                <td id="uname" class="py-3 px-6 text-left">
                    <?php echo $row["uname"];?>
                </td>

                <td id="email" class="py-3 px-6 text-center">
                    <?php echo $row["email"]; ?>
                </td>
                <td id="mobile" class="py-3 px-6 text-center">
                    <?php echo $row["mobile"] ?>

                </td>

                <td id="status" class="py-3 px-6 text-center">
                    <?php
                    switch ($row["role"]){
                        case 1:
                            echo "   <span class='bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs user'>User</span> ";
                            break;
                        case 2:
                            echo "   <span class='bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs writer'>Writer</span> ";
                            break;
                        case 3:
                            echo "   <span class='bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs manager'>Manager</span> ";
                            break;
                    }
                    ?>

                </td>

                <td id="action" class="py-3 px-6 text-center">
                    <div class="flex item-center justify-center">
                        <!--              ONLINE   OR   OFFLINE                   -->
                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" id="onOff">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                            </svg>
                        </div>

                        <!--              EDIT PERSON                             -->
                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" id="edit" >
                            <a href="./edit.php?uniqeID=<?php echo $row["id"]?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                        </div>

                        <!--               DELETE PERSON                          -->
                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" id="delete">
                            <a href="?uniqeID=<?php echo $row["id"]?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </td>
                <td id="check" class="py-3 px-6 text-center">

                    <input name="userCheck[]" type="checkbox" value="<?php echo $row["id"]?>">

                </td>


            </tr>
            <?php
            $counter++;
        endforeach;?>









        </tbody>
    </table>
    </form>
</div>



<script src="js/jquery-3.6.0.js"></script>
<script src="js/script.js"></script>
</body>
</html>
