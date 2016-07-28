<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160728_132519_create_tables2 extends Migration
{
//    public function up()
//    {
//
//    }
//
//    public function down()
//    {
//        echo "m160728_132519_create_tables2 cannot be reverted.\n";
//
//        return false;
//    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user2}}', [
            'id' => Schema::TYPE_PK,
            'user2name' => Schema::TYPE_STRING . ' NOT NULL',
            'password' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . ' NOT NULL',
            'token' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL'
        ], $tableOptions);
        $this->createIndex('user2name', '{{%user2}}', 'user2name', true);
        $this->createTable('{{%category2}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_STRING
        ], $tableOptions);
        $this->createIndex('name', '{{%category2}}', 'name', true);
        $this->createTable('{{%post2}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'category2_id' => Schema::TYPE_SMALLINT . ' unsigned NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);
        $this->createIndex('status', '{{%post2}}', 'status');
        $this->createTable('{{%comment2}}', [
            'id' => Schema::TYPE_PK,
            'author' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'url' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL'
        ], $tableOptions);
        $this->createIndex('status', '{{%comment2}}', 'status');
        $this->execute($this->adduser2Sql());
    }
    private function adduser2Sql()
    {
        $password = Yii::$app->security->generatePasswordHash('admin');
        $auth_key = Yii::$app->security->generateRandomString();
        $token = Yii::$app->security->generateRandomString() . '_' . time();
        return "INSERT INTO {{%user2}} (`user2name`, `email`, `password`, `auth_key`, `token`) VALUES ('admin', 'admin@myblog.loc', '$password', '$auth_key', '$token')";
    }
    public function safeDown()
    {
        $this->dropTable('{{%user2}}');
        $this->dropTable('{{%post2}}');
        $this->dropTable('{{%comment2}}');
        $this->dropTable('{{%category2}}');
    }
}
