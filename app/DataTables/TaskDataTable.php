<?php

namespace App\DataTables;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TaskDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->editColumn('project_name', function ($data) {
                return $data->project->project_name;
            })

            ->editColumn('status', function ($data) {
                if ($data->status == 0) {
                    return '<span class="badge badge-warning">Pending...</span>';
                } else if ($data->status == 1) {
                    return '<span class="badge badge-success">Complete</span>';
                } else {
                    return '<span class="badge badge-danger">Closed</span>';
                }
            })

            ->editColumn('user_name', function ($data) {
                return $data->user->name;
            })

            ->filterColumn('user_name', function ($query, $keyword) {
                $query->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })

            ->filterColumn('project_name', function ($query, $keyword) {
                $query->whereHas('project', function ($query) use ($keyword) {
                    $query->where('project_name', 'like', "%{$keyword}%");
                });
            })

            ->editColumn('roles', function ($data) {
                if ($data->roles == 1) {
                    return '<span class="badge badge-danger">Cordinator</span>';
                } else {
                    return '<span class="badge badge-success">Employee</span>';
                }
            })

            ->rawColumns(['status', 'roles'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Task $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('task-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('no')->data('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('id')->hidden(),
            Column::make('project_name')->searchable(true),
            Column::make('task_name')->searchable(true),
            Column::make('user_name')->searchable(true),
            Column::make('startdate'),
            Column::make('enddate'),
            Column::make('roles'),
            Column::make('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Task_' . date('YmdHis');
    }
}
