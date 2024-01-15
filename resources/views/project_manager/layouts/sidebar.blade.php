<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ url('admin/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('admin/addEmployee') }}">
                <i class="bi bi-person"></i>
                <span>Add Employee</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('admin/addProject') }}">
                <i class="bi bi-person"></i>
                <span>Add Project</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('admin/task') }}">
                <i class="bi bi-person"></i>
                <span>Assign Task</span>
            </a>
        </li>
    </ul>

</aside>
