<?php

/**
 * BaseUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $is_active
 * @property integer $is_super_admin
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string $type
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseUser extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('id', 'integer', 8, array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'length' => '8'));
        $this->hasColumn('is_active', 'integer', 1, array('type' => 'integer', 'default' => '1', 'length' => '1'));
        $this->hasColumn('is_super_admin', 'integer', 1, array('type' => 'integer', 'default' => '0', 'length' => '1'));
        $this->hasColumn('created_at', 'timestamp', 25, array('type' => 'timestamp', 'notnull' => true, 'length' => '25'));
        $this->hasColumn('updated_at', 'timestamp', 25, array('type' => 'timestamp', 'notnull' => true, 'length' => '25'));
        $this->hasColumn('first_name', 'string', 255, array('type' => 'string', 'length' => '255'));
        $this->hasColumn('last_name', 'string', 255, array('type' => 'string', 'length' => '255'));
        $this->hasColumn('username', 'string', 255, array('type' => 'string', 'length' => '255'));
        $this->hasColumn('password', 'string', 255, array('type' => 'string', 'length' => '255'));
        $this->hasColumn('type', 'string', 255, array('type' => 'string', 'length' => '255'));
    }

}