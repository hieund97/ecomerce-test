<?php

function generateVariant($data){
    $aryVariant = [];
    foreach ($data as $type => $aryValue) {
        if (!empty($aryValue)) {
            foreach ($aryValue as $k => $value) {
                if(isset($data[$type+1])){
                    foreach ($data[$type+1] as $t => $nextValue) {
                        $aryVariant[] = [
                            $value, $nextValue
                        ];
                    }
                }
            }
        }
    }

    return $aryVariant;
}
