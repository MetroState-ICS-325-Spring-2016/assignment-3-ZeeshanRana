<?php
/**
 * Created by PhpStorm.
 * User: Zeeshan
 * Date: 2/29/2016
 * Time: 5:37 PM
 */
$db_hostname = '127.0.0.1';

$db_username = 'root';

$db_password = 'zeeshan';

$db_database = 'classicmodels';

$mysql_connection = @new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($mysql_connection->connect_errno) {
    printf("Failed to connect to the MySQL database server: %s\n", $mysql_connection->connect_error);
    exit(1);
}

$query_result = $mysql_connection->query("select customers.customerName, customers.country, employees.firstName, employees.lastName
                                            from customers, employees
                                            where customers.salesRepEmployeeNumber = employees.employeeNumber
                                            order by country,customerName");

if ($query_result !== false) {
    while($row_array = $query_result->fetch_assoc()) {
        echo $row_array["customerName"] . ", " . $row_array["country"] . " - " .
            $row_array["firstName"] . " " . $row_array["lastName"] . ".\n";
    }

    // We're done with the query result set, so free it.
    // This frees up the memory the result set object was using.
    // http://php.net/manual/en/mysqli-result.free.php
    $query_result->free();
} else {
    // http://php.net/manual/en/mysqli.error.php
    echo "The query failed: $mysql_connection->error\n";
    exit(2);
}

$mysql_connection->close();
