<?php
// mendeteksi browser
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //mengambil platform
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }

    // mengambil nama useragent client
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    }
    elseif(preg_match('/OPR/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 
?>

<html>
   <head>
   </head>  
   <body>
   	<style>
   		.div1 {
   			background-color: lightblue;
   			border: solid powderblue;
   			padding: 15px;
   			text-align: center;
   		}
   	</style>
   	<div class="div1">
      <?php 

      	   session_start();

    $username = $_REQUEST['usr'];
    $password = $_REQUEST['pwd'];

    if($username == "Aldo" and 
        $password == "password") {
            $_SESSION['login'] = true;
            echo "Hi, Aldo" . "<br>";

        }
        else echo "Login gagal." . "<br>";

     	$ua=getBrowser();
		$yourbrowser= "Your browser: " . $ua['name'] . " v" . $ua['version'] . " on " .$ua['platform'] . "<br>";
		print_r($yourbrowser);

// ucapan selamat
	date_default_timezone_set('Asia/Jakarta');
		$time = date("h:i a");
		echo "Time now is " . date("h:i a") . "<br>";
		echo "Date now is " .  date ("Y-m-d"). "<br>";

		$time = date ("H");
		if (($time >=6) && ($time<=11)) 
			{
			echo "Good Morning, $username";
		} 
		elseif (($time>=11) && ($time<=15)) 
			{
			echo "Good Afternoon, $username";
		} else 
			{
			echo "Good Night, $username";
		}
      	?>
      </div>
   </body>
</html>