<?php
header("Content-disposition: attachment; filename=objetivos.md");
header("Content-type: application/octet-stream");
readfile("objetivos.md");
?>