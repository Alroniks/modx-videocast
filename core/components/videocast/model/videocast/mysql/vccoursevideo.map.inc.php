<?php
$xpdo_meta_map['vcCourseVideo']= array (
  'package' => 'videocast',
  'version' => '1.1',
  'table' => 'vc_courses_videos',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'course' => 0,
    'video' => 0,
    'rank' => 0,
  ),
  'fieldMeta' => 
  array (
    'course' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Link to course',
      'dbtype' => 'integer',
      'precision' => '10',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'pk',
    ),
    'video' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Link to video',
      'dbtype' => 'integer',
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
        'course' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'video' => 
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
    'Course' => 
    array (
      'class' => 'vcCourse',
      'local' => 'course',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Video' => 
    array (
      'class' => 'vcVideo',
      'local' => 'video',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
