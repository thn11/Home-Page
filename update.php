<?php


run_commands() {
  exec('git pull origin master --strategy-option=theirs', $output, $error);
  if ($error) {
    return [
      'message' => "Could not pull: Error code " . $error,
      'type' => "yellow"
    ];
  }
  exec('git submodule init', $output, $error);
  if ($error) {
    return [
      'message' => "Could not init submodules: Error code " . $error,
      'type' => "yellow"
    ];
  }
  exec('git submodule update', $output, $error);
  if ($error) {
    return [
      'message' => "Could not update submodules: Error code " . $error,
      'type' => "yellow"
    ];
  }

}


if (!($username = filter_var($_POST['username'], FILTER_SANITIZE_STRING))){
  $username = '';
}
if (!($password = filter_var($_POST['password'], FILTER_SANITIZE_STRING))){
  $password = '';
}

$message = '';
$messageType = '';

if ($username !== '' && $password !== '') {
  // load file
  // Check if username is on list
  // Check password
  // Do commands:
  //   git pull origin master
  //   git submodule init
  //   git submodule update


  if (is_file('users.json')){
    $string = file_get_contents('users.json');
    if ($json = json_decode($string, true)){
      if ($json[strtolower($username)]) {
        if (password_verify($password, $json[$username])){
          $results = run_commands();
          $message = $results['message'];
          $messageType = $results['type'];
        } else {
          $message = "Bad password";
          $messageType = "red";
        }
      } else {
        $message = "Bad username";
        $messageType = 'red';
      }
    } else {
      $message = "Bad json";
      $messageType = 'yellow';
    }
  } else {
    $message = "Users file not found";
    $messageType = 'yellow';
  }
} else if ($_POST) {
  $message = "Missing fields";
  $messageType = 'red';
}


?>
<html>
<head>

</head>
<body>
  <form class="login-form" method="post">
    <h1>TN</h1>
    <?php if ($message !== ''){
      echo '<p class="info '.$messageType.'">'.$message.'</p>';
    } ?>
    <input required value="<?= $username ?>" type="text" id="username" name="username" placeholder="Username" pattern=\w{3,80}>
    <input required value="<?= $password ?>" type="password" id="password" name="password" placeholder="Password" pattern=\w{8,80}>
    <button type="submit">Pull Changes</button>
  </form>
</body>
<style>
  body {
    display: flex;
    align-items: center;
    justify-content: center;
      background-color: #eeeeee;
  }
  body > .login-form {
    background-color: white;
    padding: 10px;
    border-radius: 12px;
    box-shadow: 3px 3px 15px 1px #aaa;
  }
  body > .login-form > h1 {
    width: 90vw;
    max-width: 200px;
    display: block;
    background-color: white;
    margin: 0;
    padding: 0;
    text-align: center;
    color: #ff6800;
    text-shadow: #888888 2px 2px 6px;
    margin-bottom: 10px;
  }
  body > .login-form > button,
  body > .login-form > input {
    width: 90vw;
    max-width: 200px;
    display: block;
    background-color: white;
    border: 1px solid #0032ff;
    box-shadow: 0 0 2px 0 #0032ff;
    color: #0032ff;
    margin: 0;
    padding: 0;
    border-radius: 3px;
    margin-bottom: 10px;
    padding: 10px 15px;
    transition: all 0.5s;
  }
  body > .login-form > button {
    border-radius: 3px 3px 8px 8px;
    margin-bottom: 0;
    cursor: pointer;
  }
  body > .login-form > input:hover,
  body > .login-form > button:hover {
    border-color: #ff6800;
    box-shadow: 0 0 3px 0 #ff6800;
  }
  body > .login-form > input:focus,
  body > .login-form > button:focus {
    outline: 0;
    border-color: #ff6800;
    box-shadow: 0 0 4px 0 #ff6800;
    color: #ff6800;
    border-radius: 8px;
  }
  body > .login-form > .info {
    width: 90vw;
    max-width: 200px;
    display: block;
    box-sizing: border-box;
    border: 1px solid rgb(160, 160, 160);
    background-color: rgba(160,160,160, 0.4);
    margin: 0;
    padding: 0;
    border-radius: 3px;
    margin-bottom: 10px;
    padding: 5px 10px;
    font-size: 14px;
  }
  body > .login-form > .info.green {
    border-color: rgb(0, 160, 50);
    background-color: rgba(0, 160, 50, 0.4);
  }
  body > .login-form > .info.yellow {
    border-color: rgb(180, 180, 30);
    background-color: rgba(180, 180, 30, 0.4);
  }
  body > .login-form > .info.red {
    border-color: rgb(160, 30, 30);
    background-color: rgba(160, 30, 30, 0.4);
  }
</style>
</html>
