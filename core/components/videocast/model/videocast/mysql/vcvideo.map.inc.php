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
    'type' => '',
    'duration' => 0,
    'plays' => 0,
    'free' => 0,
    'hidden' => 0,
    'publishedon' => 'CURRENT_TIMESTAMP',
    'updatedon' => 'CURRENT_TIMESTAMP',
    'collection' => 0,
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'phptype' => 'string',
      'comment' => 'Short name of video',
      'dbtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
    ),
    'alias' => 
    array (
      'phptype' => 'string',
      'comment' => 'Slugged title for link of video',
      'dbtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'description' => 
    array (
      'phptype' => 'string',
      'comment' => 'Description or introduction of video',
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
    'source' => 
    array (
      'phptype' => 'string',
      'comment' => 'Link to video file or video code on external hosting',
      'dbtype' => 'varchar',
      'precision' => '555',
      'null' => false,
      'default' => '',
    ),
    'type' => 
    array (
      'phptype' => 'string',
      'comment' => 'Type of video source',
      'dbtype' => 'varchar',
      'precision' => '20',
      'null' => false,
      'default' => '',
    ),
    'duration' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Duration of video (in seconds)',
      'dbtype' => 'integer',
      'precision' => '3',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'plays' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Count of plays of video',
      'dbtype' => 'integer',
      'precision' => '5',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'free' => 
    array (
      'phptype' => 'boolean',
      'comment' => 'Status of video: free or private',
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
      'index' => 'index',
    ),
    'hidden' => 
    array (
      'phptype' => 'boolean',
      'comment' => 'Video, that exists but hidden from lists and search',
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
      'index' => 'index',
    ),
    'publishedon' => 
    array (
      'phptype' => 'timestamp',
      'comment' => 'Date of publishing video',
      'dbtype' => 'timestamp',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
      'index' => 'index',
    ),
    'updatedon' => 
    array (
      'phptype' => 'timestamp',
      'comment' => 'Date of update video object',
      'dbtype' => 'timestamp',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
      'attributes' => 'ON UPDATE CURRENT_TIMESTAMP',
      'index' => 'index',
    ),
    'collection' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Link to collection',
      'dbtype' => 'integer',
      'precision' => '10',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
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
    'plays' => 
    array (
      'alias' => 'plays',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'plays' => 
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
    'type' => 
    array (
      'alias' => 'type',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'type' => 
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
  'validation' => 
  array (
    'rules' => 
    array (
      'source' => 
      array (
        'notEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'vc_videos_source_err_notEmpty',
        ),
        'onlyNumbers' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^[a-z0-9:_\\-\\/\\.\\?=&]*$/iu',
          'message' => 'vc_videos_source_err_onlyUrls',
        ),
      ),
      'title' => 
      array (
        'notEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'vc_videos_title_err_notEmpty',
        ),
        'onlyAlphaNum' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^[a-zа-я0-9,\\._\\-\\s\\(\\)\\?=]*$/iu',
          'message' => 'vc_videos_title_err_onlyAlphaNum',
        ),
      ),
      'alias' => 
      array (
        'notEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'vc_videos_alias_err_notEmpty',
        ),
        'onlyAlphaNum' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^[a-zA-Z0-9\\-]*$/',
          'value' => '1',
          'message' => 'vc_videos_alias_err_notEmpty',
        ),
      ),
      'description' => 
      array (
        'notEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'vc_videos_description_err_notEmpty',
        ),
      ),
      'cover' => 
      array (
        'notEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'vc_videos_cover_err_notEmpty',
        ),
      ),
    ),
  ),
);
