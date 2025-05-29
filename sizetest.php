<?php

// 現在のスクリプトが存在するディレクトリのパス取得
$currentDir = __DIR__;

// ファイルやディレクトリのサイズ計算関数
function calculateDirectorySize($alldir) {
    $totalSize = 0;
    $fileitems = scandir($alldir);
    foreach ($fileitems as $fileitem) {
        if ($fileitem === '.' || $fileitem === '..') {
            continue;
        }
        $checkdirpath = $alldir . '/' . $fileitem;
        if (is_file($checkdirpath)) {
            $totalSize += filesize($checkdirpath);
        } elseif (is_dir($checkdirpath)) {
            // サブディレクトリのサイズ計算
            $totalSize += calculateDirectorySize($checkdirpath);
        }
    }
    return $totalSize;
}

// バイト変換関数
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, $precision) . ' ' . $units[$i];
}

// サブディレクトリのサイズ計算関数
function outputSubdirectorySizes($baseDir) {
    echo "Subdirectory Sizes:";
    echo "<ul>";
    $subitems = scandir($baseDir);
    foreach ($subitems as $subitem) {
        if ($subitem === '.' || $subitem === '..') {
            continue;
        }
        $subDirPath = $baseDir . '/' . $subitem;
        if (is_dir($subDirPath)) {
            $sizeBytes = calculateDirectorySize($subDirPath);
            $sizeFormatted = formatBytes($sizeBytes);
            echo "<li>" . htmlspecialchars($subitem) . ": " . htmlspecialchars($sizeFormatted) . "</li>";
        }
    }
    echo "</ul>";
}

// 各関数実行
// ディレクトリのサイズ計算実行
$directorySizeBytes = calculateDirectorySize($currentDir);
// バイト変換実行
$directorySizeFormatted = formatBytes($directorySizeBytes);

// 画面に出力 (現在のディレクトリの合計サイズ)
echo "This directory: " . htmlspecialchars($currentDir) . "<br>";
echo "Total size of this directory (including subdirectories): <br><ul><li>" . htmlspecialchars($directorySizeFormatted) . "</li></ul><br>";

// サブディレクトリの容量を出力
outputSubdirectorySizes($currentDir);

?>