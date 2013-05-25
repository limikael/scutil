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
		 * Get instance.
		 */
		public static function getInstance() {
			if (!self::$instance)
				self::$instance=new SCUtilPlugin();

			return self::$instance;
		}
	}