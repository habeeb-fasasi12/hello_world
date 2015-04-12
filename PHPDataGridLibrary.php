<?php
class PHPDataGrid{
  var $Classconnect_no;
  var $Classquery2;
 
 function DataGrid($phost_ip,$pusername,$ppassword,$pdbname,$ptablename,$plimit,$pFieldNameArray,$pWebAddressName)
  {
    global $host_ip,$username,$password,$dbname,$tablename,$limit,$FieldNameArray,$WebAddressName;
      $host_ip =$phost_ip;
	  $username = $pusername;
	  $password = $ppassword;
	  $dbname = $pdbname;
	  $tablename = $ptablename;
	  $limit = $plimit;
	  
	  if($limit == 0)
	  $limit=5;
	  
	  $FieldNameArray = $pFieldNameArray;
	  
	  if(!$FieldNameArray)
	  {
	  global $FieldNameArray;
	  $FieldNameArray = array();
	  }
	  
	  $WebAddressName = $pWebAddressName;
		 						
    // "Session" function is called by the following code 
    $this -> Session();
                                    
    echo"<link rel='shortcut icon' href='Sourcefile/BEASTS.ICO' />";
  global $baslangic,$sql;

  $_SESSION["pWebAddressName"]= $WebAddressName;
   
  $_SESSION["host_ip"] = $host_ip;
  $_SESSION["username"] = $username;
  $_SESSION["password"] = $password;
  $_SESSION["dbname"] = $dbname;
  $_SESSION["tablename"] = $tablename;

  $_SESSION["FieldNameArray"] = $FieldNameArray;

     $ArrayCount=count($FieldNameArray);
	 
    // "connect" function is called by the following code
    $this -> connect($host_ip,$username,$password,$dbname );
	
     $sql="SELECT * FROM $tablename";
	       // "Query" function is called by the following code
             $this -> Query($sql,$this ->Classconnect_no);
	                          	
	 global $FieldNameIndex;
     $FieldNameIndex = mysql_field_name($this ->Classquery2, 0);
     $sql="SELECT count($FieldNameIndex) AS data_count FROM $tablename";
             
	 // "Query" function is called by the following code
             $this ->Query($sql,$this ->Classconnect_no);

    //Pagination
     $number_of_rows=mysql_fetch_array($this ->Classquery2); 
     $number_of_pages=$number_of_rows[0]/$limit; # Determination for the number of pages
   

     $baslangic=$_GET["id"]*$limit; 
     $sql="select * from $tablename order by $FieldNameIndex asc LIMIT $baslangic,$limit";

     // "Query" function is called by the following code
             $this -> Query($sql,$this ->Classconnect_no);


    echo"<html><head><title>DataGrid</title>";
    echo "<script language='javascript' src='CssJavaScript.js'></script>"; 
    echo"<link rel='stylesheet' href='style.css'/>";
    echo" </head>";
    echo"<body>";
    echo"<br>";
    echo"<br>";
    echo"<form name='form1' method='POST' action='$WebAddressName.php'>";
	
    echo" <table class='hilite' id='highlight' border='1' Style='font-family : Verdana; font-size:12pt; border:1 solid #808080' cellspacing='0' cellpadding='0'>"; 
	
    echo "<tr>";
   
    echo "  <A title='AddNewData'   href='$WebAddressName.php?Add=1' >";
	
    echo " <IMG  src='Sourcefile/create.png'>Add New Data</A>";  
    echo "  <A title='ResetTable' href='$WebAddressName.php' >";
    echo "<IMG  src='Sourcefile/reset.png'>Reset Table</A>  ";
    echo " </tr>";
    echo "<THEAD >	";
	
    echo "<tr bgcolor='#9999CC' >";

 $counterFinish=mysql_num_fields($this ->Classquery2);
   
            if($ArrayCount==0)
			             {
    for($counter=0;$counter<$counterFinish;$counter++)
      { 
	$FieldName = mysql_field_name($this ->Classquery2, $counter);
    echo"<td> &nbsp; $FieldName &nbsp; </td>\n";  
      }
	                      }
						  else
						  {
						  for($counterArray=0;$counterArray<$ArrayCount;$counterArray++)
	                            {
	                      $FieldName = mysql_field_name($this ->Classquery2, $FieldNameArray[$counterArray]);
                           echo"<td> &nbsp; $FieldName &nbsp; </td>\n";    

	                            }
						  }
	
	echo "<td>&nbsp; &nbsp; </td>";
	echo "<td>&nbsp; &nbsp; </td>";
    echo "</font>";	
    echo "</tr>"; 
    echo"</THEAD>";
    echo"<TBODY>"; 
	global	$OperationEdit,$OperationDelete, $pageId,$id;
	$id=0;
	$id=trim($_GET[id]);
    if($id=="")
    $id=0;	
	$OperationEdit=1;
	$OperationDelete=2;
	
	$pageId=0;
    $i=0;
	
 While($sira=mysql_fetch_row($this ->Classquery2))
  {
	echo "<tr>";
	
	   if($ArrayCount==0)
	      {
          for($counter=0;$counter<$counterFinish;$counter++)
	         {
	        echo"<td > &nbsp; ".$sira[$counter]." &nbsp; </td> \n";   
             } 
	      }
	   else
		  {
		 for($counterArray=0;$counterArray<$ArrayCount;$counterArray++)
	        {	                      
			echo"<td > &nbsp; ".$sira[$FieldNameArray[$counterArray]]." &nbsp; </td> \n";   
	        }
		  }
	               
	echo" <td><A  href='$WebAddressName.php?id=".$id."&id2=".$sira[0]."&op=".$OperationEdit."' name='EDIT'  id='$sira[0]' type='button'><IMG   title=Edit alt=Edit src='Sourcefile/edit.png' ></A>";
    echo"<td><A   href='$WebAddressName.php?id=".$id."&id2=".$sira[0]."&op=".$OperationDelete."' name='DELETE'  id='$sira[0]' type='button'><IMG  title=Delete alt=Delete src='Sourcefile/delete.png'></A></td>";
         
		$this -> getURL();
		 
		 if($_GET['id2']==$sira[0] && $_GET['op']==2)
            {
          $sql="delete from $tablename where $FieldNameIndex=$sira[0]";
          // "Query" function is called by the following code
             $this -> Query($sql,$this ->Classconnect_no);

         $sql="select * from $tablename order by $FieldNameIndex asc LIMIT $baslangic,$limit";
         // "Query" function is called by the following code
             $this -> Query($sql,$this ->Classconnect_no);
			 //$ReplaceAddress="$WebAddressName.php";
			 
			 
			//echo '<script type="text/javascript"> var ReplaceAddressName ="$WebAddressName" + ".php";</script>';
    echo '<script type="text/javascript"> window.onload=function(){window.location.replace(get,"","");} </script>' ; 

            }
			
	   if($_GET['id2']==$sira[0] && $_GET['op']==1)
            {
	     global $EditId;
	     $EditId=$sira[0];	
	     $sql="select * from $tablename where $FieldNameIndex='$EditId'";	
        $this -> popupWindowEdit($sql,$EditId);
            } 
	echo    "<tr>\n";	
  }
	echo"</TBODY>";
	echo"<TFOOT>";	
	echo"</TFOOT>";
    echo "</table><br>";
		   
  while($i<$number_of_pages)
	{	   
	$value=$pageId +1;
	   
	echo  " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$WebAddressName.php?id=$pageId\">$value</a>"; #ekrana sayfa sayýsý kadar 0 dan baþlayarak rakam(link) yazdýrýyorum tabiki sql sorguma etki etsin diye id deðerleride var
	$id=$_GET['id'];  
	$i++;
	$pageId++;
		
	}

   echo"</form>";

     if($_GET['Add']==1)
        {
       $this -> popupWindowRegister();
   
       }

    echo"</body></html>";
	
	
	}//close of the "DataGrid" function 
	
