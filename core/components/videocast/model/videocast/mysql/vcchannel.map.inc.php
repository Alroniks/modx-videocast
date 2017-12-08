<?php
$xpdo_meta_map['vcChannel']= array (
  'package' => 'videocast',
  'version' => '1.1',
  'table' => 'vc_channels',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'title' => '',
    'alias' => '',
    'description' => '',
    'cover' => '',
    'complexity' => '',
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'phptype' => 'string',
      'comment' => 'Short name of channel',
      'dbtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
    ),
    'alias' => 
    array (
      'phptype' => 'string',
      'comment' => 'Slugged title for link of channel',
      'dbtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'description' => 
    array (
      'phptype' => 'string',
      'comment' => 'Description or introduction of channel',
      'dbtype' => 'text',
      'null' => true,
      'default' => '',
    ),
    'cover' => 
    array (
      'phptype' => 'string',
      'comment' => 'Path to image, that will be used as cover',
      'dbtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
    ),
    'complexity' => 
    array (
      'phptype' => 'string',
      'comment' => 'Complexity of channel (youngling | padawan | knight | master)',
      'dbtype' => 'varchar',
      'precision' => '50',
      'null' => true,
      'default' => '',
      'index' => 'index',
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
    'complexity' => 
    array (
      'alias' => 'complexity',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'complexity' => 
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
    'Collections' => 
    array (
      'class' => 'vcChannelCollection',
      'local' => 'id',
      'foreign' => 'channel',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Videos' => 
    array (
      'class' => 'vcChannelVideo',
      'local' => 'id',
      'foreign' => 'channel',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
