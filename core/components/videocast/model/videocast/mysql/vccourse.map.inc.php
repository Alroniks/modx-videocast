<?php
$xpdo_meta_map['vcCourse']= array (
  'package' => 'videocast',
  'version' => '1.1',
  'table' => 'vc_courses',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'title' => '',
    'alias' => '',
    'description' => '',
    'complexity' => '',
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'phptype' => 'string',
      'comment' => 'Short name of course',
      'dtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
    ),
    'alias' => 
    array (
      'phptype' => 'string',
      'comment' => 'Slugged title for link of course',
      'dtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'description' => 
    array (
      'phptype' => 'string',
      'comment' => 'Description or introduction of course',
      'dtype' => 'text',
      'null' => true,
      'default' => '',
    ),
    'complexity' => 
    array (
      'phptype' => 'string',
      'comment' => 'Complexity of course (youngling | padawan | knight | master)',
      'dtype' => 'text',
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
      'class' => 'vcCourseCollection',
      'local' => 'id',
      'foreign' => 'course',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Videos' => 
    array (
      'class' => 'vcCourseVideo',
      'local' => 'id',
      'foreign' => 'course',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
