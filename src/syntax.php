<?php
// Copyright 2012 Andreas Parschalk

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
require_once('cUrlHelper.php');
require_once('BzBug.php');

class syntax_plugin_bugzillaHTTP extends DokuWiki_Syntax_Plugin {


	private $starttime;
	private $endtime;

	function getInfo(){
		return array(
				'author' => 'andreas parschalk',
				'email'  => 'dprskavec@gmail.com',
				'date'   => '2012-08-17',
				'name'   => 'bugzilla http plugin',
				'desc'   => 'Gets information about bugs via HTTP (xml-view).',
				'url'    => 'http://www.dokuwiki.org/plugin:bugzillaHTTP',
		);
	}

	function getType()  {
		return 'substition';
	}
	function getPType() {
		return 'normal';
	}
	function getSort()  {
		return 777;
	}

	function connectTo($mode) {
		$this->Lexer->addSpecialPattern('^\[buglist\s*\|\s*\d+\s*(?:\s*,\s*\d+)*\s*\]', $mode, 'plugin_bugzillaHTTP');
	}

	
	function fetchBugs($idString) {
	//	$this->starttime = microtime(true);
		$url = $this->getConf('bug_xml_url');
		$url .= $idString;
		$curl = new cUrlHelper();
		$content = $curl->fetchContent($url);
		$bug = new BzBug();
		$buglist = $bug->unmarshall($content);
	//	$this->endtime = microtime(true);
		return $buglist;
	}

	function handle($match, $state, $pos, &$handler) {
		preg_match('/^\[buglist\s*\|([\s(\d),]+)\]/', $match, $submatch);
		$idString = preg_replace('/\s/', '', $submatch[1]);
		return $idString;
	}


	function uncachedHandle($idString) {
		return $this->fetchBugs($idString);
	}

	
	function render($mode, &$renderer, $idString) {
		$bugData = $this->uncachedHandle($idString);
		//var_dump($bugData);
		$url = $this->getConf('bug_url');
		if($mode == 'xhtml'){
			// render tableheader
			$bugtable = '<table class="bugtable"><tr><th>ID</th><th>PRI</th><th>SEV</th><th>ASSIGNEE</th><th>STATUS</th><th>SHORT DESCRIPTION</th></tr>';
			//print_r($data_bugs);
			foreach($bugData as $bug) {
				$rowclass = "bugtable_".$bug->getPriority();
				if ($bug->getStatus() === 'CLOSED') {
					$rowclass = "bugtable_closed";
				}
				if ($bug->getStatus() === 'VERIFIED') {
					$rowclass = "bugtable_verified";
				}
				if ($bug->getStatus() === 'RESOLVED') {
					$rowclass = "bugtable_resolved";
				}
				$bugtable .= '<tr class="'.$rowclass.'">';
				$bugtable .= '<td><a href="'.$url . $bug->getId().'" target="_blank">'.$bug->getId().'</a></td><td>'.$bug->getPriority().'</td><td>'.$bug->getSeverity().'</td><td>'.
						$bug->getAssignedTo().'</td><td>'.$bug->getStatus().'</td><td>'.$bug->getShortDesc().'</td>';
				$bugtable .= '</tr>';
			}
			$bugtable .= '</table>';
				
			$renderer->doc .= $bugtable;
		//	$renderer->doc .= 'fetchted buglist in '.($this->endtime - $this->starttime) .'s';
			return true;

		}
		return false;
	}

}
?>	
