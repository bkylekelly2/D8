<?php
// src/Service/DBService.php

/**
 * @file
 * Contains Drupal\learningspaces\Service\DBService.
 */

namespace  Drupal\learningspaces\Service;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Database\Database;

class DBService {
	
 protected $Results;
	
	 public function __construct() {
	   $this->Results = $this->returnResults();
	 }
	
	 public function  getResults(){

		 return $this->Results;

	 }
	
	
	private function returnResults(){
		
		
		$request = Request::createFromGlobals();

// the URI being requested (e.g. /about) minus any query parameters
$request->getPathInfo();
	
if ($request->request->get('input_facilities')<>"") {
$f_values = $request->request->get('input_facilities');
$pos = strpos($f_values, ",");
}
	
$sqlarray = array();
	
$sql = 'SELECT room.nid FROM node room, node__field_campus_reference cID';
if ($request->request->get('input_workType')<>"") {
	$sql .= ", node__field_work_type wt";
}
if ($request->request->get('input_noiseLevels')<>"") {
	$sql .= ", node__field_noise_levels nl";
}
if ($request->request->get('input_facilities')<>"") {
	$sql .= ", node__field_facilities f";
}
if ($request->request->get('input_buildingID')<>"") {
	$sql .= ", node__field_building_reference bID";
}
//echo $sql; exit;
	
	$sql .= " WHERE room.type = :type";
	$sql .= " AND room.nid = cID.entity_id";
//echo $sql; exit;	
if ($request->request->get('input_workType')<>"") {
	$sql .= " AND room.nid = wt.entity_id";
}
if ($request->request->get('input_noiseLevels')<>"") {
	$sql .= " AND room.nid = nl.entity_id";
}
if ($request->request->get('input_facilities')<>"") {
	$sql .= " AND room.nid = f.entity_id";
}
if ($request->request->get('input_buildingID')<>"") {
	$sql .= " AND room.nid = bID.entity_id";
}
	$sql .= " AND cID.field_campus_reference_target_id = :cID";
	
if ($request->request->get('input_workType')<>"") {
	$sql .= " AND wt.field_work_type_value = :wt";
}
if ($request->request->get('input_noiseLevels')<>"") {
	$sql .= " AND nl.field_noise_levels_value = :nl";
}
if ($request->request->get('input_buildingID')<>"") {
	$sql .= " AND bID.field_building_reference_target_id = :bID";
}

if ($request->request->get('input_facilities')<>"") {
if ($pos === false) {
		
			$sql .= " AND f.field_facilities_value = :f  ";
			$sqlarray[':f'] = $f_values;	
		
	} else {
		
			$f_values = explode(",",$f_values);
			$f_count = count($f_values);

			$sql .= " AND f.field_facilities_value = :0 ";
			$sqlarray[':0'] = $f_values[0];	

			for ($x = 1; $x <= ($f_count-1) ; $x++) {
			$sql .= " AND f.field_facilities_value = :".$x."  ";
			$sqlarray[':'.$x] = $f_values[$x];	
			}
			
}
}

	
	if ($request->request->get('type')<>"") {
	$sqlarray[':type'] = $request->request->get('type');
	} else {
	$sqlarray[':type'] = 'room';
	}	
	
	if ($request->request->get('input_campus')<>"") {
	$sqlarray[':cID'] = $request->request->get('input_campus');	
	} else {
	$sqlarray[':cID'] = '433';
	}
	
	if ($request->request->get('input_workType')<>"") {
	$sqlarray[':wt'] = $request->request->get('input_workType');
	}
	
	if ($request->request->get('input_noiseLevels')<>"") {
	$sqlarray[':nl'] = $request->request->get('input_noiseLevels');	
	}
	
	if ($request->request->get('input_buildingID')<>"") {
	$sqlarray[':bID'] = $request->request->get('input_buildingID');
	}
	
	if ($request->request->get('limit')<>"") {
	$limit = $request->request->get('limit');
	} else {
	$limit = 35;	
	}
	$sql .= " LIMIT ".$limit;
		

 
// Load the list of rooms and build an array of nids to be returned rendered as a list of teasers.
$connection = Database::getConnection(); $results = $connection->query($sql, $sqlarray); //execute query
	
// Iterate results
foreach ($results as $result) {
   
	
		$nids[] .= $result->nid;
	
	
}
		

	return $nids;
		
	}
	
	 
	
}

?>