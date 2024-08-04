<?php
include "assets/phpqrcode/qrlib.php";

$param = base_url() . "/app/asset_detail/" . $asset_list->Id; // remember to sanitize that - it is user input!

// we need to be sure ours script does not output anything!!!
// otherwise it will break up PNG binary!

ob_start("callback");

// here DB request or some processing
$codeText = $param;

// end of processing here
$debugLog = ob_get_contents();
ob_end_clean();

// outputs image directly into browser, as PNG stream
//QRcode::png($codeText);
QRcode::png($codeText);
