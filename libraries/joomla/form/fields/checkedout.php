<?php
/**
 * @package     Joomla.Libraries
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('list');

/**
 * Form Field to load a list of users who checked items out.
 *
 * @since  3.8
 */
class JFormFieldCheckedout extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  3.8
	 */
	public $type = 'Checkedout';

	/**
	 * Cached array of the category items.
	 *
	 * @var    array
	 * @since  3.8
	 */
	protected static $options = array();

	/**
	 * Builds the query for the checked out list.
	 *
	 * @return  JDatabaseQuery  The query for the checked out form field
	 *
	 * @since   3.8
	 */
	protected function getQuery()
	{
		// Get table name and alias
		if (preg_match("%^(#__[a-z0-9_]+)\s*(?:AS)?\s*([a-z0-9_]?)$%i", (string) $this->element['sql_from'], $matches))
		{
			$tableName = $matches[1];
			$alias = empty($matches[2]) ? 'c' : $matches[2];
		}
		else
		{
			$tableName = '#__content';
			$alias = 'c';
		}

		// Get selected id
		if (is_numeric($this->value))
		{
			$selectedId = (int) $this->value;
			$orSelectedId = ($selectedId > 0) ? ' OR uc.id = ' . $selectedId : '';
		}
		else
		{
			$orSelectedId = '';
		}

		$db = JFactory::getDbo();

		// Construct the query
		$query = $db->getQuery(true)
			->select('uc.id AS value, uc.name AS text')
			->from($tableName . ' AS ' . $alias)
			->join('INNER', '#__users AS uc ON ' . $alias . '.checked_out = uc.id' . $orSelectedId)
			->group('uc.id, uc.name')
			->order('uc.name');

		if ($where = (string) $this->element['sql_where'])
		{
			$query->where($where);
		}

		return $query;
	}

	/**
	 * Method to get the options to populate list
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   3.8
	 */
	protected function getOptions()
	{
		$db = JFactory::getDbo();
		$db->setQuery($this->getQuery());

		// Get the result
		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			$options = array();
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
