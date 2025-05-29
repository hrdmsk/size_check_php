<?php

// 現在のスクリプトが存在するディレクトリのパス取得
$currentDir = __DIR__;

// ディレクトリ内のファイルとディレクトリのサイズ計算関数
function calculateDirectorySize($dir) {
    $totalSize = 0;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . '/' . $item;
        if (is_file($path)) {
            $totalSize += filesize($path);
        } elseif (is_dir($path)) {
        	// サブディレクトリのサイズ計算
            $totalSize += calculateDirectorySize($path); 
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
echo "ディレクトリ: " . htmlspecialchars($currentDir) . "<br>";
echo "このディレクトリの合計サイズ: " . htmlspecialchars($directorySizeFormatted) . "<br>";

?>
