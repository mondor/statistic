<?php

namespace Fuel\Migrations;

class Create_event_companies {

	public function up()
	{
		\DBUtil::create_table('event_companies', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'event_id' => array('constraint' => 11, 'type' => 'int'),
			'company_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('event_companies');
	}
}