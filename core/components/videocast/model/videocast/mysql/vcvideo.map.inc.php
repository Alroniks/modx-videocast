<?php
$xpdo_meta_map['vcVideo']= array (
  'package' => 'videocast',
  'version' => '1.1',
  'table' => 'vc_videos',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'title' => '',
    'alias' => '',
    'description' => '',
    'cover' => '',
    'source' => '',
    'duration' => '0',
    'free' => '0',
    'hidden' => '0',
    'publishedon' => 'CURRENT_TIMESTAMP',
    'collection' => '',
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'phptype' => 'string',
      'comment' => 'Short name of video',
      'dtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
    ),
    'alias' => 
    array (
      'phptype' => 'string',
      'comment' => 'Slugged title for link of video',
      'dtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'description' => 
    array (
      'phptype' => 'string',
      'comment' => 'Description or introduction of video',
      'dtype' => 'text',
      'null' => true,
      'default' => '',
    ),
    'cover' => 
    array (
      'phptype' => 'string',
      'comment' => 'Path to image, that will be used as cover',
      'dtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
    ),
    'source' => 
    array (
      'phptype' => 'string',
      'comment' => 'Link to video file or embedded code for video player',
      'dtype' => 'varchar',
      'precision' => '555',
      'null' => false,
      'default' => '',
    ),
    'duration' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Duration of video (in seconds)',
      'dtype' => 'integer',
      'precision' => '3',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => '0',
    ),
    'free' => 
    array (
      'phptype' => 'boolean',
      'comment' => 'Status of video: free of paid',
      'dtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => '0',
      'index' => 'index',
    ),
    'hidden' => 
    array (
      'phptype' => 'boolean',
      'comment' => 'Video, that exists but hidden from lists and search',
      'dtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => '0',
      'index' => 'index',
    ),
    'publishedon' => 
    array (
      'phptype' => 'timestamp',
      'comment' => 'Date of publishing video',
      'dtype' => 'timestamp',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
      'index' => 'index',
    ),
    'collection' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Link to collection',
      'dtype' => 'integer',
      'precision' => '10',
      'attributes' => 'unsigned',
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
    'hidden' => 
    array (
      'alias' => 'hidden',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'hidden' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
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
  ),
  'aggregates' => 
  array (
    'Collection' => 
    array (
      'class' => 'vcCollection',
      'local' => 'collection',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
