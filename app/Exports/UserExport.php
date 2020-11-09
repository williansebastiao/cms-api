<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView {

    /**
     * @return View
     */
    public function view(): View {
        return view('export.users', [
            'users' => User::where('active', true)
                ->get()
        ]);
    }

}
