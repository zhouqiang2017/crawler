<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    /**
     * 使用 ToCollection
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {
        //如果需要去除表头
        unset($rows[0]);
        //$rows 是数组格式
        $this->createData($rows);
    }

    public function createData($rows)
    {
        dd($rows);
    }
}
