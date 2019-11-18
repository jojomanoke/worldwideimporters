
<?php
$db = mysqli_connect("localhost","root","","wideworldimporters");
$sql = "SELECT * FROM stockitems";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);


?>


<html>
<body>
<?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['Photo'] ).'"/>'; ?>



</body>
</html>