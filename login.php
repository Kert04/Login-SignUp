
<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<style>
     
        body {
            
            margin-left: 1000px;
            margin: 0; 
            display: flex;
            flex-direction: column; 
            align-items: center; 
            padding-top: 20px; 
            background-image: url('image/kd.jpeg');
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            opacity: 0.8; 
        }

        
        form {
            margin-left:500px;
            margin-right: auto;
            margin-top: 100px;
            width: 100%; 
            max-width: 330px; 
            padding: 20px;
            background-color: rgba(211, 211, 211, 0.336);
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1); 
        }

        
        label {
            color: black;
        }
        input {
            width: 300px;
        }
       
        h1 {
           
            color: white;
            text-align: center;
            margin-bottom: 20px; 
        }
        button{
            margin-top: 25px;
            margin-left:100px;
            margin-right: auto;
        }
        label{
            color: black; 
        }
</style>
<body>
    
    
    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <form method="post">
    <h1>Login</h1>

        <input type="email" name="email" id="email"placeholder="Email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <input type="password" name="password" id="password"placeholder="Password">
        
        <button>Log in</button>
    </form>
    
</body>

</html>


