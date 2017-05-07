<?php

require_once 'config.php';

$connection = new PDO(DSN, DB_USER, DB_PASSWORD);

function createdb() {
  global $connection;
  $WEIGHINS = "CREATE TABLE weighins (
                  name VARCHAR PRIMARY KEY, 
                  feeling integer check(feeling BETWEEN 1 AND 5), 
                  motivation text, 
                  bodyshot_path varchar, 
                  weight integer check(weight BETWEEN 0 and 1000),
                  \"timestamp\" timestamp not null default current_timestamp
               )";
  $connection->exec($WEIGHINS);
}

function insert_weighin($name, $feeling, $motivation, $bodyshot_path, $weight) {
  global $connection;
  $INSERT = "INSERT INTO weighins 
             (name, feeling, motivation, bodyshot_path, weight) 
             VALUES (?, ?, ?, ?, ?)";
  $stm = $connection->prepare($INSERT);
  $stm->execute([$name, $feeling, $motivation, $bodyshot_path, $weight]);
}

function history_for($name) {
  global $connection;
  $stm = $connection->prepare("SELECT \"timestamp\"::date, weight FROM weighins WHERE name = ?");
  $stm->execute([$name]);
  return $stm->fetchAll(PDO::FETCH_KEY_PAIR);
}