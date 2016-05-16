<?php

if (!$object->xpdo && !$object->xpdo instanceof modX) {
    return true;
}

/** @var modX $modx */
$modx =& $object->xpdo;
$modelPath = $modx->getOption('videocast.core_path', null, $modx->getOption('core_path') . 'components/videocast/') . 'model/';

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        $modx->addPackage('videocast', $modelPath);
        $manager = $modx->getManager();

        $tables = [
            'vcCollection',
            'vcCourse',
            'vcCourseCollection',
            'vcCourseVideo',
            'vcVideo'
        ];

        foreach ($tables as $table) {
            $manager->createObjectContainer($table);
            $tableName = $modx->getTableName($table);

            // Fields initialization
            $fields = [];
            $sql = $modx->query("SHOW FIELDS FROM $tableName");
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $fields[$row['Field']] = strtolower($row['Type']);
            }

            // Add or alter existing fields
            $map = $modx->getFieldMeta($table);
            foreach ($map as $key => $field) {
                // Add new fields
                if (!isset($fields[$key])) {
                    $manager->addField($table, $key);
                } else {
                    $type = strtolower($field['dbtype']);
                    // Modify existing fields
                    if ($type != $fields[$key]) {
                        $manager->alterField($table, $key);
                    }
                }
            }

            // Remove old fields
            foreach ($fields as $key => $field) {
                if (!isset($map[$key])) {
                    $manager->removeField($table, $key);
                }
            }

            // Manage indexes
            $indexes = [];
            $sql = $modx->query("SHOW INDEXES FROM $tableName");
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $name = $row['Key_name'];
                if (!isset($indexes[$name])) {
                    $indexes[$name] = [$row['Column_name']];
                } else {
                    $indexes[$name][] = $row['Column_name'];
                }
            }
            foreach ($indexes as $name => $values) {
                sort($values);
                $indexes[$name] = implode(':', $values);
            }
            $map = $modx->getIndexMeta($table);

            // Remove old indexes
            foreach ($indexes as $key => $index) {
                if (!isset($map[$key])) {
                    $manager->removeIndex($table, $key);
                }
            }

            // Add or alter existing
            foreach ($map as $key => $index) {
                ksort($index['columns']);
                $index = implode(':', array_keys($index['columns']));
                if (!isset($indexes[$key])) {
                    $manager->addIndex($table, $key);
                } else {
                    if ($index != $indexes[$key]) {
                        $manager->removeIndex($table, $key);
                        $manager->addIndex($table, $key);
                    }
                }
            }

            if ($modx instanceof modX) {
                $modx->addExtensionPackage('videocast', '[[++core_path]]components/videocast/model/');
            }
        }

        break;
    case xPDOTransport::ACTION_UNINSTALL:
        if ($modx instanceof modX) {
            $modx->removeExtensionPackage('videocast');
        }
        break;
}

return true;
