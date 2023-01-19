<?php
/*
 * Tom Falcone
 * csv_combiner: A class to read CSV files from addresses on cammand line and concatenate them by rows, adding a columen
 *               for the file name of all non-header rows.
 * 1/18/23
 */

class csv_combiner {
    public function __construct()
    {

    }

    public static function combineCSV() {
        global $argv;
        global $argc;
        // loop through all arguments
        for($i=1; $i < $argc; $i++) {
            // open file given by each successive argument (which should be a filename)
            if (($fileptr = fopen($argv[$i], "r")) !== FALSE) {
                // keep track of records read
                $count = 0;
                // use a memory object to write the data to (collect data to store
                //        $csv = fopen('php://temp/maxmemory' . (5*1024*1024), 'a+');
                while (($data = fgets($fileptr, null)) !== FALSE) {
                    // clean the data to remove quotes within data items, which interfere with csv format
                    $data = str_replace("\\\"", "'", $data);
                    // strip newline, tab, return, \0 from end of string
                    $data = trim($data);

                    // for first element read
                    if($count === 0) {
                        // if it's the first record, get the header and print it
                        if($i === 1) {
                            $data = $data . ",\"filename\"". PHP_EOL;
                            $count++;
                            //                    $str_arr = explode(",", $data);

                            //                    fputcsv($csv, $str_arr, ",");
                            print_r($data);
                        } else {
                            // otherwise, don't print header for next csv file
                            $count++;
                            continue;
                        }

                    } else {
                        // if it's not a header row, split the argv (file address) by slashes
                        $fileAddr = explode("\\", $argv[$i]);
                        // get the last element of that array, which is the filename
                        $fileAddr = $fileAddr[count($fileAddr)-1];
                        // concat the data, adding an EOL character
                        $data = $data .",\"" . $fileAddr . "\"" . PHP_EOL;
                        $count++;
                        //                $str_arr = explode(",", $data);

                        //                fputcsv($csv, $str_arr, ",");
                        // print the data
                        print_r($data);
                    }


                }
                // close the last fileptr
                fclose($fileptr);
            }
            //    rewind($csv);
            //    fclose($csv);
        }
        return true;
    }

}

// call the function to run it
csv_combiner::combineCSV();
?>