	function getURL()
	{
	 echo '<script type="text/javascript"> 
			 var url = window.location.href 
			 var parts = url.split("?")
			
			 var get = parts[0]
			 document.cookie=get
             </script>';
			 

	}
	function Session()
           {
          session_start();
           }
		   
        function popupWindowRegister()
           {
         echo '<script type="text/javascript"> window.onload=function(){window.open("Register.php",""," width = 450, height = 360");} </script>' ; 
           } 
    
	    function popupWindowEdit($sql,$EditId)
           {
        $EditId2=$EditId;
        $_SESSION["product1"] = $EditId2;
        echo '<script type="text/javascript"> window.onload=function(){window.open("Edit.php",""," width = 450, height = 360");} </script>' ; 
   
           }
   
        function connect($host_ip,$username,$password,$dbname )
           {
         global $connect_no;
           $connect_no=mysql_connect($host_ip, $username, $password); #buradan asagisi standart sql baglantisi
	         if(!$connect_no)
                {
	          echo "Now,don't connect to database server!";
              exit();
                }
              else
			    {
                  $this ->Classconnect_no = $connect_no;
                }				  
	         if(!@mysql_select_db($dbname, $connect_no))
                {
               echo " Now,don't connect to database! ";
               exit();
                 }
           mysql_query("SET NAMES 'utf8'");#bu kod sql den alinan kodlari türkçe karakter sorunundan kurtariyor tabi mysql de de tablolar utf8 turkçe seçilmeli.
           }

        function Query($sql,$connect_no)
            {
        global $query2;
       $query2=@mysql_query($sql,$connect_no);
	
        if(!$query2)
         { 
	     echo "Wrong a sql query!. <br>",
         $connect_no , $sql."<br>";
         exit();
         }
		 else
		 {
		 $this ->Classquery2 = $query2;
		 }
		    }
  
		
		
}//close of the DataGridClass
?>
