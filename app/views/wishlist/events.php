<?php
// events.php

// Fetch events data from a database or any other data source
$events = [
    [
        'title' => 'Event 1',
        'start' => '2024-03-01'
    ],
    [
        'title' => 'Event 2',
        'start' => '2024-03-05'
    ]
];

// Output events data in JSON format

echo json_encode($events);
?>