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

    // Make sure data folder exists
    if (is_dir("data")) {

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator("data"),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {

            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen(realpath("data")) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    $zip->close();

    // Download ZIP
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($zipname) . '"');
    header('Content-Length: ' . filesize($zipname));
    readfile($zipname);

    // Delete zip after download
    unlink($zipname);

    exit();

} else {
    echo "Backup failed!";
}
