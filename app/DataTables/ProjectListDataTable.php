<?php

namespace App\DataTables;

use App\Models\ProjectList;
use App\Models\ProjectUser;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Contracts\Auth\Authenticatable;

class ProjectListDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    protected $user;

    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->editColumn('project_id', function ($data) {
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

            ->editColumn('user_id', function ($data) {
                return $data->user->name;
            })

            ->filterColumn('user_id', function ($query, $keyword) {
                $query->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })

            ->filterColumn('project_id', function ($query, $keyword) {
                $query->whereHas('project', function ($query) use ($keyword) {
                    $query->where('project_name', 'like', "%{$keyword}%");
                });
            })

            ->rawColumns(['roles'])
            ->addIndexColumn();
    }

    public function setUser(Authenticatable $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProjectUser $model): QueryBuilder
    {
        return $model->newQuery()
        ->where('user_id', $this->user->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('projectlist-table')
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
            Column::make('project_id')->title('Project Name')->searchable(true),
            Column::make('user_id')->title('User Name')->searchable(true),
            Column::make('roles')->title('Assign Roles')->searchable(true),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProjectList_' . date('YmdHis');
    }
}
