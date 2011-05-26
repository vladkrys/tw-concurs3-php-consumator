<html>
<body>
<head>
    <link href="request.css" rel="stylesheet" type="text/css">
</head>
<div id="wrapper">
<h3>PHP_Client_Request_Evaluate</h3>
<br/>
<?php
 $flag=0;
 $param = "parametrii " .$_SERVER["REQUEST_URI"];
 $param1 = substr($param,52);
 $param2 = str_replace("+"," ",$param1);
 $pDom = new DOMDocument();
 $pDom->load('http://tw-concurs3.heroku.com/rest/projects/updated-list.xml');
 $nodes= $pDom->getElementsByTagName('project');
 $arrFeeds = array();
  foreach ($nodes as $node) {
    $itemRSS = array ( 
      'submited-at' => $node->getElementsByTagName('submited-at')->item(0)->nodeValue,
      'id' => $node->getElementsByTagName('id')->item(0)->nodeValue,
      'author1'=> $node->getElementsByTagName('first')->item(0)->nodeValue,
      'author2'=> $node->getElementsByTagName('second')->item(0)->nodeValue
       );
    array_push($arrFeeds, $itemRSS);
  }
  $flag =0;
  $flag2=0;
 foreach ($arrFeeds as $aThread)
{
    
    if(strcmp($aThread['author1'],$param2)==0) {
        $flag = 1;
        $coleg = $aThread['author2'];
        if(strcmp($coleg,"")==0) 
            {$coleg ="-";
             $flag2=1;}
        $timestamp = $aThread['submited-at'];
        break;
        }
    if( $flag2!=1 && strcmp($aThread['author2'],$param2)==0) {
        $flag=1;
        $coleg = $aThread['author1'];
        $timestamp = $aThread['submited-at'];
        break;
        } 
  }
  if($flag == 0) 
      {   
       echo "<div id =\"warning\">$param2 nu a fost gasit in baza de date</div>";
       echo "<form  action=\"php_client.php\"><input id= \"back\" type=\"submit\" value=\"Inapoi\" /></form>";      
       }
   if($flag == 1)
       {
        $ppDom = new DOMDocument();
        $url_string = "http://tw-concurs3.heroku.com/rest/projects/show/".$aThread['id'].".xml";
        $ppDom->load($url_string);
        $nodes= $ppDom->getElementsByTagName('project');
        $arrFeeds2 = array();
        foreach ($nodes as $node) {
            $itemRSS2 = array ( 
              'project-url' => $node->getElementsByTagName('project-url')->item(0)->nodeValue,
              'details' => $node->getElementsByTagName('details')->item(0)->nodeValue
               );
        array_push($arrFeeds2, $itemRSS2);
    
        }            
    foreach ($arrFeeds2 as $aThread)
        {            
        $site_web = $aThread['project-url'];
        $details=  $aThread['details'];
        } 
    echo "<div id=\"middle\">";
    echo "<div id=\"id_user\">";
        echo "<div id=\"ident\">Nume : <b>$param2</b></div>";
    echo "</div>";
    echo "<div id=\"id_user\">";
        echo "<div id=\"ident\">Co-autor : <b>$coleg</b></div>";
    echo "</div>";
    echo "<div id=\"id_web\">";
        echo "<div id=\"ident\">Adresa Web :<br/><b><a href=\"$site_web\">$site_web</a></b></div>";
    echo "</div>";
    echo "<div id=\"id_user\">";
        echo "<div id=\"ident\">Timestamp : <b>$timestamp</b></div>";
    echo "</div>";
    echo "<div id=\"id_user\">";
        echo "<div id=\"id_remarci\">Remarci : <br/><br/><b>$details</b></div>";
    echo "</div>";
    }    
?>
</div>
</body>
</html>
