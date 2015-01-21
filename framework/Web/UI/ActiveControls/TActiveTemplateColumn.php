<?php
/**
 * TActiveDataGrid class file
 *
 * @author LANDWEHR Computer und Software GmbH <programmierung@landwehr-software.de>
 * @link http://www.landwehr-software.de/
 * @copyright Copyright &copy; 2009 LANDWEHR Computer und Software GmbH
 * @license https://github.com/pradosoft/prado/blob/master/COPYRIGHT
 * @package Prado\Web\UI\ActiveControls
 */

namespace Prado\Web\UI\ActiveControls;

/**
 * TActiveTemplateColumn class
 *
 * TActiveTemplateColumn customizes the layout of controls in the column with templates.
 * In particular, you can specify {@link setItemTemplate ItemTemplate},
 * {@link setEditItemTemplate EditItemTemplate}, {@link setHeaderTemplate HeaderTemplate}
 * and {@link setFooterTemplate FooterTemplate} to customize specific
 * type of cells in the column.
 *
 * This is the active counterpart to the {@link TTemplateColumn} control. For that purpose,
 * if sorting is allowed, the header links/buttons are replaced by active controls.
 *
 * Please refer to the original documentation of the {@link TTemplateColumn} for usage.
 *
 * @author LANDWEHR Computer und Software GmbH <programmierung@landwehr-software.de>
 * @package Prado\Web\UI\ActiveControls
 * @since 3.1.9
 */
class TActiveTemplateColumn extends TTemplateColumn {
	protected function initializeHeaderCell($cell,$columnIndex) {
		$text=$this->getHeaderText();

		if(($classPath=$this->getHeaderRenderer())!=='') {
			$control=Prado::createComponent($classPath);
			if($control instanceof IDataRenderer) {
				if($control instanceof IItemDataRenderer) {
					$item=$cell->getParent();
					$control->setItemIndex($item->getItemIndex());
					$control->setItemType($item->getItemType());
				}
				$control->setData($text);
			}
			$cell->getControls()->add($control);
		}
		else if($this->getAllowSorting()) {
				$sortExpression=$this->getSortExpression();
				if(($url=$this->getHeaderImageUrl())!=='') {
					$button=Prado::createComponent('System.Web.UI.WebControls.TActiveImageButton');
					$button->setImageUrl($url);
					$button->setCommandName(TDataGrid::CMD_SORT);
					$button->setCommandParameter($sortExpression);
					if($text!=='')
						$button->setAlternateText($text);
					$button->setCausesValidation(false);
					$cell->getControls()->add($button);
				}
				else if($text!=='') {
						$button=Prado::createComponent('System.Web.UI.WebControls.TActiveLinkButton');
						$button->setText($text);
						$button->setCommandName(TDataGrid::CMD_SORT);
						$button->setCommandParameter($sortExpression);
						$button->setCausesValidation(false);
						$cell->getControls()->add($button);
					}
					else
						$cell->setText('&nbsp;');
			}
			else {
				if(($url=$this->getHeaderImageUrl())!=='') {
					$image=Prado::createComponent('System.Web.UI.WebControls.TActiveImage');
					$image->setImageUrl($url);
					if($text!=='')
						$image->setAlternateText($text);
					$cell->getControls()->add($image);
				}
				else if($text!=='')
						$cell->setText($text);
					else
						$cell->setText('&nbsp;');
			}
	}
}