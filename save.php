<?php
$contenido = $_REQUEST["contenido"];
$link = new PDO("mysql:host=localhost;dbname=wysiwyg",
                "root","");
$statement = $link->prepare("INSERT INTO post(contenido)
                            Values(:contenido)");
$statement->execute(["contenido" => "$contenido"]);