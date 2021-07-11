<?php

namespace Config\Core;

class View{
	public function render($contentView, $templateView, $data=null)
	{
		if ($data != null) {
			foreach ($data as $key=>$value) {
				${$key} = $value;
			}
		}
		include '../views/'.$templateView;
	}
}