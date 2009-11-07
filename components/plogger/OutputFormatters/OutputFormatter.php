<?php
class OutputFormatter
{
	public function format($params)
	{
		$msg = "[".$params["id"]."::".$params["file"]."::{$params["line"]}][{$params["time"]}]".$params["msg"]."\n";
		return $msg;
	}
}
?>