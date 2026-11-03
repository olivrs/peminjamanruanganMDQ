<?php
// Bridge between Vercel Serverless Function and CodeIgniter 3
$_SERVER['SCRIPT_NAME'] = '/index.php';
chdir(__DIR__ . '/..');
require __DIR__ . '/../index.php';
