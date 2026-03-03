<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}

$month = date("F-Y");
$zipname = "society_backup_" . $month . ".zip";

$zip = new ZipArchive();

if ($zip->open($zipname, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator("data"),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen(realpath("data")) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.$zipname.'"');
    header('Content-Length: ' . filesize($zipname));

    readfile($zipname);
    unlink($zipname);
    exit;
}
?>
