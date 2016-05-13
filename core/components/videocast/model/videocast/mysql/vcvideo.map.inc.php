<?php
$xpdo_meta_map['vcVideo']= array (
  'package' => 'videocast',
  'version' => '1.1',
  'table' => 'vc_videos',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => '',
    'description' => '',
    'source' => '',
    'free' => '1',
    'review' => '0',
    'length' => '0',
    'complicity' => '',
    'language' => 'ru',
    'published_at' => 'CURRENT_TIMESTAMP',
    'collection' => '0',
    'course' => '0',
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'phptype' => 'string',
      'comment' => 'Name of video, title',
      'dtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
    ),
    'description' => 
    array (
      'phptype' => 'text',
      'comment' => 'Description of video, textual into for video',
      'dtype' => 'text',
      'null' => true,
      'default' => '',
    ),
    'source' => 
    array (
      'phptype' => 'varchar',
      'comment' => 'Source of video, link to file or code for embed',
      'dtype' => 'varchar',
      'precision' => '100',
      'null' => false,
      'default' => '',
    ),
    'free' => 
    array (
      'phptype' => 'boolean',
      'comment' => 'Status of video: free of paid',
      'dtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => '1',
    ),
    'review' => 
    array (
      'phptype' => 'boolean',
      'dtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => '0',
    ),
    'length' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Length of video in seconds',
      'dtype' => 'integer',
      'precision' => '3',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => '0',
    ),
    'complicity' => 
    array (
      'phptype' => 'string',
      'dtype' => 'varchar',
      'precision' => '10',
      'null' => false,
      'default' => '',
    ),
    'language' => 
    array (
      'phptype' => 'string',
      'comment' => 'Main language of this video',
      'dtype' => 'varchar',
      'precision' => '2',
      'null' => false,
      'default' => 'ru',
    ),
    'published_at' => 
    array (
      'phptype' => 'timestamp',
      'dtype' => 'timestamp',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
    ),
    'collection' => 
    array (
      'phptype' => 'integer',
      'dtype' => 'integer',
      'precision' => '10',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => '0',
    ),
    'course' => 
    array (
      'phptype' => 'integer',
      'dtype' => 'integer',
      'precision' => '10',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => '0',
    ),
  ),
  'indexes' => 
  array (
    'free' => 
    array (
      'alias' => 'free',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'free' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'review' => 
    array (
      'alias' => 'review',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'review' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'language' => 
    array (
      'alias' => 'language',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'language' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'collection' => 
    array (
      'alias' => 'collection',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'collection' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'course' => 
    array (
      'alias' => 'course',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'course' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Collection' => 
    array (
      'class' => 'modResource',
      'local' => 'collection',
      'foreign' => 'id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
  ),
);
