<?php
require_once __DIR__ . '/../includes/auth.php';
do_logout();
session_start();
set_flash('info', 'Anda telah keluar.');
redirect('index.php');
