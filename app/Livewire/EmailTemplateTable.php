<?php

namespace App\Livewire;

use App\Models\EmailTemplate;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\Lazy;
#[Lazy]
class EmailTemplateTable extends LivewireTableComponent
{
    protected $model = EmailTemplate::class;

    public $showFilterOnHeader = false;

    public $paginationIsEnabled = true;

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage'];

    public function placeholder()
    {
        return view('livewire.skeleton_files.without_add_button_skeleton');
    }
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setQueryStringStatus(false);
    
        
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
    
            if ($columnIndex == '1') {
                return [
                    'class' => 'text-left',
                    'width' => '8%',
                ];
            }
    
            return [
                'class' => 'text-left',
            ];
        });
    }
    public function columns(): array
    {
        return [


            Column::make(__('messages.email_template.email_subject'), 'email_subject')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.common.actions'), 'id')
                ->format(function ($value, $row) {
                    return view('email-template.columns.action', [
                        'row' => $row,
                    ]);
                })
                ->html(),
        ];
    }
}
