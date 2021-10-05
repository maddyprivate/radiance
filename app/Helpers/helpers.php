<?php
if (! function_exists('dmyDate')) {
    function dmyDate($paramDate) {
        return date('d/m/Y',strtotime($paramDate));
    }
}
?>