<?php

namespace CCUFFS\Scrap;

use DateInterval;
use DatePeriod;
use DateTime;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;

class UniversityRestaurantUFFS
{
	public $campus = [
		"cerro-largo" => 'https://www.uffs.edu.br/campi/cerro-largo/restaurante_universitario',
		"chapeco" => 'https://www.uffs.edu.br/campi/chapeco/restaurante_universitario',
		"erechim" => 'https://www.uffs.edu.br/campi/erechim/restaurante_universitario',
		"laranjeiras-do-sul" => 'https://www.uffs.edu.br/campi/laranjeiras-do-sul/restaurante_universitario',
		"passo-fundo" => 'https://www.uffs.edu.br/campi/passo-fundo/restaurante-universitario',
		"realeza" => 'https://www.uffs.edu.br/campi/realeza/restaurante_universitario/apresentacao-do-ru'
	];

	public function __construct()
	{
		$this->client = new Client();
	}

	public function formatDate($date)
	{
		return $date->format('d/m/Y');
	}

	public function getMenuByCampus(string $link)
	{
		$response = $this->client->get($link);

		$htmlString = (string) $response->getBody();
		libxml_use_internal_errors(true);

		$doc = new DOMDocument();
		$doc->preserveWhiteSpace = false;
		$doc->loadHTML($htmlString);
		$xpath = new DOMXPath($doc);

		$section = $doc->getElementById('content-core')->getElementsByTagName('span')[0];
		$menus = [];

		foreach ($section->childNodes as $index => $element) {
			$week = "";
			$path = $element->getNodePath();
			$object = $xpath->query($path)[0];
			if ($object->nodeName != '#text' && ($object->localName == "table" || $object->getElementsByTagName('table')[0])) {
				if ($object->localName == "table") {
					$table = $object;
				} else {
					$table = $object->getElementsByTagName('table')[0];
				}

				$week = $section->childNodes->item($index - 2)->nodeValue;

				$week_string_dates = $this->handleWeekDate($week);

				$rows = $table->getElementsByTagName('tr');

				foreach ($rows as $i => $row) {
					if (
						$i != 0
					) {
						$items = $row->getElementsByTagName('td');
						foreach ($items as $j => $item) {
							$treated_item = trim(preg_replace('/[\pZ\pC]/u', ' ', $item->textContent));
							if ($treated_item != "") {
								$menus[$week_string_dates[$j]][] = $treated_item;
							}
						}
					}
				}
			}
		}

		return $menus;
	}

	public function handleWeekDate(string $week)
	{
		preg_match_all("/(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/([0-9]{4}|[0-9]{2})/", $week, $matches);
		preg_match_all("/\s(0[1-9]|[1-2][0-9]|3[0-1])\s|\s([1-9])\s/", $week, $matches_prime);
		if ($matches_prime[0]) {
			$date2 = date_create_from_format("d/m/Y", $matches[0][0])->modify('+1 day');
			$date1 = clone $date2;
			$date1->modify("-5 days");
		} else {
			$date2 = date_create_from_format("d/m/Y", $matches[0][1])->modify('+1 day');
			$date1 = date_create_from_format("d/m/Y", $matches[0][0]);

			if ($date2->diff($date1)->m > 0) {
				$date1 = clone $date2;
				$date1->modify("-5 days");
			}
		}

		if ($date1->format("Y") < 100) {
			$date1 = date_create_from_format("d/m/y", $date1->format("d/m/y"));
		}

		if ($date2->format("Y") < 100) {
			$date2 = date_create_from_format("d/m/y", $date2->format("d/m/y"));
		}

		$week_dates = new DatePeriod(
			$date1,
			new DateInterval('P1D'),
			$date2
		);

		return array_map(array($this, 'formatDate'), iterator_to_array($week_dates));
	}

	public function getMenuByDate(string $link, string $date)
	{
		$menu = $this->getMenuByCampus($link);

		return array_key_exists($date, $menu) ? $menu[$date] : null;
	}

	public function getMenuByWeekDay(string $link, string $weekday)
	{
		$date = $this->formatDate($this->getDateByWeekDay($weekday));
		$menu = $this->getMenuByCampus($link);

		return array_key_exists($date, $menu) ? $menu[$date] : null;
	}

	public function getDateByWeekDay(string $weekday)
	{
		switch (strtolower($weekday)) {
			case "dom":
				return new DateTime('sunday');
			case "seg":
				return new DateTime('monday');
			case "ter":
				return new DateTime('tuesday');
			case "qua":
				return new DateTime('wednesday');
			case "qui":
				return new DateTime('thursday');
			case "sex":
				return new DateTime('friday');
			case "sab":
				return new DateTime('saturday');
			default:
				return null;
		}
	}
}
