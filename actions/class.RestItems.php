<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 */

use \oat\tao\model\routing\AnnotationReader\security;

/**
 *
 * @author plichart
 */
class taoItems_actions_RestItems extends tao_actions_CommonRestModule
{

    /**
     * taoItems_actions_RestItems constructor.
     * @security("hide")
     */
	public function __construct()
    {
		parent::__construct();
		//The service taht implements or inherits get/getAll/getRootClass ... for that particular type of resources
		$this->service = taoItems_models_classes_CrudItemsService::singleton();
	}

	/**
	 * Optionnaly a specific rest controller may declare
	 * aliases for parameters used for the rest communication
	 */
	protected function getParametersAliases()
    {
	    return array_merge(parent::getParametersAliases(), array(
		    "model"=> taoItems_models_classes_ItemsService::PROPERTY_ITEM_MODEL,
		    "content" => taoItems_models_classes_ItemsService::PROPERTY_ITEM_CONTENT

	    ));
	}
	/**
	 * Optionnal Requirements for parameters to be sent on every service
	 *
	 */
	protected function getParametersRequirements()
    {
	    return array(
		/** you may use either the alias or the uri, if the parameter identifier
		 *  is set it will become mandatory for the method/operation in $key
		* Default Parameters Requirents are applied
		* type by default is not required and the root class type is applied
		*/

	    );
	}
}
