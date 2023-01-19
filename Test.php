<?php
/* Test.php:  a skeleton of a testing class for csv_conbiner.
 *            My consideration of the tests that are needed are commented.
 */

use PHPUnit\Framework\TestCase;

final class Test extends TestCase
{
    public function testNumCols() {
        $combo = new csv_combiner();

        // test num columns = 1 + num columns in args

    }

    public function testNumRows() {
        // Test that num rows = wum of rows in all csv files
    }

    public function testCleanData() {
        // test that data doesn't have double-quotes or slashes
    }

    public function testErrorHandling() {
        // test output handles empty csv files or no arguments gracefully
        // test that class handles fileNotFound gracefully
        // test that class
    }
}

?>