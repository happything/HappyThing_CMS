<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST" ){
        if(trim($_POST["username"]) != "" && trim($_POST["password"])){
            $username = mysql_real_escape_string($_POST["username"]);
            $password = substr(sha1($_POST["password"]),0,13);

            $sql = "SELECT id,user_types_id,name,lastname FROM users WHERE user = '".$username."' AND password = '$password'";
            $result = mysql_query($sql,$link);

            if(mysql_num_rows($result)){
            $row = mysql_fetch_assoc($result);
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_type"] = $row["user_types_id"];
            $_SESSION["user_name"] = $row["name"]." ".$row["lastname"];

            header("location:/happycms");
            } else { header("location:/happycms/login/er/2"); } 
        } else { header("location:/happycms/login/er/1"); } 
    } else { header("location:/happycms/login"); }
?>