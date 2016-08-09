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
    'cover' => '',
    'rank' => 0,
    'hidden' => 0,
    'publishedon' => 'CURRENT_TIMESTAMP',
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
    'cover' => 
    array (
      'phptype' => 'string',
      'comment' => 'Path to image, that will be used as cover',
      'dbtype' => 'varchar',
      'precision' => '255',
      'null' => false,
      'default' => '',
    ),
    'rank' => 
    array (
      'phptype' => 'integer',
      'comment' => 'Order of categories in lists',
      'dbtype' => 'integer',
      'precision' => '10',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'hidden' => 
    array (
      'phptype' => 'boolean',
      'comment' => 'Collection, that exists but hidden from lists and search',
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
  'validation' => 
  array (
    'rules' => 
    array (
      'title' => 
      array (
        'notEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'vc_collections_title_err_notEmpty',
        ),
        'onlyAlphaNum' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^[a-zа-я0-9,\\._\\-\\s\\(\\)\\?=\\+]*$/iu',
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
          'message' => 'vc_collections_alias_err_notEmpty',
        ),
        'onlyAlias' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^[a-zA-Z0-9_\\-]*$/',
          'value' => '1',
          'message' => 'vc_collections_alias_err_onlyAlias',
        ),
      ),
      'description' => 
      array (
        'notEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'vc_collections_description_err_notEmpty',
        ),
      ),
      'cover' => 
      array (
        'notEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'vc_collections_cover_err_notEmpty',
        ),
      ),
    ),
  ),
);
