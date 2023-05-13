<?php

namespace App\Http\Livewire\Components\User;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Avatar", "avatar")
                ->format(
                    fn($value, $row, Column $column) => '<img src="' . $value . '" alt="avatar" class="rounded-full h-8 w-8">'
                )->html(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            LinkColumn::make("Name")
                ->title(fn($row) => 'Chat')
                ->location(fn($row) => url('/chat') . '/' . base64_encode($row->id)),
            Column::make("Created at", "created_at")
                ->sortable(),
        ];
    }
}