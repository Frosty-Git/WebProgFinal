<?php

// Turns the first result in a select query into an associated array 
// to give us access to the fields. The index is the field name. 
function decodeSelectResults($results, $index) {
    return json_decode(json_encode($results[$index]),true);    
}
?>