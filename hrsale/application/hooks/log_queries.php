<?php
/*// NOTE: buat log query by luffy*/
function log_queries(){
	$CI =& get_instance();
	$times=$CI->db->query_times;
	// foreach($CI->db->queries as $key=>$query){
  //  // modif di sini
	// 	echo "Query: ". $query." | ".$times[$key] . "<br />";
	// }
	$CI->output->_display();
}
?>
