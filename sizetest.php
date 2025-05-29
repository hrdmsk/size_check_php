<?php

// 現在のスクリプトが存在するディレクトリのパス取得
$currentDir = __DIR__;

// ディレクトリ内のファイルとディレクトリのサイズ計算関数
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


//各関数実行
// ディレクトリのサイズ計算実行
$directorySizeBytes = calculateDirectorySize($currentDir);
// バイト変換実行
$directorySizeFormatted = formatBytes($directorySizeBytes);

// 画面に出力
echo "This directory: " . htmlspecialchars($currentDir) . "<br>";
echo "Total size of this directory: " . htmlspecialchars($directorySizeFormatted) . "<br>";

?>
