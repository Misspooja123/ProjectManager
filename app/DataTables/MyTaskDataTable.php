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
use Illuminate\Contracts\Auth\Authenticatable;


class MyTaskDataTable extends DataTable
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
            ->addColumn('action', function ($data) {

                $result = '';

                if ($data->roles == 2 && $data->status == 0) {
                    $result .= '<button class="complete_btn btn btn-primary btn-sm" data-id="' . $data->id . '">&nbspComplete</button>&nbsp ';
                    // $result .= '<button class="closed_btn btn btn-primary btn-sm" data-id="' . $data->id . '" disabled>&nbspClosed</button>&nbsp&nbsp';
                } else if ($data->roles == 2 && $data->status == 1) {
                    $result .= '<button class="complete_btn btn btn-primary btn-sm" data-id="' . $data->id . '" disabled>&nbspComplete</button>&nbsp ';
                    // $result .= '<button class="closed_btn btn btn-primary btn-sm" data-id="' . $data->id . '" disabled>&nbspClosed</button>&nbsp&nbsp';
                } else if($data->roles == 1 && $data->status == 0){
                    $result .= '<button class="complete_btn btn btn-primary btn-sm" data-id="' . $data->id . '">&nbspComplete</button>&nbsp ';
                    $result .= '<button class="closed_btn btn btn-primary btn-sm" data-id="' . $data->id . '">&nbspClosed</button>&nbsp&nbsp';
                }else if($data->roles == 1 && $data->status == 1){
                    $result .= '<button class="complete_btn btn btn-primary btn-sm" data-id="' . $data->id . '" disabled>&nbspComplete</button>&nbsp ';
                    $result .= '<button class="closed_btn btn btn-primary btn-sm" data-id="' . $data->id . '">&nbspClosed</button>&nbsp&nbsp';
                }else if($data->roles == 1 && $data->status == 2){
                    $result .= '<button class="complete_btn btn btn-primary btn-sm" data-id="' . $data->id . '" disabled>&nbspComplete</button>&nbsp ';
                    $result .= '<button class="closed_btn btn btn-primary btn-sm" data-id="' . $data->id . '" disabled>&nbspClosed</button>&nbsp&nbsp';
                }

                if ($data->roles == 1) {
                    $result .= '<button class="assignTaskButton btn btn-primary btn-sm" >&nbspAssign Task</button>&nbsp ';
                }
                return $result;
            })

            ->editColumn('project_id', function ($data) {
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
            ->editColumn('roles', function ($data) {
                if ($data->roles == 1) {
                    return '<span class="badge badge-danger">Cordinator</span>';
                } else {
                    return '<span class="badge badge-success">Employee</span>';
                }
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

            ->editColumn('user_id', function ($data) {
                return $data->user->name;
            })
            ->rawColumns(['status', 'action', 'roles'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Task $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('user_id', $this->user->id);
    }

    public function setUser(Authenticatable $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('mytask-table')
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
            Column::make('task_name')->title('Task Name')->searchable(true),
            Column::make('user_id')->title('User Name')->searchable(true),
            Column::make('startdate')->title('Start Date'),
            Column::make('enddate')->title('End Date'),
            Column::make('roles')->title('Assign Roles'),
            Column::make('status')->title('Status'),
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
        return 'MyTask_' . date('YmdHis');
    }
}
