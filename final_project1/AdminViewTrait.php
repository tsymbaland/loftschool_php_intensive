<?php

trait AdminViewTrait
{
	public function makeAdminViewHtml(array $meta, array $data): string
	{
		$table = ['<table border="2">'];
		$table[] = $this->makeHeaderForAdminView($meta);
		$table = array_reduce($data, function ($acc, $rec) use ($meta) {
			$acc[] = $this->makeRowForAdminView($meta, $rec);

			return $acc;
		}, $table);
		$table[] = '</table>';

		return implode('', $table);
	}

	private function makeHeaderForAdminView(array $meta): string
	{
		$header = ['<thead>'];
		foreach ($meta as $param => $caption) {
			$header[] = "<th>$caption</th>";
		}
		$header[] = '</thead>';

		return implode('', $header);
	}

	private function makeRowForAdminView(array $meta, array $rec): string
	{
		$row = ['<tr>'];
		foreach ($meta as $param => $caption) {
			$row[] = "<td>$rec[$param]</td>";
		}
		$row[] = "</tr>";

		return implode('', $row);
	}
}
