<?php

// Database configuration.
$dbType = getenv('DB_TYPE') || "mysql";
$dbName = getenv('DB_NAME') || "fpmscraper";
$dbUser = getenv('DB_USER') || "root";
$dbPass = getenv('DB_PASS') || "root";
$dbPort = getenv('DB_PORT') || "3307";

// Google maps API key.
$GLOBALS['gmapsKey'] = getenv('GOOGLE_MAPS_KEY');

// Attempt a connection to our database.
try {
    $GLOBALS['conn'] = new PDO($dbType . ":host=127.0.0.1:" . $dbPort . ";dbname=" . $dbName, $dbUser, $dbPass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Make sure the table exists.
$sql = "SHOW TABLES LIKE 'pokemon_spawns';";
$stmt = $GLOBALS['conn']->prepare($sql);
$stmt->execute();
if(count($stmt->fetchAll()) < 1) {
    $createSql = "CREATE TABLE pokemon_spawns(id int(11) NOT NULL AUTO_INCREMENT, spawnpoint varchar(24), encounterid varchar(128), pokemonid int(11), lat double, lng double, expiration decimal(65, 0), UNIQUE(encounterid), PRIMARY KEY (id));";
    $cStmt = $GLOBALS['conn']->prepare($createSql);
    $cStmt->execute();
}