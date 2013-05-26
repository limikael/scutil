<?php

	require_once __DIR__."/../scormcloud/SCORMCloud_PHPLibrary/ScormEngineService.php";

	/**
	 * SCUtil plugin.
	 */
	class SCUtilPlugin {

		private static $instance;

		/**
		 * Get currenct url.
		 */
		private function getCurrentUrl() {
			$url='http';

			if ($_SERVER["HTTPS"]=="on")
				$url.="s";

			$url.="://".$_SERVER["SERVER_NAME"];

			if ($_SERVER["SERVER_PORT"] != "80")
				$url.=":".$_SERVER["SERVER_PORT"];

			$url.=$_SERVER["REQUEST_URI"];

			return $url;
		}

		/**
		 * Show a preview button.
		 */
		function scpreview($attrs) {
			global $scdoneopenfunc;

			$out="";

			if (!$scdoneopenfunc) {
				$out.='<script language="javascript">';
				$out.='  function scopenurl(u) {';
				$out.='    window.location=u;';
				$out.='  }';
				$out.='</script>';

				$scdoneopenfunc=TRUE;
			}

			$scormService=ScormCloudPlugin::get_cloud_service();
			$courseService=$scormService->getCourseService();

			$url=$courseService->GetPreviewUrl($attrs["courseid"],self::getCurrentUrl());

			$linktext="Preview";
			if (isset($attrs["link"]))
				$linktext=$attrs["link"];

			$out.='<a class="sc-preview-link" href="javascript:void(0);" onclick="scopenurl('."'".$url."'".');">';
			$out.=$linktext;
			$out.='</a>';

			return $out;
		}

		/**
		 * Internal Cfunction to compare items for the toplist.
		 */
		private function compareToplistItems($a,$b) {
			$aval=floatval($a["score"]);
			$bval=floatval($b["score"]);

			if ($aval>$bval)
				return -1;

			else if ($aval<$bval)
				return 1;

			return 0;
		}

		/**
		 * Show result toplist.
		 */
		function sctoplist($attrs) {
			if (!isset($attrs["courseid"]))
				return "Use [sctoplist courseid=<...>]";

			$scormService=ScormCloudPlugin::get_cloud_service();
			$registrationService=$scormService->getRegistrationService();
			$regsRaw=$registrationService->GetRegistrationListResults(NULL,$attrs["courseid"],0);
			//echo $regsRaw;

			$regsXml=simplexml_load_string($regsRaw);

			$items=array();

			foreach ($regsXml->registrationlist->registration as $reg) {
				$item=array();

				$item["name"]=$reg->learnerFirstName." ".$reg->learnerLastName;
				$item["score"]=$reg->registrationreport->score;
				$item["complete"]=$reg->registrationreport->complete;
				$item["success"]=$reg->registrationreport->success;

				$items[]=$item;
			}

			usort($items,array($this,"compareToplistItems"));

			$columns=array("name","complete","score");
			if (isset($attrs["columns"]))
				$columns=explode(",",$attrs["columns"]);

			$out="";
			$out.='<table class="sc-toplist-table">'."\n";

			$out.=' <tr class="sc-toplist-header-row">'."\n";
			foreach ($columns as $column)
				$out.='  <th class="sc-toplist-header-item '.$column.'">'.$column.'</th>'."\n";

			$out.=' </tr>'."\n";

			foreach ($items as $item) {
				$classes=array("sc-toplist-row",$item["complete"],$item["success"]);
				$out.=' <tr class="'.join(" ",$classes).'">'."\n";

				foreach ($columns as $column)
					$out.='  <td class="sc-toplist-item '.$column.'">'.$item[$column].'</td>'."\n";

				$out.=' </tr>'."\n";
			}
			$out.='</table>'."\n";

			return $out;
		}

		/**
		 * Get instance.
		 */
		public static function getInstance() {
			if (!self::$instance)
				self::$instance=new SCUtilPlugin();

			return self::$instance;
		}
	}