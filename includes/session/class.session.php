<?
class WPMSession {

  // the WPMSession function starts a session and sets the appropriate cookie (which can, of course,
  // be renamed). It takes one parameter, logout, which, if set will log the user out and kill the session
  function WPMSession($logout = "", $params="") {
    session_start();

    if ($logout) {
      //$_SESSION = array(); // old session destroy
      //session_destroy();   // old session destroy
      $this->destroySession($params);
      setcookie("WPMLoginCookie", SID, time()-180*60, "/");
      $this->errMsg = "You have been logged out.";
      return $this->errMsg;
    }
    return null;
  }

  /* login takes two parameters, username and password and compares them against
  values in the database. It returns error messages if login fails.
  If login succeeds, several session variables are set and the user is redirected to the
  appropriate page. login takes 6 parameters
  username = the username (or email if login is of email/password type)
  passowrd = the password
  location = the page to which the user will be redirected if login is successful (optional)
  table = the table where user info is stored (optional, defaults to "users")
  userField = the name of the field in the database to which the username will be compared. Useful if using email instead of
    username (optional, defaults to "username")
  passwordField = the name of the field in the database to which the password will be compared (optional, defaults to "password")
  */
  function login($username, $password, $location = "", $table = "users", $userField = "username", $passField = "password", $params = "") {
    if (!$username || !$password) {
      $this->errMsg = "Please enter your $userField and $passField";
      return $this->errMsg;
    }
		$userval = trim(str_replace('%', '', $username));
		$passval = trim(str_replace('%', '', $password));
    $result = select("$table","","*","$userField = '$userval' AND $passField = '$passval'");
    if ($username && $password && num_rows($result) == 0) {
      $this->errMsg = "Either your $userField or $passField is incorrect";
      return $this->errMsg;
    } elseif (num_rows($result) > 0) {
      $row = fetch_array($result);
      setcookie("WPMLoginCookie", SID, time()+180*60, "/", ".webpagemaintenance.com", "0");
      $_SESSION[$params . 'logged_in'] = 1;
      $_SESSION[$params . 'auth_level'] = $row['cmsauthlevel'];
      $_SESSION[$params . 'pm_auth_level'] = $row['authlevel'];
      $_SESSION[$params . 'fname'] = $row['fname'];
      $_SESSION[$params . 'lname'] = $row['lname'];
      $_SESSION[$params . 'userid'] = $row['id'];
      $_SESSION[$params . 'account'] = $row['account_id'];
      $_SESSION[$params . 'last_login'] = $row['last_login'];
      execute_query("update $table set last_login = '" . date("m/d/Y H:i:s") . "' where id = $row[id]");
      if ($location) {
        if ($location == "db") {
          header("Location: $row[home]");
        } else {
          header("Location: $location");
        }
        return null;
      }
    }//if num_rows > 0
    return null;
  }//function login

  // sessionSet just sets a session variable. Requires two parameters
  // name = name of session variable
  // arr = argument or array that will be the value of the new session variable
  function sessionSet($name,$arr) {
    $_SESSION ["$name"] = $arr;
  }

  // sessionGet is the companion of sessionSet and retrives the value of the session variable $name
  function sessionGet($name) {
    return $_SESSION["$name"];
  }

  // see login.php for an explanation
  function sessionCompare($k, $o, $v) {
    switch($o) {
      case "<":
        if ($_SESSION ["$k"] < $v) {
          return TRUE;
        }
      break;
      case ">":
        if ($_SESSION ["$k"] > $v) {
          return TRUE;
        }
      break;
      case ">=":
        if ($_SESSION ["$k"] >= $v) {
          return TRUE;
        }
      break;
      case "<=":
        if ($_SESSION ["$k"] <= $v) {
          return TRUE;
        }
      break;
      default:
        if ($_SESSION ["$k"] == $v) {
          return TRUE;
        }
    }
  }

  function destroySession($params="")
  {
      unset($_SESSION[$params . 'logged_in']);
      unset($_SESSION[$params . 'auth_level']);
      unset($_SESSION[$params . 'pm_auth_level']);
      unset($_SESSION[$params . 'fname']);
      unset($_SESSION[$params . 'lname']);
      unset($_SESSION[$params . 'userid']);
      unset($_SESSION[$params . 'account']);
      unset($_SESSION[$params . 'last_login']);
  }

}//WPMSession
