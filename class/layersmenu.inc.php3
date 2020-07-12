<?php

// PHP Layers Menu 1.1.3 (unstable) (C) 2001, 2002 Marco Pratesi <pratesi@telug.it>

//$phplmwwwroot = "/~pratesi/phplayersmenu/";			// with an ending "/"
//$phplmdirroot = "/home/pratesi/public_html/phplayersmenu/";	// with an ending "/"
$phplmwwwroot = "";
$phplmdirroot = "./";

//include_once ($phplmdirroot . "template.inc.php3");	// taken from PHPLib

/* ********** */
class phplm {
/* ********** */

// measures are given in pixels if not differently specified

var $packagename;
var $version;
var $copyright;
var $author;

var $layerscount;	// it counts layers for all menus
var $tree;
var $layer_label;
var $layer_name;
var $layer_content;
var $popUps;		// the JS functions to popUp layers paths
var $moveLayers;	// the JS function to set initial positions of all layers
var $shutdown;		// the JS function to shutdown all layers of all menus
var $firstlevelmenu;

var $rightarrow;
var $abscissa_step;	// step for the left boundaries of layers
var $ordinata_step;	// estimated value of the vertical distance between adjacent links on a generic layer
var $thresholdY;	// threshold for vertical repositioning of a layer

function phplm(	// object constructor; initialization of a menu system
	$rightarrow = " &middot;&middot;&middot;&gt;",
	$abscissa_step = 140,
	$ordinata_step = 15,
	$thresholdY = 15
	) {

	$this->packagename = "PHP Layers Menu";
	$this->version = "1.1.3 (unstable)";
	$this->copyright = "(C) 2001, 2002";
	$this->author = "Marco Pratesi <pratesi@telug.it>";

	$this->layerscount = 0;
	$this->tree = array();
	$this->layer_label = array();
	$this->layer_name = array();
	$this->layer_content = array();
	$this->popUps = "";
	$this->moveLayers = "";
	$this->shutdown = "";
	$this->firstlevelmenu = array();

	$this->rightarrow = $rightarrow;
	$this->abscissa_step = $abscissa_step;
	$this->ordinata_step = $ordinata_step;
	$this->thresholdY = $thresholdY;
}

function newmenu(
	$menuname = "",		// non consistent default...
	$treefile = "",		// non consistent default...
	$horizontal = 0,	// 0 --> vertical menu; 1 --> horizontal menu
	$ordinata_margin_firstlevel = "default",	// default: 20 (vertical), -10 (horizontal)
	$ordinata_margin = 20	// default: 20 (vertical)
	) {
	// this method prepares the popUp() functions and the firstlevel table
	// for the menu $menuname

	global $phplmdirroot;

	if ($ordinata_margin_firstlevel == "default")
		$ordinata_margin_firstlevel = $horizontal ? -10 : 20;

	$ordinata = array();
	$abscissa = array();

	$abscissa_stepx5 = $this->abscissa_step*5;
	if ($horizontal)
		$ordinata[1] = 0;
	else
		$ordinata[1] = -$this->ordinata_step;

	$this->moveLayers .= "var " . $menuname . "LEFT = getoffsetleft('" . $menuname . "');\n";
	$this->moveLayers .= "var " . $menuname . "TOP = getoffsettop('" . $menuname . "');\n";
	if ($horizontal)
		$this->moveLayers .= "var " . $menuname . "HEIGHT = getoffsetheight('" . $menuname . "');\n";

	$this->firstlevelmenu[$menuname] = "";

	$firstlevellayeropen  = "<div id=\"" . $menuname . "\" style=\"position: relative; visibility: visible;\">\n";
	$firstlevellayeropen .= "<!-- Netscape 4.05 crashes, apparently due to the above div tag; probably I will not support it anymore and I will support only versions >= 4.07 -->\n";
	$firstlevellayeropen .= "<script language=\"JavaScript\">\n";
	$firstlevellayeropen .= "<!--\n";
	$firstlevellayeropen .= "if (IE4) {\n";
	$firstlevellayeropen .= "\tif (DOM)\n";
	$firstlevellayeropen .= "\t\tsetwidth(\"" . $menuname . "\", \"100%\");\n";
	$firstlevellayeropen .= "\telse {\t// IE4 IS SIMPLY A BASTARD !!!\n";
	$firstlevellayeropen .= "\t\tdocument.write('</div>');\n";
	$firstlevellayeropen .= "\t\tdocument.write('<div id=\"IE4" . $menuname . "\" style=\"position: relative; width: 100%; visibility: visible;\">');\n";
	$firstlevellayeropen .= "\t}\n";
	$firstlevellayeropen .= "}\n";
	$firstlevellayeropen .= "// -->\n";
	$firstlevellayeropen .= "</script>\n";
	$firstlevellayerclose = "\n</div>";
	$firstlevellayerput = 0;

	$t = new Template();
	if ($horizontal) {
		$t->set_file("page", $phplmdirroot . "layersmenu-hormenu.ihtml");
		$t->set_block("page", "hormenu_cell", "hormenu_cell_blck");
		$t->set_var("hormenu_cell_blck", "");
	} else
		$t->set_file("page", $phplmdirroot . "layersmenu-vermenu.ihtml");

	/* ********************************************************** */
	/* Taken from TreeMenu 1.1 - Bjorge Dijkstra (bjorge@gmx.net) */
	/* ********************************************************** */
	/* with some changes */

	/*********************************************/
	/*  Read text file with tree structure       */
	/*********************************************/

	/*********************************************/
	/* read file to $tree array                  */
	/* tree[x][0] -> tree level                  */
	/* tree[x][1] -> item text                   */
	/* tree[x][2] -> item link                   */
	/* tree[x][3] -> link target                 */
	/*********************************************/

	$maxlevel = 0;
	$cnt = $this->layerscount + 1;
	$firstlevelcnt = 0;

Global $XoopsLayerString ;
Global $XoopsLayerUse ;
if (! $XoopsLayerUse){
	$fd = fopen($phplmdirroot . $treefile, "r");
	if ($fd == 0) die("Unable to open file " . $treefile);
	while ($buffer = fgets($fd, 4096)) {
		$buffer = ereg_replace(chr(13), "", $buffer);	// Microsoft Stupidity Suppression
		$this->tree[$cnt][0] = strspn($buffer, ".");
		$tmp = rtrim(substr($buffer, $this->tree[$cnt][0]));
		$node = explode("|", $tmp);
		for ($i=count($node); $i<=2; $i++)
			$node[$i] = "";
		$this->tree[$cnt][1] = $node[0];
		$this->layer_label[$cnt] = "L" . $cnt;
		$this->tree[$cnt][2] = (ereg_replace(" ", "", $node[1]) == "") ? "#" : $node[1];
		$this->tree[$cnt][3] = $node[2];
		if ($this->tree[$cnt][0] > $maxlevel) $maxlevel = $this->tree[$cnt][0];
		$abscissa[$cnt] = $this->tree[$cnt][0] * $this->abscissa_step;
		if ($horizontal) {
			if ($this->tree[$cnt][0] == 1) $firstlevelcnt++;
			$abscissa[$cnt] += ($firstlevelcnt - 2) * $this->abscissa_step;
		}
		$cnt++;
	}
}else{
	for ($LayerCounter = 0; $LayerCounter < count($XoopsLayerString) ; $LayerCounter++ ) {
		$buffer =$XoopsLayerString [$LayerCounter];
		$buffer = ereg_replace(chr(13), "", $buffer);	// Microsoft Stupidity Suppression
		$this->tree[$cnt][0] = strspn($buffer, ".");
		$tmp = rtrim(substr($buffer, $this->tree[$cnt][0]));
		$node = explode("|", $tmp);
		for ($i=count($node); $i<=2; $i++)
			$node[$i] = "";
		$this->tree[$cnt][1] = $node[0];
		$this->layer_label[$cnt] = "L" . $cnt;
		$this->tree[$cnt][2] = (ereg_replace(" ", "", $node[1]) == "") ? "#" : $node[1];
		$this->tree[$cnt][3] = $node[2];
		if ($this->tree[$cnt][0] > $maxlevel) $maxlevel = $this->tree[$cnt][0];
		$abscissa[$cnt] = $this->tree[$cnt][0] * $this->abscissa_step;
		if ($horizontal) {
			if ($this->tree[$cnt][0] == 1) $firstlevelcnt++;
			$abscissa[$cnt] += ($firstlevelcnt - 2) * $this->abscissa_step;
		}
		$cnt++;
	}
}
if (! $XoopsLayerUse){
	fclose($fd);
}


	$tmpcount = count($this->tree);
	$this->tree[$tmpcount+1][0] = 0;

	/* ******************************************************************** */

	for ($cnt=$this->layerscount+1; $cnt<=$tmpcount; $cnt++) {	// this counter scans all nodes of the new menu
		// assign the layers name to the current hierarchical level,
		// to keep trace of the route leading to the current node on the tree
		$this->layer_name[$this->tree[$cnt][0]] = $this->layer_label[$cnt];

		// assign the starting vertical coordinates for all sublevels
		for ($i=$this->tree[$cnt][0]+1; $i<$maxlevel; $i++)
			$ordinata[$i] = $ordinata[$i-1] + 1.5*$this->ordinata_step;
		if ((!$horizontal || $this->tree[$cnt][0]>1) && $this->tree[$cnt][0]<$maxlevel)
			// increment the starting vertical coordinate for the current sublevel
			$ordinata[$this->tree[$cnt][0]] += $this->ordinata_step;

		if ($this->tree[$cnt+1][0]>$this->tree[$cnt][0] && $cnt<$tmpcount) {	// the node is not a leaf, hence it has at least a child
			// initialize the corresponding layer content trought a void string
			$this->layer_content[$this->layer_label[$cnt]] = "";
			// prepare the popUp function related to the children
			$this->popUps .= "function popUp" . $this->layer_label[$cnt] . "() {\n" . "shutdown();\n";
			for ($i=1; $i<=$this->tree[$cnt][0]; $i++)
				$this->popUps .= "popUp('" . $this->layer_name[$i] . "',true);\n";
			$this->popUps .= "}\n";

			// geometrical parameters are assigned to the new layer, related to the above mentioned children
			$this->moveLayers .= "setleft('" . $this->layer_label[$cnt] . "', " . $menuname . "LEFT + " . $abscissa[$cnt] . ");\n";
			if ($horizontal)
				$this->moveLayers .= "settop('" . $this->layer_label[$cnt] . "', "  . $menuname . "TOP + " . $menuname . "HEIGHT + " . $ordinata[$this->tree[$cnt][0]] . ");\n";
			else
				$this->moveLayers .= "settop('" . $this->layer_label[$cnt] . "', "  . $menuname . "TOP + " . $ordinata[$this->tree[$cnt][0]] . ");\n";
//			$this->moveLayers .= "setwidth('" . $this->layer_label[$cnt] . "'," . $this->abscissa_step . ");\n";

			// the new layer is accounted for in the shutdown() function
			$this->shutdown .= "popUp('" . $this->layer_label[$cnt] . "',false);\n"; 
		}

		if ($this->tree[$cnt+1][0]>$this->tree[$cnt][0] && $cnt<$tmpcount)	// not a leaf
			$currentarrow = $this->rightarrow;
		else	// a leaf
			$currentarrow = "";
	/* */
		$currentlink = $this->tree[$cnt][2];
	/* */
	/*
		if ($this->tree[$cnt+1][0]>$this->tree[$cnt][0] && $cnt<$tmpcount)	// not a leaf
			$currentlink = "#";
		else	// a leaf
			$currentlink = $this->tree[$cnt][2];
	*/
		if ($this->tree[$cnt][3] != "")
			$currenttarget = " target=\"" . $this->tree[$cnt][3] . "\"";
		else
			$currenttarget = "";
		if ($this->tree[$cnt][0] > 1) {
		// the hierarchical level is > 1, hence the current node is not a child of the root node
		// handle accordingly the corresponding link, distinguishing if the current node is a leaf or not
			if ($this->tree[$cnt+1][0]>$this->tree[$cnt][0] && $cnt<$tmpcount)	// not a leaf
				$onmouseover = " onMouseover=\"moveLayerY('" . $this->layer_label[$cnt] . "', currentY, " . $ordinata_margin . ") ; popUp" . $this->layer_label[$cnt] . "();\"";
			else	// a leaf
//				$onmouseover = " onMouseover=\"popUp" . $this->layer_name[$this->tree[$cnt][0]-1] . "();\"";
				$onmouseover = "";
			$this->layer_content[$this->layer_name[$this->tree[$cnt][0]-1]] .= "<a href=\"" . $currentlink . "\"" . $onmouseover . $currenttarget . ">" . stripslashes($this->tree[$cnt][1]) . "</a>" . $currentarrow . "<br>\n";
		} else if ($this->tree[$cnt][0] == 1) {
		// the hierarchical level is = 1, hence the current node is a child of the root node
		// handle accordingly the corresponding link, distinguishing if the current node is a leaf or not
			if ($this->tree[$cnt+1][0]>$this->tree[$cnt][0] && $cnt<$tmpcount)	// not a leaf
				if ($horizontal)
					$onmouseover = " onMouseover = \"popUp" . $this->layer_label[$cnt] . "();\"";
				else
					$onmouseover = " onMouseover = \"moveLayerY('" . $this->layer_label[$cnt] . "', currentY, " . $ordinata_margin_firstlevel . ") ; popUp" . $this->layer_label[$cnt] . "();\"";
			else	// a leaf
				$onmouseover = " onMouseover=\"shutdown();\"";
			if ($horizontal) {
				$appoggio = "<a href=\"" . $currentlink . "\"" . $onmouseover . $currenttarget . ">" . stripslashes($this->tree[$cnt][1]) . "</a>" . $currentarrow;
				if (!$firstlevellayerput) {
					$appoggio = $firstlevellayeropen . $appoggio . $firstlevellayerclose;
					$firstlevellayerput = 1;
				}
				$t->set_var(array(
					"cellwidth"	=> $this->abscissa_step,
					"cellbody"	=> $appoggio
				));
				$t->parse("hormenu_cell_blck", "hormenu_cell", true);
			} else
				$this->firstlevelmenu[$menuname] .= "<a href=\"" . $currentlink . "\"" . $onmouseover . $currenttarget . ">" . stripslashes($this->tree[$cnt][1]) . "</a>" . $currentarrow . "<br>\n";
		}

	}	// end of the "for" cycle scanning all nodes

	if (!$horizontal) {
		$this->firstlevelmenu[$menuname] = substr($this->firstlevelmenu[$menuname], 0, strlen($this->firstlevelmenu[$menuname])-5);
		$this->firstlevelmenu[$menuname] = $firstlevellayeropen . $this->firstlevelmenu[$menuname] . $firstlevellayerclose;
	}

	if ($horizontal) {
		$appoggio = $firstlevelcnt * $this->abscissa_step;
		$t->set_var("menuwidth", $appoggio);
	} else {
		$t->set_file("page", $phplmdirroot . "layersmenu-vermenu.ihtml");
		$t->set_var("abscissa_step", $this->abscissa_step);
	}
	$t->set_var(array(
		"layer_label"	=> $menuname,
		"menubody"	=> $this->firstlevelmenu[$menuname]
	));
	$this->firstlevelmenu[$menuname] = $t->parse("out", "page");

	$this->layerscount = $tmpcount;
}

function printheader($phplmwwwroot) {
// the moveLayers function has to be completed here
// the shutdown function has to be completed here
// the header has to be printed after preparing of moveLayers and shutdown

//	global $phplmwwwroot;

	$this->moveLayers = "function moveLayers() {\n" . $this->moveLayers . "}\n";
	$this->shutdown = "function shutdown() {\n" . $this->shutdown . "}\n" . "if (NS4) {\ndocument.onmousedown = function() { shutdown(); }\n} else {\ndocument.onclick = function() { shutdown(); } \n}\n";

	print "<!-- " . $this->packagename . " " . $this->version . " " . $this->copyright . " " . $this->author . " -->\n";
	print "</script>\n";
	print "\n";
	print "<script language=\"JavaScript\">\n";
	print "<!--\n";
	print "var thresholdY = " . $this->thresholdY . ";\n";
	print "// -->\n";
	print "</script>\n";
	print "\n";
	print "<script language=\"JavaScript\" src=\"" . $phplmwwwroot . "layersmenu.js\"></script>\n";
	print "\n";
	print "<script language=\"JavaScript\">\n";
	print "<!--\n";
	print "\n";
	print $this->popUps;
	print "\n";
	print $this->moveLayers;
	print "\n";
	print $this->shutdown;
	print "\n";
	print "// -->\n";
	print "</script>\n";
	print "\n";
	print "<!-- " . $this->packagename . " " . $this->version . " " . $this->copyright . " " . $this->author . " -->\n";
}

function printfirstlevelmenu($menuname) {
	print $this->firstlevelmenu[$menuname];
}

function printfooter() {

	global $phplmdirroot;

	print "<!-- " . $this->packagename . " " . $this->version . " " . $this->copyright . " " . $this->author . " -->\n";
	print "\n";

	$t = new Template();
	$t->set_file("page", $phplmdirroot . "layersmenu-submenu.ihtml");
	$t->set_var("abscissa_step", $this->abscissa_step);

	for ($cnt=1; $cnt<=$this->layerscount; $cnt++)
		if ($this->tree[$cnt+1][0] > $this->tree[$cnt][0]) {
			print "\n<div id=\"" . $this->layer_label[$cnt] . "\" style=\"position: absolute; visibility: hidden;\">\n";
			$this->layer_content[$this->layer_label[$cnt]] = substr($this->layer_content[$this->layer_label[$cnt]], 0, strlen($this->layer_content[$this->layer_label[$cnt]])-1);
			$t->set_var(array(
				"layer_title"	=> stripslashes($this->tree[$cnt][1]),
				"layer_content"	=> $this->layer_content[$this->layer_label[$cnt]]
			));
			$t->pparse("out", "page");
			print "</div>\n\n";
		}

	print "\n";
	print "<script language=\"JavaScript\">\n";
	print "<!--\n";
	print "//moveLayers();\n";
	print "loaded = 1;\t// to avoid stupid errors of Microsoft browsers\n";
	print "// -->\n";
	print "</script>\n";
	print "\n";
	print "<!-- " . $this->packagename . " " . $this->version . " " . $this->copyright . " " . $this->author . " -->\n";
}

/* ********** */
}
/* ********** */

?>
