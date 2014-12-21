<?php

class erLhcoreClassModelCoBrowse {

	public function getState()
	{
		return array(
				'id'         		=> $this->id,
				'chat_id'   	 	=> $this->chat_id,
				'mtime'     	 	=> $this->mtime,
				'url'    			=> $this->url,
				'modifications'     => $this->modifications,
				'initialize'     	=> $this->initialize,
				'finished'     		=> $this->finished,
		);
	}

	public function setState( array $properties )
	{
		foreach ( $properties as $key => $val )
		{
			$this->$key = $val;
		}
	}
	
	public static function getCount($params = array())
	{
		$session = erLhcoreClassCoBrowse::getSession();
		$q = $session->database->createSelectQuery();
		$q->select( "COUNT(id)" )->from( "lh_cobrowse" );

		if (isset($params['filter']) && count($params['filter']) > 0)
		{
			$conditions = array();

			foreach ($params['filter'] as $field => $fieldValue)
			{
				$conditions[] = $q->expr->eq( $field, $q->bindValue($fieldValue) );
			}

			$q->where(
					$conditions
			);
		}

		$stmt = $q->prepare();
		$stmt->execute();
		$result = $stmt->fetchColumn();

		return $result;
	}

	public function __get($var) {
		switch ($var) {
							
			case 'mtime_front':
					return date('Ymd') == date('Ymd',$this->mtime) ? date(erLhcoreClassModule::$dateHourFormat,$this->mtime) : date(erLhcoreClassModule::$dateDateHourFormat,$this->mtime); 
				break;

			case 'is_sharing':
					return $this->finished == 0 && $this->mtime > time()-30;
				break;
				
			default:
				;
			break;
		}
	}
	
	public static function getList($paramsSearch = array())
	{
		$paramsDefault = array('limit' => 32, 'offset' => 0);

		$params = array_merge($paramsDefault,$paramsSearch);

		$session = erLhcoreClassCoBrowse::getSession();
		$q = $session->createFindQuery( 'erLhcoreClassModelCoBrowse' );

		$conditions = array();

		if (isset($params['filter']) && count($params['filter']) > 0)
		{
			foreach ($params['filter'] as $field => $fieldValue)
			{
				$conditions[] = $q->expr->eq( $field, $q->bindValue($fieldValue) );
			}
		}

		if (isset($params['filterin']) && count($params['filterin']) > 0)
		{
			foreach ($params['filterin'] as $field => $fieldValue)
			{
				$conditions[] = $q->expr->in( $field, $fieldValue );
			}
		}

		if (isset($params['filterlt']) && count($params['filterlt']) > 0)
		{
			foreach ($params['filterlt'] as $field => $fieldValue)
			{
				$conditions[] = $q->expr->lt( $field, $q->bindValue($fieldValue) );
			}
		}

		if (isset($params['filtergt']) && count($params['filtergt']) > 0)
		{
			foreach ($params['filtergt'] as $field => $fieldValue)
			{
				$conditions[] = $q->expr->gt( $field,$q->bindValue( $fieldValue ));
			}
		}

		if (count($conditions) > 0)
		{
			$q->where(
					$conditions
			);
		}

		$q->limit($params['limit'],$params['offset']);

		$q->orderBy(isset($params['sort']) ? $params['sort'] : 'id DESC' );

		$objects = $session->find( $q );

		return $objects;
	}

	public static function fetch($id) {
		$Faq = erLhcoreClassCoBrowse::getSession()->load( 'erLhcoreClassModelCoBrowse', (int)$id );
		return $Faq;
	}

	public function saveThis()
	{
		$this->mtime = time();
		erLhcoreClassCoBrowse::getSession()->saveOrUpdate($this);
	}

	public function removeThis() {
		erLhcoreClassCoBrowse::getSession()->delete( $this );
	}

	public $id = NULL;
	public $chat_id = NULL;
	public $mtime = NULL;
	public $url = '';
	public $modifications = '';	
	public $initialize = '';	
	public $finished = 0;	
}

?>