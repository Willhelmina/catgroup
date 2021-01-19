<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if(!$conn)
{
  echo "Connection Failed";
}

mysqli_select_db($conn,"cattool");

mysqli_query($conn,"set names utf8");

session_start();

?>

<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style>
			#content-0
			{
				position:absolute;
				top:-680px;
				left:300px;
				
			}
		</style>
	</head>

<body>
	
	<script type="text/javascript" src="/meowcat/Resources/js/PM_navigation.js"></script>
		<div id="content-0">
			<div class="container-fiuled col-md-10" style="width:1000px;>
    <?php 
    mysqli_select_db($conn,"cattool"); //连接数据库

    mysqli_query($conn,"set names utf8"); //防止乱码
    $pageSize = 10;
			

    if (isset($_GET['page']) && $_GET['page'] >1) {
        $pageVal = $_GET['page'];
    }else {
        $pageVal = 1;
    }
    //计算起始位置
   $page = ($pageVal-1)*$pageSize;
    ?>
    <div class="container-fluid">
    <?php
			$flag=0;
            $res=mysqli_query($conn,"select * from teamtm");
            $numrows = mysqli_num_rows($res);
			$pageNum = ceil($numrows/$pageSize);

	      $result = mysqli_query($conn,"select `ID`,`source`,`target`,`project_id`,`file_id` FROM teamtm limit $page,$pageSize");
		//}
		if($pageVal <=3){
			$begin =1;
			$end = $pageNum>=5?5:$pageNum;
		}else{
			$end = $pageVal+2>=$pageNum?$pageNum:$pageVal+2;
			$begin =$end -4<=1?1:$end -4; 
		}
		$prev = $pageVal -1<=1?1:$pageVal-1;
        $next = $pageVal +1 >=$pageNum?$pageNum:$pageVal +1;

    echo "<table class='table table-bordered table-hover text-center' id='txtHint'>";
    echo "<thead>";
    echo "<tr class='active'>";
    echo "<th class='text-center'>ID</th>";
    echo "<th class='text-center'>Source</th>";
    echo "<th class='text-center'>Target</th>";
    echo "<th class='text-center'>Project</th>";
    echo "<th class='text-center'>File</th>";
    echo "<th class='text-center' style='width: 100px;'>操作</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
	if($result){
    	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {  
            echo "<tr>";
            echo "<td>".$row['ID']."</td>";
            echo "<td>".$row['source']."</td>";
            echo "<td>".$row['target']."</td>";
            echo "<td>".$row['project_id']."</td>";
            echo "<td>".$row['file_id']."</td>";
            echo "<td><button class='btn btn-primary btn-xs' onclick=''>导出</button></td>";
            echo "</tr>";
            }  

    echo "</tbody>";
    echo "</table>\n";}

    ?>

            <nav class='text-center'>
                            <ul class='pagination'>
                                <li>
                                    <a href="?page=<?php echo $prev; ?>">
                                        <span>&laquo;</span>
									</a>
								</li>
 
					<?php 
					for($i=$begin;$i<=$end;$i++){
						if($pageVal==$i){
							echo "<li class='active'><a href='?page=$i'>".$i."</a></li>";
						}
						else {
							echo "<li><a href='?page=$i'>".$i."</a></li>";
						}
					}
					?>
								<li>
                                    <a href="?page=<?php echo $next; ?>" aria-label='Next'>
                                        <span aria-hidden='true'>&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                         </nav>
			</div>
		</div>

</body>
</html>
