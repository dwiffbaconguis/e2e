<?php

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 10;
$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;