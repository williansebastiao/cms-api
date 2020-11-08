<?php

namespace App\Exports;

use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RoleExport implements FromView {

    /**
     * @return View
     */
    public function view(): View {
        return view('export.roles', [
            'permissions' => Permission::where('active', true)
                ->get()
        ]);
    }

}
