<?php
	
	define("ALREADY_EXISTS", -200);

	print_r($argv);
	
	$actionarg = $argv[1];
	$actionarr = explode(":",$actionarg);
	$action = $actionarr[0];
	$action_item = $actionarr[1];

	switch ($action) {
		case 'create':
			switch ($action_item) {
				case 'model':
					$module = $argv[2];
					$path = evaluatePath($module);
					$result = create('model',$argv[3],$path,$argv);
					if($result == ALREADY_EXISTS)
						echo "Model Already Exists";

					break;
				
				default:
					# code...
					break;
			}
			break;
		
		default:
			# code...
			break;
	}

	function evaluatePath($module){

		if(strpos($module,":") == false){

			switch ($module) {
				case 'rayon':
					$path = 'Rayon';
					break;
				case 'roster':
					$path = 'Roster';
					break;
				default:
					$path = $module;
					break;
			}
			


		}
		else{

			$modarr = explode(":", $module);
			$modulename = "modules/".$modarr[1];
			$path = $modulename;
		}

		if(file_exists($path))
			return $path;

	}
	function create($thing,$name,$path,$params){

		$tdir = $thing."s";
		if($path !== false){
			
			if(!file_exists($path."/$tdir")){
				mkdir($path."/$tdir");
			}
			if(!file_exists($path."/$tdir/$name.php")){
				$file = fopen($path."/$tdir/$name.php","w");
				$func = "generate".ucwords($thing);
				fwrite($file, $func($name,$params));
			}
			else{
					return ALREADY_EXISTS;
			}
		}


	}
	function generateModel($model,$params){

		$modelclass = ucwords($model);
		$modeltable = strtolower($model);
		$script = "<?php \nclass $modelclass extends Model { \n\tpublic ".'$table'." = \"$modeltable\";";
		$script .= "\n\tpublic ".'$columns'." = array(";

		foreach (array_slice($params,4) as $param) {
			$parr = explode(":", $param);
			$col = $parr[0];
			$type = $parr[1];

			$script .= "\n\t\tarray(\"colname\" => \"$col\",\"type\" => \"$type\",\"value\" => \"\"),";

		
		}
		$script .= "\n\t);";
		$script .= "\n\tpublic function __construct(){\n\t\tparent::__construct(".'$this'." -> table,".'$this'." -> columns);\n\t}";
		$script .= "\n}\n?>";
		return $script;
	}

?>