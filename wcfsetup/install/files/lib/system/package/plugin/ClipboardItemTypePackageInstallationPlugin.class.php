<?php
namespace wcf\system\package\plugin;
use wcf\system\WCF;

/**
 * This PIP installs, updates or deletes clipboard item types.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	acp.package.plugin
 * @category 	Community Framework
 */
class ClipboardItemTypePackageInstallationPlugin extends AbstractXMLPackageInstallationPlugin {
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::$className
	 */
	public $className = 'wcf\data\clipboard\item\type\ClipboardItemTypeEditor';
	
	/**
	 * @see	wcf\system\package\plugin\AbstractPackageInstallationPlugin::$tableName
	 */
	public $tableName = 'clipboard_item_type';
	
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::$tagName
	 */	
	public $tagName = 'type';
	
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::handleDelete()
	 */
	protected function handleDelete(array $items) {
		$sql = "DELETE FROM	wcf".WCF_N."_".$this->tableName."
			WHERE		typeName = ?
					AND packageID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		foreach ($items as $item) {
			$statement->execute(array(
				$item['attributes']['name'],
				$this->installation->getPackageID()
			));
		}
	}
	
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::prepareImport()
	 */
	protected function prepareImport(array $data) {
		return array(
			'listClassName' => $data['elements']['listclassname'],
			'typeName' => $data['attributes']['name']
		);
	}
	
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::findExistingItem()
	 */
	protected function findExistingItem(array $data) {
		$sql = "SELECT	*
			FROM	wcf".WCF_N."_".$this->tableName."
			WHERE	typeName = ?
				AND packageID = ?";
		$parameters = array(
			$data['typeName'],
			$this->installation->getPackageID()
		);
		
		return array(
			'sql' => $sql,
			'parameters' => $parameters
		);
	}
}
