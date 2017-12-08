<?php
$xpdo_meta_map['vcChannelCollection']= array (
  'package' => 'videocast',
  'version' => '1.1',
  'table' => 'vc_channels_collections',
  'extends' => 'xPDOObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'channel' => 0,
    'collection' => 0,
    'rank' => 0,
  ),
  'fieldMeta' => 
  array (
    'channel' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Link to channel',
      'dbtype' => 'integer',
      'precision' => '10',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'pk',
    ),
    'collection' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Link to collection',
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'pk',
    ),
    'rank' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Order of elements in lists',
      'dbtype' => 'integer',
      'precision' => '10',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
  ),
  'indexes' => 
  array (
    'PRIMARY' => 
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'channel' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'collection' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'rank' => 
    array (
      'alias' => 'rank',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'rank' => 
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
    'Channel' => 
    array (
      'class' => 'vcChannel',
      'local' => 'channel',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
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
