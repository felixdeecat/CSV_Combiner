// csvCombiner.php
// A first try at the problem. There is a problem with dirty data (a quote that remains after attempted cleaning).
// I am keeping this as an accumulation of the attempts I made in producing a working solution.
// Tom Falcone
// 1/18/2023

<?php

if (PHP_SAPI != "cli") {
    exit("Designed for CLI use only");
}

$row = []; // empty array
// read each cmd line arg
$output = "";
$csv = null;
for($i=1; $i < $argc; $i++) {
    if(($fileptr = fopen($argv[$i], "r")) !== FALSE) {
        $count = 0;
        $csv = fopen('php://temp/maxmemory' . (5*1024*1024), 'a+');
        while(($data = fgetcsv($fileptr, null, ",")) !== FALSE) {
            if($count === 0) {
                if($i === 1)
                {
                    $row[$count] = $data;
                    $row[$count][count($data)] = "filename";
//                    $output = json_encode($row[$count]);
                    array_walk($row[$count], function(&$val) {str_replace(['\\"'], "'", $val);});
                    fputcsv($csv, array_values($row[$count]), ",");

//                    print_r($row[0] . ", " . $row[1] . ", " .  $row[2] . PHP_EOL);
//                    $output = implode(", ", $row[$count]);
//                    print($output . PHP_EOL);
//                    print_r($row[$count]);

                }
                $count++;
            }
            else {
            $fileAddr = explode("\\",$argv[$i]);
            $row[$count] =$data;
            $row[$count][count($data)]= $fileAddr[count($fileAddr)-1];
//            $output = json_encode($row[$count]);
            array_walk($row[$count], function(&$val) {$val = str_replace(['\\"'], "'", $val);});

            fputcsv($csv, array_values($row[$count]), ",");

//            $output = implode(", ", $row[$count]);
//            print($output .PHP_EOL);
//            print_r($row[$count]);
//            print_r($row[0] . ", " . $row[1] . ", " .  $row[2] . PHP_EOL);
            }
            $count++;
            //print_r($data[0] . PHP_EOL);
//            print_r($data);
//            $num = count($data);
//            for($c = 0; $c < $num; $c++) {
//                print( $data[$c] . PHP_EOL);
//            }
        }
        fclose($fileptr); // close the file
    }
    rewind($csv);

    $result = stream_get_contents($csv);
    fclose($csv);

    print_r($result);

//    $out = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');
//    fputcsv($out, $row);
//    rewind($out);
//
//    $output = stream_get_contents($out);
//
//    print_r(rtrim($output));


//    $headers = array_shift($rows);
//    print_r($headers);
}


?>