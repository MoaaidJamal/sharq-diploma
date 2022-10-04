<?php

namespace App\Imports;

use App\Models\Phase;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::query()->updateOrCreate(['email' => $row[2]],[
            'name' => [
                'ar' => $row[0],
                'en' => $row[1],
            ],
            'type' => User::TYPE_USER
        ]);
        $phases_ids = array_filter(array_map(function ($phase_id) {
            return (int)trim($phase_id);
        }, explode(',', $row[3])));
        Phase::query()->whereIn('id', $phases_ids)->each(function (Phase $phase) use ($user) {
            $phase->users()->syncWithoutDetaching($user->getKey());
        });
        return $user;
    }

    public function startRow(): int
    {
        return 2;
    }
}
