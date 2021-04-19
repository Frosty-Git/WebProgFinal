<?php
function decodeSelectResults($results) {
    return json_decode(json_encode($results[0]),true);    
}
?>