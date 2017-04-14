<?php
require_once('config.php');
// prepare the tag cloud array for display
$word='';

$terms = array(); // create empty array
$maximum = 0; // $maximum is the highest counter for a search ter
$sql = "SELECT * FROM WordCloud ORDER BY Counter";
$result = $conn -> query($sql);

$Q1="select Term,Counter from WordCloud order by Counter"; 
$Q1prep=$dbconn->prepare($Q1);
$Q1prep->execute();
$Q1res=$Q1prep->fetchAll(PDO::FETCH_ASSOC);
 if(isset($_POST['searchmedia']))
 {
    $word=$_POST['search'];
	
	
 }
  if(!empty($_GET['word']))
  {
	  $word = $_GET['word'];
  }	  
    $temp=0;
    foreach ($Q1res as $key => $value) {
        if($value['Term']==$word){
            $count=$value['Counter']+1;
        $Q1="update WordCloud set Counter='$count' where Term='$word'";
        $Q1prep=$dbconn->prepare($Q1);
        $Q1prep->execute();
        $temp=1;
        }
  
    }
    if($temp==0){
    $Q1="insert into WordCloud(Term,Counter)values('$word','1')";
    $Q1prep=$dbconn->prepare($Q1);
    $Q1prep->execute();
    }
 
// shuffle terms unless you want to retain the order of highest to lowest
$Q3="select Term,Counter from WordCloud order by Counter desc LIMIT 10"; 
$Q3prep=$dbconn->prepare($Q3);
$Q3prep->execute();
$Q3res=$Q3prep->fetchAll(PDO::FETCH_ASSOC);
$Q2="select Counter from WordCloud order by Counter desc limit 1"; 
$Q2prep=$dbconn->prepare($Q2);
$Q2prep->execute();
$Q2res=$Q2prep->fetchAll(PDO::FETCH_ASSOC);
$maximum=$Q2res[0]['Counter'];

?>
<html>
    <head>
        <title>Tag Cloud Example</title>
        <style type="text/css">
            #tagcloud {
				margin-left:25%;
                width: 300px;
                background:#CFE3FF;
                color:#0066FF;
                padding: 10px;
                border: 1px solid #559DFF;
                text-align:center;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                border-radius: 4px;
            }

           #tagcloud a:visited {
                text-decoration:none;
                color: #333;
            }

            #tagcloud a:hover {
                text-decoration: underline;
            }

            #tagcloud span {
                padding: 4px;
            }

            #tagcloud .smallest a{
                font-size: 10px;
                color:yellow;
            }

            #tagcloud .small a{
                font-size: 15px;
                color:blue;
            }

            #tagcloud .medium a{
                font-size:20px;
                color:red;
            }

            #tagcloud .large a{
                font-size:25px;
                color:black;
            }

            #tagcloud .largest a{
                font-size:30px; 
                color:orange;  
            }
        </style>
    </head>

    <body>
        
        <div id="tagcloud">
            <?php 
           foreach ($Q3res as $key => $value) {
                // determine the popularity of this term as a percentage
                $percent = floor(($value['Counter'] / $maximum) * 100);

                // determine the class for this term based on the percentage
                if ($percent < 20)
				{$class = 'smallest';
					?><div class="smallest">
              <a href="searchmedia.php?word=<?php echo $value['Term']; ?>"> <p> <?php echo $value['Term']; ?> </p></a></div>
            <?php } 
                    
                elseif ($percent >= 20 and $percent < 40)
                    {$class = 'small';
					?><div class="small">
              <a href="searchmedia.php?word=<?php echo $value['Term']; ?>"> <p> <?php echo $value['Term']; ?> </p></a></div>
            <?php } 
                elseif ($percent >= 40 and $percent < 60)
                    {$class = 'medium';
					?><div class="medium">
              <a href="searchmedia.php?word=<?php echo $value['Term']; ?>"> <p> <?php echo $value['Term']; ?> </p></a></div>
            <?php } 
                elseif ($percent >= 60 and $percent < 80)
                    {$class = 'large';
					?><div class="large">
              <a href="searchmedia.php?word=<?php echo $value['Term']; ?>"> <p> <?php echo $value['Term']; ?> </p></a></div>
            <?php } 
                else
                    {$class = 'largest';
					?><div class="largest">
              <a href="searchmedia.php?word=<?php echo $value['Term']; ?>"> <p> <?php echo $value['Term']; ?> </p></a></div>
		   <?php } }
            ?>
                
        </div>
    </body>
</html>
