<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class CodeExport implements FromView
{
	use Exportable;

	protected $codes;

	public function __construct($codes)
	{
		$this->codes = $codes;
	}

	/**
	 * @return View
	 */
	public function view(): View
    {
		return view('backend.code.excel', [
			'codes' => $this->codes
		]);
    }
}
