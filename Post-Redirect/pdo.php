<?php
$pdo = new PDO('mysql:host=localhost;port=8889;dbname=misc', 'dengnan', 'pass');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);