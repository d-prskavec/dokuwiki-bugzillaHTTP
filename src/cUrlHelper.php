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

class cUrlHelper {

	private $header = array('Connection: Keep-Alive', 'Accept: text/xml');
	private $useragent = 'dokuwiki-bugzillaHTTP plugin - php-cUrl';



	private function setCurlOptions($handle) {
		curl_setopt($handle, CURLOPT_HTTPHEADER, $this->header);
		curl_setopt($handle, CURLOPT_USERAGENT, $this->useragent);
		curl_setopt($handle, CURLOPT_HTTPGET, 1);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
	}

	public function fetchContent($url) {
		$handle = curl_init($url);
		$this->setCurlOptions($handle);
		$return = curl_exec($handle);
		curl_close($handle);
		return $return;
	}

}

?>