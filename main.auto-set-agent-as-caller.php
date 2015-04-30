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
		$bModuleEnabled = utils::GetConfig()->GetModuleSetting('auto-set-agent-as-caller', 'enabled');
		if ($bModuleEnabled && $bEditMode && $oObject->IsNew())
		{
			$iOrgId = $this->GetUserOrgId();
			$iCallerId = UserRights::GetContactId();
			$oPage->add_ready_script(
<<< EOF
				if ($iOrgId && $iCallerId) {
					var orgFieldId = oWizardHelper.GetFieldId("org_id");
					var callerFieldId = oWizardHelper.GetFieldId("caller_id");
					$("#field_" + callerFieldId).one("update", "select", function() {
						$("#" + callerFieldId).val("$iCallerId").trigger("change");
					});
					$("#" + orgFieldId).val("$iOrgId").trigger("change");
				}
EOF
			);
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

	protected function GetUserOrgId()
	{
		$iOrgId = 0;
		$iContactId = UserRights::GetContactId();
		$oContact = MetaModel::GetObject('Contact', $iContactId, false); // false => Can fail
		if (is_object($oContact))
		{
			$oOrg = MetaModel::GetObject('Organization', $oContact->Get('org_id'), false); // false => can fail
			if (is_object($oOrg))
			{
				$iOrgId = $oOrg->GetKey();
			}
		}
		return $iOrgId;
	}
}
?>
