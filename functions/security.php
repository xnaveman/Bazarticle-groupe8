<?php
// Check if user have access to ressource, take level needed and return boolean
function check_access($level) {
    if(isset($_SESSION['numMemb'])){
        $user_level = sql_select("MEMBRE", 'numStat', "numMemb = " . $_SESSION['numMemb'])[0]['numStat'];
        if($user_level <= $level){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}