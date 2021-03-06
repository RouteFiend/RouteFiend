<?php
function genTime($toOrFrom,$time,$period) {
   if ($toOrFrom == 0) {
      $ts = 'timeSelectFrom[]';
      $periodName = 'periodFrom';
      $periodID = 'periodFrom[]';
  }
  elseif ($toOrFrom == 1) {
      $ts = 'timeSelectTo[]';
      $periodID = 'periodTo[]';
  }
  $output = "\n"."<select class='input-mini' name='$ts' id='ts'>"."\n";
  for ($i=1; $i < 13; $i++) {
     for ($j=0; $j < 60; $j = $j + 15) { 
        $timeOption = ($j == 0 ? $i.":00" : $i.":".$j);
        if ($timeOption == $time) {
            $output .= ($j == 0 ? "<option selected='selected' value='$i:00'>$i:00</option>" : "<option selected='selected' value='$i:$j'>$i:$j</option>");
        }
        else {
            $output .= ($j == 0 ? "<option value='$i:00'>$i:00</option>" : "<option value='$i:$j'>$i:$j</option>");
        }
        $output .= "\n";
    }
}
$output .= "</select> \n <select class='input-mini' name='$periodID' id='$periodID'> \n";


if ($period == 'am') {
    $output .= "<option selected='selected' value='am'>am</option>";
    $output .= "<option value='pm'>pm</option>";
    $output .= "\n";

}
else {
    $output .= "<option selected='selected' value='pm'>pm</option>";
    $output .= "<option value='am'>am</option>";
    $output .= "\n";
}
$output .= "</select> \n";
return $output;
}
function genSelect($ft,$fp,$tt,$tp) {
   $in = genTime(0,$ft,$fp);
   $out = genTime(1,$tt,$tp);
   return $in.'<span class="toto"><i class="icon-arrow-right"> </i>    </span>'.$out;

}
function genTimeDefault($s) {
    if ($s == 0) {
        $ts = 'timeSelectFrom[]';
        $periodName = 'periodFrom';
        $periodID = 'periodFrom[]';
    }
    elseif ($s == 1) {
        $ts = 'timeSelectTo[]';
        $periodID = 'periodTo[]';
    }
    $output = "\n"."<select class='input-mini'name='$ts' id='$ts'>"."\n";
    for ($i=1; $i < 13; $i++) {
        for ($j=0; $j < 60; $j = $j + 15) { 
            $output .= ($j == 0 ? "<option value='$i:00'>$i:00</option>" : "<option value='$i:$j'>$i:$j</option>");
            $output .= "\n";
        }
    }
    $output .= "</select> \n <select class='input-mini'name='$periodID' id='$periodID'> \n";

    for ($m = 0; $m < 2; $m++) {
        $output .= ($m == 0 ? "<option value='am'>am</option>" : "<option value='pm'>pm</option>");
        $output .= "\n";

    }
    $output .= "</select> \n";
    return $output;
}
function genSelectDefault() {
    $in = genTimeDefault(0);
    $out = genTimeDefault(1);
    return $in;
}
function finGenTime() {
    $output = "<select style='width:70px;'class='input-small' name='time[]' id='ts'>"."\n";
    for ($i=0; $i < 24; $i++) {
        for ($j=0; $j < 60; $j = $j + 15) { 
            if($j == 0 && $i < 10) {
                $output .= "<option value='0$i:00'>0$i:00</option>";
            }
            else if($j == 0) {
                $output .= "<option value='$i:00'>$i:00</option>";
            }
            else if($i < 10) {
                $output .= "<option value='0$i:$j'>0$i:$j</option>";
            }
            else {
                $output .=  "<option value='$i:$j'>$i:$j</option>";
            }
            $output .= "\n";
        }
    }
    $output .= "</select>";
    return $output;
}

function finGenSelTime($selected) {
    $output = "<select style='width:70px;' class='input-small' name='time[]' id='ts'>"."\n";
    for ($i=0; $i < 24; $i++) {
        for ($j=0; $j < 60; $j = $j + 15) { 
            if($j == 0 && $i < 10) {
                $vals = "0$i:00";
            }
            else if($j == 0) {
                $vals = "$i:00";
            }
            else if($i < 10) {
                $vals = "0$i:$j";
            }
            else {
                $vals ="$i:$j";
            }
            if ($vals == $selected) {
                $output .=  "<option selected='selected' value='$vals'>$vals</option>";
            }
            else {
                $output .=  "<option value='$vals'>$vals</option>";
            }
            $output .= "\n";
        }
    }
    $output .= "</select>";
    return $output;
}
function isPost($postcode) {
    $postcode = strtoupper($postcode);
    $postcode = preg_replace('/[^A-Z0-9]/', '', $postcode);
    $postcode = preg_replace('/([A-Z0-9]{3})$/', ' \1', $postcode);
    $postcode = trim($postcode);

    if (preg_match('/^[a-z](\d[a-z\d]?|[a-z]\d[a-z\d]?) \d[a-z]{2}$/i', $postcode)) {
        return true;
    } else {
        return false;
    }
}
?>