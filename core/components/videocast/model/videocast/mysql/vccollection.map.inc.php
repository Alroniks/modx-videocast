<?php
$xpdo_meta_map['vcCollection']= array (
  'package' => 'videocast',
  'version' => '1.1',
  'table' => 'vc_collections',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'title' => '',
    'alias' => '',
    'description' => '',
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'phptype' => 'string',
      'comment' => 'Short name of collection',
      'dbtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
    ),
    'alias' => 
    array (
      'phptype' => 'string',
      'comment' => 'Slugged title for link of collection',
      'dbtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'description' => 
    array (
      'phptype' => 'string',
      'comment' => 'Description or introduction of collection',
      'dbtype' => 'text',
      'null' => true,
      'default' => '',
    ),
  ),
  'indexes' => 
  array (
    'alias' => 
    array (
      'alias' => 'alias',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'alias' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Videos' => 
    array (
      'class' => 'vcVideo',
      'local' => 'id',
      'foreign' => 'collection',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
