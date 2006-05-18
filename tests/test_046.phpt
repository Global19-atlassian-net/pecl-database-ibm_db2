--TEST--
IBM-DB2: db2_fetch_array() - several rows 4
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php

require_once('connection.inc');

$conn = db2_connect($db,$username,$password);
//$_GET['EMPNO'] = '000130';

if (isset($_GET['EMPNO']) && isset($_GET['FORMAT'])) {
	$result = db2_exec($conn, "select photo_format, picture, length(picture) from emp_photo where photo_format='" . $_GET['FORMAT'] . "' and empno='".$_GET['EMPNO']."'");
	$row = db2_fetch_array($result); 			
	if ($row) {
		// We'll be outputting a 		
		header('Content-type: image/'. $row[0]);
		header('Content-Length: '. $row[2]);
		echo $row[1];			
	}
	else {
		echo $db2_error();			
	}
	exit();
}
else {
	$result = db2_exec($conn, "select EMPNO, PHOTO_FORMAT, length(PICTURE) from emp_photo");	
	while ($row = db2_fetch_array($result)) {
		if( $row[1] != 'xwd' ) {
			printf ("<a href='test_046.php?EMPNO=%s&FORMAT=%s' target=_blank>%s - %s - %s bytes</a><br>",$row['0'], $row[1], $row['0'], $row[1], $row[2]);
			print "\n";
		}
	}
}

?>
--EXPECT--
<a href='test_046.php?EMPNO=000130&FORMAT=bitmap' target=_blank>000130 - bitmap - 43690 bytes</a><br>
<a href='test_046.php?EMPNO=000130&FORMAT=gif' target=_blank>000130 - gif - 29540 bytes</a><br>
<a href='test_046.php?EMPNO=000140&FORMAT=bitmap' target=_blank>000140 - bitmap - 71798 bytes</a><br>
<a href='test_046.php?EMPNO=000140&FORMAT=gif' target=_blank>000140 - gif - 29143 bytes</a><br>
<a href='test_046.php?EMPNO=000150&FORMAT=bitmap' target=_blank>000150 - bitmap - 73438 bytes</a><br>
<a href='test_046.php?EMPNO=000150&FORMAT=gif' target=_blank>000150 - gif - 39795 bytes</a><br>
<a href='test_046.php?EMPNO=000190&FORMAT=bitmap' target=_blank>000190 - bitmap - 63542 bytes</a><br>
<a href='test_046.php?EMPNO=000190&FORMAT=gif' target=_blank>000190 - gif - 36088 bytes</a><br>

