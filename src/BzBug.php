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
 
class BzBug {
	private $id;
	private $product;
	private $shortDesc;
	private $dateCreated;
	private $assignedTo;
	private $reportedBy;
	private $status;
	private $priority;
	private $severity;

	public function getId() {
		return $this->id;
	}
	public function getProduct() {
		return $this->product;
	}
	public function getShortDesc() {
		return $this->shortDesc;
	}
	public function getDateCreated() {
		return $this->dateCreated;
	}
	public function getAssignedTo() {
		return $this->assignedTo;
	}
	public function getReportedBy() {
		return $this->reportedBy;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getPriority() {
		return $this->priority;
	}
	public function getSeverity() {
		return $this->severity;
	}

	public function setId($id) {
		return $this->id = $id;
	}
	public function setProduct($p) {
		return $this->product = $p;
	}
	public function setShortDesc($d) {
		return $this->shortDesc = $d;
	}
	public function setDateCreated($d) {
		return $this->dateCreated = $d;
	}
	public function setAssignedTo($a) {
		return $this->assignedTo = $a;
	}
	public function setReportedBy($r) {
		return $this->reportedBy = $r;
	}
	public function setStatus($s) {
		return $this->status = $s;
	}
	public function setPriority($p) {
		return $this->priority = $p;
	}
	public function setSeverity($s) {
		return $this->severity = $s;
	}

	
	public function unmarshall($xmlBugString) {
		$bugArray = array(); 
		try {
			$xml = simplexml_load_string($xmlBugString);
			$bugs = $xml->bug;
			//echo "FETCHED ".sizeof($bugs). "BUGS!<br /><br />";
			foreach ($bugs as $bug) {
				
				$b = new BzBug();
				$b->setId((string)$bug->bug_id);
				$b->setDateCreated((string)$bug->creation_ts);
				$b->setAssignedTo((string)$bug->assigned_to);
				$b->setReportedBy((string)$bug->reporter);
				$b->setShortDesc((string)$bug->short_desc);
				$b->setProduct((string)$bug->product);
				$b->setStatus((string)$bug->bug_status);
				$b->setSeverity((string)$bug->bug_severity);
				$b->setPriority((string)$bug->priority);
				$bugArray[] = $b;
			}
		} catch (Exception $e) {
			//invalid xml string
			die("ERROR unmarshalling xml from bugzilla:".$e->getMessage());
		}
		return $bugArray;
	}
}
?>
