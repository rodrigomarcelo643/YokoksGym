<?php
//============Logout Configuration Details

//======Starting the main point session
session_start();
//========Unsetting the main point session  
session_unset();
//==========Destrying the Data or the account being logged in
session_destroy();

//===Encoding through JSON Format
echo json_encode(["success" => true]);


?>