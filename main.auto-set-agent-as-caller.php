<?php

/**
 * Module auto-set-agent-as-caller
 *
 * @author      Vladimir Kunin <v.b.kunin@gmail.com>
 *              https://github.com/vbkunin/auto-set-agent-as-caller
 * @license     http://www.opensource.org/licenses/gpl-3.0.html LGPL
 */


class AutoSetAgentAsCaller implements iApplicationUIExtension
{
	public function OnDisplayProperties($oObject, WebPage $oPage, $bEditMode = false)
	{
		if ($this->IsEnabled($oObject) && $bEditMode && $oObject->IsNew())
		{
			$iOrgId = 0;
			$sOrgName = '';
			$iCallerId = UserRights::GetContactId();
			$sCallerName = '';
			$oCaller = MetaModel::GetObject('Contact', $iCallerId, false); // false => Can fail
			if (is_object($oCaller)) {
				$sCallerName = $oCaller->Get('friendlyname');
				$oOrg = MetaModel::GetObject('Organization', $oCaller->Get('org_id'), false); // false => can fail
				if (is_object($oOrg)) {
					$iOrgId = $oOrg->GetKey();
					$sOrgName = $oOrg->Get('friendlyname');
				}
			}
			if ($iOrgId && $sOrgName && $iCallerId && $sCallerName)
			{
				$oPage->add_ready_script(
<<< EOF
					var orgFieldId = oWizardHelper.GetFieldId("org_id");
					var callerFieldId = oWizardHelper.GetFieldId("caller_id");
					$("#" + orgFieldId).one("change", function() {
						// Нужно ждать, пока обновится виджет (select или autocomplete)
						// Как отловить это событие, не придумал ;-(
                        setTimeout(function() {
                            $("#label_" + callerFieldId).val("$sCallerName");
							$("#" + callerFieldId).val("$iCallerId");
							$("#" + callerFieldId).trigger("change");
							$("#" + callerFieldId).trigger("extkeychange");
						}, 1000);
					});
					$("#label_" + orgFieldId).val("$sOrgName");
					$("#" + orgFieldId).val("$iOrgId");
					$("#" + orgFieldId).trigger("change");
					$("#" + orgFieldId).trigger("extkeychange");
EOF
				);
			}
		}
	}

	public function OnDisplayRelations($oObject, WebPage $oPage, $bEditMode = false)
	{
	}

	public function OnFormSubmit($oObject, $sFormPrefix = '')
	{
	}

	public function OnFormCancel($sTempId)
	{
	}

	public function EnumUsedAttributes($oObject)
	{
		return array();
	}

	public function GetIcon($oObject)
	{
		return '';
	}

	public function GetHilightClass($oObject)
	{
		// Possible return values are:
		// HILIGHT_CLASS_CRITICAL, HILIGHT_CLASS_WARNING, HILIGHT_CLASS_OK, HILIGHT_CLASS_NONE
		return HILIGHT_CLASS_NONE;
	}

	public function EnumAllowedActions(DBObjectSet $oSet)
	{
		// No action
		return array();
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// Plug-ins specific functions
	//
	///////////////////////////////////////////////////////////////////////////////////////////////////////

	protected function IsEnabled($oObject)
	{
		$ModuleSettings = utils::GetConfig()->GetModuleSetting('auto-set-agent-as-caller', 'enabled');
		if (gettype($ModuleSettings) == 'boolean')
		{
			return $ModuleSettings;
		}
		elseif (gettype($ModuleSettings) == 'string')
		{
			$aClasses = array_map('trim', explode(",", $ModuleSettings));
			foreach ($aClasses as $sClass)
			{
				if ($oObject instanceof $sClass)
				{
					return true;
				}
			}
			return false;
		}
		else
		{
			return false;
		}
	}
}
