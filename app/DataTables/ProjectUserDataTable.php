<?php

namespace App\DataTables;

use App\Models\ProjectUser;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProjectUserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {

                $result = '';
                if ($data->roles == 0) {
                    $result .= '<button class="cordinator_btn btn btn-danger btn-sm" data-id="' . $data->id . '"><i class="fa-solid fa-user"></i>&nbspCordinator</button>&nbsp ';
                    $result .= '<button class="employee_btn btn btn-primary btn-sm" data-id="' . $data->id . '"><i class="fa-solid fa-user"></i>&nbspEmployee</button>&nbsp&nbsp';
                } else if ($data->roles == 1) {
                    $result .= '<button class="cordinator_btn btn btn-danger btn-sm" data-id="' . $data->id . '" disabled><i class="fa-solid fa-user"></i>&nbspCordinator</button>&nbsp ';
                } else {
                    $result .= '<button class="employee_btn btn btn-primary btn-sm" data-id="' . $data->id . '" disabled><i class="fa-solid fa-user"></i>&nbspEmployee</button>&nbsp&nbsp';
                }
                return $result;
            })

            ->editColumn('project_name', function ($data) {
                return $data->project->project_name;
            })

            ->editColumn('roles', function ($data) {
                if ($data->roles == 0) {
                    return '<span class="badge badge-primary">Role not assign</span>';
                } else if ($data->roles == 1) {
                    return '<span class="badge badge-danger">Cordinator</span>';
                } else {
                    return '<span class="badge badge-success">Employee</span>';
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

            ->rawColumns(['action', 'roles'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProjectUser $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('projectuser-table')
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
            Column::make('user_name')->searchable(true),
            Column::make('roles'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-left'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProjectUser_' . date('YmdHis');
    }
}