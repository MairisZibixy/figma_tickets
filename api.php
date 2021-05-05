<?php

header('Content-type: application/json');

include "DB.php";
$db = new DB('localhost', 'root', 'root', 'contact_management');

$db->fetchAll('tickets');

$data = $db->getAll();

if (is_array($data)) {
    foreach ($data as &$row) {
        if (array_key_exists('priority', $row)) {
            switch ($row['priority']) {
                case 1:
                    $row['priority'] = 'low';
                    break;
                case 2:
                    $row['priority'] = 'normal';
                    break;
                case 3:
                    $row['priority'] = 'high';
                    break;
            }
        }

        if (array_key_exists('date_time', $row)) {
            $datatime = new Datetime($row['date_time']);
            $row['date'] = $datatime->format('M d, Y');
            $row['time'] = $datatime->format('h:i A');
            unset($row['date_time']);
        }
    }
}


echo json_encode(array_values($data));
