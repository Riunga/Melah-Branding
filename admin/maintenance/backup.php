<?php
class DatabaseBackup {
    public static function createBackup() {
        $config = require __DIR__ . '/../config/secure_config.php';
        $date = date('Y-m-d_H-i-s');
        $backupFile = __DIR__ . "/../backups/backup_{$date}.sql";
        
        $command = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s > %s',
            escapeshellarg($config['database']['host']),
            escapeshellarg($config['database']['user']),
            escapeshellarg($config['database']['pass']),
            escapeshellarg($config['database']['name']),
            escapeshellarg($backupFile)
        );
        
        exec($command, $output, $returnVar);
        
        if ($returnVar === 0) {
            self::cleanOldBackups();
            return true;
        }
        return false;
    }

    private static function cleanOldBackups() {
        $backupDir = __DIR__ . '/../backups/';
        $files = glob($backupDir . 'backup_*.sql');
        
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        // Keep only last 7 backups
        while (count($files) > 7) {
            unlink(array_pop($files));
        }
    }
}