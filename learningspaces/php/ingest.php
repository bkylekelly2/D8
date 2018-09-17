<?php exit;
include("/home/library/www/html/modules/events/php/classroom.php");
use Drupal\node\Entity\Node;

//$rooms = $room_softwares; 
$rooms = $room_capabilities; 
//print_r($rooms); exit;

$total = (count($rooms)-1);
//$_upper = 1;
$_upper = 400;
	
	if ($_POST['lower']==""){
		$lower = 0;
	} else {
		$lower = (($_POST['upper']-$lower) + 1);	
	}

	if ($_POST['upper']==""){
		$upper = $_upper;
	} else {
		
		if ($total >= ($_POST['upper'] + $_upper)){
		$upper = ($_POST['upper'] + $_upper);
		} else {
			$upper = $total;
		}
		
	}
	

for ($x = $lower; $x <= $upper; $x++) {

$roomID = $rooms[$x]['room_id'];
$softwareID = $rooms[$x]['software_id'];
$capabilityID = $rooms[$x]['capability_id'];

/*
	$query = \Drupal::entityQuery('node')
	->condition('type', 'software') 
	->condition('status', 1)
	->condition('field_software_id', $softwareID, '=');
	$nid = $query->execute();

	foreach ($nid as $key1 => $val2) {
		$sID = $val2;
	}
	
*/
	
	$query = \Drupal::entityQuery('node')
	->condition('type', 'capability') 
	->condition('status', 1)
	->condition('field_capability_id', $capabilityID, '=');
	$nid = $query->execute();

	foreach ($nid as $key1 => $val2) {
		$sID = $val2;
	}

	
	
	
	
//////////////////////////////////////////////////////////

	$query = \Drupal::entityQuery('node')
	->condition('type', 'room') 
    ->condition('status', 1)
    ->condition('field_room_id', $roomID, '=');
$nid = $query->execute();
	
	foreach ($nid as $key2 => $val1) {
		$rID = $val1;
	}
	
//echo $rID; exit;
$node = \Drupal::entityManager()->getStorage('node')->load($rID); 
 
	//print_r($node->field_software_reference->getValue());
	//exit;
	//echo "<HR>";

	//exit;
	
	
//$node->field_software_reference[] = $sID; //add an element to the software reference array
$node->field_capability_reference[] = $sID; //add an element to the capability reference array
	
		try {
			$node->save();
			//$nid = $node->id;
			echo "save successful for: ". $x ." ". $roomID . " & ". $sID .'<BR>';
			//print_r($room)."<BR>";
			echo  "<HR>";
		}
		catch (Exception $e) {
			echo "problem". '<BR>';
		}

//$node->field_code_used_by[] = $user_id;
//print_r($node);
	
	

	$node = "";

}

?>

<form action="/node/14" method="post" id="formtopost" name="formtopost">
	<input type="text" id="lower" name="lower" value="<?php echo $lower; ?>">
	<input type="text" id="upper" name="upper" value="<?php echo $upper; ?>">
</form>

<?php 
if  ($lower<=$upper){
		if ($upper==1){
			break;
		}
?>
<script> 

window.onload = function(e){ 
    document.getElementById("formtopost").submit();
}

</script>
<?php } ?>